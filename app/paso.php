<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paso extends Model
{
    protected $fillable = [
        'id_etapa','id_puesto','nombre','orden',
     ];

     public function entrega_pasos(){
        return $this->HasMany('App\entrega_paso','id_paso','id');
    }

    public function etapas(){
        return $this->belongsTo('App\etapa','id_etapa','id');
    }
}
