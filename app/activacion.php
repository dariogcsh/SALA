<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activacion extends Model
{
    protected $fillable = [
        'organizacion_id','pantalla_id','id_antena','nserie','suscripcion_id','duracion','precio','fecha','estado','nfactura',
        'id_user',
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('activacions.id','organizacions.NombOrga','antenas.NombAnte','activacions.nserie'
                                ,'activacions.created_at','activacions.fecha','suscripcions.nombre','activacions.duracion'
                                ,'activacions.precio','activacions.estado','activacions.nfactura','pantallas.NombPant',
                                'users.name','users.last_name','activacions.id_user')
                        ->leftjoin('users','activacions.id_user','=','users.id')
                        ->join('organizacions','activacions.organizacion_id','=','organizacions.id')
                        ->leftjoin('antenas','activacions.id_antena','=','antenas.id')
                        ->leftjoin('pantallas','activacions.pantalla_id','=','pantallas.id')
                        ->join('suscripcions','activacions.suscripcion_id','=','suscripcions.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }


    public function organizacions(){
        return $this->belongsTo('App\organizacion','organizacion_id','id');
    }
    public function pantallas(){
        return $this->belongsTo('App\pantalla','pantalla_id','id');
    }
    public function antenas(){
        return $this->belongsTo('App\antena','id_antena','id');
    }
    public function suscripcions(){
        return $this->belongsTo('App\suscripcion','suscripcion_id','id');
    }
    public function users(){
        return $this->belongsTo('App\user','id_user','id');
    }
}
