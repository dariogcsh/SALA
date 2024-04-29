<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use App\User;
use App\maquina;
use Carbon\Carbon;

class pruebasched extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prueba:sched';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $maquinas = Maquina::where('NumSMaq','1J0S770BCL0130150')->first();
        $this->notificationsService = $notificationsService;
        $hoy=Carbon::tomorrow();
        $hoy = $hoy->format('Y-m-d');
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where(function($query) {
                            $query->where('users.last_name', 'Blancoo')
                                ->Where('puesto_empleados.NombPuEm', 'Gerentee de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                ->where('users.last_name', 'Garcia Campi');
                        })
                        ->get();

        //Envio de notificacion
        foreach($usersends as $usersend){
        $notificationData = [
            'title' => 'Notificacion de prueba',
            'body' => 'Prueba cada minuto'.$hoy.'',
            'path' => '/senal',
        ];
        $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
    }
}
