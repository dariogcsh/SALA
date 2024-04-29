<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class repuesto_faltante extends Model
{
    protected $guarded = [];  

    public function reparacions(){
        return $this->belongsTo('App\reparacion','CodiReparacions','id');
    }

}