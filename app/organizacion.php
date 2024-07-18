<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class organizacion extends Model
{
    //
    protected $fillable = [
        'CodiOrga','NombOrga','CodiSucu','InscOrga','CUIT',
    ];

    public function sucursals(){
        return $this->belongsTo('App\sucursal', 'CodiSucu','id');
    }
    public function users(){
        return $this->HasMany('App\User','CodiOrga','id');
    }
    public function maquinas(){
        return $this->HasMany('App\maquina','CodiOrga','id');
    }
    public function tareas(){
        return $this->HasMany('App\tarea','id_organizacion','id');
    }
    public function mails(){
        return $this->HasMany('App\mail','OrgaMail','id');
    }
    public function mibonificacions(){
        return $this->HasMany('App\mibonificacion','id_organizacion','id');
    }
    public function senals(){
        return $this->HasMany('App\senal','id_organizacion','id');
    }
    public function reclamos(){
        return $this->HasMany('App\reclamo','id_organizacion','id');
    }
    public function contactos(){
        return $this->HasMany('App\contacto','id_organizacion','id');
    }
    public function activacions(){
        return $this->HasMany('App\activacion','organizacion_id','id');
    }
    public function paqueteagronomicos(){
        return $this->HasMany('App\paqueteagronomico','id_organizacion','id');
    }
    public function insumos(){
        return $this->HasMany('App\insumo','id_organizacion','id');
    }
    public function mezclas(){
        return $this->HasMany('App\mezcla','id_organizacion','id');
    }
    public function entregas(){
        return $this->HasMany('App\entrega','id_organizacion','id');
    }
    public function ordentrabajos(){
        return $this->belongsTo('App\ordentrabajo','id_organizacion','id');
    }
    public function clientes(){
        return $this->HasMany('App\cliente','id_organizacion','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('organizacions.id','organizacions.NombOrga','sucursals.NombSucu','organizacions.InscOrga',
                                'organizacions.CUIT')
                        ->leftjoin('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
