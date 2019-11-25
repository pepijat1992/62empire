<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;

use App\Models\Withdraw;
use App\Models\CreditTransaction;
use App\Models\AdminActiity;
use App\User;

use Auth;

class WithdrawController extends Controller
{
    use ValidationTrait;
    
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index(Request $request) {
        config(['site.page' => 'withdraw']);

        $mod = new Withdraw();
        $user = $period = '';
        if($request->user != '') {
            $user = $request->user;
            $user_array = User::where('username', 'like', "%$user%")
                                ->orWhere('phone_number', 'like', "%$user%")->pluck('id');
            $mod =  $mod->whereIn('user_id', $user_array);
        }       
        
        if($request->has('period') && $request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10)." 00:00:00";
            $to = substr($period, 14, 10)." 23:59:59";
            $mod = $mod->whereBetween('hk_at', [$from, $to]);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        $collection = $mod->get();
        $total_amount = $collection->sum('amount');
        $total_fee = $collection->sum('counter_fee');
        
        return view('admin.withdraw.index', compact('data', 'total_amount', 'total_fee', 'user', 'period'));
    }

    public function confirm(Request $request) {
        $item = Withdraw::find($request->get('id'));
        $item->update([
            'amount' => $request->get('amount'),
            'counter_fee' => $request->get('fee') ? $request->get('fee') : 0,
            'confirm_at' => date('Y-m-d H:i:s'),
            'admin_id' => Auth::guard('admin')->user()->id,
            'status' => 2,
        ]);
        $player = $item->user;
        $admin = Auth::guard('admin')->user();
        $before_score = $player->score;
        $player->decrement('score', $request->amount); 
        $after_score = $player->score;  
        CreditTransaction::create([
            'sender_id' => $admin->id,
            'sender_role' => 'admin',
            'receiver_id' => $player->id,
            'receiver_role' => 'user',
            'before_score' => $before_score,
            'after_score' => $after_score,
            'amount' => $request->amount,
            'type' => 'player_withdraw',
            'ip' => getIp(),
        ]);
        // if($request->counter_fee > 0) {
        //     $before_score = $player->score;
        //     $player->decrement('score', $request->counter_fee);   
        //     $after_score = $player->score;     
        //     CreditTransaction::create([
        //         'sender_id' => $admin->id,
        //         'sender_role' => 'admin',
        //         'receiver_id' => $player->id,
        //         'receiver_role' => 'user',
        //         'amount' => $request->counter_fee,
        //         'before_score' => $before_score,
        //         'after_score' => $after_score,
        //         'type' => 'fee',
        //         'ip' => getIp(),
        //     ]);
        // }
        
        AdminActivity::create([
            'admin_id' => $admin->id,
            'type' => 'confirm_withdraw',
            'ip_address' => getIp(),
            'description' => "Confirm Withdraw -- Player : " . $player->username . ", Amount: " . $request->amount ,
        ]);

        return back()->with('success', __('words.successfully_set'));
    }

    public function fail(Request $request) {
        $item = Withdraw::find($request->get('id'));
        $auth_admin = Auth::guard('admin')->user();
        $item->update([
            'fail_reason' => $request->fail_reason,
            'admin_id' => $auth_admin->id,
            'status' => 0,
        ]);

        AdminActivity::create([
            'admin_id' => $auth_admin->id,
            'type' => 'reject_withdraw',
            'ip_address' => getIp(),
            'description' => "Reject Withdraw -- Player : " . $item->user->username . ", Amount: " . $item->amount ,
        ]);

        return back()->with('success', __('words.successfully_set'));
    }
}
