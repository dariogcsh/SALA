<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class entrega_paso extends Model
{
    protected $fillable = [
        'id_entrega','id_paso','id_user','detalle',
    ];

    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
    public function entregas(){
        return $this->belongsTo('App\entregas','id_entrega','id');
    }
    public function pasos(){
        return $this->belongsTo('App\paso','id_paso','id');
    }
}
