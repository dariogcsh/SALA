<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class imgusado extends Model
{
    protected $fillable = [
        'id_usado', 'ruta',
    ];

    public function usados(){
        return $this->belongsTo('App\usado','id_usado','id');
    }
}
