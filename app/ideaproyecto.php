<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ideaproyecto extends Model
{
    protected $fillable = [
        'id_user','id_proyecto','descripcion','estado',
    ];

    public function proyectos(){
        return $this->belongsTo('App\proyectos','id_proyecto','id');
    }
    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
}
