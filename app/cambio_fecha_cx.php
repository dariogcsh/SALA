<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cambio_fecha_cx extends Model
{
    protected $fillable = [
        'id_reclamo','accion', 'fecha_vieja', 'fecha_nueva',
    ];
}
