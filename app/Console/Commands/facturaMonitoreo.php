<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use App\monitoreo;
use Carbon\Carbon;
use App\User;

class facturaMonitoreo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factura:monitoreo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Todos los miercoles se verifica que no haya un paquete listo para facturar, en caso de estar en el med estipulado con el cliente para facturar el paquete, se cambia el estado de pendiente a Listo para facturar y se envia una notificacion a administración para que se realice la facturacion.';

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

        $hoy = Carbon::now();
        $mes_num = $hoy->format('m');
        if ($mes_num == '1') {
            $mes = "Enero";
        }elseif($mes_num == '2'){
            $mes = "Febrero";
        }elseif($mes_num == '3'){
            $mes = "Marzo";
        }elseif($mes_num == '4'){
            $mes = "Abril";
        }elseif($mes_num == '5'){
            $mes = "Mayo";
        }elseif($mes_num == '6'){
            $mes = "Junio";
        }elseif($mes_num == '7'){
            $mes = "Julio";
        }elseif($mes_num == '8'){
            $mes = "Agosto";
        }elseif($mes_num == '9'){
            $mes = "Septiembre";
        }elseif($mes_num == '10'){
            $mes = "Octubre";
        }elseif($mes_num == '11'){
            $mes = "Noviembre";
        }elseif($mes_num == '12'){
            $mes = "Diciembre";
        }

        $pendientes = Monitoreo::select('monitoreos.id','organizacions.NombOrga')
                                ->join('organizacions','monitoreos.id_organizacion','=','organizacions.id')
                                ->where([['estado','Pendiente'], ['mes_facturacion', $mes]])->get();
        
        if ($pendientes->count() > 0) {
            foreach ($pendientes as $pendiente) {
                $pendiente->where('monitoreos.id',$pendiente->id)->update(['estado' => 'Listo para facturar']);

                $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where('puesto_empleados.NombPuEm', 'Analista de creditos')
                        ->orWhere(function($query) {
                            $query->where('users.last_name', 'Blanc')
                                  ->Where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Especialista AMS')
                                ->where('users.last_name', 'Pellizza');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                ->where('users.last_name', 'Garcia Campi');
                        })
                        ->get();

                //Envio de notificacion
                foreach($usersends as $usersend){
                    $notificationData = [
                        'title' => 'Paquete de monitoreo - Listo para facturar',
                        'body' => 'Hay un paquete de monitoreo listo para facturar de '.$pendiente->NombOrga.'',
                        'path' => '/monitoreo/index_pendientes',
                    ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
            }
        }
    }
}
