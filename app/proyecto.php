<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
    protected $fillable = [
        'descripcion','inicio','finalizacion','horas','presupuesto','estado','categoria'
    ];

    public function ideaproyectos(){
        return $this->HasMany('App\proyectos','id_proyecto','id');
    }

    public function users_proyectos(){
        return $this->HasMany('App\proyectos','id_proyecto','id');
    }
}
