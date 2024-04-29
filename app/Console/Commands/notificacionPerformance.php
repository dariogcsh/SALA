<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\jdlink;
use App\mail;
use App\objetivo;
use App\utilidad;

class notificacionPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que se ejecuta una vez al dia y evalua la performance de cada máquina monitoreada en cuanto a su utilizacion de tecnologia e indicadores como factor de carga y tiempos en ralenti que se encuentre dentro de los parametros normales. En caso de que este desfasado de esos parametros la App envia una notificacion al cliente y a SALA para que esten al tanto de dicha condicion';

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
                        ->where([['jdlinks.vencimiento_contrato','>',$fecha_hoy], ['jdlinks.monitoreo','SI']])->get();

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
            $objetivor = 0;
            
            //Calculo horas
            $ralentihs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                        ['SeriUtil','Ralentí'], ['UOMUtil','hr']])->sum('ValoUtil');
            $trabajohs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                        ['SeriUtil','Trabajando'], ['UOMUtil','hr']])->sum('ValoUtil');
            $transportehs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha_ayer],
                        ['SeriUtil','Transporte'], ['UOMUtil','hr']])->sum('ValoUtil');

            $totalhs = $ralentihs + $trabajohs + $transportehs;
            if ($totalhs > 0) {
                $ralentip = ($ralentihs / $totalhs) * 100;
                $ralentip = number_format($ralentip,1);
            }
            
            if (($totalhs > 0) AND ($trabajohs > 1)) {

                $obj_ralenti_cliente = Objetivo::join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                                ->where([['objetivos.id_maquina',$maquina->id],['objetivos.establecido','Cliente'] ,
                                                        ['tipoobjetivos.nombre','Ralenti (%)'],['objetivos.cultivo',$cultivo],
                                                        ['objetivos.ano',$ano_pasado]])->first();

                if (isset($obj_ralenti_cliente)) {
                    //Calculo porcentajes
                    $objetivor = $obj_ralenti_cliente->objetivo;
                    
                    //En caso de que el valor del día esté desfazado del objetivo, envia la notificación al cliente y tutor responsable
                    if($objetivor < $ralentip){
                        foreach ($usersends as $usersend) {
                            $notificationData = [
                                'title' => 'Performance Ralenti - '.$maquina->NombOrga.'',
                                'body' => 'Valor de Ralenti del día de ayer para la máquina '.$maquina->nombre.' fue de '.$ralentip.'% y tiene un objetivo '.$objetivor.'%',
                                'path' => '/utilidad/showdiario/'.$fecha_ayer.'_'.$maquina->CodiOrga.'',
                            ];
                            $this->notificationsService->sendToUser($usersend->UserMail, $notificationData);
                        }
                    }
                } else {
                    $obj_ralenti_app = Objetivo::join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->where([['objetivos.id_maquina',$maquina->id],['objetivos.establecido','App'] ,
                                                    ['tipoobjetivos.nombre','Ralenti (%)'],['objetivos.cultivo',$cultivo],
                                                    ['objetivos.ano',$ano_pasado]])->first();
                    if (isset($obj_ralenti_app)) {
                        //Calculo porcentajes
                        $objetivor = $obj_ralenti_app->objetivo;
                                            
                        //En caso de que el valor del día esté desfazado del objetivo, envia la notificación al cliente y tutor responsable
                        if($objetivor < $ralentip){
                            foreach ($usersends as $usersend) {
                                $notificationData = [
                                    'title' => 'Performance Ralenti - '.$maquina->NombOrga.'',
                                    'body' => 'Valor de Ralenti del día de ayer para la máquina '.$maquina->nombre.' fue de '.$ralentip.'% y tiene un objetivo '.$objetivor.'%',
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
