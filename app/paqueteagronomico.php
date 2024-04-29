<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paqueteagronomico extends Model
{
    protected $fillable = [
        'id_organizacion','altimetria','hectareas','costo','suelo','compactacion','vencimiento','anofiscal','lotes',
    ];

    public function organizacions(){
        return $this->belongsTo('App\organizacion', 'id_organizacion','id');
    }
    public function paquete_maquinas(){
        return $this->HasMany('App\paquete_maquina','id_paquete','id');
    }
}
