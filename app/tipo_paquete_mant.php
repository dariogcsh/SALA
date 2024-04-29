<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_paquete_mant extends Model
{
    protected $fillable = [
        'modelo','costo','horas'
    ];

    public function paquetemants(){
        return $this->HasMany('App\paquetemant','id_tipo_paquete_mant','id');
    }
}
