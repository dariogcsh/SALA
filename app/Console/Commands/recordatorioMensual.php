<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\User;
use App\organizacion;

class recordatorioMensual extends Command
{
    protected $notificationsService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorio:mensual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esta funcion es para enviar recordatorios mensuales de ciertas cosas a realizar con fecha limite para gerencia';

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
        $fecha = $hoy->format('d-m-Y');

        //Busco organizacion sala para hacer una busqueda mas precisa del colaborador a enviar el aviso
        $organizacion = Organizacion::where('NombOrga','Sala Hnos')->first();
        if (
            ($fecha == '11-06-2024') OR
            ($fecha == '12-07-2024') OR
            ($fecha == '14-08-2024') OR
            ($fecha == '11-09-2024') OR
            ($fecha == '15-10-2024') OR
            ($fecha == '12-11-2024') OR
            ($fecha == '12-12-2024')
            ) {

                $usersends = User::select('users.id')
                                ->Where(function($query) use ($organizacion) {
                                    $query->where('users.name', 'Manuel')
                                        ->where('users.last_name', 'Lovera')
                                        ->where('CodiOrga',$organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion) {
                                    $query->where('users.name', 'Fernando')
                                        ->where('users.last_name', 'Sartori')
                                        ->where('CodiOrga',$organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion) {
                                    $query->where('users.name', 'Joel')
                                        ->where('users.last_name', 'Cerioni')
                                        ->where('CodiOrga',$organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion) {
                                    $query->where('users.name', 'Joel')
                                        ->where('users.last_name', 'Costantino')
                                        ->where('CodiOrga',$organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion) {
                                    $query->where('users.name', 'Kevin')
                                        ->where('users.last_name', 'Sobarzo')
                                        ->where('CodiOrga',$organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion) {
                                    $query->where('users.name', 'Julieta')
                                        ->where('users.last_name', 'Perassi')
                                        ->where('CodiOrga',$organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion) {
                                    $query->where('users.name', 'Dario')
                                        ->where('users.last_name', 'Garcia Campi')
                                        ->where('CodiOrga',$organizacion->id);
                                })
                                ->get();

                foreach($usersends as $usersend){
            // Envio de notificacions
            $notificationData = [
                'title' => 'PROCESO DE LIQUIDACIÓN DE HABERES –  FECHA LIMITE',
                'body' => 'Fecha limite para enviar las novedades de su departamento/área al responsable de liquidación de sueldo y administración de personal (Julieta Perassi).',
                'path' => '/user_notification/index',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
        }


        //////////////////// JULIETA PERASSI /////////////////////
        $usuario = User::where([['name','Julieta'],['last_name','Perassi'],['CodiOrga',$organizacion->id]])->first();
        //Si la fecha actual es igual a la fecha límite, enviar la notificación.
        if (
            (($fecha == '13-06-2024') AND ($usuario->name == 'Julieta')) OR 
            (($fecha == '16-07-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '16-08-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '13-09-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '17-10-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '14-11-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '16-12-2024') AND ($usuario->name == 'Julieta')) 
            ) {
            // Envio de notificacions
            $notificationData = [
                'title' => 'PROCESO DE LIQUIDACIÓN DE HABERES –  FECHA LIMITE',
                'body' => 'Fecha limite para enviar las novedades sobre liquidación de haberes al Estudio Contable Externo',
                'path' => '/user_notification/index',
                ];
                $this->notificationsService->sendToUser($usuario->id, $notificationData);
        }

        //Si la fecha actual es igual a la fecha límite, enviar la notificación.
        if (
            (($fecha == '21-06-2024') AND ($usuario->name == 'Julieta')) OR 
            (($fecha == '26-07-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '28-08-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '25-09-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '28-10-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '27-11-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '26-12-2024') AND ($usuario->name == 'Julieta')) 
            ) {
            // Envio de notificacions
            $notificationData = [
                'title' => 'PROCESO DE LIQUIDACIÓN DE HABERES –  FECHA LIMITE',
                'body' => 'Fecha límite para controla la preventiva de liquidación y enviarla al Departamento de Adm y Finanzas',
                'path' => '/user_notification/index',
                ];
                $this->notificationsService->sendToUser($usuario->id, $notificationData);
        }

        //Si la fecha actual es igual a la fecha límite, enviar la notificación.
        if (
            (($fecha == '29-08-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '27-09-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '29-10-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '28-11-2024') AND ($usuario->name == 'Julieta')) OR
            (($fecha == '27-12-2024') AND ($usuario->name == 'Julieta')) 
            ) {
            // Envio de notificacions
            $notificationData = [
                'title' => 'PROCESO DE LIQUIDACIÓN DE HABERES –  FECHA LIMITE',
                'body' => '-	Fecha limite para corroborar con el responsable del departamento de Administración y Finanzas las cuentas sueldo de cada colaborador',
                'path' => '/user_notification/index',
                ];
                $this->notificationsService->sendToUser($usuario->id, $notificationData);
        }

        //////////////////// MARTIN LOVERA /////////////////////
        $usuario = User::where([['name','Martin'],['last_name','Lovera'],['CodiOrga',$organizacion->id]])->first();
        //Si la fecha actual es igual a la fecha límite, enviar la notificación.
        if (
            (($fecha == '19-06-2024') AND ($usuario->name == 'Martin')) OR 
            (($fecha == '23-07-2024') AND ($usuario->name == 'Martin')) OR
            (($fecha == '23-08-2024') AND ($usuario->name == 'Martin')) OR
            (($fecha == '19-09-2024') AND ($usuario->name == 'Martin')) OR
            (($fecha == '23-10-2024') AND ($usuario->name == 'Martin')) OR
            (($fecha == '22-11-2024') AND ($usuario->name == 'Martin')) OR
            (($fecha == '19-12-2024') AND ($usuario->name == 'Martin')) 
            ) {
            // Envio de notificacions
            $notificationData = [
                'title' => 'PROCESO DE LIQUIDACIÓN DE HABERES –  FECHA LIMITE',
                'body' => 'Fecha limite para recordar al estudio contable que envíe la preventiva de liquidación de haberes',
                'path' => '/user_notification/index',
                ];
                $this->notificationsService->sendToUser($usuario->id, $notificationData);
        }

         //////////////////// JOEL CERIONI /////////////////////
         $usuario = User::where([['name','Joel'],['last_name','Cerioni'],['CodiOrga',$organizacion->id]])->first();
         //Si la fecha actual es igual a la fecha límite, enviar la notificación.
         if (
             (($fecha == '07-08-2024') AND ($usuario->name == 'Joel')) OR
             (($fecha == '06-09-2024') AND ($usuario->name == 'Joel')) OR
             (($fecha == '04-10-2024') AND ($usuario->name == 'Joel')) OR
             (($fecha == '06-11-2024') AND ($usuario->name == 'Joel')) OR
             (($fecha == '06-12-2024') AND ($usuario->name == 'Joel')) 
             ) {
             // Envio de notificacions
             $notificationData = [
                 'title' => 'PROCESO DE LIQUIDACIÓN DE HABERES –  FECHA LIMITE',
                 'body' => 'Fecha limite para enviar el informe de cobranzas a Julieta Perassi y Fernando Sartori ',
                 'path' => '/user_notification/index',
                 ];
                 $this->notificationsService->sendToUser($usuario->id, $notificationData);
         }

        //Si la fecha actual es igual a la fecha límite, enviar la notificación.
        if (
            (($fecha == '25-06-2024') AND ($usuario->name == 'Joel')) OR 
            (($fecha == '29-07-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '29-08-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '27-09-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '29-10-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '28-11-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '27-12-2024') AND ($usuario->name == 'Joel')) 
            ) {
            // Envio de notificacions
            $notificationData = [
                'title' => 'PROCESO DE LIQUIDACIÓN DE HABERES –  FECHA LIMITE',
                'body' => 'Fecha limite para organizar y preparar todas las transferencias correspondientes a la liquidación de haberes. Corroborar con el responsable de liquidación de sueldo y administración de personal (Julieta Perassi) las cuentas sueldo de cada colaborador para evitar errores',
                'path' => '/user_notification/index',
                ];
                $this->notificationsService->sendToUser($usuario->id, $notificationData);
        }

        //Si la fecha actual es igual a la fecha límite, enviar la notificación.
        if (
            (($fecha == '28-06-2024') AND ($usuario->name == 'Joel')) OR 
            (($fecha == '30-07-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '30-08-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '30-09-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '30-10-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '29-11-2024') AND ($usuario->name == 'Joel')) OR
            (($fecha == '30-12-2024') AND ($usuario->name == 'Joel')) 
            ) {
            // Envio de notificacions
            $notificationData = [
                'title' => 'PROCESO DE LIQUIDACIÓN DE HABERES –  FECHA LIMITE',
                'body' => 'Fecha limite para realizar las transferencias correspondientes a las liquidaciones de haberes',
                'path' => '/user_notification/index',
                ];
                $this->notificationsService->sendToUser($usuario->id, $notificationData);
        }
    }
}
