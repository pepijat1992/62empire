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

class RecordGi998 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:gi998';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Game Record from Gi998';

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
        $game = Game::where('name', 'gi998')->first();
        $domain = $game->domain;
        $api_id = $game->username;
        $api_key = $game->api_key;
        $timestamp = time();
        $sign = md5($api_id.$timestamp.$api_key);

        $date_from = date('d/m/Y H:i:s', strtotime($bet_date." 00:00:00"));
        $date_to = date('d/m/Y H:i:s', strtotime($bet_date." 23:59:59"));
        $post_data = [
            'api_id' => $api_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'date_from' => $date_from,
            'date_to' => $date_to,
        ];
        $url = $domain."/api/acc/getGameLog";    
        $client = new Client();
        $response = $client->post($url, [
                        'form_params' => $post_data,
                    ]);
        $result = json_decode($response->getBody(), true);
        if($result['code'] == 0) {
            $collection = collect($result['userGameLogDTO']);
            $player_array = $collection->pluck('loginId')->unique()->toArray();
            $url = $domain."/api/acc/getWinLose";
            foreach ($player_array as $player) {
                $post_data['user_id'] = $player;
                $client = new Client();
                $response = $client->post($url, [
                                'form_params' => $post_data,
                            ]);
                $result = json_decode($response->getBody(), true);
                // dump($result);
                if($result['code'] == 0) {
                    $game_account = GameUser::where('game_id', $game->id)->where('username', $player)->first();
                    if($game_account) {                     
                        $user = $game_account->user;
                        foreach ($result['reportDTO'] as $sale) {
                            $sale_date = date('Y-m-d', $sale['reportDate']/1000);
                            $record = GameRecord::where('bet_date', $sale_date)->where('game_account_id', $game_account->id)->first();
                            if($record) {
                                $record->update([
                                    'win_lose_amount' => $sale['winLose'],
                                ]);
                            } else {
                                try{
                                    DB::transaction(function() use($user, $game, $game_account, $player, $sale, $sale_date) {
                                        GameRecord::create([
                                            'user_id' => $user->id,
                                            'player' => $user->username,
                                            'game_id' => $game->id,
                                            'agent_id' => $user->agent->id ?? null,
                                            'game_account_id' => $game_account->id,
                                            'username' => $player,
                                            'bet_date' => $sale_date,
                                            'win_lose_amount' => $sale['winLose'],
                                            'currency' => $sale['currency'],
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
    }
}
