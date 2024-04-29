<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calendario extends Model
{
    protected $fillable = [
        'id_evento','id_sucursal','ubicacion','fechainicio','fechafin','horainicio','horafin','titulo',
        'descripcion','movilidad','reserva','externos','id_capacitacion','id_user',
    ];

    public function eventos(){
        return $this->belongsTo('App\evento','id_evento','id');
    }
    public function sucursals(){
        return $this->belongsTo('App\sucursal','id_sucursal','id');
    }
    public function capacitacions(){
        return $this->belongsTo('App\capacitacion','id_capacitacion','id');
    }
}
