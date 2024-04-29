<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\asist;
use App\sucursal;
use App\User;

class notificacionSolicitud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifi:solicitud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se envia notificacion a miembros de la concesionaria para advertir que hay una solicitud de asistencia sin responder';

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

        $horaActual = Carbon::now();
        // Busco asistencias que esten en estado 'Solicitud' y hayan pasado 5 minutos sin respuesta.
        $asistencias = Asist::where('EstaAsis', 'Solicitud')->get();
        if (isset($asistencias)){
            foreach ($asistencias as $asist) {
                $horaAsist = $asist->created_at;

                $horaLimite = $horaAsist->modify('+ 5 minutes');
                if ($horaActual >= $horaLimite){
                    $body = 'La solicitud de asistencia N°: ' .$asist->id. ' no ha sido respondida por el Administrativo de servicio, es requerido que el Gerente de sucursal tome el caso.';
                }
                $horaAsist = $asist->created_at;

                $horaLimite = $horaAsist->modify('+ 10 minutes');
                if ($horaActual >= $horaLimite){
                    $body = 'La solicitud de asistencia N°: ' .$asist->id. ' no ha sido respondida por el Gerente de sucursal, es requerido que el Coordinador de servicio tome el caso.';
                }
                $horaAsist = $asist->created_at;

                $horaLimite = $horaAsist->modify('+ 15 minutes');
                if ($horaActual >= $horaLimite){
                    $body = 'La solicitud de asistencia N°: ' .$asist->id. ' no ha sido respondida por el Coordinador de servicio, es requerido que el Gerente de posventa tome el caso.';
                }
                $horaAsist = $asist->created_at;

                $horaLimite = $horaAsist->modify('+ 20 minutes');
                if ($horaActual >= $horaLimite){
                    $body = 'La solicitud de asistencia N°: ' .$asist->id. ' no ha sido respondida por el Gerente de posventa, es requerido que el area de Soluciones integrales tome el caso.';
                }
                $horaAsist = $asist->created_at;

                $horaLimite = $horaAsist->modify('+ 5 minutes');
                if ($horaActual >= $horaLimite){

                    //obtener sucursal donde pertenece el usuario que solicita la asistencia
                    $sucursalid = Sucursal::select('sucursals.id')
                                        ->join('users','sucursals.id','=','users.CodiSucu')
                                        ->join('asists','users.id','=','asists.id_user')
                                        ->where('asists.id',$asist->id)
                                        ->first();

                    // Selecciona a los usuarios correspondientes a enviar notificacion de recordatorio
                    $matchTheseAdministrativo = [['puesto_empleados.NombPuEm', 'Administrativo de servicio'], ['users.CodiSucu', $sucursalid->id]];
                    $matchTheseGerente = [['puesto_empleados.NombPuEm', 'Gerente de sucursal'], ['users.CodiSucu', $sucursalid->id]];
                    $matchTheseCoordinador = [['puesto_empleados.NombPuEm', 'Coordinador de servicios']];
                    $matchTheseTC = [['puesto_empleados.NombPuEm', 'Technical Comunicator']];
                    $usersends = User::select('users.id')
                                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                                    ->join('role_user','users.id','=','role_user.user_id')
                                    ->join('roles','role_user.role_id','=','roles.id')
                                    ->orWhere($matchTheseAdministrativo)
                                    ->orWhere($matchTheseGerente)
                                    ->orWhere($matchTheseCoordinador)
                                    ->orWhere($matchTheseTC)
                                    ->orWhere('roles.name','Admin')
                                    ->get();

                    // Envio de notificacion
                    foreach($usersends as $usersend){
                        $notificationData = [
                            'title' => 'SALA - ¡Asistencia sin respuesta!',
                            'body' => $body,
                            'path' => '/asist/'.$asist->id.'',
                        ];
                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }
                }
            }
        }
    }
}
