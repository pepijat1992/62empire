<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class HomeController extends Controller
{
    public function index(Request $request) {
        if(Auth::user()){
            if(is_Mobile()) {
                return redirect(route('wap.index'));
            } else {
                return redirect(route('web.index'));
            }
        }
        return redirect(route('check_passcode'));      
    }
}