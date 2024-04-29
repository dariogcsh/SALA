<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehiculo extends Model
{
    protected $fillable = [
        'nombre','patente','id_vsat',
    ];

    public function viajes(){
        return $this->HasMany('App\viaje','id_vehiculo','id');
    }
}
