<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tarea_reparacion extends Model
{
    protected $guarded = [];  

    public function campo_reparacions(){
        return $this->belongsTo('App\campo_reparacion','CodiCampoReparacions','id');
    }

    public function taller_reparacions(){
        return $this->belongsTo('App\taller_reparacion','CodiTallerReparacions','id');
    }

}