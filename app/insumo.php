<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class insumo extends Model
{
    protected $fillable = [
        'categoria','id_organizacion','id_marcainsumo','nombre','tipo','principio_activo','concentracion',
        'bultos','cantxbulto','litros','peso','semillas'
    ];

    public function marcainsumos(){
        return $this->belongsTo('App\marcainsumo','id_marcainsumo','id');
    }
    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }
}
