<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usado extends Model
{
    protected $fillable = [
        'ingreso','excliente','tipo','marca','modelo','ano','nserie','patente','traccion','rodado','horasm','horast',
        'desparramador','agprecision','nrodado','nrodadotras','rodadoest','rodadoesttras','plataforma','cabina','hp',
        'transmision','nseriemotor','tomafuerza','bombah','botalon','tanque','picos','corte','categoria','surcos','monitor',
        'dosificacion','fertilizacion','tolva','fertilizante','distancia','reqhidraulico','estado','precio',
        'comentarios','fechafact','fechareserva','fechahasta','id_sucursal','id_vendedor','id_vreserva','id_antena',
        'activacion_antena','id_pantalla','activacion_pantalla','camaras','prodrive','id_conectividad',
        'precio_reparacion','comentario_reparacion','ancho_plataforma','configuracion_roto','cantidad_rollos',
        'cutter','monitor_roto','espaciamiento','reservado_para','create_at','updated_at',
    ];
    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
    public function sucursals(){
        return $this->belongsTo('App\sucursal','id_sucursal','id');
    }
    public function conectividads(){
        return $this->belongsTo('App\conectividad','id_conectividad','id');
    }

    public function imgusados(){
        return $this->HasMany('App\imgusado','id_usado','id');
    }
    public function antenas(){
        return $this->HasMany('App\antena','id_antena','id');
    }
    public function pantallas(){
        return $this->HasMany('App\pantalla','id_pantalla','id');
    }

    
}
