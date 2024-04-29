<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class entrega extends Model
{
    protected $fillable = [
        'id_organizacion','id_sucursal','tipo','marca','modelo','pin','detalle',
    ];

    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }
    public function sucursals(){
        return $this->belongsTo('App\sucursal','id_sucursal','id');
    }
    public function entrega_pasos(){
        return $this->HasMany('App\entrega_paso','id_entrega','id');
    }
}