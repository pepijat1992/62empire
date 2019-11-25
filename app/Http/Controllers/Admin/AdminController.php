<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin;
use App\Agent;
use App\User;
use App\Models\CreditTransaction;
use App\Models\GameTransaction;
use App\Models\Game;
use App\Models\GameUser;
use App\Models\AdminActivity;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\FreeBonus;

use Auth;
use Hash;

class AdminController extends Controller
{
    /**
     * construct
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        config(['site.page' => 'home']);

        $user_array = User::all();
        $login_count = 0;
        foreach ($user_array as $user) {
            if($user->isOnline()) $login_count++;
        }
        
        $return['today_register_count'] = User::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->count();
        $return['total_register_count'] = User::orderBy('created_at', 'asc')->count();
        $return['login_count'] = $login_count;

        $return['today_deposit_count'] = Deposit::where('status', 2)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->count();
        $return['today_deposit_sum'] = Deposit::where('status', 2)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->sum('amount');
        $return['total_deposit_sum'] = Deposit::where('status', 2)->sum('amount');

        $return['today_withdraw_count'] = Withdraw::where('status', 2)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->count();
        $return['today_withdraw_sum'] = Withdraw::where('status', 2)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->sum('amount');
        $return['total_withdraw_sum'] = Withdraw::where('status', 2)->orderBy('created_at', 'asc')->sum('amount');

        $return['today_bonus_count'] = FreeBonus::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->count();
        $return['today_bonus_sum'] = FreeBonus::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->sum('amount');
        $return['total_bonus_sum'] = FreeBonus::orderBy('created_at', 'asc')->sum('amount');
        
        return view('admin.home', compact('return'));
    }

    public function change_password(Request $request){        
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $data = $request->all();
        // dd($data);
        $admin = Auth::guard('admin')->user();

        if (!Hash::check($data['old_password'], $admin->password)) {
            return back()->withErrors(['old_password' => 'Current Password does not match.']);
        }

        $admin->password = Hash::make($data['password']);
        $admin->save();

        AdminActivity::create([
            'admin_id' => $admin->id,
            'type' => 'change_password',
            'ip_address' => getIp(),
            'description' => "Change Password" ,
        ]);
        
        return back()->with('success', __('words.updated_successfully'));
    }

    public function credit_transaction(Request $request) {
        config(['site.page' => 'credit_transaction']);

        $mod = new CreditTransaction();
        $mod = $mod->where(function($query){
            return $query->where('sender_role', 'admin')->orWhere('receiver_role', 'admin');
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
        $total_income = $collection->where('receiver_role', 'admin')->sum('amount');
        $total_expense = $collection->where('sender_role', 'admin')->sum('amount');

        return view('admin.credit.index', compact('data', 'total_expense', 'total_income', 'type', 'username', 'period'));
    }

    public function game_account(Request $request) {
        config(['site.page' => 'game_account']);

        $games = Game::all();

        $mod = new GameUser();
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
        return view('admin.game_account.index', compact('data', 'games' , 'game_id', 'username', 'player', 'period'));
    }

    public function game_account1(Request $request) {
        config(['site.page' => 'game_account']);
        $games = Game::all();
        $account = $player = '';
        $mod = new User();
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
        
        return view('admin.game_account.index1', compact('data', 'player', 'account'));
    }

    public function game_transaction(Request $request) {
        config(['site.page' => 'game_transaction']);
        $games = Game::all();
        $mod = new GameTransaction();
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

        return view('admin.game_transaction.index', compact('data', 'games', 'total_deposit', 'total_withdraw', 'type', 'game_id', 'player', 'period'));

    }

    public function activity(Request $request) {
        config(['site.page' => 'activity']);
        $mod = new AdminActivity();
        $type = $keyword = $period = '';

        if($request->type != '') {
            $type = $request->type;
            $mod = $mod->where('type', $type);
        }
        if($request->keyword != '') {
            $keyword = $request->keyword;
            $mod = $mod->where(function($query) use($keyword) {
                        return $query->where('ip_address', 'like', "%$keyword%")
                                    ->orWhere('description', 'like', "%$keyword%");
                    });
        }
        if($request->period != '') {
            $period = $request->get('period');
            $from = substr($period, 0, 10)." 00:00:00";
            $to = substr($period, 14, 10)." 23:59:59";
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }
        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.activity.index', compact('data', 'type', 'keyword', 'period'));
    }

    public function set_bonus(Request $request) {
        $win_player = User::all()->random();
        $amount = $request->amount;
        if($amount <= 0) return back()->withErrors(['bonus' => __('error.something_went_wrong')]);
        $auth_admin = Auth::guard('admin')->user();
        FreeBonus::create([
            'user_id' => $win_player->id,
            'amount' => $amount,
        ]);
        $before_score = $win_player->score;
        $win_player->increment('score', $amount);
        $after_score = $win_player->score;
        CreditTransaction::create([
            'sender_id' => $auth_admin->id,
            'sender_role' => 'admin',
            'receiver_id' => $win_player->id,
            'receiver_role' => 'user',
            'amount' => $amount,
            'before_score' => $before_score,
            'after_score' => $after_score ,
            'type' => 'bonus',
            'ip' => getIp(),
        ]);
        $message = 'Player '.$win_player->username." got free bonus ".$amount.".";
        return back()->with('bonus', $message)->with('success', __('words.successfully_set'));
    }

    public function bonus(Request $request) {
        config(['site.page' => 'bonus']);
        $mod = new FreeBonus();
        $player = $period = '';
        if($request->player != '') {
            $player = $request->player;
            $player_array = User::where('username', 'like', "%$player%")->pluck('id');
            $mod = $mod->whereIn('user_id', $player_array);
        }
        if($request->period != '') {
            $period = $request->get('period');
            $from = substr($period, 0, 10)." 00:00:00";
            $to = substr($period, 14, 10)." 23:59:59";
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.bonus.index', compact('data', 'player', 'period'));

    }
}
