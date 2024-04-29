<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paquetemant extends Model
{
    protected $fillable = [
        'horas','id_repuesto','id_tipo_paquete_mant','cantidad','descripcion'
    ];

    public function repuestos(){
        return $this->belongsTo('App\repuesto','id_repuesto','id');
    }

    public function tipo_paquete_mant(){
        return $this->belongsTo('App\tipo_paquete_mant','id_tipo_paquete_mant','id');
    }

    public function mant_maqs(){
        return $this->HasMany('App\paquetemant','id_paquetemant','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('paquetemants.id','paquetemants.horas','tipo_paquete_mants.modelo',
                                'tipo_paquete_mants.horas as horasmant','repuestos.codigo','repuestos.nombre',
                                'cantidad','paquetemants.descripcion')
                        ->join('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                        ->join('repuestos','paquetemants.id_repuesto','=','repuestos.id')
                        ->where($tipo,'LIKE',"%$buscar%")
                        ->orderBy('tipo_paquete_mants.modelo','asc')
                        ->orderBy('paquetemants.horas','asc')
                        ->orderBy('paquetemants.descripcion','asc');
        }
    }
    
}
