<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alerta extends Model
{
    protected $fillable = [
        'fecha','hora','descripcion','pin','accion','presupuesto','cor','notificado','lat','lon','id_alert','codigo',
        'id_useraccion'
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('organizacions.NombOrga','alertas.id','alertas.fecha','alertas.hora'
                                ,'alertas.descripcion', 'alertas.pin','alertas.accion','maquinas.TipoMaq'
                                ,'maquinas.ModeMaq','alertas.descripcion','users.name','users.last_name', 'sucursals.NombSucu')
                        ->leftjoin('users','alertas.id_useraccion','users.id')
                        ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->orderBy('alertas.id','desc')
                        ->where([[$tipo,'LIKE',"%$buscar%"], ['InscMaq','SI']]);
        }
    }
}
