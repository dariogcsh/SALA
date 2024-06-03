<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\vehiculo;

class vencimientoPoliza extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vencimiento:poliza';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esta es una tarea cron que se ejecuta todos los dias para notificar una semana antes y el dia antes del vencimiento de una poliza de vehiculo';

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
        $hoy = $hoy->addDay();
        $fecha = $hoy->format('d-m-Y');
        $vencimientosmanana = Vehiculo::select('vehiculo_responsables.id_user')
                                ->join('vehiculo_responsables','vehiculos.id','=','vehiculo_responsables.id_vehiculo')
                                ->where('vto_poliza',$hoy)->get();

        // Envio de notificacion
        foreach($vencimientosmanana as $vencimientom){
            $notificationData = [
            'title' => 'SALA - Recordatorio de vencimiento de poliza',
            'body' => 'La poliza de su vehículo de SALA vencerá mañana',
            'path' => '/vehiculo',
            ];
            $this->notificationsService->sendToUser($vencimientom->id_user, $notificationData);
        }

        $hoy = $hoy->addDay(6);
        $fecha = $hoy->format('d-m-Y');
        $vencimientosemana = Vehiculo::select('vehiculo_responsables.id_user')
                                ->join('vehiculo_responsables','vehiculos.id','=','vehiculo_responsables.id_vehiculo')
                                ->where('vto_poliza',$hoy)->get();

        // Envio de notificacion
        foreach($vencimientosemana as $vencimientos){
            $notificationData = [
            'title' => 'SALA - Recordatorio de vencimiento de poliza',
            'body' => 'La poliza de su vehículo de SALA vencerá el dia '.$fecha.'',
            'path' => '/vehiculo',
            ];
            $this->notificationsService->sendToUser($vencimientos->id_user, $notificationData);
        }
    }
}
