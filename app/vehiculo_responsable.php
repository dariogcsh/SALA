<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehiculo_responsable extends Model
{
    protected $fillable = [
        'id_user','id_vehiculo',
    ];
}
