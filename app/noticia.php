<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class noticia extends Model
{
    //
    protected $fillable = [
        'titulo','descripcion','fuente',
    ];
}
