<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calificacion extends Model
{
    protected $fillable = [
        'id_asist','id_user', 'puntos', 'descripcion',
    ];

    public function asists(){
        return $this->belongsTo('App\asist','id_asist','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('calificacions.id','users.name','users.last_name','organizacions.NombOrga','calificacions.puntos',
                                'calificacions.descripcion','calificacions.created_at')
                        ->join('asists','calificacions.id_asist','=','asists.id')
                        ->join('users','asists.id_user','=','users.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
