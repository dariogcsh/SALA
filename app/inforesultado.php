<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inforesultado extends Model
{
    protected $fillable = [
        'NumSMaq','indicador', 'valor', 'mejorar','created_at','updated_at',
    ];
}
