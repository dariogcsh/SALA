<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orden_insumo extends Model
{
    protected $fillable = [
        'id_ordentrabajo','insumo','unidades','kg','lts',
    ];

    public function ordentrabajos(){
        return $this->belongsTo('App\ordentrabajo','id_ordentrabajo','id');
    }
}
