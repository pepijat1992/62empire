<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function promotion() {
        return $this->belongsTo('App\Models\Promotion');
    }

    public function bank_account() {
        return $this->belongsTo(BankAccount::class);
    }
}
