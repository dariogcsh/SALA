<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conectividad extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function usados(){
        return $this->HasMany('App\usado','id_conectividad','id');
    }
}
