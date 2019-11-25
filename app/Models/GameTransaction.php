<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameTransaction extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function game() {
        return $this->belongsTo(Game::class);
    }

    public function game_account() {
        return $this->belongsTo(GameUser::class);
    }
}
