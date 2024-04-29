<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class antena extends Model
{
    protected $fillable = [
        'NombAnte',
    ];

    public function asists(){
        return $this->HasMany('App\asist','id_antena','id');
    }
    public function senals(){
        return $this->HasMany('App\senal','id_antena','id');
    }
    public function activacions(){
        return $this->HasMany('App\activacion','id_antena','id');
    }
    public function usados(){
        return $this->HasMany('App\usado','id_antena','id');
    }
}
