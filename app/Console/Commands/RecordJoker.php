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

class RecordJoker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:joker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Game Record from Joker';

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
        $game = Game::where('name', 'joker')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $app_id = $game->username;
        $timestamp =time();
        $method = "RWL";
        $signature = base64_encode(hash_hmac("sha1", "EndDate=".$bet_date."&Method=".$method."&StartDate=".$bet_date."&Timestamp=".$timestamp, $secret_key, true));
        $signature = urlencode($signature);
        $post_data = array(
            'Method' => 'RWL',
            'Timestamp' => $timestamp,
            'StartDate' => $bet_date,
            'EndDate' => $bet_date,
        );
        $url = $domain."?AppID=".$app_id."&Signature=".$signature;
        $client = new Client();
        $request_body = json_encode($post_data);
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        if(isset($result['Winloss']) && is_array($result['Winloss'])) {
            $collection = collect($result['Winloss']);
            $player_array = $collection->pluck('Username')->unique()->toArray();
            foreach ($player_array as $player) {
                $game_account = GameUser::where('game_id', $game->id)->where('username', $player)->first();
                if($game_account) {                     
                    $user = $game_account->user;
                    $player_amount = $collection->where('Username', $player)->sum('Amount');
                    $player_result = $collection->where('Username', $player)->sum('Result');
                    $player_win_amount = $player_amount - $player_result;
                    
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
}
