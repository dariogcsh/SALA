<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contacto extends Model
{
    protected $fillable = [
       'id_user','id_organizacion', 'persona', 'tipo','departamento','comentarios','created_at','updated_at',
    ];

    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }

    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('contactos.id','contactos.id_user','contactos.id_organizacion','organizacions.NombOrga',
                                'contactos.persona','contactos.tipo','contactos.departamento','contactos.comentarios',
                                'contactos.created_at')
                        ->join('organizacions','contactos.id_organizacion','=','organizacions.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
