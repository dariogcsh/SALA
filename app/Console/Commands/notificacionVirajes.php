<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\jdlink;
use App\mail;
use App\objetivo;
use App\utilidad;

class notificacionVirajes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:viraje';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esta funcionalidad dispara una notificacion cuando el indicador de separador de virajes con cabecero se desfasa de el objetivo que tiene establecido la máquina del cliente';

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
        $hoy = Carbon::today();
        //$hoy = Carbon::yesterday();
        $ayer = Carbon::yesterday();
        $ano_actual = $hoy->format('Y');
        $ano_pasado = $ano_actual - 1;
        $fecha_ayer = $ayer->format('Y-m-d');
        $fecha_hoy = $hoy->format('Y-m-d');

        

       
        $maquinas = Jdlink::select('maquinas.id','maquinas.NumSMaq','organizacions.NombOrga','maquinas.nombre',
                                    'organizacions.id as id_orga', 'organizacions.CodiOrga')
                        ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->where([['jdlinks.vencimiento_contrato','>',$fecha_hoy], ['jdlinks.monitoreo','SI'],
                                ['maquinas.TipoMaq','COSECHADORA']])->get();

        foreach ($maquinas as $maquina) {

            $cultivo_maiz = Utilidad::where([['NumSMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                                            ['CateUtil','LIKE','%Tiempo en maíz%'], ['UOMUtil','hr']])->sum('ValoUtil');
            $cultivo_soja = Utilidad::where([['NumSMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                                            ['CateUtil','LIKE','%Tiempo en soja%'], ['UOMUtil','hr']])->sum('ValoUtil');
            $cultivo_trigo = Utilidad::where([['NumSMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                                            ['CateUtil','LIKE','%Tiempo en trigo%'], ['UOMUtil','hr']])->sum('ValoUtil');
            //Valor por defecto                                
            $cultivo = 'Soja';

            if($cultivo_maiz > 1){
                $cultivo = 'Maíz';
            }elseif($cultivo_soja > 1){
                $cultivo = 'Soja';
            }elseif($cultivo_trigo > 1){
                $cultivo = 'Trigo';
            }

            //Usuarios a enviar notificación
            $usersends = Mail::select('organizacions.NombOrga', 'mails.UserMail')
                            ->join('organizacions','mails.OrgaMail','=','organizacions.id')
                            ->where('mails.OrgaMail',$maquina->id_orga)->get();

            //////////////////////////// Ralenti //////////////////////////////////
            $objetivov = 0;
            
            //Calculo horas
            $ralentihs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                        ['SeriUtil','Ralentí'], ['UOMUtil','hr']])->sum('ValoUtil');
            $trabajohs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                        ['SeriUtil','Trabajando'], ['UOMUtil','hr']])->sum('ValoUtil');
            $transportehs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                        ['SeriUtil','Transporte'], ['UOMUtil','hr']])->sum('ValoUtil');
                        
            //tiempo de virajes en cabecera
            $virajeshs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                                         ['SeriUtil','Separador de virajes en cabecero engranado'],
                                         ['UOMUtil', 'hr']])->sum('ValoUtil');

            $totalhs = $ralentihs + $trabajohs + $transportehs;
            if ($totalhs > 0) {
                $virajesp = ($virajeshs / $totalhs) * 100;
                $virajesp = number_format($virajesp,1);
            }
            
            if (($totalhs > 0) AND ($trabajohs > 1)) {

                $obj_viraje_cliente = Objetivo::join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                                ->where([['objetivos.id_maquina',$maquina->id],['objetivos.establecido','Cliente'] ,
                                                        ['tipoobjetivos.nombre','Separador de virajes con cabecero engranado (%)'],
                                                        ['objetivos.cultivo',$cultivo], ['objetivos.ano',$ano_pasado]])->first();

                if (isset($obj_viraje_cliente)) {
                    //Calculo porcentajes
                    $objetivov = $obj_viraje_cliente->objetivo;
                    
                    //En caso de que el valor del día esté desfazado del objetivo, envia la notificación al cliente y tutor responsable
                    if($objetivov < $virajesp){
                        foreach ($usersends as $usersend) {
                            $notificationData = [
                                'title' => 'Performance separador de virajes con cabecero engranado - '.$maquina->NombOrga.'',
                                'body' => 'Valor de separador de virajes con cabecero engranado del día de ayer para la máquina '.$maquina->nombre.' fue de '.$virajesp.'% y tiene un objetivo '.$objetivov.'% en '.$cultivo.'',
                                'path' => '/utilidad/showdiario/'.$fecha_ayer.'_'.$maquina->CodiOrga.'',
                            ];
                            $this->notificationsService->sendToUser($usersend->UserMail, $notificationData);
                        }
                    }
                } else {
                    $obj_virajes_app = Objetivo::join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->where([['objetivos.id_maquina',$maquina->id],['objetivos.establecido','App'] ,
                                                    ['tipoobjetivos.nombre','Separador de virajes con cabecero engranado (%)'],
                                                    ['objetivos.cultivo',$cultivo],['objetivos.ano',$ano_pasado]])->first();
                    if (isset($obj_virajes_app)) {
                        //Calculo porcentajes
                        $objetivov = $obj_virajes_app->objetivo;
                                            
                        //En caso de que el valor del día esté desfazado del objetivo, envia la notificación al cliente y tutor responsable
                        if($objetivov < $virajesp){
                            foreach ($usersends as $usersend) {
                                $notificationData = [
                                    'title' => 'Performance separador de virajes con cabecero engranado - '.$maquina->NombOrga.'',
                                    'body' => 'Valor de separador de virajes con cabecero engranado del día de ayer para la máquina '.$maquina->nombre.' fue de '.$virajesp.'% y tiene un objetivo '.$objetivov.'% en '.$cultivo.'',
                                    'path' => '/utilidad/showdiario/'.$fecha_ayer.'_'.$maquina->CodiOrga.'',
                                ];
                                $this->notificationsService->sendToUser($usersend->UserMail, $notificationData);
                            }
                        }
                    }
                }
            }
        }
    }
}


