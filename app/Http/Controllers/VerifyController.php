<?php

namespace App\Http\Controllers;

use App;
use Auth;
use Nexmo;
use Illuminate\Http\Request;

use App\User;

class VerifyController extends Controller
{
    public function show(Request $request) {
        return view('auth.phone_verify');
    }

    public function login_verify(Request $request) {
        $this->validate($request, [
            'code' => 'size:4',
        ]);
        $url = 'https://api.nexmo.com/verify/check/json?' . http_build_query([
            'api_key' => env('NEXMO_KEY'),
            'api_secret' => env('NEXMO_SECRET'),
            'request_id' => $request->session()->get('verify:request_id'),
            'code' => $request->code
        ]);
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);
        if(isset($response->status) && $response->status == 0){
            Auth::loginUsingId($request->session()->pull('verify:user:id'));
            session()->forget('login_status');            
            Auth::user()->update([
                'last_login_ip' => $_SERVER['REMOTE_ADDR'],
                'last_login_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect('/home');
        }else{
            if(isset($response->error_text)){
                return redirect(route('login'))->withErrors(['code' => $response->error_text]);
            }else{
                return redirect(route('login'))->withErrors(['code' => __('words.something_went_wrong')]);
            }            
        }
    }
    
    public function register_verify(Request $request) {
        $this->validate($request, [
            'code' => 'size:4',
            'phone_number' => 'required',
        ]);
        $url = 'https://api.nexmo.com/verify/check/json?' . http_build_query([
            'api_key' => env('NEXMO_KEY'),
            'api_secret' => env('NEXMO_SECRET'),
            'request_id' => $request->session()->get('verify:request_id'),
            'code' => $request->code
        ]);
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);
        if($response->status == 0){            
            if($request->phone_number != ''){
                $phone_number = config('app.prefix_number').$request->phone_number;
            }else{
                $phone_number = $request->session()->get('phone_number');
            }
            $agent_id = $request->session()->pull('agent_id');
            $user = User::create([
                'username' => substr($phone_number, 3),
                'phone_number' => $phone_number,
                'agent_id' => $agent_id,
                'register_ip' => getIp(),
            ]);
            session()->forget('phone_number');
            session()->forget('register_status');
            Auth::login($user);
            $user->update([
                'last_login_ip' => $_SERVER['REMOTE_ADDR'],
                'last_login_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect('/home');
        }else{
            return redirect(route('register'))->withErrors(['code' => $response->error_text]);
        }
    }

    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
