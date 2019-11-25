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

class RecordScr2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:scr2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Game Record from Scr2';

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

        if($hour == '00' && $minute < 20){
            $this->record($prev_date);
        }
        $this->record($cur_date);
    }

    public function record($bet_date) {
        $game = Game::where('name', 'scr2')->first();
        $domain = $game->domain;
        $apiuserid = $game->username;
        $apipassword = $game->password;

        $post_data = [
            'apiuserid' => $apiuserid,
            'apipassword' => $apipassword,
            'operation' => 'totalreport',
            'startdate' => $bet_date,
            'enddate' => $bet_date,
        ];
        $url = $domain."/reports";
        $client = new Client();
        $response = $client->post($url, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody(), true);
        if($result['returncode'] == 0) {
            $collection = collect($result['player_bets']);
            $player_array = $collection->pluck('playerid')->toArray();
            foreach ($collection as $sale) {
                $game_account = GameUser::where('game_id', $game->id)->where('username', $sale['playerid'])->first();
                if($game_account) {                     
                    $user = $game_account->user;
                    $record = GameRecord::where('bet_date', $bet_date)->where('game_account_id', $game_account->id)->first();
                    if($record) {
                        $record->update([
                            'win_lose_amount' => $sale['win'],
                        ]);
                    } else {
                        try{
                            DB::transaction(function() use($user, $game, $game_account, $sale, $bet_date) {
                                GameRecord::create([
                                    'user_id' => $user->id,
                                    'player' => $user->username,
                                    'agent_id' => $user->agent->id ?? null,
                                    'game_id' => $game->id,
                                    'game_account_id' => $game_account->id,
                                    'username' => $sale['playerid'],
                                    'bet_date' => $bet_date,
                                    'win_lose_amount' => $sale['win'],
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
