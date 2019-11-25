<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;

use App\Models\Deposit;
use App\Models\Setting;
use App\Models\CreditTransaction;
use App\Models\BankAccount;
use App\Models\Bank;

use Auth;
use Hash;

class IndexController extends Controller
{
    use ValidationTrait;

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'home']);
        if(is_Mobile()){
            return redirect(route('wap.index'));
        } else {
            return view('web.index');
        }  
    }

    public function deposit() {
        config(['site.page' => 'deposit']);
        $deposit_flag = Setting::find(1)->deposit_flag;
        if(!$deposit_flag) return back()->withErrors(['deposit_flag' => __('error.deposit_flag_error')]);
        $auth_user = Auth::user();
        $bank_accounts = $auth_user->bank_accounts;
        $data = $auth_user->deposits()->orderBy('hk_at', 'desc')->paginate(10);

        return view('web.wallet.deposit', compact('data', 'bank_accounts'));
    }
    
    public function withdraw() {
        config(['site.page' => 'withdraw']);
        $auth_user = Auth::user();
        $banks = Bank::all();
        $data = $auth_user->withdraws()->orderBy('hk_at', 'desc')->paginate(10);
        return view('web.wallet.withdraw', compact('data', 'banks'));
    }
    public function transfer() {
        config(['site.page' => 'transfer']);
        $auth_user = Auth::user();
        $where_data = [
            'type' => 'player_agent',
            'sender_role' => 'user',
            'sender_id' => $auth_user->id,
        ];
        $data = CreditTransaction::where($where_data)->orderBy('created_at', 'desc')->paginate(5);

        return view('web.wallet.transfer', compact('data'));        
    }

    public function bank_account(Request $request) {
        config(['site.page' => 'bank_account']);
        $auth_user = Auth::user();
        $banks = Bank::all();
        $data = $auth_user->bank_accounts;
        return view('web.wallet.bank_account', compact('data', 'banks'));
    }

    public function casino(Request $request) {
        config(['site.page' => 'casino']);
        return view('web.game.casino');
    }
    public function hot_game(Request $request) {
        config(['site.page' => 'hot_game']);
        return view('web.game.hot_game');
    }
    public function lottery(Request $request) {
        config(['site.page' => 'lottery']);
        return view('web.game.lottery');
    }
    public function profile(Request $request) {
        config(['site.page' => 'profile']);
        return view('web.profile');
    }

    public function change_password(Request $request) {
        $request->validate([
            'password' => 'string|required|min:6|max:12|confirmed',
        ]);

        $auth_user = Auth::user();
        $auth_user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', __('words.successfully_set'));
    }

}
