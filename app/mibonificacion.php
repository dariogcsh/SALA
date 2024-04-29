<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mibonificacion extends Model
{
    protected $fillable = [
        'id_bonificacion','id_organizacion','estado',
    ];

    public function bonificacions(){
        return $this->belongsTo('App\bonificacion','id_bonificacion','id');
    }
    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }

    public function senals(){
        return $this->HasMany('App\senal','id_mibonificacion','id');
    }

    public function jdlinks(){
        return $this->HasMany('App\jdlink','id_mibonificacion','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('mibonificacions.id','mibonificacions.estado','bonificacions.tipo',
                                'bonificacions.descuento','organizacions.NombOrga')
                        ->join('bonificacions', 'mibonificacions.id_bonificacion','=','bonificacions.id')
                        ->join('organizacions', 'mibonificacions.id_organizacion','=','organizacions.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }

}
