<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pantalla extends Model
{
    protected $fillable = [
        'NombPant',
    ];

    public function asists(){
        return $this->HasMany('App\asist','id_pantalla','id');
    }
    public function activacions(){
        return $this->HasMany('App\activacion','pantalla_id','id');
    }
    public function usados(){
        return $this->HasMany('App\usado','id_pantalla','id');
    }
}
