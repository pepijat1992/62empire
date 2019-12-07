<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;

use App\Agent;
use App\User;
use App\Models\CreditTransaction;
use App\Models\AdminActivity;
use App\Models\Setting;

use Auth;
use Hash;

class UserController extends Controller
{
    
    use ValidationTrait;
    
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index(Request $request)
    {
        config(['site.page' => 'user']);
        $admin = Auth::guard('admin')->user();
        $agent = $agent_id = $agent_keyword = $user_keyword = '';
        $mod_agent = new Agent();
        $mod_user = new User();

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

        return view('admin.user.index', compact('data_agent', 'data_user', 'agent_id', 'agent', 'agent_keyword', 'user_keyword'));
    }

    public function create_agent(Request $request){

        $validator = $this->verify($request, 'admin.create_agent');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }   

        $phone_number = $request->get('phone_number');
        $prefix_number = env('PREFIX_NUMBER');

        if(substr($phone_number, 0, 3) != $prefix_number){
            $phone_number = $prefix_number . $phone_number;
        }
        
        $agent = Agent::create([
                'username' => $request->get('username'),
                'name' => $request->get('name'),
                'phone_number' => $phone_number,
                'rate' => $request->get('rate') ? $request->get('rate') : 0,
                'score' => $request->get('score') ? $request->get('score') : 0,
                'agent_id' => $request->get('agent_id'),
                'description' => $request->get('description'),
                'password' => Hash::make($request->get('password')),
                'passcode' => Setting::find(1)->first_passcde,
            ]);
        $admin = Auth::guard('admin')->user();
        CreditTransaction::create([
            'sender_id' => $admin->id,
            'sender_role' => 'admin',
            'receiver_id' => $agent->id,
            'receiver_role' => 'agent',
            'amount' => $request->score,
            'type' => 'admin_agent',
            'ip' => getIp(),
        ]); 
        
        AdminActivity::create([
            'admin_id' => $admin->id,
            'type' => 'create_agent',
            'ip_address' => getIp(),
            'description' => "Create Agent -- " . $agent->username . ", Score : " . $request->score ,
        ]);
            
