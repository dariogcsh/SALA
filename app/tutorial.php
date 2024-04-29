<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tutorial extends Model
{
    protected $fillable = [
        'titulo','url','descripcion'
    ];
}
