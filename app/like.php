<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    protected $fillable = [
        'id_noticia','id_user', 'categoria',
     ];
}
