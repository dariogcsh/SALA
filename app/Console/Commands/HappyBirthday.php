<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\User;

class HappyBirthday extends Command
{
    protected $notificationsService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se envia una notificación a todos los colaboradores de SALA informando el cumpleaños que ese dia cumple cierta/s persona/s';

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

        // Formatear la fecha para obtener el mes y día
        $mesDiaHoy = $hoy->format('m-d');

        // Obtener los usuarios que cumplen años hoy y pertenecen a la organización 'Conce'
        $usuariosCumpleHoy = User::whereRaw('DATE_FORMAT(nacimiento, "%m-%d") = ?', [$mesDiaHoy])
                            ->join('organizacions', 'users.CodiOrga', '=', 'organizacions.id')
                            ->where('organizacions.NombOrga', 'Sala Hnos')
                            ->get();
/*
        $usersends = User::select('users.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->Where('organizacions.NombOrga','Sala Hnos')
                        ->get();
*/
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->Where('users.last_name','Garcia Campi')
                        ->orWhere(function($q){
                            $q->where(function($query){
                                $query->where('puesto_empleados.NombPuEm','Gerente de RRHH')
                                    ->where('users.last_name', 'Bonamico');      
                            })
                            ->orWhere(function($query){
                                $query->where('puesto_empleados.NombPuEm', 'Responsable de RRHH')
                                    ->where('users.last_name', 'Ramilo');
                            })
                            ->orWhere(function($query){
                                $query->where('puesto_empleados.NombPuEm', 'Responsable de Marketing')
                                    ->where('users.last_name', 'Cortese');
                            });
                        })
                        ->get();

        foreach($usuariosCumpleHoy as $cumple_colaborador){
                // Envio de notificacion
                foreach($usersends as $usersend){
                    $notificationData = [
                    'title' => 'SALA - ¡Feliz Cumpleaños '.$cumple_colaborador->name.'!',
                    'body' => 'Hoy es el cumpleañoos de '.$cumple_colaborador->name.' '.$cumple_colaborador->last_name.', te deseamos un feliz día!',
                    'path' => '/home',
                    ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
        }
    }
}
