<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditTransaction extends Model
{
    protected $guarded = [];

    public function sender(){
        if($this->sender_role == 'admin'){
            return $this->belongsTo('App\Admin', 'sender_id');
        }else if($this->sender_role == 'agent') {
            return $this->belongsTo('App\Agent', 'sender_id');
        }else if($this->sender_role == 'user') {
            return $this->belongsTo('App\User', 'sender_id');
        }        
    }

    public function receiver(){
        if($this->receiver_role == 'admin'){
            return $this->belongsTo('App\Admin', 'receiver_id');
        }else if($this->receiver_role == 'agent') {
            return $this->belongsTo('App\Agent', 'receiver_id');
        }else if($this->receiver_role == 'user') {
            return $this->belongsTo('App\User', 'receiver_id');
        }
    }  
}
