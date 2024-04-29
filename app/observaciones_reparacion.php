<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class observaciones_reparacion extends Model
{
    protected $guarded = [];

    public function campo_obs_reparacions(){
        return $this->belongsTo('App\campo_reparacion','CodiCampoObsReparacions','id');
    }

}