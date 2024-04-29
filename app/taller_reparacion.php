<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class taller_reparacion extends Model
{
    protected $guarded = [];  

    public function tareas(){
        return $this->hasMany('App\tarea_reparacion','CodiTallerReparacions','id');
    }
}