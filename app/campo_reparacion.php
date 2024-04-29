<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class campo_reparacion extends Model
{
    protected $guarded = [];  

    public function observaciones(){
        return $this->hasMany('App\observaciones_reparacion','CodiCampoObsReparacions','id');
    }

    public function tareas(){
        return $this->hasMany('App\tarea_reparacion','CodiCampoReparacions','id');
    }

    protected $casts = [
        'tecnicos' => 'array'
    ];
}