<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mezcla_insu extends Model
{
    protected $fillable = [
        'id_mezcla', 'id_insumo','cantidad',
    ];
    
    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }
}
