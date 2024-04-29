<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\senal;
use App\User;

class recordatorioAlquiler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alquiler:senal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando se ejecuta en 2 horarios del dia para recordar que hay un alquiler de señal para activar dicho dia.';

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
        $diaActual = Carbon::now();
        
        $senals = Senal::join('organizacions','senals.id_organizacion','=','organizacions.id')
                        ->where('senals.estado','Facturado')
                        ->orWhere('senals.estado','Pagado')->get();
        foreach ($senals as $senal) {            
            if (isset($senal->activacion)) {
                if ($senal->activacion == $diaActual) {
                    $usersends = User::select('users.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->join('role_user','users.id','=','role_user.user_id')
                            ->join('roles','role_user.role_id','=','roles.id')
                            ->Where(function($query) {
                                $query->where('users.last_name', 'Blanc')
                                    ->Where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                            })
                            ->orWhere(function($query) {
                                $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                    ->where('users.last_name', 'Garcia Campi');
                            })
                            ->get();

                //Envio de notificacion
                foreach($usersends as $usersend){
                    $notificationData = [
                        'title' => 'Activar alquiler de señal',
                        'body' => 'Hoy es el dia de activar la señal de: '.$senal->organizacions->NombOrga.'',
                        'path' => '/senal',
                    ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
                }
                
            }
        }

    }
}
