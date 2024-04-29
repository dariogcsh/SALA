<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_ticket extends Model
{
    protected $fillable = [
        'fecha_inicio','fecha_fin','id_user','id_ticket','detalle','tiempo',
    ];
}
