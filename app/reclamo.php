<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reclamo extends Model
{
    //
    protected $fillable = [
        'id_organizacion','id_sucursal','fecha','origen','hallazgo','proceso','nombre_cliente','descripcion',
        'estado','causa','id_user_responsable','fecha_contacto','accion_contingencia','id_user_contingencia',
        'fecha_limite_contingencia','accion_correctiva','fecha_limite_correctiva',
        'verificacion_implementacion','id_user_implementacion','fecha_implementacion','medicion_eficiencia',
        'id_user_eficiencia','fecha_eficiencia','fecha_registro_contingencia','fecha_registro_causa',
        'vencido_contingencia','vencido_causa','created_at','updated_at'
    ];

    public function organizacions(){
        return $this->belongsTo('App\organizacion','id_organizacion','id');
    }
    public function sucursals(){
        return $this->belongsTo('App\sucursal','id_sucursal','id');
    }
}
