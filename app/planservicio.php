<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class planservicio extends Model
{
    protected $fillable = [
        'id_user','id_tarea','estado'
    ];

    public function tareas(){
        return $this->belongsTo('App\tarea', 'id_tarea','id');
    }
}
