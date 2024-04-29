<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\usado;
use App\User;

class usadoDisponible extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usado:disponible';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Al momento de reservar un usado tiene fecha de 72 hs de reserva, cumplida esas horas este comando lo cambia de estado a disponible y envia notificación al equipo de ventas.';

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
        $dia = $hoy->format('Y-m-d');

        $usados_reservados = Usado::where([['estado','Reservado'], ['fechahasta','<',$hoy]])->get();

        if($usados_reservados->count() > 0){
            /// ENVIO DE NOTIFICACION
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                ->where('users.last_name', 'Garcia Campi');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Vendedor');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente general');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de usados');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->Where('puesto_empleados.NombPuEm', 'Gerente comercial');
                        })
                        ->get();

                    //Envio de notificacion
                    foreach($usados_reservados as $usado){
                        $usado->update(['estado' => 'Disponible', 'fechareserva' => null, 'fechahasta' => null, 'reservado_para' => null]);
                        foreach($usersends as $usersend){
                            //Aqui va un foreach de usersend
                            $notificationData = [
                                'title' => 'Usados - Baja de reserva',
                                'body' => 'La reserva de el/la '.$usado->tipo.' '.$usado->marca.' '.$usado->modelo.' modelo '.$usado->ano.' ex '.$usado->excliente.' ha vencido, por lo tanto dicha unidad ya se encuentra disponible',
                                'path' => '/usado/'.$usado->id.'',
                            ];
                            $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        }
                    }
            }
    }
}
