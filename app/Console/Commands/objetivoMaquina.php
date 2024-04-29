<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\utilidad;
use App\tipoobjetivo;
use App\objetivo;
use App\maquina;

class objetivoMaquina extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'definir:objetivo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Una vez al año, se insertan en la table de objetivos los valores promedios 
                            de factor de carga, ralenti y virajes que se obtuvieron de cada máquina el año anterior ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;

        // Obtengo el año actual
        $hoy = Carbon::today();
        
        // Calculo el año anterior al actual
        $anopasado = $hoy->subYear();
        $fecha = $anopasado->format('Y');
        $anoactual = $hoy->format('Y');

        // Defino las fechas para cada cultivo
        $fecha_soja_desde = $fecha.'-04-01';
        $fecha_soja_hasta = $fecha.'-04-30';
        $fecha_maiz_desde = $fecha.'-05-15';
        $fecha_maiz_hasta = $fecha.'-06-30';
        $fecha_trigo_desde = $fecha.'-11-01';
        $fecha_trigo_hasta = $fecha.'-12-15';

        // Consultar los valores promedios de factor de carga de motor para todas las máquinas monitoreadas correspondientes al año anterior
        $id_tipo_objetivo_factor = Tipoobjetivo::where('nombre','LIKE','%carga%')->first();
        $id_tipo_objetivo_ralenti = Tipoobjetivo::where('nombre','Ralenti (%)')->first();
        $id_tipo_objetivo_llena = Tipoobjetivo::where('nombre','LIKE','%tolva llena%')->first();
        $id_tipo_objetivo_vacia = Tipoobjetivo::where('nombre','LIKE','%tolva vacia%')->first();
        $id_tipo_objetivo_autotrac = Tipoobjetivo::where('nombre','LIKE','%autotrac%')->first();
        $id_tipo_objetivo_automatizacion = Tipoobjetivo::where('nombre','LIKE','%mantener automaticamente%')->first();
        $id_tipo_objetivo_harvest = Tipoobjetivo::where('nombre','LIKE','%harvest smart%')->first();
        $id_tipo_objetivo_molinete = Tipoobjetivo::where('nombre','LIKE','%molinete%')->first();
        $id_tipo_objetivo_separador = Tipoobjetivo::where('nombre','LIKE','%Separador de virajes%')->first();
        $maquinas = Utilidad::select('NumSMaq')->distinct('NumSMaq')->get();



        ///////////////////////// VALORES DE SOJA //////////////////////////////////

        
        foreach($maquinas as $maquina){
            $id_maquina = Maquina::where([['NumSMaq',$maquina->NumSMaq], ['TipoMaq','COSECHADORA']])->first();
            
            if(isset($id_maquina)){

                $comprobacion = Objetivo::where([['id_maquina',$id_maquina->id],
                                                ['cultivo','Soja'], ['ano',$fecha], ['establecido','App']])->first();
                    if($comprobacion == ""){
     
                    //Consulta tiempo trabajando, en ralenti y en transporte
                    $trabajando_soja = Utilidad::where([['FecIUtil','>=', $fecha_soja_desde], ['FecFUtil','<=', $fecha_soja_hasta],
                                                    ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');

                    $transporte_soja = Utilidad::where([['FecIUtil','>=', $fecha_soja_desde], ['FecFUtil','<=', $fecha_soja_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');
                    $ralenti_soja = Utilidad::where([['FecIUtil','>=', $fecha_soja_desde], ['FecFUtil','<=', $fecha_soja_hasta],
                                                ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                            ->sum('ValoUtil');

                    //Consulta ralenti con tolva llena y con tolva vacia
                    $ralentillena_soja = Utilidad::where([['FecIUtil','>=', $fecha_soja_desde], ['FecFUtil','<=', $fecha_soja_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], 
                                                        ['SeriUtil','Ralentí con depósito de grano lleno'], 
                                                        ['UOMUtil', 'hr']])
                                                        ->sum('ValoUtil');

                    $ralentivacia_soja = Utilidad::where([['FecIUtil','>=', $fecha_soja_desde], ['FecFUtil','<=', $fecha_soja_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], 
                                                        ['SeriUtil','Ralentí con depósito de grano no lleno'],
                                                        ['UOMUtil', 'hr']])
                                                        ->sum('ValoUtil');

                    $separadordevirajes_soja = Utilidad::where([['FecIUtil','>=', $fecha_soja_desde], ['FecFUtil','<=', $fecha_soja_hasta],
                                                                ['NumSMaq', $maquina->NumSMaq], 
                                                                ['SeriUtil','Separador de virajes en cabecero engranado'],
                                                                ['UOMUtil', 'hr']])
                                                                ->sum('ValoUtil');

                    $totalhs = $trabajando_soja + $transporte_soja + $ralenti_soja;
                    if($totalhs <> 0){
                        $ralenti_soja_p = $ralenti_soja * 100 / $totalhs;
                        $ralentillena_soja_p = $ralentillena_soja * 100 / $totalhs;
                        $ralentivacia_soja_p = $ralentivacia_soja * 100 / $totalhs;
                        $separador_soja_p = $separadordevirajes_soja * 100 / $totalhs;
                        $factor_soja_p = 70;
                        $autotrac_soja_p = 80;
                        $harvest_soja_p = 80;
                        $automatizacion_soja_p = 80;
                        $molinete_soja_p = 80;
                    } else {
                        $ralenti_soja_p = 0;
                        $ralentillena_soja_p = 0;
                        $ralentivacia_soja_p = 0;
                        $separador_soja_p = 0;
                        $factor_soja_p = 70;
                        $autotrac_soja_p = 80;
                        $harvest_soja_p = 80;
                        $automatizacion_soja_p = 80;
                        $molinete_soja_p = 80;
                    }

                    //insert de factor de carga
                    $factoressp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_factor->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$factor_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti
                    $ralentisp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_ralenti->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralenti_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti llena
                    $ralentillenasp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_llena->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralentillena_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti vacia
                    $ralentivaciasp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_vacia->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralentivacia_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de separador de virajes
                    $separadorsp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_separador->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$separador_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de autotrac
                    $autotracsp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_autotrac->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$autotrac_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de harvest smart
                    $harvest_smartsp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_harvest->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$harvest_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de automatizacion
                    $automatizacionsp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_automatizacion->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$automatizacion_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de molinete
                    $molinetesp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_molinete->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$molinete_soja_p, 'cultivo'=>'Soja', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                }
            }
        }


        ///////////////////////// VALORES DE MAIZ //////////////////////////////////

        
        foreach($maquinas as $maquina){
            $id_maquina = Maquina::where([['NumSMaq',$maquina->NumSMaq], ['TipoMaq','COSECHADORA']])->first();
            
            if(isset($id_maquina)){

                $comprobacion = Objetivo::where([['id_maquina',$id_maquina->id],
                                                ['cultivo','Maíz'], ['ano',$fecha], ['establecido','App']])->first();
                    if($comprobacion == ""){

                    //Consulta tiempo trabajando, en ralenti y en transporte
                    $trabajando_maiz = Utilidad::where([['FecIUtil','>=', $fecha_maiz_desde], ['FecFUtil','<=', $fecha_maiz_hasta],
                                                    ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');

                    $transporte_maiz = Utilidad::where([['FecIUtil','>=', $fecha_maiz_desde], ['FecFUtil','<=', $fecha_maiz_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');
                    $ralenti_maiz = Utilidad::where([['FecIUtil','>=', $fecha_maiz_desde], ['FecFUtil','<=', $fecha_maiz_hasta],
                                                ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                            ->sum('ValoUtil');

                    //Consulta ralenti con tolva llena y con tolva vacia
                    $ralentillena_maiz = Utilidad::where([['FecIUtil','>=', $fecha_maiz_desde], ['FecFUtil','<=', $fecha_maiz_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], 
                                                        ['SeriUtil','Ralentí con depósito de grano lleno'], 
                                                        ['UOMUtil', 'hr']])
                                                        ->sum('ValoUtil');

                    $ralentivacia_maiz = Utilidad::where([['FecIUtil','>=', $fecha_maiz_desde], ['FecFUtil','<=', $fecha_maiz_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], 
                                                        ['SeriUtil','Ralentí con depósito de grano no lleno'],
                                                        ['UOMUtil', 'hr']])
                                                        ->sum('ValoUtil');

                    $separadordevirajes_maiz = Utilidad::where([['FecIUtil','>=', $fecha_maiz_desde], ['FecFUtil','<=', $fecha_maiz_hasta],
                                                                ['NumSMaq', $maquina->NumSMaq], 
                                                                ['SeriUtil','Separador de virajes en cabecero engranado'],
                                                                ['UOMUtil', 'hr']])
                                                                ->sum('ValoUtil');

                    $totalhs = $trabajando_maiz + $transporte_maiz + $ralenti_maiz;
                    if($totalhs <> 0){
                        $ralenti_maiz_p = $ralenti_maiz * 100 / $totalhs;
                        $ralentillena_maiz_p = $ralentillena_maiz * 100 / $totalhs;
                        $ralentivacia_maiz_p = $ralentivacia_maiz * 100 / $totalhs;
                        $separador_maiz_p = $separadordevirajes_maiz * 100 / $totalhs;
                        $factor_maiz_p = 70;
                        $autotrac_maiz_p = 80;
                        $harvest_maiz_p = 80;
                        $automatizacion_maiz_p = 80;
                    } else {
                        $ralenti_maiz_p = 0;
                        $ralentillena_maiz_p = 0;
                        $ralentivacia_maiz_p = 0;
                        $separador_maiz_p = 0;
                        $factor_maiz_p = 70;
                        $autotrac_maiz_p = 80;
                        $harvest_maiz_p = 80;
                        $automatizacion_maiz_p = 80;
                    }

                    //insert de factor de carga
                    $factoresmp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_factor->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$factor_maiz_p, 'cultivo'=>'Maíz', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti
                    $ralentimp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_ralenti->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralenti_maiz_p, 'cultivo'=>'Maíz', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti llena
                    $ralentillenamp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_llena->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralentillena_maiz_p, 'cultivo'=>'Maíz', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti vacia
                    $ralentivaciamp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_vacia->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralentivacia_maiz_p, 'cultivo'=>'Maíz', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de separador de virajes
                    $separadormp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_separador->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$separador_maiz_p, 'cultivo'=>'Maíz', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de autotrac
                    $autotracmp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_autotrac->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$autotrac_maiz_p, 'cultivo'=>'Maíz', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de harvest smart
                    $harvest_smartmp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_harvest->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$harvest_maiz_p, 'cultivo'=>'Maíz', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de automatizacion
                    $automatizacionmp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_automatizacion->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$automatizacion_maiz_p, 'cultivo'=>'Maíz', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                }
            }
        }


        ///////////////////////// VALORES DE TRIGO //////////////////////////////////

        
        foreach($maquinas as $maquina){
            $id_maquina = Maquina::where([['NumSMaq',$maquina->NumSMaq], ['TipoMaq','COSECHADORA']])->first();
        
            if(isset($id_maquina)){

                $comprobacion = Objetivo::where([['id_maquina',$id_maquina->id],
                                                ['cultivo','Trigo'], ['ano',$fecha], ['establecido','App']])->first();
                if($comprobacion == ""){
                    //Consulta tiempo trabajando, en ralenti y en transporte
                    $trabajando_trigo = Utilidad::where([['FecIUtil','>=', $fecha_trigo_desde], ['FecFUtil','<=', $fecha_trigo_hasta],
                                                    ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');

                    $transporte_trigo = Utilidad::where([['FecIUtil','>=', $fecha_trigo_desde], ['FecFUtil','<=', $fecha_trigo_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');
                    $ralenti_trigo = Utilidad::where([['FecIUtil','>=', $fecha_trigo_desde], ['FecFUtil','<=', $fecha_trigo_hasta],
                                                ['NumSMaq', $maquina->NumSMaq], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                            ->sum('ValoUtil');

                    //Consulta ralenti con tolva llena y con tolva vacia
                    $ralentillena_trigo = Utilidad::where([['FecIUtil','>=', $fecha_trigo_desde], ['FecFUtil','<=', $fecha_trigo_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], 
                                                        ['SeriUtil','Ralentí con depósito de grano lleno'], 
                                                        ['UOMUtil', 'hr']])
                                                        ->sum('ValoUtil');

                    $ralentivacia_trigo = Utilidad::where([['FecIUtil','>=', $fecha_trigo_desde], ['FecFUtil','<=', $fecha_trigo_hasta],
                                                        ['NumSMaq', $maquina->NumSMaq], 
                                                        ['SeriUtil','Ralentí con depósito de grano no lleno'],
                                                        ['UOMUtil', 'hr']])
                                                        ->sum('ValoUtil');

                    $separadordevirajes_trigo = Utilidad::where([['FecIUtil','>=', $fecha_trigo_desde], ['FecFUtil','<=', $fecha_trigo_hasta],
                                                                ['NumSMaq', $maquina->NumSMaq], 
                                                                ['SeriUtil','Separador de virajes en cabecero engranado'],
                                                                ['UOMUtil', 'hr']])
                                                                ->sum('ValoUtil');

                    $totalhs = $trabajando_trigo + $transporte_trigo + $ralenti_trigo;
                    if($totalhs <> 0){
                        $ralenti_trigo_p = $ralenti_trigo * 100 / $totalhs;
                        $ralentillena_trigo_p = $ralentillena_trigo * 100 / $totalhs;
                        $ralentivacia_trigo_p = $ralentivacia_trigo * 100 / $totalhs;
                        $separador_trigo_p = $separadordevirajes_trigo * 100 / $totalhs;
                        $factor_trigo_p = 70;
                        $autotrac_trigo_p = 80;
                        $harvest_trigo_p = 80;
                        $automatizacion_trigo_p = 80;
                        $molinete_trigo_p = 80;
                    } else {
                        $ralenti_trigo_p = 0;
                        $ralentillena_trigo_p = 0;
                        $ralentivacia_trigo_p = 0;
                        $separador_trigo_p = 0;
                        $factor_trigo_p = 70;
                        $autotrac_trigo_p = 80;
                        $harvest_trigo_p = 80;
                        $automatizacion_trigo_p = 80;
                        $molinete_trigo_p = 80;
                    }

                    //insert de factor de carga
                    $factorestp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_factor->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$factor_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti
                    $ralentitp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_ralenti->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralenti_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti llena
                    $ralentillenatp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_llena->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralentillena_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de ralenti vacia
                    $ralentivaciatp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_vacia->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$ralentivacia_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de separador de virajes
                    $separadortp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_separador->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$separador_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de autotrac
                    $autotractp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_autotrac->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$autotrac_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de harvest smart
                    $harvest_smarttp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_harvest->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$harvest_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de automatizacion
                    $automatizaciontp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_automatizacion->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$automatizacion_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                    //insert de molinete
                    $molinetetp = Objetivo::create(['id_tipoobjetivo'=>$id_tipo_objetivo_molinete->id, 'id_maquina'=>$id_maquina->id,
                                                        'objetivo'=>$molinete_trigo_p, 'cultivo'=>'Trigo', 'ano'=>$anoactual, 
                                                        'establecido'=>'App']);
                }
            }
        }  
    }
}
