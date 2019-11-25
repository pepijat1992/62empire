<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Agent;
use App\Models\CreditTransaction;

use Auth;

class WapController extends Controller
{
    public function __construct(){
        $this->middleware('auth.agent');
    }

    public function index(Request $request) {
        $auth_agent = Auth::guard('agent')->user();
        $username = '';
        $mod = new User();
        if($request->username != '') {
            $username = $request->username;
            $mod = $mod->where('username', 'like', "%$username%");
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);

        return view('agent.wap.index', compact('data', 'username'));
    }

    public function player_transfer(Request $request, $id) {
        $auth_agent = Auth::guard('agent')->user();
        $user = User::find($id);
        $mod = new CreditTransaction();
        $mod = $mod->where('sender_role', 'user')
                ->where('sender_id', $id)
                ->where('receiver_role', 'agent')
                ->where('receiver_id', $auth_agent->id)
                ->where('type', 'player_agent');

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        return view('agent.wap.player_transfer', compact('data', 'user'));
    }

    
    public function set_player(Request $request, $id) {
        $auth_agent = Auth::guard('agent')->user();
        $user = User::find($id);
        $mod = new CreditTransaction();
        $where_data = [
            'sender_role' => 'agent',
            'sender_id' => $auth_agent->id,
            'receiver_role' => 'user',
            'receiver_id' => $id,
            'type' => 'agent_user',
        ];
        $mod = $mod->where($where_data);

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        return view('agent.wap.set_player', compact('data', 'user'));
    }
}
