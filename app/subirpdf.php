<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subirpdf extends Model
{
    protected $fillable = [
        'titulo','tipo','ruta','ventastipo',
    ];
}
