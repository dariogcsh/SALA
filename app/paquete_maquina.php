<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paquete_maquina extends Model
{
    protected $fillable = [
        'id_paquete','id_jdlink',
    ];

    public function paqueteagronomicos(){
        return $this->belongsTo('App\paqueteagronomico', 'id_paquete','id');
    }
    public function jdlinks(){
        return $this->belongsTo('App\jdlink', 'id_jdlink','id');
    }
}
