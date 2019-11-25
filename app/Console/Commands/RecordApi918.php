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

class RecordApi918 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:api918';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Game Record from 918Kiss';

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
        $game = Game::where('name', '918kiss')->first();
        $domain = $game->domain;
        $username = $game->username;
        $secret_key = $game->api_key;
        $auth_code = $game->token;
        $timestamp =time()."000";

        $sDate = $bet_date;
        $eDate = $bet_date;
        $sign = strtoupper(md5(strtolower($auth_code.$username.$timestamp.$secret_key)));
        $url = "http://api.918kiss.com:9919/ashx/AgentTotalReport.ashx";
        $post_data = [
            'userName' => $username,
            'sDate' => $sDate,
            'eDate' => $eDate,
            'Type' => 'ServerTotalReport',
            'time' => $timestamp,
            'authcode' => $auth_code,
            'sign' => $sign,
        ];
           
        $client = new Client();
        $response = $client->post($url, [ 'form_params' => $post_data ]);
        $result = json_decode($response->getBody(), true);
        if($result['success']) {
            $collection = collect($result['results']);

            $data = $collection->where('win', '<>', 0)->all();

            foreach ($data as $item) {
                $game_account = GameUser::where('game_id', $game->id)->where('username', $item['Account'])->first();
                if($game_account) {                     
                    $user = $game_account->user;
                    $record = GameRecord::where('bet_date', $bet_date)->where('game_account_id', $game_account->id)->first();
                    if($record) {
                        $record->update([
                            'win_lose_amount' => $item['win'],
                        ]);
                    } else {
                        try{
                            DB::transaction(function() use($user, $game, $game_account, $bet_date, $item) {
                                GameRecord::create([
                                    'user_id' => $user->id,
                                    'player' => $user->username,
                                    'game_id' => $game->id,
                                    'agent_id' => $user->agent->id ?? null,
                                    'game_account_id' => $game_account->id,
                                    'username' => $item['Account'],
                                    'bet_date' => $bet_date,
                                    'win_lose_amount' => $item['win'],
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
