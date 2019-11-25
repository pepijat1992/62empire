<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Agent extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];
    public $role = 'agent';

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function agents() {
        return $this->hasMany(Agent::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
    
    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    public function game_records() {
        return $this->hasMany('App\Models\GameRecord');
    }

}