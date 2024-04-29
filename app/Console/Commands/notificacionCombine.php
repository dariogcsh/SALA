<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\maquina;
use App\mail;
use App\jdlink;
use App\utilidad;

class notificacionCombine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:combine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se miden todas las máquinas con combine advisor y harvest smart, se comparan con el objetivo y se envia notificación en el caso de no llegar al objetivo de utilización.';

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
        

        $fecha = Carbon::yesterday();
        $ayer = $fecha->format('Y-m-d');
        $hoy = Carbon::today();
        $fecha_hoy = $hoy->format('Y-m-d');

        // Deberia buscar la cantidad de horas de trabajo en el dia y poner en los "IF" que sea mayor a una hora
       
        //Busqueda de maquinas con combine advisor
        //$equipos_combine = Maquina::where([['combine_advisor','SI']])->get();

        $equipos_combine = Jdlink::select('maquinas.id','maquinas.NumSMaq','organizacions.NombOrga','maquinas.nombre',
                                        'organizacions.id as id_orga','organizacions.CodiOrga')
                                ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->where([['jdlinks.vencimiento_contrato','>',$fecha_hoy], ['jdlinks.monitoreo','SI'],
                                        ['maquinas.combine_advisor','SI']])->get();

        foreach ($equipos_combine as $equipo_c) {

            $trabajohs = Utilidad::where([['NumsMaq',$equipo_c->NumSMaq],['FecIUtil',$ayer],
                                        ['SeriUtil','Trabajando'], ['UOMUtil','hr']])->sum('ValoUtil');

            $combine_advisor_total = Utilidad::where([['NumSMaq',$equipo_c->NumSMaq], ['FecIUtil',$ayer],
                                                ['CateUtil','LIKE','%Mantener automáticamente%'], ['UOMUtil','hr']])
                                            ->sum('ValoUtil');
            $combine_advisor_activo = Utilidad::where([['NumsMaq',$equipo_c->NumSMaq],['FecIUtil',$ayer],
                                                        ['CateUtil','LIKE','%Mantener automáticamente%'], ['SeriUtil','Enc'], 
                                                        ['UOMUtil','hr']])
                                                ->sum('ValoUtil');

            //Usuarios a enviar notificación
            $usersends = Mail::select('organizacions.NombOrga', 'mails.UserMail')
                            ->join('organizacions','mails.OrgaMail','=','organizacions.id')
                            ->where('mails.OrgaMail',$equipo_c->id_orga)->get();

            if ($combine_advisor_total > 0) {
                $porc_mantenerauto = $combine_advisor_activo / $combine_advisor_total;
            } else {
                $porc_mantenerauto = 0;
            }
            if (($porc_mantenerauto < '0.5') AND ($trabajohs > 1)) {
                $valor = $porc_mantenerauto * 100;
                $valor = number_format($valor);

                foreach ($usersends as $usersend) {
                $notificationData = [
                    'title' => 'SALA - Automatización del equipo',
                    'body' => 'Se ha recibido información del dia '.$ayer.' en el que la automatización del equipo '.$equipo_c->nombre.' de '.$usersend->NombOrga.' se utilizó el '.$valor.' %',
                    'path' => '/utilidad/showdiario/'.$ayer.'_'.$equipo_c->CodiOrga.'',
                    ];
                    $this->notificationsService->sendToUser($usersend->UserMail, $notificationData);
                }
            }
        }
         //$equipos_harvest = Maquina::where([['harvest_smart','SI']])->get();
        $equipos_harvest = Jdlink::select('maquinas.id','maquinas.NumSMaq','organizacions.NombOrga','maquinas.nombre',
                                        'organizacions.id as id_orga','organizacions.CodiOrga')
                                ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->where([['jdlinks.vencimiento_contrato','>',$fecha_hoy], ['jdlinks.monitoreo','SI'],
                                         ['maquinas.harvest_smart','SI']])->get();

        foreach ($equipos_harvest as $equipo_h) {

            $trabajohs = Utilidad::where([['NumsMaq',$equipo_h->NumSMaq],['FecIUtil',$ayer],
                                        ['SeriUtil','Trabajando'], ['UOMUtil','hr']])->sum('ValoUtil');

            //Usuarios a enviar notificación
            $usersends_h = Mail::select('organizacions.NombOrga', 'mails.UserMail')
                            ->join('organizacions','mails.OrgaMail','=','organizacions.id')
                            ->where('mails.OrgaMail',$equipo_h->id_orga)->get();
                            
                $harvest_smart_total = Utilidad::where([['NumSMaq',$equipo_h->NumSMaq], ['FecIUtil',$ayer],
                                                        ['CateUtil','LIKE','%Harvest Smart%'], ['UOMUtil','hr']])
                                                ->sum('ValoUtil');
                $harvest_smart_activo = Utilidad::where([['utilidads.NumsMaq',$equipo_h->NumSMaq],['utilidads.FecIUtil',$ayer],
                                                        ['CateUtil','LIKE','%Harvest Smart%'], ['SeriUtil','Enc'], 
                                                        ['UOMUtil','hr']])
                                                ->sum('ValoUtil');

                if ($harvest_smart_total > 0) {
                    $porc_harvest = $harvest_smart_activo / $harvest_smart_total;
                } else {
                    $porc_harvest = 0;
                }
                if (($porc_harvest < '0.4') AND ($trabajohs > 1)) {
                    $valor = $porc_harvest * 100;
                    $valor = number_format($valor);

                foreach ($usersends_h as $usersend_h) {
                    $notificationData = [
                    'title' => 'SALA - Harvest Smart del equipo',
                    'body' => 'Se ha recibido información del dia '.$ayer.' en el que el Harvest Smart del equipo '.$equipo_h->nombre.' de '.$usersend_h->NombOrga.' se utilizó el '.$valor.' %',
                    'path' => '/utilidad/showdiario/'.$ayer.'_'.$equipo_h->CodiOrga.'',
                    ];
                    $this->notificationsService->sendToUser($usersend_h->UserMail, $notificationData);
                }
                }
        }
        
        //$equipos_monitoreados = Jdlink::where([['monitoreo','SI'], ['vencimiento_contrato','>=',$fecha_hoy],['TipoMaq','COSECHADORA']])->get();
        /*
        $equipos_monitoreados = Jdlink::select('maquinas.id','maquinas.NumSMaq','organizacions.NombOrga','maquinas.nombre',
                                        'organizacions.id')
                                ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->where([['jdlinks.vencimiento_contrato','>',$fecha_hoy], ['jdlinks.monitoreo','SI'],
                                        ['TipoMaq','COSECHADORA']])->get();

        foreach ($equipos_monitoreados as $equipo_m) {
            $velmolinete_total = Utilidad::where([['NumSMaq', $equipo_m->NumSMaq], ['FecIUtil',$ayer], ['CateUtil','LIKE','%Velocidad auto de molinetes%'], ['UOMUtil','hr']])->sum('ValoUtil');
            $velmolinete = Utilidad::where([['NumSMaq', $equipo_m->NumSMaq], ['FecIUtil',$ayer], ['CateUtil','LIKE','%Velocidad auto de molinetes%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');

            if ($velmolinete_total > 0) {
                $porc_molinete = $velmolinete / $velmolinete_total;
            } else {
                $porc_molinete = 0;
            }
            if ($porc_molinete < '0.8') {
                $valor = $porc_molinete * 100;
                $valor = number_format($valor);

            //Usuarios a enviar notificación
            $usersends_monitoreo = Mail::select('organizacions.NombOrga', 'mails.UserMail')
                                        ->join('organizacions','mails.OrgaMail','=','organizacions.id')
                                        ->where('mails.OrgaMail',$equipo_m->id)->get();

                foreach ($usersends_monitoreo as $usersend_m) {
                    $notificationData = [
                        'title' => 'SALA - Velocidad autmática del molinete',
                        'body' => 'Se ha recibido información del dia '.$ayer.' en el que la velocidad automática del molinete del equipo '.$equipo_m->nombre.' de '.$usersend_m->NombOrga.' se utilizó el '.$valor.' %',
                        'path' => '/utilidad/indexdiario',
                        ];
                        $this->notificationsService->sendToUser('3', $notificationData);
                }
            }
        }
*/

    $notificationData = [
        'title' => 'Notificacion de prueba',
        'body' => 'Funciona Combine',
        'path' => '/senal',
    ];
    $this->notificationsService->sendToUser('3', $notificationData);

    }

}