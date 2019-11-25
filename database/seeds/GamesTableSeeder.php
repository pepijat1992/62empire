<?php

use Illuminate\Database\Seeder;
use App\Models\Game;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::create([
            'name' => '918kiss',
            'title' => '918Kiss',
            'type' => 'hot_game',
            'status' => 1,
            'image' => 'wap/images/games/918kiss.jpg'
        ]);
        Game::create([
            'name' => 'mega888',
            'title' => 'Mega888',
            'type' => 'hot_game',
            'status' => 1,
            'image' => 'wap/images/games/mega888.jpg'
        ]);
        Game::create([
            'name' => 'xe88',
            'title' => 'XE-88',
            'type' => 'hot_game',
            'status' => 1,
            'image' => 'wap/images/games/xe88.jpg'
        ]);
        Game::create([
            'name' => 'pussy888',
            'title' => 'Pussy888',
            'type' => 'hot_game',
            'status' => 1,
            'image' => 'wap/images/games/pussy888.jpg'
        ]);
        Game::create([
            'name' => 'joker',
            'title' => 'Joker',
            'type' => 'hot_game',
            'status' => 1,
            'image' => 'wap/images/games/joker.jpg'
        ]);
        Game::create([
            'name' => 'ag_casino',
            'title' => 'AG Casino',
            'type' => 'online_casino',
            'status' => 1,
            'image' => 'wap/images/games/ag_casino.jpg'
        ]);
        Game::create([
            'name' => 'playtech',
            'title' => 'PlayTech',
            'type' => 'online_casino',
            'status' => 1,
            'image' => 'wap/images/games/playtech.jpg'
        ]);
    }
}
