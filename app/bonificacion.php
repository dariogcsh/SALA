<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bonificacion extends Model
{
    protected $fillable = [
        'tipo','descuento','costo','imagen','descripcion','desde','hasta',
    ];

    public function mibonificacions(){
        return $this->HasMany('App\mibonificacion','id_bonificacion','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
