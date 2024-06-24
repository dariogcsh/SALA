<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class insumo extends Model
{
    protected $fillable = [
        'categoria','id_organizacion','id_marcainsumo','nombre','tipo','tipo_grano','principio_activo','concentracion',
        'bultos','cantxbulto','litros','peso','semillas','precio','unidades_medidas','stock_minimo',
    ];

    public function marcainsumos(){
        return $this->belongsTo('App\marcainsumo','id_marcainsumo','id');
    }
    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }
    public function insumo_compras(){
        return $this->HasMany('App\insumo_compra','id_insumo','id');
    }

    public function scopeBuscar($query, $tipo, $buscar, $id_organizacion){
        if (($tipo) && ($buscar)){
            return $query->select('marcainsumos.nombre as nombremarca','insumos.nombre','insumos.categoria',
                                'insumos.litros','insumos.peso','insumos.id','insumos.bultos', 'insumos.tipo',
                                'insumos.tipo_grano','insumos.precio','insumos.semillas','insumos.stock_minimo',
                                'insumos.unidades_medidas')
                        ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                        ->join('organizacions','insumos.id_organizacion','=','organizacions.id')
                        ->where([[$tipo,'LIKE',"%$buscar%"], ['insumos.id_organizacion',$id_organizacion]]);
        }
    }
}
