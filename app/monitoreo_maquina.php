<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monitoreo_maquina extends Model
{
    protected $fillable = [
        'id_monitoreo','NumSMaq','costo'
    ];
}
