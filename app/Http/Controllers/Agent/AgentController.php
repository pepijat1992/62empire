<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Agent;
use App\User;
use App\Models\CreditTransaction;
use App\Models\GameTransaction;
use App\Models\Game;
use App\Models\GameUser;

use Auth;
use Hash;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.agent');
    }

    /**
     * Show the agent dashboard.
     */
    public function index()
    {
        config(['site.page' => 'home']);
        $auth_agent = Auth::guard('agent')->user();
        $return['today_register_count'] = $auth_agent->users()->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->count();
        $return['total_register_count'] = $auth_agent->users()->orderBy('created_at', 'asc')->count();

        if(is_Mobile()) {
            return redirect(route('agent.wap.index'));
        }
        return view('agent.home', compact('return'));
    }

    public function change_password(Request $request){        
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $data = $request->all();
        // dd($data);
        $agent = Auth::guard('agent')->user();

        if (!Hash::check($data['old_password'], $agent->password)) {
            return back()->withErrors(['old_password' => 'Current Password does not match.']);
        }

        $agent->password = Hash::make($data['password']);
        $agent->save();
        
        return back()->with('success', __('words.updated_successfully'));
    }
    
    public function credit_transaction(Request $request) {
        config(['site.page' => 'credit_transaction']);
        $auth_agent = Auth::guard('agent')->user();
        $mod = new CreditTransaction();
        $mod = $mod->where(function($query) use($auth_agent){
                    return $query->where('sender_role', 'agent')->where('sender_id', $auth_agent->id);
                })
                ->orWhere(function($query) use($auth_agent){
                    return $query->where('receiver_role', 'agent')->where('receiver_id', $auth_agent->id);
                });
        $type = $username = $period = '';
        if($request->type != '') {
            $type = $request->type;
            $mod = $mod->where('type', $type);
        }
        if($request->username != '') {
            $username = $request->username;
            $user_array = User::where('username', 'like', "%$username%")->pluck('id');
            $agent_array = Agent::where('username', 'like', "%$username%")->pluck('id');
            $admin_array = Admin::where('username', 'like', "%$username%")->pluck('id');
            $mod = $mod->where(function($query) use($username, $user_array){
                        return $query->where('sender_role', 'user')
                                    ->whereIn('sender_id', $user_array);
                    })
                    ->orWhere(function($query) use($username, $agent_array){
                        return $query->where('sender_role', 'agent')
                                    ->whereIn('sender_id', $agent_array);
                    })
                    ->orWhere(function($query) use($username, $admin_array){
                        return $query->where('sender_role', 'admin')
                                    ->whereIn('sender_id', $admin_array);                        
                    })
                    ->orWhere(function($query) use($username, $user_array){
                        return $query->where('receiver_role', 'user')
                                    ->whereIn('receiver_id', $user_array);
                    })
                    ->orWhere(function($query) use($username, $agent_array){
                        return $query->where('receiver_role', 'agent')
                                    ->whereIn('receiver_id', $agent_array);
                    })
                    ->orWhere(function($query) use($username, $admin_array){
                        return $query->where('receiver_role', 'admin')
                                    ->whereIn('receiver_id', $admin_array);                        
                    });            
        }

        if($request->has('period') && $request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10)." 00:00:00";
            $to = substr($period, 14, 10)." 23:59:59";
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        $collection = $mod->get();
        $total_income = $collection->where('receiver_role', 'agent')->sum('amount');
        $total_expense = $collection->where('sender_role', 'agent')->sum('amount');

        return view('agent.credit.index', compact('data', 'total_expense', 'total_income', 'type', 'username', 'period'));
    }

    public function game_account(Request $request) {
        config(['site.page' => 'game_account']);
        $auth_agent = Auth::guard('agent')->user();
        $games = Game::all();
        $user_array = $auth_agent->users()->pluck('id');
        $mod = new GameUser();
        $mod = $mod->whereIn('user_id', $user_array);
        $player = $username = $game_id = $period = '';
        if($request->game_id != '') {
            $game_id = $request->game_id;
            $mod = $mod->where('game_id', $game_id);
        }
        if($request->username != '') {
            $username = $request->username;
            $mod = $mod->where('username', "%$username%");
        }
        if($request->player != '') {
            $player = $request->player;
            $player_array = User::where('username', 'like', "%$player%")->pluck('id');
            $mod = $mod->whereIn('user_id', $player_array);
        }
        if($request->has('period') && $request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10)." 00:00:00";
            $to = substr($period, 14, 10)." 23:59:59";
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }
        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        return view('agent.game_account.index', compact('data', 'games' , 'game_id', 'username', 'player', 'period'));
    }

    public function game_account1(Request $request) {
        config(['site.page' => 'game_account']);
        $games = Game::all();
        $auth_agent = Auth::guard('agent')->user();
        $account = $player = '';
        $mod = $auth_agent->users();
        $account_mod = new GameUser();
        
        if($request->account != '') {
            $account = $request->account;
            $account_mod = $account_mod->where('username', 'like', "%$account%");
        }

        $account_user_array = $account_mod->distinct()->pluck('user_id');


        $mod = $mod->whereIn('id', $account_user_array);
        if($request->player != '') {
            $player = $request->player;
            $mod = $mod->where('username', 'like', "%$player%");
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(10);
        
        return view('agent.game_account.index1', compact('data', 'player', 'account'));
    }

    public function game_transaction(Request $request) {
        config(['site.page' => 'game_transaction']);
        $games = Game::all();
        $auth_agent = Auth::guard('agent')->user();
        $agent_user_array = $auth_agent->users->pluck('id');
        $mod = new GameTransaction();
        $mod = $mod->whereIn('user_id', $agent_user_array);
        $type = $player = $game_id = $period = '';
        if($request->type != '') {
            $type = $request->type;
            $mod = $mod->where('type', $type);
        }
        if($request->player != '') {
            $player = $request->player;
            $user_array = User::where('username', 'like', "%$player%")->pluck('id');
            $mod = $mod->whereIn('user_id', $user_array);
        }
        if($request->game_id != '') {
            $game_id = $request->game_id;
            $mod = $mod->where('game_id', $game_id);
        }

        if($request->has('period') && $request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10)." 00:00:00";
            $to = substr($period, 14, 10)." 23:59:59";
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        $collection = $mod->get();
        $total_deposit = $collection->where('type', 'deposit')->sum('amount');
        $total_withdraw = $collection->where('type', 'withdraw')->sum('amount');

        return view('agent.game_transaction.index', compact('data', 'games', 'total_deposit', 'total_withdraw', 'type', 'game_id', 'player', 'period'));

    }
}
