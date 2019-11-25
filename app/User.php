<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cache;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $role = 'user';

    public function isOnline() {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    public function bank_accounts(){
        return $this->hasMany('App\Models\BankAccount');
    }
    public function deposits(){
        return $this->hasMany('App\Models\Deposit');
    }
    public function withdraws(){
        return $this->hasMany('App\Models\Withdraw');
    }
    public function games(){
        return $this->hasMany('App\Models\GameUser');
    }
    public function game_transactions(){
        return $this->hasMany('App\Models\GameTransaction');
    }
    public function game_records(){
        return $this->hasMany('App\Models\GameRecord');
    }
    public function free_bonuses(){
        return $this->hasMany('App\Models\FreeBonus');
    }
}
