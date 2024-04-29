<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class marcainsumo extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function insumos(){
        return $this->HasMany('App\insumo','id_marcainsumo','id');
    }
}
