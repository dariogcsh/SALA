<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cosecha extends Model
{
    protected $fillable =[
        'cliente','granja','organizacion','campo','nombre_maquina','pin','operador','variedad','cultivo','superficie',
        'humedad','rendimiento','combustible','inicio','fin','created_at','updated_at',
    ];
}
