<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $fillable = [
        'id_op','id_organizacion_op', 'id_organizacion', 'nombre','created_at','updated_at',
     ];

     public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }
    public function granjas(){
        return $this->HasMany('App\granja','id_cliente','id');
    }
}
