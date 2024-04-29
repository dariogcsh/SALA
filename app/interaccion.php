<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class interaccion extends Model
{
    protected $fillable = [
        'id_user','modulo','enlace',
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('interaccions.id','users.name','users.last_name','interaccions.created_at',
                                'interaccions.enlace','interaccions.modulo','organizacions.NombOrga',
                                'sucursals.NombSucu')
                        ->join('users','interaccions.id_user','=','users.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
