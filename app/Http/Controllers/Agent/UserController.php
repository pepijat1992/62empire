<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;

use App\Agent;
use App\User;
use App\Models\CreditTransaction;

use Auth;
use Hash;

class UserController extends Controller
{
    
    use ValidationTrait;
    
    public function __construct(){
        $this->middleware('auth.agent');
    }

    public function index(Request $request)
    {
        config(['site.page' => 'user']);
        $auth_agent = Auth::guard('agent')->user();
        $agent = $agent_id = $agent_keyword = $user_keyword = '';
        $mod_agent = $auth_agent->agents();
        $mod_user = $auth_agent->users();

        if($request->agent_id != '') {
            $agent_id = $request->agent_id;
            $agent = Agent::find($agent_id);
            $mod_agent = $agent->agents();
            $mod_user = $agent->users();
        }

        if($request->agent_keyword != '') {
            $agent_keyword = $request->agent_keyword;
            $mod_agent = $mod_agent->where(function($query) use($agent_keyword) {
                return $query->where('username', 'like', "%$agent_keyword%")
                            ->orWhere('name', 'like', "%$agent_keyword%")
                            ->orWhere('phone_number', 'like', "%$agent_keyword%")
                            ->orWhere('description', 'like', "%$agent_keyword%");
            });
        }
        
        if($request->user_keyword != '') {
            $user_keyword = $request->user_keyword;
            $mod_user = $mod_user->where(function($query) use($user_keyword) {
                return $query->where('username', 'like', "%$user_keyword%")
                            ->orWhere('name', 'like', "%$user_keyword%")
                            ->orWhere('phone_number', 'like', "%$user_keyword%")
                            ->orWhere('description', 'like', "%$user_keyword%");
            });
        }

        $data_agent = $mod_agent->orderBy('created_at', 'desc')->paginate(5, ['*'], 'agent');        
        $data_user = $mod_user->orderBy('created_at', 'desc')->paginate(10, ['*'], 'user');

        return view('agent.user.index', compact('data_agent', 'data_user', 'agent_id', 'agent', 'agent_keyword', 'user_keyword'));
    }

    public function create_agent(Request $request){

        $validator = $this->verify($request, 'agent.create_agent');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $auth_agent = Auth::guard('agent')->user();
        
        $agent = Agent::create([
                'username' => $request->get('username'),
                'name' => $request->get('name'),
                'phone_number' => $request->get('phone_number'),
                'score' => $request->get('score'),
                'agent_id' => $auth_agent->id,
                'description' => $request->get('description'),
                'password' => Hash::make($request->get('password'))
            ]);           
        $auth_agent->decrement('score', $request->score); 
        CreditTransaction::create([
            'sender_id' => $auth_agent->id,
            'sender_role' => 'agent',
            'receiver_id' => $agent->id,
            'receiver_role' => 'agent',
            'amount' => $request->score,
            'before_score' => 0,
            'after_score' => $request->score,
            'type' => 'agent_agent',
            'ip' => getIp(),
            'description' => 'add agent with score '.$request->score
        ]);
            
        return responseSuccess(__('words.created_successfully'));
    }

    public function edit_agent(Request $request){
        $validator = $this->verify($request, 'agent.edit_agent');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $agent = Agent::find($request->get("id"));        
        $agent->username = $request->get("username");
        $agent->name = $request->get("name");
        $agent->phone_number = $request->get("phone_number");
        $agent->description = $request->get("description");

        if($request->get('password') != ''){
            $agent->password = Hash::make($request->get('password'));
        }

        $agent->save();

        return responseSuccess(__('words.updated_successfully'));
    }
    
    public function delete_agent($id){
        Agent::destroy($id);
        return back()->with("success", __('words.deleted_successfully'));
    }

    public function create_user(Request $request){
        $validator = $this->verify($request, 'agent.create_user');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $auth_agent = Auth::guard('agent')->user();
        if($request->score > $auth_agent->score) {
            return responseWrong(['score' => [__('error.insufficient_balance')]]);
        }
        $user = User::create([
                'username' => $request->get('username'),
                'name' => $request->get('name'),
                'phone_number' => $request->get('phone_number'),
                'score' => $request->get('score') ? $request->get('score') : 0,
                'agent_id' => $auth_agent->id,
                'description' => $request->get('description'),
                'password' => Hash::make($request->get('password'))
            ]);
        $auth_agent->decrement('score', $request->score);
        CreditTransaction::create([
            'sender_id' => $auth_agent->id,
            'sender_role' => 'agent',
            'receiver_id' => $user->id,
            'receiver_role' => 'user',
            'amount' => $request->score,
            'before_score' => 0,
            'after_score' => $request->score,
            'type' => 'agent_user',
            'ip' => getIp(),
            'description' => 'add player with score '.$request->score
        ]);
            
        return responseSuccess(__('words.created_successfully'));
    }

