<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Agent;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showRegisterForm(){
        session(['register_status'], 'register');
        config(['site.page' => 'sign_up']);
        if(is_Mobile()) {
            return view('wap.register');
        } else {
            return view('web.register');
        }
    }

    public function register(Request $request){
        $agent = Agent::where('username', $request->agent_id)->first();
        if (!$agent) {
            return back()->withErrors(['agent' => __('error.no_agent')]);
        }
        $request->session()->put('phone_number', $request->phone_number);
        $request->session()->put('agent', $request->agent_id);
        $request->validate([
            'phone_number' => 'required',
        ]);        
        $phone_number = config('app.prefix_number') . $request->phone_number;
        if (User::where('phone_number', $phone_number)->first()) {
            return back()->withErrors(['phone_number' => __('words.phone_number_already_taken')]);
        } else {
            $register_ip = getIp();
            if(User::where('register_ip', $register_ip)->first()){
                return back()->withErrors(['ip_address' => __('words.device_already_taken')]);
            }
            
            $url = 'https://api.nexmo.com/verify/json?' . http_build_query([
                'api_key' => env('NEXMO_KEY'),
                'api_secret' => env('NEXMO_SECRET'),
                'number' => $phone_number,
                'brand' => config('app.name'),
                'workflow_id' => '4',
            ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $response = json_decode($response);
            // dd($response);
            if($response->status == 0){
                $request->session()->put('verify:request_id', $response->request_id);
                $request->session()->put('register_status', 'verify');
                $request->session()->put('agent_id', $agent->id);
                return back()->with('success', __('words.already_sent_verification_code'));
            }elseif($response->status == 3){
                return redirect(route('register'))->withErrors(['phone_number' => __('words.invalid_phone_number')]);
            }else {
                return redirect(route('register'))->withErrors(['phone_number' => __('words.something_went_wrong')]);                
            }
        }        
    }
}
