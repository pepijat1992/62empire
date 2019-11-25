<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Promotion;

class GameController extends Controller
{
    public function casino(){
        config(['site.page' => 'casino']);
        return view('web.game.casino');
    }

    public function hot_game(){
        config(['site.page' => 'casino']);
        return view('web.game.hot_game');
    }

    public function lottery(){
        config(['site.page' => 'lottery']);
        return view('web.game.lottery');
    }
    
    public function promotion(){
        config(['site.page' => 'promotion']);
        $promotions = Promotion::all();
        if(is_Mobile()) {
            return view('wap.promotion', compact('promotions'));
        } else {
            return view('web.promotion', compact('promotions'));
        }        
    }
}
