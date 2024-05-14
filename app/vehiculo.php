<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehiculo extends Model
{
    protected $fillable = [
        'nombre','patente','id_vsat','marca','modelo','ano','tipo_registro','seguro','vto_poliza','id_sucursal',
        'departamento','nvehiculo','nchasis','nmotor',
    ];

    public function viajes(){
        return $this->HasMany('App\viaje','id_vehiculo','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('vehiculos.id','vehiculos.nombre','vehiculos.id_vsat','vehiculos.nombre',
                                'vehiculos.marca','vehiculos.modelo','vehiculos.ano','vehiculos.nvehiculo',
                                'vehiculos.patente','sucursals.NombSucu','vehiculos.seguro','vehiculos.tipo_registro',
                                'vehiculos.vto_poliza')
                        ->leftjoin('sucursals','vehiculos.id_sucursal','=','sucursals.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
