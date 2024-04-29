<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reparacion extends Model
{
    protected $guarded = [];  

    public function repuestos_faltantes(){
        return $this->hasMany('App\repuesto_faltante','CodiReparacions','id');
    }
}