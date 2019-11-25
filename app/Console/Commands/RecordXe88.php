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

class RecordXe88 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:xe88';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle() {
        $cur_date = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime("yesterday"));

        $hour = date('H');
        $minute = date('i');

        if($hour == '00' && $minute <= 20){
            $this->record($prev_date);
        }

        $this->record($cur_date); 
    }

    public function record($bet_date)
    {
        $game = Game::where('name', 'xe88')->first();
        $domain = $game->domain;
        $agent_id = $game->agent;
        $signature_key = $game->api_key;
        $prefix = $game->prefix;
        $url = $domain . "customreport/playerreport";

        $date_from = $bet_date." 00:00:00";
        $date_to = $bet_date." 23:59:59";

        $per_page = 500;
        $page = 1;
        $total_pages = 1;
        do {
            $post_data = array(
                'agentid' => $agent_id,
                'startdate' => $date_from,
                'enddate' => $date_to,
                'page' => $page,
                'perpage' => $per_page,
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
            $result = json_decode($response->getBody(), true);
            if($result['code'] == 0){
                $sales = $result['result'];
                $page++;
                $total_pages = $result['pagination']['totalpages'];
                foreach ($sales as $sale) {
                    $game_account = GameUser::where('game_id', $game->id)->where('username', $sale['username'])->first();
                    if($game_account) {
                        $user = $game_account->user;
                        $record = GameRecord::where('bet_date', $bet_date)->where('game_account_id', $game_account->id)->first();
                        if($record) {
                            $record->update([
                                'win_lose_amount' => $sale['houseearnings'],
                            ]);
                        } else {
                            try{
                                DB::transaction(function() use($user, $game, $game_account, $sale, $bet_date) {
                                    GameRecord::create([
                                        'user_id' => $user->id,
                                        'player' => $user->username,
                                        'game_id' => $game->id,
                                        'agent_id' => $user->agent->id ?? null,
                                        'game_account_id' => $game_account->id,
                                        'username' => $sale['username'],
                                        'bet_date' => $bet_date,
                                        'win_lose_amount' => $sale['houseearnings'],
                                    ]);
                                });
                            }catch(\Exception $e){
                                DB::rollback();
                            }
                        } 
                    }
                }
            }            
        } while ($page <= $total_pages);
    }
}
