<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class guardiasadmin extends Model
{
    protected $fillable = [
        'id_sucursal', 'fecha'
    ];

    public function sucursals(){
        return $this->belongsTo('App\sucursal','id_sucursal','id');
    }
}
