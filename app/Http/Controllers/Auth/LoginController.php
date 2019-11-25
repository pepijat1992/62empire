<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        
        session(['login_status'], 'login');
        config(['site.page' => 'sign_in']);
        if(is_Mobile()) {
            return view('wap.login');
        } else {
            return view('web.login');
        }
        
    }

    public function showLoginVerificationForm()
    {
        session(['login_status'], 'login');
        config(['site.page' => 'sign_in']);
        config(['site.wap_footer' => 'sign_in']);
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        if(is_Mobile()) {
            return view('wap.login_verify');
        } else {
            return view('web.login_verify');
        }      
    } 

    public function login(Request $request)
    {        
        if($request->type == 'phone_number'){
            $request->session()->put('phone_number', $request->phone_number);
            $request->validate([
                'phone_number' => 'required',
            ]);        
            $phone_number = config('app.prefix_number') . $request->phone_number;
            if ($user = User::where('phone_number', $phone_number)->first()) {
                $login_ip = getIp();
                if(filter_var($user->register_ip, FILTER_VALIDATE_IP)){
                    if($user->register_ip != $login_ip){
                        return back()->withErrors(['error' => 'Invalid machine.']);
                    }
                }else{
                    $user->update(['register_ip' => $login_ip]);
                }
                $request->session()->put('verify:user:id', $user->id);

                $url = 'https://api.nexmo.com/verify/json?' . http_build_query([
                    'api_key' => env('NEXMO_KEY'),
                    'api_secret' => env('NEXMO_SECRET'),
                    'number' => $user->phone_number,
                    'brand' => config('app.name'),
                    'workflow_id' => '4',
                ]);

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $response = json_decode($response);
                if(isset($response->status) && $response->status == 0){
                    $request->session()->put('verify:request_id', $response->request_id);
                    $request->session()->put('login_status', 'verify');
                    return back()->with('success', __('words.already_sent_verification_code'));
                }else{
                    if(isset($response->error_text)){
                        return redirect(route('login'))->withErrors(['phone_number' => $response->error_text]);
                    }else{
                        return redirect(route('login'))->withErrors(['phone_number' => __('words.something_went_wrong')]);
                    }
                }
            }
            return back()->withErrors(['phone_number' => __('words.invalid_phone_number')]);
        } else {
            $phone_number = config('app.prefix_number') . $request->phone_number;
            if (auth()->attempt(['phone_number' => $phone_number, 'password' => $request->password])) {
                $user = auth()->user();
                $login_ip = getIp();
                if(filter_var($user->register_ip, FILTER_VALIDATE_IP)){
                    if($user->register_ip != $login_ip){
                        return back()->withErrors(['error' => 'Invalid machine.']);
                    }
                }else{
                    $user->update(['register_ip' => $login_ip]);
                }
                $user->update([
                    'last_login_ip' => $_SERVER['REMOTE_ADDR'],
                    'last_login_at' => date('Y-m-d H:i:s'),
                ]);
                return redirect(route('home'));
            }
            return back()->withErrors(['phone_number' => __('error.invalid_phone_number_or_password')]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url('/'));
    }
}
