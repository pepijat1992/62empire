<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;

use App\Models\Withdraw;
use App\Models\CreditTransaction;
use App\User;

use Auth;

class WithdrawController extends Controller
{
    use ValidationTrait;
    
    public function __construct(){
        $this->middleware('auth.agent');
    }

    public function index(Request $request) {
        config(['site.page' => 'withdraw']);
        $auth_agent = Auth::guard('agent')->user();
        $user_array = $auth_agent->users->pluck('id');
        $mod = new Withdraw();
        $mod = $mod->whereIn('user_id', $user_array);
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
        
        return view('agent.withdraw.index', compact('data', 'total_amount', 'total_fee', 'user', 'period'));
    }
}
