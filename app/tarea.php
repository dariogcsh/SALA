<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tarea extends Model
{
    protected $fillable = [
        'id_organizacion','descripcion','ncor','nseriemaq','ubicacion','prioridad','fechaplan','fechafplan','turno','importe','estado'
    ];

    public function organizacions(){
        return $this->belongsTo('App\organizacion', 'id_organizacion','id');
    }
    public function planservicios(){
        return $this->HasMany('App\planservicio','id_tarea','id');
    }
    public function scopeSucursal($query, $sucursal){
        if ($sucursal) {
            return $query->where('organizacions.CodiSucu',$sucursal)
                        ->orderBy('tareas.updated_at','desc');
        }
    }
    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('tareas.id','tareas.fechaplan','sucursals.NombSucu','organizacions.NombOrga','maquinas.ModeMaq',
                                    'tareas.ncor')
                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->orderBy('tareas.updated_at','desc')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
