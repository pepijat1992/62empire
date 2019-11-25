<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];
    public $role = 'admin';

    protected $hidden = [
        'password', 'remember_token',
    ];
}