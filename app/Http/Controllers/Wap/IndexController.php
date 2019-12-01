<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;

use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\CreditTransaction;
use App\Models\Game;
use App\Models\GameUser;
use App\Models\Setting;
use App\Models\Promotion;
use App\Models\Memo;

use Auth;
use Hash;
use Imagick;

class IndexController extends Controller
{
    use ValidationTrait;

    public function __construct() {
        $this->middleware('auth');
    }

    public function home()
    {        
        config(['site.wap_footer' => 'me']);
        return view('wap.home');
    }

    public function index()
    {        
        config(['site.wap_footer' => 'me']);
        return view('wap.index');
    }

    public function online_deposit() {
        config(['site.wap_footer' => 'me']);
        $deposit_flag = Setting::find(1)->deposit_flag;
        if(!$deposit_flag) return back()->withErrors(['deposit_flag' => __('error.deposit_flag_error')]);
        $user = Auth::user();
        $bank_accounts = $user->bank_accounts;
        return view('wap.online_deposit', compact('bank_accounts'));
    }

    public function post_online_deposit(Request $request) {
        $deposit_flag = Setting::find(1)->deposit_flag;
        if(!$deposit_flag) return back()->withErrors(['deposit_flag' => __('error.deposit_flag_error')]);
        $request->validate([
            'bank_account' => 'required',
            'amount' => 'required',
            'receipt' => 'required|file|image',
        ]);
        $data = $request->all();
        $user = Auth::user();
        
        $promotion_amount = 0;
        if ($data['promotion_id']) {
            $promotion = Promotion::find($data['promotion_id']);
            $promotion_rate = $promotion->rate;
            if($promotion_rate) {
                $promotion_amount = $data['amount'] * $promotion_rate / 100;
            } else {
                $promotion_amount = $promotion->amount;
            }            
        }
        $booking_image = '';
        if($request->has("receipt")){
            $picture = request()->file('receipt');
            $imageName = "deposit_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/deposit_images/'), $imageName);
            $booking_image = 'images/uploaded/deposit_images/'.$imageName;
        }
        

        Deposit::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'amount' => $data['amount'],
            'promotion_amount' => $promotion_amount,
            'promotion_id' => $data['promotion_id'],
            'bank_account_id' => $data['bank_account'],
            'status' => 1,
            'image'  => $booking_image,
            'hk_at' => date('Y-m-d H:i:s'),
        ]);

        return back()->with('success', __('words.successfully_set'));

    }

    public function bank_account(Request $request) {
        config(['site.wap_footer' => 'me']);
        $user = Auth::user();
        $banks = Bank::all();
        $data = $user->bank_accounts;
        return view('wap.bank_account', compact('data', 'banks'));
    }

    public function create_bank_account(Request $request) {
        $request->validate([
            'bank' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
        ]);
        $user = Auth::user();
        BankAccount::create([
            'bank_id' => $request->bank,
            'user_id' => $user->id,
            'account_name' => $request->account_name,
            'account_no' => $request->account_no,
        ]);
        if($request->page == 'withdraw'){
            return redirect(route('wap.online_withdraw'))->with('success', __('created_successfully'));
        }else{
            return back()->with('success', __('words.successfully_set'));
        }
    }

    public function edit_bank_account(Request $request) {
        $request->validate([
            'bank' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
        ]);
        $user = Auth::user();
        $id = $request->get('id');
        $item = BankAccount::find($id);
        $item->update([
            'account_name' => $request->account_name,
            'account_no' => $request->account_no,
        ]);
        return back()->with('success', __('words.updated_successfully'));
    }

    public function delete_bank_account($id) {
        BankAccount::destroy($id);
        return back()->with('success', __('words.deleted_successfully'));
    }

    public function online_withdraw() {
        config(['site.wap_footer' => 'me']);
        $withdraw_flag = Setting::find(1)->withdraw_flag;
        if(!$withdraw_flag) return back()->withErrors(['withdraw_flag' => __('error.withdraw_flag_error')]);
        $user = Auth::user();
        $banks = Bank::all();
        $bank_accounts = $user->bank_accounts;
        // if($bank_accounts->isEmpty()){
        //     $page = 'withdraw';
        //     return view('wap.add_bank_account', compact('banks', 'page'));
        // }else{
            return view('wap.online_withdraw', compact('banks'));
        // }        
    }

    public function post_online_withdraw(Request $request) {
        $request->validate([
            'bank' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'amount' => 'required',
        ]);
        $user = Auth::user();
        Withdraw::create([
            'bank_id' => $request->bank,
            'account_name' => $request->account_name,
            'account_no' => $request->account_no,
            'amount' => $request->amount,
            'user_id' => $user->id,
            'hk_at' => date('Y-m-d H:i:s'),
            'status' => 1,
        ]);

        return back()->with('success', __('words.successfully_set'));
    }

    public function change_password(Request $request) {
        $validator = $this->verify($request, 'wap.change_password');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $data = $request->all();
        $user = Auth::user();
        // if (!Hash::check($data['old_password'], $user->password)) {
        //     // return response()->json(['error' => 'Current password does not match.']);
        //     return responseWrong(['old_password' => ['Current password does not match.']]);
        // }

        $user->password = Hash::make($data['password']);
        $user->save();
        return responseSuccess(__('words.updated_successfully'));
    }

    public function change_name(Request $request) {
        $validator = $this->verify($request, 'wap.change_name');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $data = $request->all();
        $user = Auth::user();
        $user->name = $data['name'];
        $user->save();
        return responseSuccess(__('words.updated_successfully'));
    }

    public function change_passcode(Request $request) {
        $validator = $this->verify($request, 'wap.change_passcode');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }
        $data = $request->all();
        $user = Auth::user();
        $user->passcode = $data['passcode'];
        $user->save();
        return responseSuccess(__('words.updated_successfully'));
    }

    public function transfer_credit(Request $request) {
        $request->validate([
            'amount' => 'required|min:0',
        ]);
        $user = Auth::user();
        $agent = $user->agent;
        if(!$agent) return back()->withErrors(['agent' => __('error.no_agent')]);
        $agent->increment('score', $request->amount);
        $user->decrement('score', $request->amount);
        CreditTransaction::create([
            'sender_id' => $user->id,
            'sender_role' => 'user',
            'receiver_id' => $agent->id,
            'receiver_role' => 'agent',
            'amount' => $request->amount,
            'type' => 'player_agent',
            'ip' => getIp(),
        ]);
        return back()->with('success', __('words.successfully_set'));
    }

    public function game($id){
        $game = Game::find($id);
        $auth_user = Auth::user();
        return view('wap.game.index', compact('game', 'game_account'));
    }

    public function read_bonus(Request $request) {
        $auth_user = Auth::user();
        $auth_user->free_bonuses()->update([
            'status' => 1,
        ]);
        echo "success";
    }

    public function memo(Request $request) {
        config(['site.wap_footer' => 'me']);
        return view('wap.memo');
    }

}
