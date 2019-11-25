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
use Carbon\Carbon;

class RecordPlaytech extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:playtech';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Game Record from PlayTech';

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
        $game = Game::where('name', 'playtech')->first();
        // $domain = $game->domain;
        $domain = 'http://imone.imaegisapi.com/';
        $merchant_code = $game->api_key;
        $url = $domain."Report/GetBetLog";

        $result_collection = collect([]);

        $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($bet_date)));

        $start = Carbon::createFromFormat('Y-m-d H.i.s', $bet_date." 00.00.00");
        $end = Carbon::createFromFormat('Y-m-d H.i.s', $bet_date." 23.59.59");
        for ($dt = $start; $dt < $end; $dt->addMinutes(30)) {
            $start_time = $dt->format('Y-m-d H.i.s');
            $end_time = $dt->copy()->addMinutes(29)->addSeconds(59)->format('Y-m-d H.i.s');

            $post_data = array(
                'MerchantCode' => $merchant_code,
                "StartDate" => $start_time,
                "EndDate" => $end_time,            
                "Page" => 1,
                "PageSize" => 5000,
                'ProductWallet' => 102,
                "Currency" => "MYR",
            );

            $response = $this->curl($post_data);

            $result = json_decode($response, true);
            if($result['Code'] == 0){
                // $result_data = array_merge($result_data, $result['Result']);
                $collection = collect($result['Result']);
                $player_array = $collection->pluck('PlayerName')->unique()->toArray();
                
                foreach ($player_array as $player) {
                    $player_win_amount = $collection->where('PlayerName', $player)->sum(function($value) {
                        return $value['Bet'] - $value['Win'];
                    });
                    $player_data = $result_collection->firstWhere('PlayerName', $player);
                    if($player_data) {
                        $result_collection->transform(function($item) use($player, $player_win_amount) {
                            if($item['PlayerName'] = $player) $item['WinAmount'] += $player_win_amount;
                            return $item;
                        });
                    } else {
                        $result_collection->push(['PlayerName' => $player, 'WinAmount' => $player_win_amount]);
                    }
                }
            }            
        }

        // dd($result_collection);
        
        if($result_collection->count()) {
            foreach ($result_collection as $item) {
                $player = $item['PlayerName'];
                $game_account = GameUser::where('game_id', $game->id)->where('username', $player)->first();
                if($game_account) {                     
                    $user = $game_account->user;
                    $player_win_amount = $item['WinAmount'];
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

    public function curl($post_data) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://imone.imaegisapi.com/Report/GetBetLog",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($post_data),
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Type: application/json",
                "Host: imone.imaegisapi.com",
                "Postman-Token: 0db176a1-9fc5-4f06-98d2-6042f07b736d,33044656-3eac-423c-8e22-9472df53d3b6",
                "User-Agent: PostmanRuntime/7.19.0",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            // echo "cURL Error #:" . $err;
            return 'error';
        } else {
            return $response;
        }
    }
}
