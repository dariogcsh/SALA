<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utilidad extends Model
{
    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('organizacions.NombOrga','utilidads.FecIUtil','sucursals.NombSucu',
            'organizacions.CodiOrga')
                        ->join('maquinas','utilidads.NumsMaq','=','maquinas.NumSMaq')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->where([[$tipo,'LIKE',"%$buscar%"], ['SeriUtil','Trabajando'],
                                ['ValoUtil','>=',1], ['UOMUtil','hr']]);
        }
    }
}
