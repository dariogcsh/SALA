<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monitoreo extends Model
{
    protected $fillable = [
        'id_organizacion','mes_facturacion','fecha_solicitada','costo_total','estado','factura','fecha_facturada','tipo','anofiscal'
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('monitoreos.id', 'maquinas.TipoMaq', 'maquinas.ModeMaq', 'monitoreos.mes_facturacion',
                                            'monitoreos.fecha_solicitada', 'costo_total', 'monitoreos.estado', 'monitoreos.factura',
                                            'monitoreos.fecha_facturada', 'monitoreos.tipo','organizacions.NombOrga',
                                            'sucursals.NombSucu')
                                    ->join('organizacions','monitoreos.id_organizacion','=','organizacions.id')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->join('monitoreo_maquinas','monitoreos.id','=','monitoreo_maquinas.id_monitoreo')
                                    ->leftjoin('maquinas','monitoreo_maquinas.NumSMaq','=','maquinas.NumSMaq')
                                    ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
