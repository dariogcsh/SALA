<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class asist extends Model
{
    protected $fillable = [
        'CodDAsis','DescAsis','EstaAsis','id_organizacion','id_asistenciatipo','id_user','id_maquina',
        'id_pantalla','id_antena','MaPaAsis','PiloAsis','TipoAsis','PrimAsis',
        'CondAsis','PrueAsis','CualAsis','CambAsis','DeriAsis','TecnAsis','ResuAsis', 'CMinAsis','DeReAsis',
        'dtac','ndtac','create_at','updated_at',
    ];

    public function asistenciatipos(){
        return $this->belongsTo('App\asistenciatipo','id_asistenciatipo','id');
    }
    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
    public function maquinas(){
        return $this->belongsTo('App\maquina','id_maquina','id');
    }
    public function pantallas(){
        return $this->belongsTo('App\pantalla','id_pantalla','id');
    }
    public function antenas(){
        return $this->belongsTo('App\antena','id_antena','id');
    }
    public function solucions(){
        return $this->HasMany('App\solucion','id_asist','id');
    }
    public function calificacions(){
        return $this->HasMany('App\calificacion','id_asist','id');
    }
}
