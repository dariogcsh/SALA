<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class maquina extends Model
{
    protected $fillable = [
        'NumSMaq','TipoMaq','idjdlink','MarcMaq', 'ModeMaq', 'CodiOrga','CanPMaq','MaicMaq', 'InscMaq','combine_advisor','harvest_smart',
    ];

    public function organizacions(){
        return $this->belongsTo('App\organizacion', 'CodiOrga','id');
    }
    public function asists(){
        return $this->HasMany('App\asist','id_maquina','id');
    }
    public function objetivos(){
        return $this->HasMany('App\objetivo','id_maquina','id');
    }


    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('maquinas.id','maquinas.TipoMaq','maquinas.ModeMaq','organizacions.NombOrga','maquinas.NumSMaq',
                                    'maquinas.ethernet','maquinas.horas','maquinas.combine_advisor','maquinas.harvest_smart',
                                    'sucursals.NombSucu')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
