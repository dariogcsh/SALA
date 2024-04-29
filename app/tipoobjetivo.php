<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoobjetivo extends Model
{
    //
    protected $fillable = [
        'nombre',
    ];

    public function objetivos(){
        return $this->HasMany('App\objetivo','id_tipoobjetivo','id');
    }
}
