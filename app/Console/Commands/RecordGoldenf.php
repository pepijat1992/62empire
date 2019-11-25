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

class RecordGoldenf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:goldenf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Game Record from AG Casino';

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
        $game = Game::where('name', 'goldenf')->first();
        $domain = $game->domain;
        $secret_key = $game->api_key;
        $operator_token = $game->token;

        $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($bet_date)));
        $start_time = strtotime($prev_date." 16:00:00") * 1000;
        $end_time = strtotime($bet_date." 15:59:59") * 1000;
        $post_data = [
            'secret_key' => $secret_key,
            'operator_token' => $operator_token,
            'row_version' => $start_time,
            'vendor_code' => 'AG',
            'count' => 200000,
            'timestamp_digit' => 10,
        ];
        
        $url = $domain."Bet/Record/Get";    
        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        if($result['error'] == null) {
            $collection = collect($result['data']['betlogs']);
            $collection = $collection->whereBetween('created_at', [$start_time / 1000, $end_time / 1000]);
            $player_array = $collection->pluck('player_name')->unique()->toArray();
            foreach ($player_array as $player) {
                $game_account = GameUser::where('game_id', $game->id)->where('username', $player)->first();
                if($game_account) {                     
                    $user = $game_account->user;
                    $player_win_amount = $collection->where('player_name', $player)->sum(function($value) {
                        return $value['bet_amount'] - $value['win_amount'];
                    });
                    
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
