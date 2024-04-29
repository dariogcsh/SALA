<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suscripcion extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function activacions(){
        return $this->HasMany('App\activacion','suscripcion_id','id');
    }
}
