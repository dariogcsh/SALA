<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class asistenciatipo extends Model
{
    protected $fillable = [
        'NombTiAs',
    ];
    public function asists(){
        return $this->HasMany('App\asist','id_asistenciatipo','id');
    }

}