        return responseSuccess(__('words.created_successfully'));
    }

    public function edit_agent(Request $request){
        $validator = $this->verify($request, 'admin.edit_agent');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $agent = Agent::find($request->get("id"));        
        $agent->username = $request->get("username");
        $agent->name = $request->get("name");
        $agent->passcode = $request->get("passcode");
        $agent->phone_number = $request->get("phone_number");
        $agent->description = $request->get("description");
        $agent->rate = $request->get("rate") ? $request->get("rate") : 0;

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

        $validator = $this->verify($request, 'admin.create_user');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $score = $request->get('score') ? $request->get('score') : 0;
            
        $phone_number = $request->get('phone_number');
        $prefix_number = env('PREFIX_NUMBER');

        if(substr($phone_number, 0, 3) != $prefix_number){
            $phone_number = $prefix_number . $phone_number;
        }

        $user = User::create([
                'username' => $request->get('username'),
                'name' => $request->get('name'),
                'phone_number' => $phone_number,
                'score' => $score,
                'agent_id' => $request->get('agent_id'),
                'description' => $request->get('description'),
                'password' => Hash::make($request->get('password')),
                'passcode' => Setting::find(1)->first_passcde,
            ]);
        $admin = Auth::guard('admin')->user();
        if($request->score > 0){
            CreditTransaction::create([
                'sender_id' => $admin->id,
                'sender_role' => 'admin',
                'receiver_id' => $user->id,
                'receiver_role' => 'user',
                'amount' => $score,
                'type' => 'admin_user',
                'ip' => getIp(),
            ]);
        } 
        
        AdminActivity::create([
            'admin_id' => $admin->id,
            'type' => 'create_player',
            'ip_address' => getIp(),
            'description' => "Create Player -- " . $user->username . ", Score : " . $score ,
        ]);     
            
        return responseSuccess(__('words.created_successfully'));
    }

    public function edit_user(Request $request){
        $validator = $this->verify($request, 'admin.edit_user');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $agent = User::find($request->get("id"));        
        $agent->username = $request->get("username");
        $agent->name = $request->get("name");
        $agent->passcode = $request->get("passcode");
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

    public function set_score(Request $request, $role, $id) {
        config(['site.page' => 'user']);
        $mod = new CreditTransaction();
        $mod = $mod->where('sender_role', 'admin')->where('receiver_role', $role)->where('receiver_id', $id);
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
        return view('admin.user.set_score', compact('data', 'user', 'total_amount', 'period'));
    }

    public function send_credit(Request $request) {
        $request->validate([
            'id' => 'required',
            'role' => 'required',
            'amount' => 'required|numeric',
        ]);
        $admin = Auth::guard('admin')->user();
        if($request->role == 'agent') {
            $agent = Agent::find($request->id);
            $min = -1 * $agent->score;
            if($request->amount < $min){
                return back()->withErrors(['amount' => 'You can not set less than '.strval($min)]);
            }
            $agent->increment('score', $request->amount);            
            CreditTransaction::create([
                'sender_id' => $admin->id,
                'sender_role' => 'admin',
                'receiver_id' => $agent->id,
                'receiver_role' => 'agent',
                'amount' => $request->amount,
                'type' => 'admin_agent',
                'ip' => getIp(),
            ]);
        }elseif ($request->role == 'user') {
            $user = User::find($request->id);
            $min = -1 * $user->score;
            if($request->amount < $min){
                return back()->withErrors(['amount' => 'You can not set less than '.strval($min)]);
            }
            $user->increment('score', $request->amount);          
            CreditTransaction::create([
                'sender_id' => $admin->id,
                'sender_role' => 'admin',
                'receiver_id' => $user->id,
                'receiver_role' => 'user',
                'amount' => $request->amount,
                'type' => 'admin_user',
                'ip' => getIp(),
            ]);
        }

        return back()->with('success', __('words.successfully_set'));
    }

    public function save_score(Request $request) {
        $request->validate([
            'amount' => 'required'
        ]);
        $admin = Auth::guard('admin')->user();
        if($request->role == 'agent'){
            $agent = Agent::find($request->id);
            $before_score = $agent->score;
            $min = -1 * $before_score;
            if($request->amount < $min){
                return back()->withErrors(['amount' => 'You can not set less than '.strval($min)]);
            }
            $agent->increment('score', $request->amount);
            $after_score = $agent->score;
            CreditTransaction::create([
                'sender_id' => $admin->id,
                'sender_role' => 'admin',
                'receiver_id' => $agent->id,
                'receiver_role' => 'agent',
                'amount' => $request->amount,
                'before_score' => $before_score,
                'after_score' => $after_score,
                'type' => 'admin_agent',
                'ip' => getIp(),
            ]);
            
            AdminActivity::create([
                'admin_id' => $admin->id,
                'type' => 'set_score',
                'ip_address' => getIp(),
                'description' => "Set score to agent -- " . $agent->username . ", Amount : " . $request->amount ,
            ]);
        }else if($request->role == 'user'){
            $user = User::find($request->id);
            $before_score = $user->score;
            $min = -1 * $user->score;
            if($request->amount < $min){
                return back()->withErrors(['amount' => 'You can not set less than '.strval($min)]);
            }
            $user->increment('score', $request->amount);
            $after_score = $user->score;
            CreditTransaction::create([
                'sender_id' => $admin->id,
                'sender_role' => 'admin',
                'receiver_id' => $user->id,
                'receiver_role' => 'user',
                'amount' => $request->amount,
                'before_score' => $before_score,
                'after_score' => $after_score,
                'type' => 'admin_user',
                'ip' => getIp(),
            ]);
            
            AdminActivity::create([
                'admin_id' => $admin->id,
                'type' => 'set_score',
                'ip_address' => getIp(),
                'description' => "Set score to player -- " . $user->username . ", Amount : " . $request->amount ,
            ]);
        }
        return back()->with('success', __('words.successfully_set'));
    }
}
