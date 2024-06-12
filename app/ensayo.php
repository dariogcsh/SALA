<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ensayo extends Model
{
    protected $fillable = [
        'id_organizacion','fecha','TipoMaq','ModeMaq','nserie','cultivo','zona','ruta','descripcion',
    ];
}
