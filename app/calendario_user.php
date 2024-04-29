<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calendario_user extends Model
{
    protected $fillable = [
        'id_user','id_calendario','tipo','estado',
    ];

    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
    public function calendarios(){
        return $this->belongsTo('App\calendario','id_calendario','id');
    }
}
