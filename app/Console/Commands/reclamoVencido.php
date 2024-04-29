<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\reclamo;
use App\User;

class reclamoVencido extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reclamo:vencido';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cuando se vence uno de los pasos del reclamo, este comando deja registrado que se venció y envía una notificacion al que debe actuar en el reclamo, al gerente de sucursal, al gerente de venta o pos venta y a la responsable de CX';

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

        $fecha = Carbon::today();
        $hoy = $fecha->format('Y-m-d');

        //vencimiento contingencia
        $reclamos = Reclamo::select('reclamos.id','organizacions.NombOrga','reclamos.proceso')
                            ->join('organizacions','reclamos.id_organizacion','=','organizacions.id')
                            ->where([['fecha_limite_contingencia','<',$hoy], ['accion_contingencia',null],
                                    ['id_user_contingencia','<>',null],['fecha_registro_contingencia',null],
                                    ['estado','<>','Cerrada'], ['estado','<>','Eficaz']])->get();

        if ($reclamos->count()>0) {
            //Aca actualiza el campo vencido_contingencia y notifica que esta vencido (o que tiene una tarea pendiente en el reclamo)
            foreach ($reclamos as $reclamo) {
                if ($reclamo->proceso == "Ventas") {
                    $puesto = "Gerente comercial";
                }elseif(($reclamo->proceso == "Repuestos") OR ($reclamo->proceso == "Servicios")){
                    $puesto = "Gerente posventa";
                }elseif($reclamo->proceso == "Administracion"){
                    $puesto = "Gerente de finanzas";
                }else{
                    $puesto = "Gerente de soluciones integrales";
                }

                $id_user = $reclamo->id_user_contingencia;
                $reclamo->update(['vencido_contingencia'=>'SI']);

                $usersends = User::select('users.id')
                                ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                                ->join('role_user','users.id','=','role_user.user_id')
                                ->join('roles','role_user.role_id','=','roles.id')
                                ->Where(function($query) {
                                    $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                        ->where('users.last_name', 'Garcia Campi');
                                })
                                ->orWhere(function($query) use ($puesto) {
                                    $query->where('puesto_empleados.NombPuEm', $puesto);
                                })
                                ->orWhere(function($query) {
                                    $query->where('puesto_empleados.NombPuEm', 'Gerente general');
                                })
                                ->orWhere(function($query) use ($id_user) {
                                    $query->where('users.id', $id_user);
                                })
                                ->orWhere(function($query) {
                                    $query->Where('puesto_empleados.NombPuEm', 'Encuastas de satisfaccion al cliente');
                                })
                                ->get();

                foreach($usersends as $usersend){
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Hay una tarea vencida y pendiente de contingencia del reclamo de '.$reclamo->nombre_cliente.' de la organización '.$reclamo->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
            }
        }
            
        

        //vencimiento causa
        $reclamos_causa = Reclamo::select('reclamos.id','organizacions.NombOrga','reclamos.proceso')
                            ->join('organizacions','reclamos.id_organizacion','=','organizacions.id')
                            ->where([['fecha_contacto','<',$hoy], ['causa',null],
                                    ['id_user_responsable','<>',null],['fecha_registro_causa',null],
                                    ['estado','<>','Cerrada'], ['estado','<>','Eficaz']])->get();

            if ($reclamos_causa->count()>0) {
                //Aca actualiza el campo vencido_contingencia y notifica que esta vencido (o que tiene una tarea pendiente en el reclamo)
                foreach ($reclamos_causa as $reclamo_causa) {

                if ($reclamo_causa->proceso == "Ventas") {
                    $puesto = "Gerente comercial";
                }elseif(($reclamo_causa->proceso == "Repuestos") OR ($reclamo_causa->proceso == "Servicios")){
                    $puesto = "Gerente posventa";
                }elseif($reclamo_causa->proceso == "Administracion"){
                    $puesto = "Gerente de finanzas";
                }else{
                    $puesto = "Gerente de soluciones integrales";
                }

                $id_user = $reclamo_causa->id_user_responsable;
                $reclamo_causa->update(['vencido_causa'=>'SI']);

                $usersends = User::select('users.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->join('role_user','users.id','=','role_user.user_id')
                            ->join('roles','role_user.role_id','=','roles.id')
                            ->Where(function($query) {
                                $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                    ->where('users.last_name', 'Garcia Campi');
                            })
                            ->orWhere(function($query) use ($puesto) {
                                $query->where('puesto_empleados.NombPuEm', $puesto);
                            })
                            ->orWhere(function($query) {
                                $query->where('puesto_empleados.NombPuEm', 'Gerente general')
                                    ->where('users.last_name', 'Lovera')
                                    ->where('users.name', 'Santiago');
                            })
                            ->orWhere(function($query) use ($id_user) {
                                $query->where('users.id', $id_user);
                            })
                            ->orWhere(function($query) {
                                $query->Where('puesto_empleados.NombPuEm', 'Encuastas de satisfaccion al cliente');
                            })
                            ->get();

                    foreach($usersends as $usersend){
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Hay una tarea vencida y pendiente de análisis de causa del reclamo de '.$reclamo_causa->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo_causa->id.'',
                    ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }
                }
            }
    }
}
