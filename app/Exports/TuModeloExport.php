<?php

namespace App\Exports;

use App\reclamo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class TuModeloExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Reclamo::select('reclamos.id','organizacions.NombOrga','sucursals.NombSucu','reclamos.fecha',
                            'reclamos.origen','reclamos.hallazgo','reclamos.proceso','reclamos.nombre_cliente',
                            'reclamos.descripcion','reclamos.anexo','reclamos.estado','reclamos.causa',
                            DB::raw('CONCAT(responsable.name, " ", responsable.last_name) as nombre_causa'),'reclamos.fecha_contacto',
                            'reclamos.fecha_registro_causa','reclamos.vencido_causa','reclamos.accion_contingencia',
                            DB::raw('CONCAT(contingencia.name, " ", contingencia.last_name) as nombre_contingencia'),
                            'reclamos.fecha_limite_contingencia','reclamos.fecha_registro_contingencia',
                            'reclamos.vencido_contingencia','reclamos.accion_correctiva',
                            DB::raw('GROUP_CONCAT(DISTINCT CONCAT(users_correctiva.name, " ", users_correctiva.last_name) SEPARATOR ", ") as nombre_correctiva'),
                            'reclamos.fecha_limite_correctiva','reclamos.verificacion_implementacion',
                            DB::raw('CONCAT(implementacion.name, " ", implementacion.last_name) as nombre_implementacion'),
                            'reclamos.fecha_implementacion','reclamos.medicion_eficiencia',
                            DB::raw('CONCAT(eficiencia.name, " ", eficiencia.last_name) as nombre_eficiencia'),
                            'reclamos.fecha_eficiencia')
                        ->leftjoin('users as responsable','reclamos.id_user_responsable','=','responsable.id')
                        ->leftjoin('users as contingencia','reclamos.id_user_contingencia','=','contingencia.id')
                        ->leftjoin('users as correctiva','reclamos.id_user_correctiva','=','correctiva.id')
                        ->leftjoin('users as implementacion','reclamos.id_user_implementacion','=','implementacion.id')
                        ->leftjoin('users as eficiencia','reclamos.id_user_eficiencia','=','eficiencia.id')
                        ->leftjoin('organizacions','reclamos.id_organizacion','=','organizacions.id')
                        ->leftjoin('sucursals','reclamos.id_sucursal','=','sucursals.id')
                        ->leftJoin('reclamo_accions', 'reclamos.id', '=', 'reclamo_accions.id_reclamo')
                        ->leftJoin('users as users_correctiva', 'reclamo_accions.id_user_correctiva', '=', 'users_correctiva.id')
                        ->groupBy(
                            'reclamos.id',
                            'organizacions.NombOrga',
                            'sucursals.NombSucu',
                            'reclamos.fecha',
                            'reclamos.origen',
                            'reclamos.hallazgo',
                            'reclamos.proceso',
                            'reclamos.nombre_cliente',
                            'reclamos.descripcion',
                            'reclamos.anexo',
                            'reclamos.estado',
                            'reclamos.causa',
                            'responsable.name',
                            'responsable.last_name',
                            'reclamos.fecha_contacto',
                            'reclamos.fecha_registro_causa',
                            'reclamos.vencido_causa',
                            'reclamos.accion_contingencia',
                            'contingencia.name',
                            'contingencia.last_name',
                            'reclamos.fecha_limite_contingencia',
                            'reclamos.fecha_registro_contingencia',
                            'reclamos.vencido_contingencia',
                            'reclamos.accion_correctiva',
                            'reclamos.fecha_limite_correctiva',
                            'reclamos.verificacion_implementacion',
                            'implementacion.name',
                            'implementacion.last_name',
                            'reclamos.fecha_implementacion',
                            'reclamos.medicion_eficiencia',
                            'eficiencia.name',
                            'eficiencia.last_name',
                            'reclamos.fecha_eficiencia'
                        )
                        ->orderBy('reclamos.id', 'desc');;
    }

    public function headings(): array
    {
        return [
            'id',
            'Organizacion',
            'Sucursal',
            'Fecha reclamo',
            'Origen',
            'Hallazgo',
            'Proceso',
            'Cliente',
            'Descripción',
            'Anexo',
            'Estado',
            'Causa',
            'Responsable causa',
            'Fecha de limite contacto',
            'Fecha registro de causa',
            'Vencido causa',
            'Acción de contingencia',
            'Responsable contingencia',
            'Fecha límite de contingencia',
            'Fecha registro de contingencia',
            'Vencido contingencia',
            'Acción correctiva',
            'Responsable correctiva',
            'Fecha limite correctiva',
            'Verificación de implementación',
            'Responsable implementacion',
            'Fecha límite implementación',
            'Medición de eficiencia',
            'Responsable eficiencia',
            'Fecha límite eficiencia',
            // Otros encabezados...
        ];
    }
}

