<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeBonus extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
