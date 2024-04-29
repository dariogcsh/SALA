<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class capacitacion extends Model
{
    protected $fillable = [
        'nombre','codigo','modalidad','fechainicio','fechafin','valoracion','horas','tipo','costo','estado',
    ];

    public function capacitacion_users(){
        return $this->HasMany('App\capacitacion_user','id_capacitacion','id');
    }
    public function calendarios(){
        return $this->HasMany('App\calendario','id_capacitacion','id');
    }
}
