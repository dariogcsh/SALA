<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class externo extends Model
{
    protected $fillable = [
        'id','titulo','imagen','descripcion','url',
    ];
}
