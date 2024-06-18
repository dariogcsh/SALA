<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cosecha extends Model
{
    protected $fillable =[
        'cliente','granja','organizacion','campo','nombre_maquina','pin','operador','variedad','cultivo','superficie',
        'humedad','rendimiento','combustible','fin','fin','created_at','updated_at',
    ];

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->select('organizacion','fin')
                                ->where($tipo,'LIKE',"%$buscar%")
                                ->whereIn('cosechas.fin', function ($sub) {
                                    $sub->selectRaw('max(cosechas.fin)')->from('cosechas')->groupBy('cosechas.fin'); // <---- la clave
                                })
                                ->distinct('cosechas.organizacion')
                                ->orderBy('cosechas.fin','desc');
        }
    }
}
