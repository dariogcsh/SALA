<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_proyecto extends Model
{
    protected $fillable = [
        'id_user','id_proyecto',
    ];

    public function proyectos(){
        return $this->belongsTo('App\proyectos','id_proyecto','id');
    }

    public function users(){
        return $this->belongsTo('App\Users','id_user','id');
    }

}
