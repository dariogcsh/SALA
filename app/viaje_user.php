<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class viaje_user extends Model
{
    protected $fillable = [
        'id_user','id_viaje',
    ];

    public function viajes(){
        return $this->belongsTo('App\viaje','id_viaje','id');
    }
    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
}
