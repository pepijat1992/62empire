<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;

use App\Models\Deposit;
use App\Models\CreditTransaction;
use App\Models\AdminActivity;
use App\User;

use Auth;

class DepositController extends Controller
{
    use ValidationTrait;
    
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index(Request $request) {
        config(['site.page' => 'deposit']);

        $mod = new Deposit();
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
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        $collection = $mod->get();
        $total_amount = $collection->sum('amount');
        $total_bonus = $collection->sum('bonus');
        
        return view('admin.deposit.index', compact('data', 'total_amount', 'total_bonus', 'user', 'period'));
    }

    public function confirm(Request $request) {
        $item = Deposit::find($request->get('id'));
        $bonus = $request->bonus ?? 0;
        $promotion_amount = $request->promotion_amount ?? 0;
        $item->update([
            'amount' => $request->get('amount'),
            'bonus' => $bonus,
            'promotion_amount' => $promotion_amount,
            'confirm_at' => date('Y-m-d H:i:s'),
            'admin_id' => Auth::guard('admin')->user()->id,
            'status' => 2,
        ]);
        $player = $item->user;
        $admin = Auth::guard('admin')->user();
        $before_score = $player->score;
        $player->increment('score', $request->amount); 
        $after_score = $player->score;  
        CreditTransaction::create([
            'sender_id' => $admin->id,
            'sender_role' => 'admin',
            'receiver_id' => $player->id,
            'receiver_role' => 'user',
            'before_score' => $before_score,
            'after_score' => $after_score,
            'amount' => $request->amount,
            'type' => 'player_deposit',
            'ip' => getIp(),
        ]);

        if($bonus > 0) {
            $before_score = $player->score;
            $player->increment('score', $request->bonus);   
            $after_score = $player->score;
            CreditTransaction::create([
                'sender_id' => $admin->id,
                'sender_role' => 'admin',
                'receiver_id' => $player->id,
                'receiver_role' => 'user',
                'amount' => $request->bonus,
                'before_score' => $before_score,
                'after_score' => $after_score,
                'type' => 'bonus',
                'ip' => getIp(),
            ]);
        }

        $activity_description = "Confirm Deposit -- Player : " . $player->username . ", Amount: " . $request->amount . ", Bonus : " . $bonus;

        if($promotion_amount > 0) {
            $before_score = $player->score;
            $player->increment('score', $promotion_amount);   
            $after_score = $player->score;
            CreditTransaction::create([
                'sender_id' => $admin->id,
                'sender_role' => 'admin',
                'receiver_id' => $player->id,
                'receiver_role' => 'user',
                'amount' => $promotion_amount,
                'before_score' => $before_score,
                'after_score' => $after_score,
                'type' => 'promotion',
                'ip' => getIp(),
                'description' => $item->promotion->title ?? '',
            ]);
            $activity_description .= ", Promotion (". $item->promotion->title . ") : " . $promotion_amount;
        }
        
        AdminActivity::create([
            'admin_id' => $admin->id,
            'type' => 'confirm_deposit',
            'ip_address' => getIp(),
            'description' =>  $activity_description,
        ]);
        
        return back()->with('success', __('words.successfully_set'));
    }

    public function fail(Request $request) {
        $item = Deposit::find($request->get('id'));
        $auth_admin = Auth::guard('admin')->user();
        $item->update([
            'fail_reason' => $request->fail_reason,
            'admin_id' => $auth_admin->id,
            'status' => 0,
        ]);

        AdminActivity::create([
            'admin_id' => $auth_admin->id,
            'type' => 'reject_deposit',
            'ip_address' => getIp(),
            'description' => "Reject Deposit -- Player : " . $item->user->username . ", Amount: " . $item->amount ,
        ]);

        return back()->with('success', __('words.successfully_set'));
    }
}
