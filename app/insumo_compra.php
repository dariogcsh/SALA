<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class insumo_compra extends Model
{
    protected $fillable = [
        'id_insumo','proveedor','nfactura','fecha_compra','bultos','semillas','litros','peso','precio','updated_at','created_at',
    ];

    public function insumos(){
        return $this->belongsTo('App\insumos','id_insumo','id');
    }

    public function scopeBuscar($query, $tipo, $buscar, $id_organizacion){
        if (($tipo) && ($buscar)){
            return $query->select('insumo_compras.proveedor','insumo_compras.fecha_compra',
                                'insumo_compras.bultos','insumo_compras.precio','insumos.nombre as nombreinsumo',
                                'insumos.categoria','marcainsumos.nombre as nombremarca','insumo_compras.id',
                                'insumo_compras.litros','insumo_compras.peso','insumo_compras.semillas',
                                'insumo_compras.nfactura')
                        ->join('insumos','insumo_compras.id_insumo','=','insumos.id')
                        ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                        ->where([[$tipo,'LIKE',"%$buscar%"], ['insumos.id_organizacion',$id_organizacion]])
                        ->orderBy('id','desc');
        }
    }
}
