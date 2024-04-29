<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class repuesto extends Model
{
    protected $fillable = [
        'codigo','nombre','costo','margen','venta','jdpart'
    ];

    public function paquetemants(){
        return $this->HasMany('App\paquetemant','id_repuesto','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->where($tipo,'LIKE',"%$buscar%");
        }
    }
}
