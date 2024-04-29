<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class velocidad_limite extends Model
{
    protected $fillable = [
        'pin','limite',
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('velocidad_limites.id', 'velocidad_limites.pin',
                                'velocidad_limites.limite','organizacions.NombOrga')
                        ->join('maquinas','velocidad_limites.pin','=','maquinas.NumsMaq')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
