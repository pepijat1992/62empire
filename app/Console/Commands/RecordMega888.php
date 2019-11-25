<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\GameUser;
use App\Models\GameRecord;
use App\Agent;
use App\User;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class RecordMega888 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:mega888';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Game Record from Mega888';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cur_date = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime("yesterday"));

        $hour = date('H');
        $minute = date('i');

        if($hour == '00' && $minute <= 20){
            $this->record($prev_date);
        }

        $this->record($cur_date); 
    }

    public function record($bet_date) {
        $game = Game::where('name', 'mega888')->first();
        $domain = $game->domain;
        $agent = $game->agent;
        $secretCode = $game->api_key;
        $sn = "ld00";
        $random = uniqid();

        $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($bet_date)));
        $start_time = $bet_date." 00:00:00";
        $end_time = $bet_date." 23:59:59";
        $method = "open.mega.player.total.report";
        $bet_data = array();
        for ($i=1; $i <= 2; $i++) { 
            $post_data = array(
                "id" => mt_rand(10000,99999),
                "method" => $method,
                "params" => array(
                    "random" => $random,
                    "digest" => md5($random.$sn.$agent.$secretCode),
                    "sn" => $sn,
                    'type' => $i,
                    'secretCode' => $secretCode,
                    "agentLoginId" => $agent,
                    'startTime' => $start_time,
                    'endTime' => $end_time,
                ),
                "jsonrpc" => "2.0",
            );
            $url = $domain.$method;
            $client = new Client();
            $request_body = json_encode($post_data);
            $response = $client->post($url, [
                            'body' => $request_body,
                        ]);
            $result = json_decode($response->getBody(), true);
            // dump($i);
            if($result['error'] == null) {
                $bet_data[$i] = $result['result'];
            }
        }
        $collection = collect($bet_data[1])->merge(collect($bet_data[2]));
        $player_array = $collection->pluck('loginId')->unique()->toArray();
        foreach ($player_array as $player) {
            $game_account = GameUser::where('game_id', $game->id)->where('username', $player)->first();
            if($game_account) {                     
                $user = $game_account->user;
                $player_win_amount = $collection->where('loginId', $player)->sum('win');
                
                $record = GameRecord::where('bet_date', $bet_date)->where('game_account_id', $game_account->id)->first();
                if($record) {
                    $record->update([
                        'win_lose_amount' => $player_win_amount,
                    ]);
                } else {
                    try{
                        DB::transaction(function() use($user, $game, $game_account, $player, $player_win_amount, $bet_date) {
                            GameRecord::create([
                                'user_id' => $user->id,
                                'player' => $user->username,
                                'game_id' => $game->id,
                                'agent_id' => $user->agent->id ?? null,
                                'game_account_id' => $game_account->id,
                                'username' => $player,
                                'bet_date' => $bet_date,
                                'win_lose_amount' => $player_win_amount,
                            ]);
                        });
                    }catch(\Exception $e){
                        DB::rollback();
                    }
                } 
            }
        }
    }
}