    public function edit_user(Request $request){
        $validator = $this->verify($request, 'agent.edit_user');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $agent = User::find($request->get("id"));        
        $agent->username = $request->get("username");
        $agent->name = $request->get("name");
        $agent->phone_number = $request->get("phone_number");
        $agent->description = $request->get("description");

        if($request->get('password') != ''){
            $agent->password = Hash::make($request->get('password'));
        }

        $agent->save();

        return responseSuccess(__('words.updated_successfully'));
    }
    
    public function delete_user($id){
        User::destroy($id);
        return back()->with("success", __('words.deleted_successfully'));
    }    
    
    public function send_credit_down(Request $request) {
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
        ]);
        $agent = Auth::guard('agent')->user();
        if($request->role == 'agent') {
            $down = Agent::find($request->id);
            $down->increment('score', $request->amount);            
            $agent->decrement('score', $request->amount);            
            CreditTransaction::create([
                'sender_id' => $agent->id,
                'sender_role' => 'agent',
                'receiver_id' => $down->id,
                'receiver_role' => 'agent',
                'amount' => $request->amount,
                'type' => 'agent_agent',
                'ip' => getIp(),
            ]);
        }elseif ($request->role == 'user') {
            $user = User::find($request->id);
            $user->increment('score', $request->amount);          
            $agent->decrement('score', $request->amount);          
            CreditTransaction::create([
                'sender_id' => $agent->id,
                'sender_role' => 'agent',
                'receiver_id' => $user->id,
                'receiver_role' => 'user',
                'amount' => $request->amount,
                'type' => 'agent_user',
                'ip' => getIp(),
            ]);
        }

        return back()->with('success', __('words.successfully_set'));
    }

    public function send_credit_top(Request $request) {
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
        ]);
        $agent = Auth::guard('agent')->user();
        $agent->decrement('score', $request->amount);
        if($agent->agent){
            $top = $agent->agent;
            $top->increment('score', $request->amount);
            CreditTransaction::create([
                'sender_id' => $agent->id,
                'sender_role' => 'agent',
                'receiver_id' => $top->id,
                'receiver_role' => 'agent',
                'amount' => $request->amount,
                'type' => 'agent_topline',
                'ip' => getIp(),
            ]);
        }else{
            CreditTransaction::create([
                'sender_id' => $agent->id,
                'sender_role' => 'agent',
                'receiver_role' => 'admin',
                'amount' => $request->amount,
                'type' => 'agent_topline',
            ]);
        }        

        return back()->with('success', __('words.successfully_set'));
    }
    
    public function set_score(Request $request, $role, $id) {
        config(['site.page' => 'user']);
        $agent = Auth::guard('agent')->user();
        $mod = new CreditTransaction();
        $mod = $mod->where('sender_role', 'agent')->where('sender_id', $agent->id)->where('receiver_role', $role)->where('receiver_id', $id);
        if($role == 'agent') {
            $user = Agent::find($id);
        }else if($role == 'user') {
            $user = User::find($id);
        }
        $period = '';
        if($request->has('period') && $request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10)." 00:00:00";
            $to = substr($period, 14, 10)." 23:59:59";
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }
        $data = $mod->orderBy('created_at', 'desc')->paginate('15');
        $collection = $mod->get();
        $total_amount = $collection->sum('amount');
        return view('agent.user.set_score', compact('data', 'user', 'total_amount', 'period'));
    }

    public function save_score(Request $request) {
        $request->validate([
            'amount' => 'required'
        ]);
        $auth_agent = Auth::guard('agent')->user();
        $max = $auth_agent->score;
        if($request->amount > $max){
            return back()->withErrors(['amount' => 'You can not set greater than '.strval($max)]);
        }
        if($request->role == 'agent'){
            $agent = Agent::find($request->id);
            $before_score = $agent->score;
            $min = -1 * $before_score;
            if($request->amount < $min){
                return back()->withErrors(['amount' => 'You can not set less than '.strval($min)]);
            }
            $agent->increment('score', $request->amount);
            $auth_agent->decrement('score', $request->amount);
            $after_score = $agent->score;
            CreditTransaction::create([
                'sender_id' => $auth_agent->id,
                'sender_role' => 'agent',
                'receiver_id' => $agent->id,
                'receiver_role' => 'agent',
                'amount' => $request->amount,
                'before_score' => $before_score,
                'after_score' => $after_score,
                'type' => 'agent_agent',
                'ip' => getIp(),
            ]);
        }else if($request->role == 'user'){
            $user = User::find($request->id);
            $before_score = $user->score;
            $min = -1 * $user->score;
            if($request->amount < $min){
                return back()->withErrors(['amount' => 'You can not set less than '.strval($min)]);
            }
            $user->increment('score', $request->amount);
            $auth_agent->decrement('score', $request->amount);
            $after_score = $user->score;
            CreditTransaction::create([
                'sender_id' => $auth_agent->id,
                'sender_role' => 'agent',
                'receiver_id' => $user->id,
                'receiver_role' => 'user',
                'amount' => $request->amount,
                'before_score' => $before_score,
                'after_score' => $after_score,
                'type' => 'agent_user',
                'ip' => getIp(),
            ]);
        }
        return back()->with('success', __('words.successfully_set'));
    }
}
