<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class capacitacion_user extends Model
{
    protected $fillable = [
        'id_user','id_capacitacion','tipo','estado','comentario',
    ];

    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
    public function capacitacions(){
        return $this->belongsTo('App\capacitacion','id_capacitacion','id');
    }
}
