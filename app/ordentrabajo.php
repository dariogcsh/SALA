<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordentrabajo extends Model
{
    protected $fillable = [
        'id_organizacion','id_lote','id_usuarioorden','id_usuariotrabajo','fechaindicada','fechainicio','fechafin','estado','has'
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
}
