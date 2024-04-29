<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class etapa extends Model
{
    protected $fillable = [
        'nombre','orden',
     ];

     public function pasos(){
        return $this->HasMany('App\paso','id_etapa','id');
    }
 
}
