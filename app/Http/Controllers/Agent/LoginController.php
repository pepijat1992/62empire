<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Agent Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating agents for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $guard = 'agent';

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
        $this->middleware('guest:agent')->except('logout');
    }     

    public function showLoginForm()
    {
        return view('auth.agent_login');
    } 

    public function login(Request $request)
    {
        if (auth()->guard('agent')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $agent = auth()->guard('agent')->user();
            $agent->update([
                'last_login_ip' => $_SERVER['REMOTE_ADDR'],
                'last_login_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect(route('agent.home'));
        }
        return back()->withErrors(['username' => 'Invalid username or password']);
    }

    public function logout()
    {
        Auth::guard('agent')->logout();
        return redirect()->guest('agent/login');
    }

    public function username()
    {
        return 'username';
    }
}
