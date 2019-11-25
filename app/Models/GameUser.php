<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameUser extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function game() {
        return $this->belongsTo('App\Models\Game');
    }
}
