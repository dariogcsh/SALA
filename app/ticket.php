<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    protected $fillable = [
        'id_organizacion','id_servicioscsc','nombreservicio','minutos_acumulados','estado',
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('servicioscscs.nombre','tickets.id','organizacions.NombOrga','tickets.nombreservicio',
                                'tickets.estado')
                        ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                        ->join('servicioscscs','tickets.id_servicioscsc','=','servicioscscs.id')
                        ->join('detalle_tickets','detalle_tickets.id_ticket','=','tickets.id')
                        ->join('users','detalle_tickets.id_user','=','users.id')
                        ->orderBy('tickets.id','desc')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
