<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class entrega_archivo extends Model
{
    protected $fillable = [
        'id_entrega','path',
    ];
}
