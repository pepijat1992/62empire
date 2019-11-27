<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Game;
use App\Models\GameUser;
use App\Models\GameTransaction;
use Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class GameController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('mega888_callback');
    }

    public function index(Request $request) {        
        config(['site.wap_footer' => 'game']); 

        $data = Game::all();
        if(is_Mobile()) {
            return view('wap.games', compact('data'));
        } else {
            return view('web.games', compact('data'));
        }
    }

    public static function datalog($content){
        $filename = storage_path() . '\\datalogs\\datalogs.log';
        
        if ($handle = fopen($filename, 'a')) {
            if (fwrite($handle, $content . " \n") === FALSE) {
                return FALSE;
            }
            fclose($handle);
            return TRUE;
        }
        return FALSE;
    }

    public function open($id) {
        

        // $client = new Client();
        // $request = $client->get('https://m.918kiss.agency/getApp.htm?v=5');
        // $response = $request->getBody();
        // dump(json_decode($response));

        config(['site.wap_footer' => 'game']);
        $game = Game::find($id);
        switch ($game->name) {
            case 'gi998':
                $game_account = $this->gi998();
                break;

            case 'scr2':
                $game_account = $this->scr2();
                break;

            case 'xe88':
                $game_account = $this->xe88();
                break;

            case 'mega888':
                $game_account = $this->mega888();
                break;

            case 'goldenf':
                $game_account = $this->goldenf();
                break;
                
            case 'pussy888':
                $game_account = $this->pussy888();
                break;
                
            case 'playtech':
                $game_account = $this->playtech();
                break;
                
            case '918kiss':
                $game_account = $this->api918();
                break;
                
            case 'joker':
                $game_account = $this->joker();
                break;
            
            default:
                return back()->withErrors(['error' => __('error.something_went_wrong')]);
                break;
        }
        if($game_account == 'error') {
            return back()->withErrors(['error' => __('error.something_went_wrong')]);
        }
        if(is_Mobile()) {
            return view('wap.game.index', compact('game', 'game_account'));
        } else {
            return view('web.game.index', compact('game', 'game_account'));
        }
    }

    public function deposit(Request $request) {
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
        ]);
        $amount = strval(abs($request->amount));
        $game = Game::find($request->id);
        $auth_user = Auth::user();
        if($amount > $auth_user->score) {return response()->json('insufficient_balance');}
        switch ($game->name) {
            case 'gi998':
                $result = $this->gi998_update_balance('deposit', $amount);
                break;
            
            case 'scr2':
                $result = $this->scr2_deposit($amount);
                break;
            
            case 'xe88':
                $result = $this->xe88_deposit($amount);
                break;
            
            case 'goldenf':
                $result = $this->goldenf_deposit($amount);
                break;

            case 'mega888':
                $result = $this->mega888_set_score('deposit', $amount);
                break;

            case 'pussy888':
                $result = $this->pussy888_set_score('deposit', $amount);
                break;

            case 'playtech':
                $result = $this->playtech_set_score('deposit', $amount);
                break;

            case '918kiss':
                $result = $this->api918_set_score('deposit', $amount);
                break;

            case 'joker':
                $result = $this->joker_set_score('deposit', $amount);
                break;
            
            default:
                return response()->json('error');
                break;
        }
        if($result == 'success') {
            return response()->json('success');
        }else {
            return response()->json('error');
        }
    }

    public function withdraw(Request $request) {
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
        ]);
        $amount = strval(abs($request->amount));
        $game = Game::find($request->id);
        switch ($game->name) {
            case 'gi998':
                $result = $this->gi998_update_balance('withdraw', $amount);
                break;
            
            case 'scr2':
                $result = $this->scr2_withdraw($amount);
                break;
            
            case 'xe88':
                $result = $this->xe88_withdraw($amount);
                break;
            
            case 'goldenf':
                $result = $this->goldenf_withdraw($amount);
                break;

            case 'pussy888':
                $result = $this->pussy888_set_score('withdraw', $amount);
                break;

            case 'mega888':
                $result = $this->mega888_set_score('withdraw', $amount);
                break;

            case 'playtech':
                $result = $this->playtech_set_score('withdraw', $amount);
                break;

            case '918kiss':
                $result = $this->api918_set_score('withdraw', $amount);
                break;

            case 'joker':
                $result = $this->joker_set_score('withdraw', $amount);
                break;
            
            default:
                return response()->json('error');
                break;
        }
        if($result == 'success') {
            return response()->json('success');
        }else {
            return response()->json('error');
        }
    }

    public function total_deposit($id) {
        $game = Game::find($id);
        $auth_user = Auth::user();
        $amount = $auth_user->score;
        if($amount == 0) return "success";
        switch ($game->name) {
            case 'gi998':
                $result = $this->gi998_update_balance('deposit', $amount);
                break;
            
            case 'scr2':
                $result = $this->scr2_deposit($amount);
                break;
            
            case 'xe88':
                $result = $this->xe88_deposit($amount);
                break;
            
            case 'goldenf':
                $result = $this->goldenf_deposit($amount);
                break;

            case 'pussy888':
                $result = $this->pussy888_set_score('deposit', $amount);
                break;
            
            default:
                return response()->json('error');
                break;
        }
        if($result == 'success') {
            return 'success';
        }else {
            return 'error';
        }
    }

    public function total_get_balance($id) {
        $game = Game::find($id);
        switch ($game->name) {
            case 'gi998':
                $result = $this->gi998_get_balance();
                break;
            
            case 'scr2':
                $result = $this->scr2_get_player_info();
                break;            
            
            case 'xe88':
                $result = $this->xe88_player_info();
                break;
            
            case 'goldenf':
                $result = $this->goldenf_get_balance();
                break;
            
            case 'pussy888':
                $result = $this->pussy888_player_info();
                break;
            
            default:
                $result = 'error';
                break;
        }
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $balance = $game_account->balance;
        return $balance;
    }

    public function total_withdraw(Request $request) {
        $game = Game::find($request->id);
        $amount = $this->total_get_balance($game->id);
        if($amount == 0) return response()->json('success');
        switch ($game->name) {
            case 'gi998':
                $result = $this->gi998_update_balance('withdraw', $amount);
                break;
            
            case 'scr2':
                $result = $this->scr2_withdraw($amount);
                break;
            
            case 'xe88':
                $result = $this->xe88_withdraw($amount);
                break;
            
            case 'goldenf':
                $result = $this->goldenf_withdraw($amount);
                break;

            case 'pussy888':
                $result = $this->pussy888_set_score('withdraw', $amount);
                break;
            
            default:
                return response()->json('error');
                break;
        }
        if($result == 'success') {
            return response()->json('success');
        }else {
            return response()->json('error');
        }
    }

    public function play($id) {
        $game = Game::find($id);
        switch ($game->name) {
            case 'gi998':
                return redirect(route('game.gi998.play'));
                break;
            
            case 'xe88':
                return redirect(route('game.xe88.play'));
                break;
            
            case 'goldenf':
                return redirect(route('game.goldenf.list'));
                break;
            
            case 'mega888':
                return redirect(route('game.mega888.play'));
                break;
            
            case 'playtech':
                return redirect(route('game.playtech.play'));
                break;
            
            case 'joker':
                return redirect(route('game.joker.play'));
                break;
            
            default:
                return back()->with(['error' => __('words.something_went_wrong')]);
                break;
        }
    }

    public function balance_refresh(Request $request){
        $game = Game::find($request->id);
        switch ($game->name) {
            case 'gi998':
                $result = $this->gi998_get_balance();
                break;
            
            case 'scr2':
                $result = $this->scr2_get_player_info();
                break;            
            
            case 'xe88':
                $result = $this->xe88_player_info();
                break;
            
            case 'goldenf':
                $result = $this->goldenf_get_balance();
                break;
            
            case 'mega888':
                $result = $this->mega888_get_balance();
                break;
            
            case 'pussy888':
                $result = $this->pussy888_player_info();
                break;
            
            case 'playtech':
                $result = $this->playtech_get_balance();
                break;
            
            case '918kiss':
                $result = $this->api918_player_info();
                break;
            
            case 'joker':
                $result = $this->joker_get_balance();
                break;
            
            default:
                $result = 'error';
                break;
        }
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if($result == 'success') {
            return response()->json(['status' => 'success', 'balance' => $game_account->balance]);
        } else {
            return response()->json(['status' => 'error']);
        }
        
    }

    public function transaction_history(Request $request, $id) {
        config(['site.wap_footer' => 'game']);
        $game = Game::find($id);
        $auth_user = Auth::user();
        $mod = $auth_user->game_transactions()->where('game_id', $id);
        $data = $mod->orderBy('created_at', 'desc')->paginate(10);
        $collection = $mod->get();
        $total_deposit = $collection->where('type', 'deposit')->sum('amount');
        $total_withdraw = $collection->where('type', 'withdraw')->sum('amount');
        if(is_Mobile()) {
            return view('wap.game.transaction', compact('data', 'game', 'total_deposit', 'total_withdraw'));
        } else {
            return view('web.game.transaction', compact('data', 'game', 'total_deposit', 'total_withdraw'));
        }
    }

        
    // ********* Gi998 *********
    public function gi998() {
        $game = Game::where('name', 'gi998')->first();
        $domain = $game->domain;
        $api_id = $game->username;
        $api_key = $game->api_key;
        $timestamp = time();
        $sign = md5($api_id.$timestamp.$api_key);

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if(!$game_account) {
            $post_data = [
                'api_id' => $api_id,
                'timestamp' => $timestamp,
                'sign' => $sign,
                'user_id' => "wins26".$auth_user->id,
            ];
            $url = $domain."/api/acc/created";    
            $client = new Client();
            $response = $client->post($url, [
                            'form_params' => $post_data,
                        ]);
            $result = json_decode($response->getBody());
            // dd($post_data);
            if($result->code == 0) {
                $game_account = GameUser::create([
                    'user_id' => $auth_user->id,
                    'game_id' => $game->id,
                    'username' => "wins26".$auth_user->id,
                    'description' => $auth_user->username . " - " . $game->title
                ]);
            } else {
                return 'error';
            }            
        }

        $url = $domain."/api/acc/getBalance";

        $post_data = [
            'api_id' => $api_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'user_id' => $game_account->username,
        ];

        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody());
        if($result->code == 0) {
            $game_account->update(['balance' => $result->balance]);
        } else {
            return 'error';
        }
        return $game_account;
    }

    public function gi998_update_balance($action, $amount) {
        $game = Game::where('name', 'gi998')->first();
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $auth_user = Auth::user();
        $domain = $game->domain;
        if($this->gi998_get_balance() == 'success') {            
            if($action == 'withdraw' && $amount > $game_account->balance) { return 'error'; }
            if($action == 'deposit' && $amount > $auth_user->score) { return 'error'; }
        }
        $url = $domain."/api/acc/updateBalance";
        $api_id = $game->username;
        $api_key = $game->api_key;
        $timestamp = time();
        $sign = md5($api_id.$timestamp.$api_key);
        $post_data = [
            'api_id' => $api_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'user_id' => $game_account->username,
            'amount' => $amount,
            'action' => $action,
        ];

        $client = new Client();
        $response = $client->post($url, [ 'form_params' => $post_data ]);

        $result = json_decode($response->getBody());
        if($result->code != 0){
            return 'error';
        } else {
            $game_account->update(['balance' => $result->balance]);
            if($action == 'deposit') {$auth_user->decrement('score', $amount);}
            if($action == 'withdraw') {$auth_user->increment('score', $amount);}
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => $amount,
                'type' => $action,
            ]);
            return 'success';
        }
    }

    public function gi998_get_balance(){
        $game = Game::where('name', 'gi998')->first();
        $domain = $game->domain;
        $api_id = $game->username;
        $api_key = $game->api_key;
        $timestamp = time();
        $sign = md5($api_id.$timestamp.$api_key);

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        $url = $domain."/api/acc/getBalance";

        $post_data = [
            'api_id' => $api_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'user_id' => $game_account->username,
        ];

        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody());
        if($result->code == 0) {
            $game_account->update(['balance' => $result->balance]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function gi998_play() {
        $game = Game::where('name', 'gi998')->first();
        $domain = $game->domain;
        $api_id = $game->username;
        $api_key = $game->api_key;
        $timestamp = time();
        $sign = md5($api_id.$timestamp.$api_key);

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $locale = session()->get('locale');
        if($locale == "zh_cn") { $locale = 'zh'; }else{ $locale = 'en'; }
        $post_data = [
            'api_id' => $api_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'user_id' => $game_account->username,
            'game_code' => 'GM001',
            'language' => $locale,
            'game_menu' => true,
        ];
        $url = $domain."/api/acc/gameLogIn";    
        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody());
        if($result->code == 0) {
            return redirect($result->gameUrl);
        } else {
            return back()->withErrors(['error' => __('error.something_went_wrong')]);
        }  
        
    }

    // ******* SCR 918Kiss *******

    public function scr2() {
        $game = Game::where('name', 'scr2')->first();
        $domain = $game->domain;
        $url = $domain."/player";
        $apiuserid = $game->username;
        $apipassword = $game->password;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if(!$game_account) {
            $post_data = [
                'apiuserid' => $apiuserid,
                'apipassword' => $apipassword,
                'operation' => 'addnewplayer',
                'playername' => $auth_user->username,
                'playertelno' => $auth_user->phone_number,
                'playerdescription' => 'Player',
                'playerpassword' => 'Ab112233'
            ];
            $client = new Client();
            $response = $client->post($url, [
                            'body' => json_encode($post_data),
                        ]);
            $result = json_decode($response->getBody());
            if($result->returncode == 0) {
                $game_account = GameUser::create([
                    'user_id' => $auth_user->id,
                    'game_id' => $game->id,
                    'username' => $result->playerid,
                    'password' => 'Ab112233',
                    'description' => $auth_user->username . " - " . $game->title
                ]);
            } else {
                return 'error';
            }            
        }

        $post_data = [
            'apiuserid' => $apiuserid,
            'apipassword' => $apipassword,
            'operation' => 'getplayerinfo',
            'playerid' => $game_account->username,
        ];

        $client = new Client();
        $response = $client->post($url, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody());
        if($result->returncode == 0) {
            $game_account->update(['balance' => $result->balance]);
        } else {
            return 'error';
        }

        return $game_account;
    }

    public function scr2_deposit($amount) {
        $game = Game::where('name', 'scr2')->first();
        $domain = $game->domain;
        $url = $domain."/funds";
        $apiuserid = $game->username;
        $apipassword = $game->password;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        // Predeposit
        $post_data = [
            'apiuserid' => $apiuserid,
            'apipassword' => $apipassword,
            'operation' => 'predeposit',
        ];
        $client = new Client();
        $response = $client->post($url, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody());
        if($result->returncode == 0) {
            $tid = $result->tid;
        } else {
            return 'error';
        }
        // Deposit
        $post_data = [
            'apiuserid' => $apiuserid,
            'apipassword' => $apipassword,
            'operation' => 'deposit',
            'playerid' => $game_account->username,
            'amount' => $amount,
            'tid' => $tid,
        ];
        $client = new Client();
        $response = $client->post($url, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody());
        if($result->returncode == 0) {            
            $auth_user->decrement('score', $amount);
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => $amount,
                'type' => 'deposit',
            ]);
            $this->scr2_get_player_info();
            return 'success';
        } else {
            return 'error';
        }
    }

    public function scr2_withdraw($amount) {
        $game = Game::where('name', 'scr2')->first();
        $domain = $game->domain;
        $url = $domain."/funds";
        $apiuserid = $game->username;
        $apipassword = $game->password;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        // Predeposit
        $post_data = [
            'apiuserid' => $apiuserid,
            'apipassword' => $apipassword,
            'operation' => 'prewithdraw',
        ];
        $client = new Client();
        $response = $client->post($url, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody());
        if($result->returncode == 0) {
            $tid = $result->tid;
        } else {
            return 'error';
        }
        // Deposit
        $post_data = [
            'apiuserid' => $apiuserid,
            'apipassword' => $apipassword,
            'operation' => 'withdraw',
            'playerid' => $game_account->username,
            'amount' => $amount,
            'tid' => $tid,
        ];
        $client = new Client();
        $response = $client->post($url, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody());
        if($result->returncode == 0) {            
            $auth_user->increment('score', $amount);
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => $amount,
                'type' => 'withdraw',
            ]);
            $this->scr2_get_player_info();
            return 'success';
        } else {
            return 'error';
        }
    }

    public function scr2_get_player_info(){
        $game = Game::where('name', 'scr2')->first();
        $domain = $game->domain;
        $url = $domain."/player";
        $apiuserid = $game->username;
        $apipassword = $game->password;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $post_data = [
            'apiuserid' => $apiuserid,
            'apipassword' => $apipassword,
            'operation' => 'getplayerinfo',
            'playerid' => $game_account->username,
        ];

        $client = new Client();
        $response = $client->post($url, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody());
        if($result->returncode == 0) {
            $game_account->update(['balance' => $result->balance]);
            return 'success';
        } else {
            return 'error';
        }
    }
    
    public function scr2_update_player_info() {
        $game = Game::where('name', 'scr2')->first();
        $domain = $game->domain;
        $url = $domain."/player";
        $apiuserid = $game->username;
        $apipassword = $game->password;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        
        $post_data = [
            'apiuserid' => $apiuserid,
            'apipassword' => $apipassword,
            'operation' => 'updateplayerinfo',
            'playerid' => $game_account->username,
            'playername' => $auth_user->username,
            'playertelno' => $auth_user->phone_number,
            'playerdescription' => 'Account of 26Wins',
            'playerpassword' => 'Ab112233'
        ];

        $client = new Client();
        $response = $client->post($url, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody());
        if($result->returncode == 0) {
            $game_account->update(['password' => 'Aa112233']);
            return 'success';
        } else {
            return 'error';
        }
    }

    // ******* XE88 ********

    public function xe88(){
        $game = Game::where('name', 'xe88')->first();
        $domain = $game->domain;
        $agent_id = $game->agent;
        $signature_key = $game->api_key;
        $prefix = $game->prefix;
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if (!$game_account) {          
            $url = $domain . "player/create";
            $post_data = array(
                'agentid' => $agent_id,
                'account' => $prefix . getRandom(4) . $auth_user->id,
                'password' => 'Aa112233',
            );
            $request_body = json_encode($post_data);
            $hash_data = hash_hmac("sha256", $request_body, $signature_key, true);
            $hash = base64_encode($hash_data);
            $headers = [
                'hashkey' => $hash,
            ];
            $client = new Client();
            $response = $client->post($url, [
                            'headers' => $headers,
                            'body' => $request_body,
                        ]);
            $result = json_decode($response->getBody());
            if($result->code == "0"){
                $game_account = GameUser::create([
                    'user_id' => $auth_user->id,
                    'game_id' => $game->id,
                    'username' => $result->result->account,
                    'password' => $result->result->password,
                    'description' => $auth_user->username . " - " . $game->title
                ]);
            } else {
                return 'error';
            }
        }
        $post_data = [            
            'agentid' => $agent_id,
            'account' => $game_account->username,
        ];
        $request_body = json_encode($post_data);
        $hash_data = hash_hmac("sha256", $request_body, $signature_key, true);
        $hash = base64_encode($hash_data);
        $headers = [
            'hashkey' => $hash,
        ];
        $url = $domain."player/info";
        $client = new Client();
        $response = $client->post($url, [
                        'headers' => $headers,
                        'body' => $request_body,
                    ]);
        $result = json_decode($response->getBody());
        if($result->code == 0) {
            $game_account->update([
                'balance' => $result->result->balance,
                'password' => $result->result->password,
            ]);
        } else {
            return 'error';
        }

        return $game_account;
    }

    public function xe88_deposit($amount) {
        $game = Game::where('name', 'xe88')->first();
        $domain = $game->domain;
        $url = $domain."player/deposit";
        $agent_id = $game->agent;
        $signature_key = $game->api_key;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        $post_data = [
            'agentid' => $agent_id,
            'account' => $game_account->username,
            'amount' => $amount,
        ];
        $request_body = json_encode($post_data);
        $hash_data = hash_hmac("sha256", $request_body, $signature_key, true);
        $hash = base64_encode($hash_data);
        $headers = [
            'hashkey' => $hash,
        ];
        $client = new Client();
        $response = $client->post($url, [
                        'headers' => $headers,
                        'body' => $request_body,
                    ]);
        $result = json_decode($response->getBody());
        if($result->code == 0) {            
            $auth_user->decrement('score', $result->result->amount);
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => $result->result->amount,
                'type' => 'deposit',
            ]);
            $game_account->update(['balance' => $result->result->currentplayerbalance]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function xe88_withdraw($amount) {
        $game = Game::where('name', 'xe88')->first();
        $domain = $game->domain;
        $url = $domain."player/withdraw";
        $agent_id = $game->agent;
        $signature_key = $game->api_key;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        $post_data = [
            'agentid' => $agent_id,
            'account' => $game_account->username,
            'amount' => $amount,
        ];
        $request_body = json_encode($post_data);
        $hash_data = hash_hmac("sha256", $request_body, $signature_key, true);
        $hash = base64_encode($hash_data);
        $headers = [
            'hashkey' => $hash,
        ];
        $client = new Client();
        $response = $client->post($url, [
                        'headers' => $headers,
                        'body' => $request_body,
                    ]);
        $result = json_decode($response->getBody());
        if($result->code == 0) {            
            $auth_user->increment('score', $result->result->amount);
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => $result->result->amount,
                'type' => 'withdraw',
            ]);
            $game_account->update(['balance' => $result->result->currentplayerbalance]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function xe88_player_info() {
        $game = Game::where('name', 'xe88')->first();
        $domain = $game->domain;
        $url = $domain."/player/info";
        $agent_id = $game->agent;
        $signature_key = $game->api_key;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $post_data = [            
            'agentid' => $agent_id,
            'account' => $game_account->username,
        ];
        
        $request_body = json_encode($post_data);
        $hash_data = hash_hmac("sha256", $request_body, $signature_key, true);
        $hash = base64_encode($hash_data);
        $headers = [
            'hashkey' => $hash,
        ];
        $client = new Client();
        $response = $client->post($url, [
                        'headers' => $headers,
                        'body' => $request_body,
                    ]);
        $result = json_decode($response->getBody());
        if($result->code == 0) {
            $game_account->update(['balance' => $result->result->balance]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function xe88_play() {
        $game = Game::where('name', 'xe88')->first();
        $domain = $game->domain;
        $agent_id = $game->agent;
        $signature_key = $game->api_key;

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        if(is_Mobile()){
            return view('wap.game.xe88', compact('game_account'));
        } else {
            return view('web.game.xe88', compact('game_account'));
        }
        
    }

    // ******* goldenf *******

    public function goldenf(){
        $user = Auth::user();
        $game = Game::where('name', 'goldenf')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $operator_token = $game->token;
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if (!$game_account) {          
            $url = $domain . "Player/Create";
            $username = "26WINS" . getRandom(4) . $auth_user->id;
            $post_data = array(
                'secret_key' => $secret_key,
                'operator_token' => $operator_token,
                'player_name' => $username,
                'currency' => 'MYR',
            );

            $client = new Client();
            $response = $client->post($url, [
                            'form_params' => $post_data,
                        ]);
            $result = json_decode($response->getBody());
            
            if($result->error == null){
                $game_account = GameUser::create([
                    'user_id' => $auth_user->id,
                    'game_id' => $game->id,
                    'username' => $username,
                    'description' => $auth_user->username . " - " . $game->title
                ]);
            } else {
                return 'error';
            }
        }
        $post_data = [   
            'secret_key' => $secret_key,
            'operator_token' => $operator_token,
            'player_name' => $game_account->username,
        ];
        $url = $domain."GetPlayerBalance";
        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody());
        if($result->error == null) {
            $game_account->update(['balance' => $result->data->balance]);
        } else {
            return 'error';
        }

        return $game_account;
    }

    public function goldenf_deposit($amount) {
        $game = Game::where('name', 'goldenf')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $operator_token = $game->token;
        
        $url = $domain."TransferIn";

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        
        $post_data = [
            'secret_key' => $secret_key,
            'operator_token' => $operator_token,
            'player_name' => $game_account->username,
            'amount' => $amount
        ];

        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody());
        if($result->error == null) {            
            $auth_user->decrement('score', $amount);
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => $amount,
                'type' => 'deposit',
            ]);
            $game_account->update(['balance' => $result->data->balance]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function goldenf_withdraw($amount) {
        $game = Game::where('name', 'goldenf')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $operator_token = $game->token;
        
        $url = $domain."TransferOut";

        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        
        $post_data = [
            'secret_key' => $secret_key,
            'operator_token' => $operator_token,
            'player_name' => $game_account->username,
            'amount' => $amount
        ];

        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody());
        if($result->error == null) {            
            $auth_user->increment('score', $amount);
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => $amount,
                'type' => 'withdraw',
            ]);
            $game_account->update(['balance' => $result->data->balance]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function goldenf_get_balance(){
        $game = Game::where('name', 'goldenf')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $operator_token = $game->token;
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        $post_data = [   
            'secret_key' => $secret_key,
            'operator_token' => $operator_token,
            'player_name' => $game_account->username,
        ];
        $url = $domain."GetPlayerBalance";
        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody());
        if($result->error == null) {
            $game_account->update(['balance' => $result->data->balance]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function goldenf_list() {
        config(['site.page' => 'casino']);
        config(['site.wap_footer' => 'game']);
        $game = Game::where('name', 'goldenf')->first();
        if(is_Mobile()) {
            return view('wap.game.goldenf', compact('game'));
        } else {
            return view('web.game.goldenf', compact('game'));
        }
    }

    public function goldenf_play(Request $request) {
        $game_code = $request->code;
        $game = Game::where('name', 'goldenf')->first();
        $deposit_status = $this->total_deposit($game->id);
        if($deposit_status != 'success') {return back()->withErrors(['error' => __('error.something_went_wrong')]);}
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $operator_token = $game->token;
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
       
        $post_data = [
            'secret_key' => $secret_key,
            'operator_token' => $operator_token,
            'player_name' => $game_account->username,
            'game_code' => $game_code,
            'language' => 'en-US',
        ];
        $url = $domain."Launch";    
        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody());
        if($result->error == null) {
            return redirect($result->data->game_url);
        } else {
            return back()->withErrors(['error' => __('error.something_went_wrong')]);
        }        
    }
    
    // ********* Mega888 *********

    public function mega888() {
        $game = Game::where('name', 'mega888')->first();
        $domain = $game->domain;
        $agent = $game->agent;
        $secretCode = $game->api_key;
        $sn = "ld00";
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $random = uniqid();
        if (!$game_account) {
            $method = "open.mega.user.create";
            $post_data = array(
                "id" => mt_rand(10000,99999),
                "method" => $method,
                "params" => array(
                    "random" => $random,
                    "digest" => md5($random.$sn.$secretCode),
                    "sn" => $sn,
                    'secretCode' => $secretCode,
                    "agentLoginId" => $agent,
                ),
                "jsonrpc" => "2.0",
            );
            $url = $domain.$method;
            $client = new Client();
            $request_body = json_encode($post_data);
            $response = $client->post($url, [
                            'body' => $request_body,
                        ]);
            $result = json_decode($response->getBody());
            if($result->error == null){
                $game_account = GameUser::create([
                    'user_id' => $auth_user->id,
                    'game_id' => $game->id,
                    'username' => $result->result->loginId,
                    'password' => 'Aa112233',
                    'game_user_id' => $result->result->userId,
                    'description' => $auth_user->username . " - " . $game->title
                ]);
            } else {
                return 'error';
            }
        }
        // get balance 
        $method = "open.mega.balance.get";
        $loginId = $game_account->username;
        $post_data = array(
            "id" => mt_rand(10000,99999),
            "method" => $method,
            "params" => array(
                "random" => $random,
                "digest" => md5($random.$sn.$loginId.$secretCode),
                "sn" => $sn,
                'secretCode' => $secretCode,
                'loginId' => $loginId,
            ),
            "jsonrpc" => "2.0",
        );
        $url = $domain.$method;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'body' => $request_body,
                    ]);
        $result = json_decode($response->getBody());
        if($result->error == null) {
            $game_account->update(['balance' => $result->result]);
        } else {
            return 'error';
        }

        return $game_account;
    }

    public function mega888_set_score($action, $amount) {        
        $game = Game::where('name', 'mega888')->first();
        $domain = $game->domain;
        $agent = $game->agent;
        $secretCode = $game->api_key;
        $sn = "ld00";
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $random = uniqid();

        if($this->mega888_get_balance() == 'success') {            
            if($action == 'withdraw' && $amount > $game_account->balance) { return 'error'; }
            if($action == 'deposit' && $amount > $auth_user->score) { return 'error'; }
        }
        
        $score = $amount;
        $method = "open.mega.balance.transfer";
        if($action == 'withdraw') {$score = -1 * $amount;}
        $loginId = $game_account->username;
        $post_data = array(
            "id" => mt_rand(10000,99999),
            "method" => $method,
            "params" => array(
                "random" => $random,
                "digest" => md5($random.$sn.$loginId.$score.$secretCode),
                "sn" => $sn,
                'secretCode' => $secretCode,
                'loginId' => $loginId,
                'amount' => $score,
            ),
            "jsonrpc" => "2.0",
        );
        $url = $domain.$method;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'body' => $request_body,
                    ]);
        $result = json_decode($response->getBody());
        if($result->error == null) {
            $game_account->update(['balance' => $result->result]);
            if($action == 'deposit') {$auth_user->decrement('score', $amount);}
            if($action == 'withdraw') {$auth_user->increment('score', $amount);}
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => abs($amount),
                'type' => $action,
            ]);
            return 'success';
        } else {            
            return 'error';
        }
    }

    public function mega888_get_balance(){
        $game = Game::where('name', 'mega888')->first();
        $domain = $game->domain;
        $agent = $game->agent;
        $secretCode = $game->api_key;
        $sn = "ld00";
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $random = uniqid();
        $method = "open.mega.balance.get";
        $loginId = $game_account->username;
        $post_data = array(
            "id" => mt_rand(10000,99999),
            "method" => $method,
            "params" => array(
                "random" => $random,
                "digest" => md5($random.$sn.$loginId.$secretCode),
                "sn" => $sn,
                'secretCode' => $secretCode,
                'loginId' => $loginId,
            ),
            "jsonrpc" => "2.0",
        );
        $url = $domain.$method;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'body' => $request_body,
                    ]);
        $result = json_decode($response->getBody());
        if($result->error == null) {
            $game_account->update(['balance' => $result->result]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function mega888_player_info() {
        $game = Game::where('name', 'mega888')->first();
        $domain = $game->domain;
        $agent = $game->agent;
        $secretCode = $game->api_key;
        $sn = "ld00";
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $random = uniqid();
        $method = "open.mega.user.get";
        $loginId = $game_account->username;
        $post_data = array(
            "id" => mt_rand(10000,99999),
            "method" => $method,
            "params" => array(
                "random" => $random,
                "digest" => md5($random.$sn.$loginId.$secretCode),
                "sn" => $sn,
                'secretCode' => $secretCode,
                'loginId' => $loginId,
            ),
            "jsonrpc" => "2.0",
        );
        $url = $domain.$method;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'body' => $request_body,
                    ]);
        $result = json_decode($response->getBody());
        dd($result);
    } 
    
    public function mega888_callback(Request $request) {
        $data = $request->all();
        $request_data = str_replace("\t", "", $request->getContent());
        $request_data = str_replace("\r", "", $request_data);
        $request_data = str_replace("\n", "", $request_data);
        $request_data = str_replace("  ", "", $request_data);
        $request_data = substr($request_data, 5);

        $filename = storage_path() . '\\datalogs\\datalogs.log';        
        if ($handle = fopen($filename, 'a')) {
            fwrite($handle, $request_data . " \n");
            fclose($handle);
        }

        $data = json_decode($request_data, true);
        if(is_array($data) && $data['method'] == 'open.operator.user.login') {
            $loginId = $data['params']['loginId'];
            $password = $data['params']['password'];
            if($game_account = GameUser::where('username', $loginId)->where('password', $password)->first()){
                $response_data = [
                    "id" => $data['id'],
                    "result" => [
                        "success" => "1",
                        "sessionId" => getRandom(12),
                        "msg" => "Login Success",
                    ],
                    "error" => null,
                    "jsonrpc" => "2.0"
                ];

            } else {
                $response_data = [
                    "id" => $data['id'],
                    "result" => [
                        "success" => "0",
                        "sessionId" => '',
                        "msg" => "No Account",
                    ],
                    "error" => 401,
                    "jsonrpc" => "2.0"
                ];
            }
        } else {
            $response_data = [
                "result" => [
                    "success" => "0",
                    "sessionId" => '',
                    "msg" => "Bad Request",
                ],
                "error" => 400,
                "jsonrpc" => "2.0"
            ];
        }
        
        return response()->json($response_data);
    }

    // ******** Pussy888 ********

    public function pussy888() {
        $game = Game::where('name', 'pussy888')->first();
        $domain = $game->domain;
        $username = $game->username;
        $secret_key = $game->api_key;
        $auth_code = $game->token;
        $timestamp =time()."000";
        $auth_user = Auth::user();
        $url = $domain."ashx/account/account.ashx";
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if (!$game_account) {
            $sign = strtoupper(md5(strtolower($username.$auth_code.$username.$timestamp.$secret_key)));
            $post_data = array(
                'loginUser' => $username,
                'action' => 'RandomUserName',
                'userName' => $username,
                'time' => $timestamp,
                'authcode' => $auth_code,
                'sign' => $sign,
            );
            $client = new Client();
            $request_body = json_encode($post_data);
            $response = $client->post($url, [
                            'form_params' => $post_data,
                        ]);
            $result = json_decode($response->getBody());
            if($result->code != 0) return 'error';
            $playername = $result->account;
            $sign = strtoupper(md5(strtolower($auth_code.$playername.$timestamp.$secret_key)));
            $post_data = array(
                'action' => 'AddPlayer',
                'agent' => $username,
                'PassWd' => "Ab112233",
                'pwdtype' => 1,
                'userName' => $playername,
                'Name' => $auth_user->username,
                'Tel' => $auth_user->phone_number,
                'Memo' => '26WinsPlayer',
                'UserType' => 1,
                'time' => $timestamp,
                'authcode' => $auth_code,
                'sign' => $sign,
            );
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => $post_data,
            ]);
            $result = json_decode($response->getBody());
            if($result->success == true){
                $game_account = GameUser::create([
                    'user_id' => $auth_user->id,
                    'game_id' => $game->id,
                    'username' => $playername,
                    'password' => 'Ab112233',
                    'description' => $auth_user->username . " - " . $game->title
                ]);
            } else {
                return 'error';
            }            
        }

        $sign = strtoupper(md5(strtolower($auth_code.$game_account->username.$timestamp.$secret_key)));
        $post_data = array(
            'action' => 'getUserInfo',
            'userName' => $game_account->username,
            'time' => $timestamp,
            'authcode' => $auth_code,
            'sign' => $sign,
        );
        $client = new Client();
        $response = $client->post($url, [
            'form_params' => $post_data,
        ]);
        $result = json_decode($response->getBody());
        if($result->success = true) {
            $game_account->update([
                'balance' => $result->ScoreNum,
            ]);
        }
        return $game_account;
    }
    
    public function pussy888_set_score($action, $amount) {        
        $game = Game::where('name', 'pussy888')->first();
        $domain = $game->domain;
        $username = $game->username;
        $secret_key = $game->api_key;
        $auth_code = $game->token;
        $timestamp =time()."000";
        $auth_user = Auth::user();
        $url = $domain."ashx/account/setScore.ashx";
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        if($this->pussy888_player_info() == 'success') {            
            if($action == 'withdraw' && $amount > $game_account->balance) { return 'error'; }
            if($action == 'deposit' && $amount > $auth_user->score) { return 'error'; }
        }
        $sign = strtoupper(md5(strtolower($auth_code.$game_account->username.$timestamp.$secret_key)));
        $score = $amount;
        if($action == 'withdraw') {$score = -1 * $amount;}
        $post_data = [
            'action' => 'setServerScore',
            'orderid' => time().$auth_user->name,
            'scoreNum' => $score,
            'userName' => $game_account->username,
            'ActionUser' => $username,
            'ActionIp' => getIp(),
            'time' => $timestamp,
            'authcode' => $auth_code,
            'sign' => $sign,
        ];

        $client = new Client();
        $response = $client->post($url, [ 'form_params' => $post_data ]);

        $result = json_decode($response->getBody());
        if(!$result->success){
            return 'error';
        } else {
            $game_account->update(['balance' => $result->money]);
            if($action == 'deposit') {$auth_user->decrement('score', $amount);}
            if($action == 'withdraw') {$auth_user->increment('score', $amount);}
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => abs($amount),
                'type' => $action,
            ]);
            return 'success';
        }
    }

    public function pussy888_player_info() {
        $game = Game::where('name', 'pussy888')->first();
        $domain = $game->domain;
        $username = $game->username;
        $secret_key = $game->api_key;
        $auth_code = $game->token;
        $timestamp =time()."000";
        $auth_user = Auth::user();
        $url = $domain."ashx/account/account.ashx";
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $sign = strtoupper(md5(strtolower($auth_code.$game_account->username.$timestamp.$secret_key)));
        $post_data = array(
            'action' => 'getUserInfo',
            'userName' => $game_account->username,
            'time' => $timestamp,
            'authcode' => $auth_code,
            'sign' => $sign,
        );
        $client = new Client();
        $response = $client->post($url, [
            'form_params' => $post_data,
        ]);
        $result = json_decode($response->getBody());
        if($result->success = true) {
            $game_account->update([
                'balance' => $result->ScoreNum,
            ]);
            return "success";
        } else {
            return 'error';
        }
    }

    // ******** PlayTech *********

    public function playtech() {
        $game = Game::where('name', 'playtech')->first();
        $domain = $game->domain;
        $merchant_code = $game->api_key;
        $prefix = $game->prefix;
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if (!$game_account) {
            $url = $domain."Player/Register";
            $username = $prefix.getRandom(4).$auth_user->id;
            $post_data = array(
                'MerchantCode' => $merchant_code,
                'PlayerId' => $username,
                'Currency' => 'MYR',
                'Password' => 'Aa112233',
            );
            $client = new Client();
            $response = $client->post($url, [
                            'json' => $post_data,
                        ]);
            $result = json_decode($response->getBody(), true);
            if($result['Code'] == 0) {
                $game_account = GameUser::create([
                        'user_id' => $auth_user->id,
                        'game_id' => $game->id,
                        'username' => $username,
                        'password' => 'Aa112233',
                        'description' => $auth_user->username . " - " . $game->title
                    ]);
            } else {
                return 'error';
            }
        }
        // get balance
        $url = $domain."Player/GetBalance";
        $post_data = array(
            'MerchantCode' => $merchant_code,
            'PlayerId' => $game_account->username,
            'ProductWallet' => 102,
        );
        $client = new Client();
        $response = $client->post($url, [
                        'json' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        if($result['Code'] == 0) {
            $game_account->update(['balance' => $result['Balance']]);
        } else {
            return 'error';
        }

        return $game_account;

    }

    public function playtech_set_score($action, $amount) {
        $game = Game::where('name', 'playtech')->first();
        $domain = $game->domain;
        $merchant_code = $game->api_key;
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        if($this->playtech_get_balance() == 'success') {            
            if($action == 'withdraw' && $amount > $game_account->balance) { return 'error'; }
            if($action == 'deposit' && $amount > $auth_user->score) { return 'error'; }
        }
        
        $score = $amount;
        if($action == 'withdraw') {$score = -1 * $amount;}        
        $post_data = array(
            'MerchantCode' => $merchant_code,
            'PlayerId' => $game_account->username,
            'ProductWallet' => '102',
            'TransactionId' => uniqid(),
            'Amount' => $score,
        );
        $url = $domain.'Transaction/PerformTransfer';
        $client = new Client();
        $response = $client->post($url, [
                        'json' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        if($result['Code'] == 0 && $result['Status'] == 'Approved') {
            $game_account->increment('balance', $score);
            if($action == 'deposit') { $auth_user->decrement('score', $amount); }
            if($action == 'withdraw') { $auth_user->increment('score', $amount); }
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => abs($amount),
                'type' => $action,
            ]);
            return 'success';
        } else {            
            return 'error';
        }
    }

    public function playtech_get_balance(){
        $game = Game::where('name', 'playtech')->first();
        $domain = $game->domain;
        $merchant_code = $game->api_key;
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        $url = $domain."Player/GetBalance";
        $post_data = array(
            'MerchantCode' => $merchant_code,
            'PlayerId' => $game_account->username,
            'ProductWallet' => 102,
        );
        $client = new Client();
        $response = $client->post($url, [
                        'json' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        if($result['Code'] == 0) {
            $game_account->update(['balance' => $result['Balance']]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function playtech_play() {
        $game = Game::where('name', 'playtech')->first();
        $domain = $game->domain;
        $merchant_code = $game->api_key;
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $url = $domain."Game/NewLaunchGame";
        $post_data = array(
            'MerchantCode' => $merchant_code,
            'PlayerId' => $game_account->username,
            'ProductWallet' => 102,
            'GameCode' => 'plba',
            'Language' => 'EN',
            'IpAddress' => getIp(),
        );
        $client = new Client();
        $response = $client->post($url, [
                        'json' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        if($result['Code'] == 0) {
            return redirect($result['GameUrl']);
        } else {
            return back()->withErrors(['error' => __('words.something_went_wrong')]);
        }
    }

    // ******** 918Kiss ********

    public function api918() {
        $game = Game::where('name', '918kiss')->first();
        $domain = $game->domain;
        $username = $game->username;
        $secret_key = $game->api_key;
        $auth_code = $game->token;
        $timestamp =time()."000";
        $auth_user = Auth::user();
        $url = $domain."ashx/account/account.ashx";
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if (!$game_account) {
            $sign = strtoupper(md5(strtolower($auth_code.$username.$timestamp.$secret_key)));
            $post_data = array(
                'action' => 'RandomUserName',
                'userName' => $username,
                'time' => $timestamp,
                'authcode' => $auth_code,
                'sign' => $sign,
            );
            $client = new Client();
            $request_body = json_encode($post_data);
            $response = $client->post($url, [
                            'form_params' => $post_data,
                        ]);
            $result = json_decode($response->getBody());
            if($result->code != 0) return 'error';
            $playername = $result->account;
            $sign = strtoupper(md5(strtolower($auth_code.$playername.$timestamp.$secret_key)));
            $post_data = array(
                'action' => 'AddPlayer',
                'agent' => $username,
                'PassWd' => "Aa112233",
                'pwdtype' => 1,
                'userName' => $playername,
                'Name' => $auth_user->username,
                'Tel' => $auth_user->phone_number,
                'Memo' => '26WinsPlayer',
                'UserType' => 1,
                'time' => $timestamp,
                'authcode' => $auth_code,
                'sign' => $sign,
            );
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => $post_data,
            ]);
            $result = json_decode($response->getBody());
            if($result->success == true){
                $game_account = GameUser::create([
                    'user_id' => $auth_user->id,
                    'game_id' => $game->id,
                    'username' => $playername,
                    'password' => 'Aa112233',
                    'description' => $auth_user->username . " - " . $game->title
                ]);
            } else {
                return 'error';
            }            
        }

        $sign = strtoupper(md5(strtolower($auth_code.$game_account->username.$timestamp.$secret_key)));
        $post_data = array(
            'action' => 'getUserInfo',
            'userName' => $game_account->username,
            'time' => $timestamp,
            'authcode' => $auth_code,
            'sign' => $sign,
        );
        $client = new Client();
        $response = $client->post($url, [
            'form_params' => $post_data,
        ]);
        $result = json_decode($response->getBody());
        if($result->success = true) {
            $game_account->update([
                'balance' => $result->ScoreNum,
            ]);
        }
        return $game_account;
    }
    
    public function api918_set_score($action, $amount) {
        $game = Game::where('name', '918kiss')->first();
        $domain = $game->domain;
        $username = $game->username;
        $secret_key = $game->api_key;
        $auth_code = $game->token;
        $timestamp =time()."000";
        $auth_user = Auth::user();
        $url = $domain."ashx/account/setScore.ashx";
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();

        if($this->pussy888_player_info() == 'success') {            
            if($action == 'withdraw' && $amount > $game_account->balance) { return 'error'; }
            if($action == 'deposit' && $amount > $auth_user->score) { return 'error'; }
        }
        $sign = strtoupper(md5(strtolower($auth_code.$game_account->username.$timestamp.$secret_key)));
        $score = $amount;
        if($action == 'withdraw') {$score = -1 * $amount;}
        $post_data = [
            'action' => 'setServerScore',
            'orderid' => time().$auth_user->name,
            'scoreNum' => $score,
            'userName' => $game_account->username,
            'ActionUser' => $username,
            'ActionIp' => getIp(),
            'time' => $timestamp,
            'authcode' => $auth_code,
            'sign' => $sign,
        ];

        $client = new Client();
        $response = $client->post($url, [ 'form_params' => $post_data ]);

        $result = json_decode($response->getBody());
        if(!$result->success){
            return 'error';
        } else {
            $game_account->update(['balance' => $result->money]);
            if($action == 'deposit') {$auth_user->decrement('score', $amount);}
            if($action == 'withdraw') {$auth_user->increment('score', $amount);}
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => abs($amount),
                'type' => $action,
            ]);
            return 'success';
        }
    }

    public function api918_player_info() {
        $game = Game::where('name', '918kiss')->first();
        $domain = $game->domain;
        $username = $game->username;
        $secret_key = $game->api_key;
        $auth_code = $game->token;
        $timestamp =time()."000";
        $auth_user = Auth::user();
        $url = $domain."ashx/account/account.ashx";
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $sign = strtoupper(md5(strtolower($auth_code.$game_account->username.$timestamp.$secret_key)));
        $post_data = array(
            'action' => 'getUserInfo',
            'userName' => $game_account->username,
            'time' => $timestamp,
            'authcode' => $auth_code,
            'sign' => $sign,
        );
        $client = new Client();
        $response = $client->post($url, [
            'form_params' => $post_data,
        ]);
        $result = json_decode($response->getBody());
        if($result->success = true) {
            $game_account->update([
                'balance' => $result->ScoreNum,
            ]);
            return "success";
        } else {
            return 'error';
        }
    }

    public function joker() {
        $game = Game::where('name', 'joker')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $app_id = $game->username;
        $timestamp =time();
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        if (!$game_account) { 
            $username = "26WINS".getRandom(4).$auth_user->id;
            $method = 'CU';
            $signature = base64_encode(hash_hmac("sha1", "Method=".$method."&Timestamp=".$timestamp."&Username=".$username, $secret_key, true));
            $signature = urlencode($signature);
            $post_data = array(
                'Method' => 'CU',
                'Timestamp' => $timestamp,
                'Username' => $username
            );
            $url = $domain."?AppID=".$app_id."&Signature=".$signature;
            $client = new Client();
            $request_body = json_encode($post_data);
            $response = $client->post($url, [
                            'form_params' => $post_data,
                        ]);
            $result = json_decode($response->getBody(), true);
            if($result['Status'] == 'Created'){
                $game_account = GameUser::create([
                    'user_id' => $auth_user->id,
                    'game_id' => $game->id,
                    'username' => $result['Data']['Username'],
                    'password' => 'Aa112233',
                    'description' => $auth_user->username . " - " . $game->title
                ]);
            } else {
                return 'error';
            }  
        }
        $username = $game_account->username;
        $method = 'GC';
        $signature = base64_encode(hash_hmac("sha1", "Method=".$method."&Timestamp=".$timestamp."&Username=".$username, $secret_key, true));
        $signature = urlencode($signature);
        $post_data = array(
            'Method' => 'GC',
            'Timestamp' => $timestamp,
            'Username' => $username
        );
        $url = $domain."?AppID=".$app_id."&Signature=".$signature;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        
        if($result['Username'] = $username) {
            $game_account->update([
                'balance' => $result['Credit'],
            ]);
        }
        return $game_account;
        
    }

    public function joker_set_score($action, $amount) {
        $game = Game::where('name', 'joker')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $app_id = $game->username;
        $timestamp =time();
        $method = "TC";
        $auth_user = Auth::user();        
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $username = $game_account->username;
        // if($this->joker_get_balance() == 'success') {            
        //     if($action == 'withdraw' && $amount > $game_account->balance) { return 'error'; }
        //     if($action == 'deposit' && $amount > $auth_user->score) { return 'error'; }
        // }
        
        $request_id = uniqid();
        $score = $amount;
        if($action == 'withdraw') {$score = -1 * $amount;}
        $signature = base64_encode(hash_hmac("sha1", "Amount=".$score."&Method=".$method."&RequestID=".$request_id."&Timestamp=".$timestamp."&Username=".$username, $secret_key, true));
        $signature = urlencode($signature);
        $post_data = [
            'Amount' => $score,
            'RequestID' => $request_id,
            'Method' => 'TC',
            'Timestamp' => $timestamp,
            'Username' => $username
        ];
        $url = $domain."?AppID=".$app_id."&Signature=".$signature;
        $client = new Client();
        $response = $client->post($url, [ 'form_params' => $post_data ]);

        $result = json_decode($response->getBody(), true);
        if($result['RequestID'] != $request_id || $result['Username'] != $username){
            return 'error';
        } else {
            $game_account->update(['balance' => $result['Credit']]);
            if($action == 'deposit') {$auth_user->decrement('score', $amount);}
            if($action == 'withdraw') {$auth_user->increment('score', $amount);}
            GameTransaction::create([
                'user_id' => $auth_user->id,
                'game_id' => $game->id,
                'game_account_id' => $game_account->id,
                'game_account_username' => $game_account->username,
                'amount' => abs($amount),
                'type' => $action,
            ]);
            return 'success';
        }
    }

    public function joker_get_balance() {
        $game = Game::where('name', 'joker')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $app_id = $game->username;
        $timestamp =time();
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $username = $game_account->username;
        $method = 'GC';
        $signature = base64_encode(hash_hmac("sha1", "Method=".$method."&Timestamp=".$timestamp."&Username=".$username, $secret_key, true));
        $signature = urlencode($signature);
        $post_data = array(
            'Method' => 'GC',
            'Timestamp' => $timestamp,
            'Username' => $username
        );
        $url = $domain."?AppID=".$app_id."&Signature=".$signature;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        
        if($result['Username'] = $username) {
            $game_account->update([
                'balance' => $result['Credit'],
            ]);
            return 'success';
        } else {
            return 'error';
        }
    }

    public function joker_play() {
        $game = Game::where('name', 'joker')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $app_id = $game->username;
        $timestamp =time();
        $auth_user = Auth::user();
        $game_account = GameUser::where('user_id', $auth_user->id)->where('game_id', $game->id)->first();
        $username = $game_account->username;
        // *** RequestToken ***
        $method = 'RT';
        $signature = base64_encode(hash_hmac("sha1", "Method=".$method."&Timestamp=".$timestamp."&Username=".$username, $secret_key, true));
        $signature = urlencode($signature);
        $post_data = array(
            'Method' => 'RT',
            'Timestamp' => $timestamp,
            'Username' => $username
        );
        $url = $domain."?AppID=".$app_id."&Signature=".$signature;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        $token = $result['Token'];

        // *** Game List ***
        $method = 'ListGames';
        $signature = base64_encode(hash_hmac("sha1", "Method=".$method."&Timestamp=".$timestamp, $secret_key, true));
        $signature = urlencode($signature);
        $post_data = array(
            'Method' => $method,
            'Timestamp' => $timestamp,
        );
        $url = $domain."?AppID=".$app_id."&Signature=".$signature;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        $games = $result['ListGames'];
        $client_url = "http://www.gwc688.net/";
        if(is_Mobile()) {
            return view('wap.game.joker', compact('games', 'token', 'client_url'));
        } else {
            return view('web.game.joker', compact('games', 'token', 'client_url'));
        }        
    }
    
}