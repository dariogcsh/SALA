<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class solucion extends Model
{
    protected $fillable = [
        'DescSolu','id_asist','id_user', 'tipo', 'ruta',
    ];

    public function asists(){
        return $this->belongsTo('App\asist','id_asist','id');
    }
    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
}
