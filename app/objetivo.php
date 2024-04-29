<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class objetivo extends Model
{
    //
    protected $fillable = [
        'id_tipoobjetivo','id_maquina','objetivo','cultivo','ano','establecido',
    ];

    public function tipoobjetivos(){
        return $this->belongsTo('App\tipoobjetivo', 'id_tipoobjetivo','id');
    }
    public function maquinas(){
        return $this->belongsTo('App\maquina', 'id_maquina','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('maquinas.NumSMaq','organizacions.NombOrga','tipoobjetivos.nombre',
                                'objetivos.objetivo','objetivos.id','objetivos.cultivo','objetivos.ano',
                                'objetivos.establecido','maquinas.ModeMaq','maquinas.nombre as nomb_maq')
                        ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                        ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
