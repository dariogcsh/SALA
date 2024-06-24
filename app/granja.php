<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class granja extends Model
{
    protected $fillable = [
        'id_op','id_cliente_op', 'id_cliente', 'nombre','created_at','updated_at',
     ];

     public function clientes(){
        return $this->belongsTo('App\cliente','id_cliente','id');
    }
    public function lotes(){
        return $this->HasMany('App\lote','id_granja','id');
    }
}
