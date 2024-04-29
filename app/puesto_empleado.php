<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class puesto_empleado extends Model
{
    //
    protected $fillable = [
        'NombPuEm',
    ];

    public function users(){
        return $this->HasMany('App\User','CodiPuEmp','id');
    }
    
}
