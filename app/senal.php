<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class senal extends Model
{
    protected $fillable = [
        'id_mibonificacion','id_organizacion','id_antena','nserie','duracion','activacion','costo','estado','nfactura','id_user',
    ];

    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }

    public function antenas(){
        return $this->belongsTo('App\antena','id_antena','id');
    }

    public function users(){
        return $this->belongsTo('App\user','id_user','id');
    }

    public function mibonificacions(){
        return $this->belongsTo('App\mibonificacion','id_mibonificacion','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('senals.id','organizacions.NombOrga','antenas.NombAnte','senals.nserie','senals.created_at',
                                'senals.activacion','senals.duracion','senals.costo','senals.estado','senals.nfactura',
                                'users.name','users.last_name')
                        ->leftjoin('users','senals.id_user','=','users.id')
                        ->join('organizacions','senals.id_organizacion','=','organizacions.id')
                        ->join('antenas','senals.id_antena','=','antenas.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
