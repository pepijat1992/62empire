<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $guarded = [];

    public function admin(){
        return $this-> belongsTo('App\Admin');
    }
}
