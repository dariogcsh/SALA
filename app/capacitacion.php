<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class capacitacion extends Model
{
    protected $fillable = [
        'nombre','codigo','modalidad','fechainicio','fechafin','horainicio','horafin','ubicacion','valoracion','horas',
        'costo','created_at','updated_at',
    ];

    public function capacitacion_users(){
        return $this->HasMany('App\capacitacion_user','id_capacitacion','id');
    }
    public function calendarios(){
        return $this->HasMany('App\calendario','id_capacitacion','id');
    }
}
