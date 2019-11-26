<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class HomeController extends Controller
{
    public function index(Request $request) {
        if(Auth::user()){
            return redirect(route('home'));
        }
        return redirect(route('check_passcode'));      
    }
}
