<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class informe extends Model
{
    protected $fillable = [
        'id','FecIInfo','FecFInfo','NumSMaq','CodiOrga','HsTrInfo','TipoInfo','CultInfo','EstaInfo','URLInfo',
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('informes.id','organizacions.CodiOrga','organizacions.NombOrga',
                                'informes.NumSMaq','informes.FecIInfo','informes.FecFInfo','informes.HsTrInfo',
                                'informes.CultInfo')
                        ->join('organizacions','informes.CodiOrga','=','organizacions.CodiOrga')
                        ->join('maquinas','informes.NumSMaq','=','maquinas.NumSMaq')
                        ->where([[$tipo,'LIKE',"%$buscar%"], ['informes.EstaInfo', 'Enviado']])
                        ->orderBy('informes.id','desc');
        }
    }

    public function scopeBuscarCliente($query, $tipo, $buscar, $organ){
        if (($tipo) && ($buscar)){
            return $query->select('informes.id','organizacions.CodiOrga','organizacions.NombOrga',
                                'informes.NumSMaq','informes.FecIInfo','informes.FecFInfo','informes.HsTrInfo',
                                'informes.CultInfo')
                        ->join('organizacions','informes.CodiOrga','=','organizacions.CodiOrga')
                        ->join('maquinas','informes.NumSMaq','=','maquinas.NumSMaq')
                        ->where([[$tipo,'LIKE',"%$buscar%"], ['organizacions.CodiOrga', $organ], 
                                ['informes.EstaInfo', 'Enviado']])
                                ->orderBy('informes.id','desc');
        }
    }
}
