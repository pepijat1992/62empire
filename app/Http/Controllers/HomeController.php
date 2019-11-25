<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {
        if(is_Mobile()){
            return view('wap.index');
        } else {
            return view('web.index');
        }       
    }
}
