<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\GameRecord;
use App\Models\Game;
use App\User;
use App\Agent;

use Auth;

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth.agent');
    }

    public function agent_report(Request $request, $id) {
        config(['site.page' => 'user']);
        $agent = Agent::find($id);
        $games = Game::all();
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        $game_id  = '';
        if($request->start_date != '') {
            $start_date = $request->start_date;
        }
        if($request->end_date != '') {
            $end_date = $request->end_date;
        }
        if($request->game_id != '') {
            $game_id = $request->game_id;
        }
        return view('agent.report.agent', compact('agent', 'games', 'start_date', 'end_date', 'game_id'));
    }

    public function user_report(Request $request, $id) {
        config(['site.page' => 'user']);
        $user = User::find($id);
        $games = Game::all();
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        $game_id  = '';
        if($request->start_date != '') {
            $start_date = $request->start_date;
        }
        if($request->end_date != '') {
            $end_date = $request->end_date;
        }
        if($request->game_id != '') {
            $game_id = $request->game_id;
        }
        return view('agent.report.user', compact('user', 'games', 'start_date', 'end_date', 'game_id'));
    }
}
