<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class viaje extends Model
{
    protected $fillable = [
        'id_vehiculo','minutos','visto','url',
    ];

    public function vehiculos(){
        return $this->belongsTo('App\vehiculo','id_vehiculo','id');
    }
    public function viaje_users(){
        return $this->HasMany('App\viaje_user','id_viaje','id');
    }
    
}
