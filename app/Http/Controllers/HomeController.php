<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {
        if(is_Mobile()){
            return redirect(route('login'));
        } else {
            return view('web.index');
        }       
    }
}
