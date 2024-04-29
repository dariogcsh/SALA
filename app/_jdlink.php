<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class jdlink extends Model
{
    protected $fillable = [
        'NumSMaq','id_mibonificacion','conectado','monitoreo','soporte_siembra','actualizacion_comp','capacitacion_op','ensayo',
        'capacitacion_asesor','ordenamiento_agro','visita_inicial','check_list','informes','alertas','mantenimiento','apivinculada','analisis_final',
        'limpieza_inyectores','hectareas','costo','contrato_firmado','factura','anofiscal','vencimiento_contrato','asesor',
        'calibracion_implemento','analisis_final','fecha_visita','fecha_comienzo','calidad_siembra','muestreo','ambientes',
    ];

    public function mibonificacions(){
        return $this->belongsTo('App\mibonificacion','id_mibonificacion','id');
    }

    public function paquete_maquinas(){
        return $this->HasMany('App\paquete_maquina','id_jdlink','id');
    }

    public function scopeBuscar($query, $tipo, $buscar){
        if (($tipo) && ($buscar)){
            return $query->where($tipo,'LIKE',"%$buscar%");
        }
    }

    public function scopeSucursal($query, $sucursal){
        if ($sucursal) {
            return $query->where('organizacions.CodiSucu',$sucursal);
        }
    }

    public function scopeTipoMaq($query, $tipomaq){
        if ($tipomaq) {
            return $query->where('maquinas.TipoMaq',$tipomaq);
        }
    }

    public function scopeModeMaq($query, $modemaq){
        if ($modemaq) {
            return $query->where('maquinas.ModeMaq',$modemaq);
        }
    }

    public function scopeAnoFiscal($query, $anofiscal){
        if ($anofiscal) {
            return $query->where('anofiscal',$anofiscal);
        }
    }

    public function scopeConectado($query, $conectado, $cno){
        if (($conectado <> "") AND ($conectado <> "")) {
            return $query->where('conectado',$conectado)
                        ->orWhere('conectado',$cno);
        }elseif ($conectado <> ""){
            return $query->where('conectado',$conectado);
        }elseif ($cno <> ""){
            return $query->where('conectado',$cno);
        }
    }

    public function scopeMonitoreo($query, $monitoreo, $mno){
        $hoy = Carbon::today();
        if (($monitoreo <> "") AND ($mno <> "")) {
            return $query->where([['monitoreo',$monitoreo], ['vencimiento_contrato','>=',$hoy]])
                        ->orWhere('monitoreo',$mno);
        }elseif ($monitoreo <> ""){
            return $query->where([['monitoreo',$monitoreo], ['vencimiento_contrato','>=',$hoy]]);
        }elseif ($mno <> ""){
            return $query->where('monitoreo',$mno);
        }
    }

    public function scopeSsiembra($query, $soporte_siembra, $sno){
        if (($soporte_siembra <> "") AND ($sno <> "")) {
            return $query->where('soporte_siembra',$soporte_siembra)
                        ->orWhere('soporte_siembra',$sno);
        }elseif ($soporte_siembra <> ""){
            return $query->where('soporte_siembra',$soporte_siembra);
        }elseif ($sno <> ""){
            return $query->where('soporte_siembra',$sno);
        }
    }

    public function scopeInformes($query, $informes, $ino){
        if (($informes <> "") AND ($ino <> "")) {
            return $query->where('informes',$informes)
                    ->orWhere('informes',$ino);
        }elseif ($informes <> ""){
            return $query->where('informes',$informes);
        }elseif ($ino <> ""){
            return $query->where('informes',$ino);
        }
    }

    public function scopeOrdenamiento($query, $ordensi, $ordenno){
        if (($ordensi <> "") AND ($ordenno <> "")) {
            return $query->where('ordenamiento_agro',$ordensi)
                        ->orWhere('ordenamiento_agro',$ordenno);
        }elseif ($ordensi <> ""){
            return $query->where('ordenamiento_agro',$ordensi);
        }elseif ($ordenno <> ""){
            return $query->where('ordenamiento_agro',$ordenno);
        }
    }

    public function scopeMantenimiento($query, $var1, $var2, $var3){
        if (($var2 <> "") AND ($var3 <> "") AND ($var1 <> "")) {
            return $query->where('mantenimiento',$var2)
                        ->orWhere('mantenimiento',$var3)
                        ->orWhere('mantenimiento',$var1);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('mantenimiento',$var1)
                        ->orWhere('mantenimiento',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('mantenimiento',$var1)
                        ->orWhere('mantenimiento',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('mantenimiento',$var2)
                        ->orWhere('mantenimiento',$var3);
        }elseif ($var1 <> ""){
            return $query->where('mantenimiento',$var1);
        }elseif ($var2 <> ""){
            return $query->where('mantenimiento',$var2);
        }elseif ($var3 <> ""){
            return $query->where('mantenimiento',$var3);
        }
    }

    public function scopeActualizacion($query, $var1, $var2, $var3, $var4){
        if (($var1 <> "") AND ($var2 <> "") AND ($var3 <> "")) {
            return $query->where('actualizacion_comp',$var1)
                        ->orWhere('actualizacion_comp',$var2)
                        ->orWhere('actualizacion_comp',$var3);
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var4 <> "")) {
            return $query->where('actualizacion_comp',$var1)
                        ->orWhere('actualizacion_comp',$var2)
                        ->orWhere('actualizacion_comp',$var4);
        }elseif (($var1 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('actualizacion_comp',$var1)
                        ->orWhere('actualizacion_comp',$var3)
                        ->orWhere('actualizacion_comp',$var4);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('actualizacion_comp',$var2)
                        ->orWhere('actualizacion_comp',$var3)
                        ->orWhere('actualizacion_comp',$var4);
        }elseif (($var1 <> "") AND ($var4 <> "")) {
            return $query->where('actualizacion_comp',$var1)
                        ->orWhere('actualizacion_comp',$var4);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('actualizacion_comp',$var1)
                        ->orWhere('actualizacion_comp',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('actualizacion_comp',$var1)
                        ->orWhere('actualizacion_comp',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('actualizacion_comp',$var2)
                        ->orWhere('actualizacion_comp',$var3);
        }elseif (($var2 <> "") AND ($var4 <> "")) {
            return $query->where('actualizacion_comp',$var2)
                        ->orWhere('actualizacion_comp',$var4);
        }elseif (($var3 <> "") AND ($var4 <> "")) {
            return $query->where('actualizacion_comp',$var3)
                        ->orWhere('actualizacion_comp',$var4);
        }elseif ($var1 <> ""){
            return $query->where('actualizacion_comp',$var1);
        }elseif ($var2 <> ""){
            return $query->where('actualizacion_comp',$var2);
        }elseif ($var3 <> ""){
            return $query->where('actualizacion_comp',$var3);
        }elseif ($var4 <> ""){
            return $query->where('actualizacion_comp',$var4);
        }
    }

    public function scopeCapacitacion($query, $capacitacion_op, $capno){
        if (($capacitacion_op <> "") AND ($capno <> "")) {
            return $query->where('capacitacion_op',$capacitacion_op)
                        ->orWhere('capacitacion_op',$capno);
        }elseif ($capacitacion_op <> ""){
            return $query->where('capacitacion_op',$capacitacion_op);
        }elseif ($capno <> ""){
            return $query->where('capacitacion_op',$capno);
        }
    }

    public function scopeVisitaInicial($query, $var1, $var2, $var3, $var4){
        if (($var1 <> "") AND ($var2 <> "") AND ($var3 <> "")) {
            return $query->where('visita_inicial',$var1)
                        ->orWhere('visita_inicial',$var2)
                        ->orWhere('visita_inicial',$var3);
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var4 <> "")) {
            return $query->where('visita_inicial',$var1)
                        ->orWhere('visita_inicial',$var2)
                        ->orWhere('visita_inicial',$var4);
        }elseif (($var1 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('visita_inicial',$var1)
                        ->orWhere('visita_inicial',$var3)
                        ->orWhere('visita_inicial',$var4);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('visita_inicial',$var2)
                        ->orWhere('visita_inicial',$var3)
                        ->orWhere('visita_inicial',$var4);
        }elseif (($var1 <> "") AND ($var4 <> "")) {
            return $query->where('visita_inicial',$var1)
                        ->orWhere('visita_inicial',$var4);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('visita_inicial',$var1)
                        ->orWhere('visita_inicial',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('visita_inicial',$var1)
                        ->orWhere('visita_inicial',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('visita_inicial',$var2)
                        ->orWhere('visita_inicial',$var3);
        }elseif (($var2 <> "") AND ($var4 <> "")) {
            return $query->where('visita_inicial',$var2)
                        ->orWhere('visita_inicial',$var4);
        }elseif (($var3 <> "") AND ($var4 <> "")) {
            return $query->where('visita_inicial',$var3)
                        ->orWhere('visita_inicial',$var4);
        }elseif ($var1 <> ""){
            return $query->where('visita_inicial',$var1);
        }elseif ($var2 <> ""){
            return $query->where('visita_inicial',$var2);
        }elseif ($var3 <> ""){
            return $query->where('visita_inicial',$var3);
        }elseif ($var4 <> ""){
            return $query->where('visita_inicial',$var4);
        }
    }

    public function scopeEnsayo($query, $var1, $var2, $var3){
        if (($var2 <> "") AND ($var3 <> "") AND ($var1 <> "")) {
            return $query->where('ensayo',$var2)
                        ->orWhere('ensayo',$var3)
                        ->orWhere('ensayo',$var1);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('ensayo',$var1)
                        ->orWhere('ensayo',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('ensayo',$var1)
                        ->orWhere('ensayo',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('ensayo',$var2)
                        ->orWhere('ensayo',$var3);
        }elseif ($var1 <> ""){
            return $query->where('ensayo',$var1);
        }elseif ($var2 <> ""){
            return $query->where('ensayo',$var2);
        }elseif ($var3 <> ""){
            return $query->where('ensayo',$var3);
        }
    }
 
    public function scopeCheckList($query, $var1, $var2, $var3, $var4){
        if (($var1 <> "") AND ($var2 <> "") AND ($var3 <> "")) {
            return $query->where('check_list',$var1)
                        ->orWhere('check_list',$var2)
                        ->orWhere('check_list',$var3);
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var4 <> "")) {
            return $query->where('check_list',$var1)
                        ->orWhere('check_list',$var2)
                        ->orWhere('check_list',$var4);
        }elseif (($var1 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('check_list',$var1)
                        ->orWhere('check_list',$var3)
                        ->orWhere('check_list',$var4);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('check_list',$var2)
                        ->orWhere('check_list',$var3)
                        ->orWhere('check_list',$var4);
        }elseif (($var1 <> "") AND ($var4 <> "")) {
            return $query->where('check_list',$var1)
                        ->orWhere('check_list',$var4);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('check_list',$var1)
                        ->orWhere('check_list',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('check_list',$var1)
                        ->orWhere('check_list',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('check_list',$var2)
                        ->orWhere('check_list',$var3);
        }elseif (($var2 <> "") AND ($var4 <> "")) {
            return $query->where('check_list',$var2)
                        ->orWhere('check_list',$var4);
        }elseif (($var3 <> "") AND ($var4 <> "")) {
            return $query->where('check_list',$var3)
                        ->orWhere('check_list',$var4);
        }elseif ($var1 <> ""){
            return $query->where('check_list',$var1);
        }elseif ($var2 <> ""){
            return $query->where('check_list',$var2);
        }elseif ($var3 <> ""){
            return $query->where('check_list',$var3);
        }elseif ($var4 <> ""){
            return $query->where('check_list',$var4);
        }
    }

    public function scopeLimpieza($query, $var1, $var2, $var3){
        if (($var2 <> "") AND ($var3 <> "") AND ($var1 <> "")) {
            return $query->where('limpieza_inyectores',$var2)
                        ->orWhere('limpieza_inyectores',$var3)
                        ->orWhere('limpieza_inyectores',$var1);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('limpieza_inyectores',$var1)
                        ->orWhere('limpieza_inyectores',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('limpieza_inyectores',$var1)
                        ->orWhere('limpieza_inyectores',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('limpieza_inyectores',$var2)
                        ->orWhere('limpieza_inyectores',$var3);
        }elseif ($var1 <> ""){
            return $query->where('limpieza_inyectores',$var1);
        }elseif ($var2 <> ""){
            return $query->where('limpieza_inyectores',$var2);
        }elseif ($var3 <> ""){
            return $query->where('limpieza_inyectores',$var3);
        }
    }

 
    public function scopeContratoFirmado($query, $var1, $var2, $var3, $var4, $var5){
        if (($var1 <> "") AND ($var2 <> "") AND ($var3 <> "") AND ($var5 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var5);
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var4 <> "") AND ($var5 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var4)
                        ->orWhere('contrato_firmado',$var5);
        }elseif (($var1 <> "") AND ($var3 <> "") AND ($var4 <> "") AND ($var5 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var4)
                        ->orWhere('contrato_firmado',$var5);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var4 <> "") AND ($var5 <> "")) {
            return $query->where('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var4)
                        ->orWhere('contrato_firmado',$var5);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var4 <> "") AND ($var1 <> "")) {
            return $query->where('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var4)
                        ->orWhere('contrato_firmado',$var1);
                        
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var3 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var3);
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var5 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var5);
        }elseif (($var5 <> "") AND ($var2 <> "") AND ($var3 <> "")) {
            return $query->where('contrato_firmado',$var5)
                        ->orWhere('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var3);
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var5 <> "") AND ($var2 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var5)
                        ->orWhere('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var1 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var5 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var5)
                        ->orWhere('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var5 <> "")) {
            return $query->where('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var5);
        }elseif (($var1 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('contrato_firmado',$var1)
                        ->orWhere('contrato_firmado',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var3);
        }elseif (($var2 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var2)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var3 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var3)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var5 <> "") AND ($var4 <> "")) {
            return $query->where('contrato_firmado',$var5)
                        ->orWhere('contrato_firmado',$var4);
        }elseif (($var5 <> "") AND ($var3 <> "")) {
            return $query->where('contrato_firmado',$var5)
                        ->orWhere('contrato_firmado',$var3);
        }elseif (($var5 <> "") AND ($var2 <> "")) {
            return $query->where('contrato_firmado',$var5)
                        ->orWhere('contrato_firmado',$var2);
        }elseif (($var5 <> "") AND ($var1 <> "")) {
            return $query->where('contrato_firmado',$var5)
                        ->orWhere('contrato_firmado',$var1);
        }elseif ($var1 <> ""){
            return $query->where('contrato_firmado',$var1);
        }elseif ($var2 <> ""){
            return $query->where('contrato_firmado',$var2);
        }elseif ($var3 <> ""){
            return $query->where('contrato_firmado',$var3);
        }elseif ($var4 <> ""){
            return $query->where('contrato_firmado',$var4);
        }elseif ($var5 <> ""){
            return $query->where('contrato_firmado',$var5);
        }
    }

    public function scopeAnalisis($query, $var1, $var2, $var3, $var4){
        if (($var1 <> "") AND ($var2 <> "") AND ($var3 <> "")) {
            return $query->where('analisis_final',$var1)
                        ->orWhere('analisis_final',$var2)
                        ->orWhere('analisis_final',$var3);
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var4 <> "")) {
            return $query->where('analisis_final',$var1)
                        ->orWhere('analisis_final',$var2)
                        ->orWhere('analisis_final',$var4);
        }elseif (($var1 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('analisis_final',$var1)
                        ->orWhere('analisis_final',$var3)
                        ->orWhere('analisis_final',$var4);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('analisis_final',$var2)
                        ->orWhere('analisis_final',$var3)
                        ->orWhere('analisis_final',$var4);
        }elseif (($var1 <> "") AND ($var4 <> "")) {
            return $query->where('analisis_final',$var1)
                        ->orWhere('analisis_final',$var4);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('analisis_final',$var1)
                        ->orWhere('analisis_final',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('analisis_final',$var1)
                        ->orWhere('analisis_final',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('analisis_final',$var2)
                        ->orWhere('analisis_final',$var3);
        }elseif (($var2 <> "") AND ($var4 <> "")) {
            return $query->where('analisis_final',$var2)
                        ->orWhere('analisis_final',$var4);
        }elseif (($var3 <> "") AND ($var4 <> "")) {
            return $query->where('analisis_final',$var3)
                        ->orWhere('analisis_final',$var4);
        }elseif ($var1 <> ""){
            return $query->where('analisis_final',$var1);
        }elseif ($var2 <> ""){
            return $query->where('analisis_final',$var2);
        }elseif ($var3 <> ""){
            return $query->where('analisis_final',$var3);
        }elseif ($var4 <> ""){
            return $query->where('analisis_final',$var4);
        }
    }
 
    public function scopeFactura($query, $var1, $var2, $var3, $var4){
        if (($var1 <> "") AND ($var2 <> "") AND ($var3 <> "")) {
            return $query->where('factura',$var1)
                        ->orWhere('factura',$var2)
                        ->orWhere('factura',$var3);
        }elseif (($var1 <> "") AND ($var2 <> "") AND ($var4 <> "")) {
            return $query->where('factura',$var1)
                        ->orWhere('factura',$var2)
                        ->orWhere('factura',$var4);
        }elseif (($var1 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('factura',$var1)
                        ->orWhere('factura',$var3)
                        ->orWhere('factura',$var4);
        }elseif (($var2 <> "") AND ($var3 <> "") AND ($var4 <> "")) {
            return $query->where('factura',$var2)
                        ->orWhere('factura',$var3)
                        ->orWhere('factura',$var4);
        }elseif (($var1 <> "") AND ($var4 <> "")) {
            return $query->where('factura',$var1)
                        ->orWhere('factura',$var4);
        }elseif (($var1 <> "") AND ($var2 <> "")) {
            return $query->where('factura',$var1)
                        ->orWhere('factura',$var2);
        }elseif (($var1 <> "") AND ($var3 <> "")) {
            return $query->where('factura',$var1)
                        ->orWhere('factura',$var3);
        }elseif (($var2 <> "") AND ($var3 <> "")) {
            return $query->where('factura',$var2)
                        ->orWhere('factura',$var3);
        }elseif (($var2 <> "") AND ($var4 <> "")) {
            return $query->where('factura',$var2)
                        ->orWhere('factura',$var4);
        }elseif (($var3 <> "") AND ($var4 <> "")) {
            return $query->where('factura',$var3)
                        ->orWhere('factura',$var4);
        }elseif ($var1 <> ""){
            return $query->where('factura',$var1);
        }elseif ($var2 <> ""){
            return $query->where('factura',$var2);
        }elseif ($var3 <> ""){
            return $query->where('factura',$var3);
        }elseif ($var4 <> ""){
            return $query->where('factura',$var4);
        }
    }

}
