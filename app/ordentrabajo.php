<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordentrabajo extends Model
{
    protected $fillable = [
        'tipo','id_organizacion','id_lote','id_usuarioorden','id_usuariotrabajo','fechaindicada','fechainicio','fechafin'
        ,'estado','has','prescripcion',
    ];
    public function users(){
        return $this->belongsTo('App\User','id_usuarioorden','id');
        return $this->belongsTo('App\User','id_usuariotrabajo','id');
    }
    public function lotes(){
        return $this->belongsTo('App\lote','id_lote','id');
    }
    public function orden_insumos(){
        return $this->HasMany('App\orden_insumo','id_ordentrabajo','id');
    }
    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->where($tipo,'LIKE',"%$buscar%");
        }
    }

    public function scopeFecha($query, $fechainicio, $fechafin){
        if (($fechainicio) && ($fechafin)){
            return $query->where([['fechainicio','>=',$fechainicio],['fechafin','<=',$fechafin]]);
        }
    }

    public function scopeLote($query, $lote){
        if ($lote) {
            return $query->where('id_lote',"$lote");
        }
    }

    public function scopeTrabajo($query, $trabajo){
        if ($trabajo) {
            return $query->where('tipo',"$trabajo");
        }
    }

    public function scopeProducto($query, $producto){
        if ($producto) {
            return $query->join('orden_insumos','ordentrabajos.id','=','orden_insumos.id_ordentrabajo')
                        ->where('orden_insumos.insumo',"$producto");
        }
    }

    public function scopeOperario($query, $operario){
        if ($operario) {
            return $query->where('id_usuariotrabajo',"$operario");
        }
    }

    public function scopeEstado($query, $estado){
        if ($estado) {
            return $query->where('estado',"$estado");
        }
    }
}
