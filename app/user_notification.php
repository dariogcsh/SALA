<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_notification extends Model
{
    protected $fillable = [
        'title','body','path','estado','id_user',
    ];

    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
    
}
