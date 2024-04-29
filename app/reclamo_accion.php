<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reclamo_accion extends Model
{
    protected $fillable = [
        'id_reclamo','id_user_correctiva','created_at','updated_at'
    ];
}
