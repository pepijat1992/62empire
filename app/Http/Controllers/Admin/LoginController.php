<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

use App\Models\AdminActivity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating admins for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $guard = 'admin';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }     

    public function showLoginForm()
    {        
        return view('auth.admin_login');
    } 

    public function login(Request $request)
    {
        if (auth()->guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $admin = auth()->guard('admin')->user();
            $admin->update([
                'last_login_ip' => $_SERVER['REMOTE_ADDR'],
                'last_login_at' => date('Y-m-d H:i:s'),
            ]);

            AdminActivity::create([
                'admin_id' => $admin->id,
                'type' => 'sign_in',
                'ip_address' => getIp(),
                'description' => "Sign in",
            ]);

            return redirect(route('admin.home'));
        }
        return back()->withErrors(['username' => 'Invalid username or password']);
    }

    public function logout()
    {
        $admin = Auth::guard('admin')->user();
        AdminActivity::create([
            'admin_id' => $admin->id,
            'type' => 'sign_out',
            'ip_address' => getIp(),
            'description' => "Sign Out",
        ]);
        Auth::guard('admin')->logout();
        return redirect()->guest('admin/login');
    }

    public function username()
    {
        return 'username';
    }
}
