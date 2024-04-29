<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\calendario;

class recordatorioEvento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorio:evento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recordatorio de dia del evento';

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
        $eventoshoy = Calendario::select('calendario_users.id_user')
                                ->join('calendario_users','calendarios.id','=','calendario_users.id_calendario')
                                ->join('eventos','calendarios.id_evento','=','eventos.id')
                                ->where('fechainicio',$hoy)
                                ->distinct('calendarios.id')->get();

        // Envio de notificacion
        foreach($eventoshoy as $eventoh){
            $notificationData = [
            'title' => 'SALA - Recordatorio de evento',
            'body' => 'Este es un recordatorio que hoy tiene un evento',
            'path' => '/calendario',
            ];
            $this->notificationsService->sendToUser($eventoh->id_user, $notificationData);
        }

        $hoy = $hoy->addDay();
        $fecha = $hoy->format('d-m-Y');
        $eventosmanana = Calendario::select('calendario_users.id_user')
                                ->join('calendario_users','calendarios.id','=','calendario_users.id_calendario')
                                ->join('eventos','calendarios.id_evento','=','eventos.id')
                                ->where('fechainicio',$hoy)
                                ->distinct('calendarios.id')->get();

        // Envio de notificacion
        foreach($eventosmanana as $eventom){
            $notificationData = [
            'title' => 'SALA - Recordatorio de evento',
            'body' => 'Este es un recordatorio que mañana tiene un evento',
            'path' => '/calendario',
            ];
            $this->notificationsService->sendToUser($eventom->id_user, $notificationData);
        }

        $hoy = $hoy->addDay(6);
        $fecha = $hoy->format('d-m-Y');
        $eventossiete = Calendario::select('calendario_users.id_user')
                                ->join('calendario_users','calendarios.id','=','calendario_users.id_calendario')
                                ->join('eventos','calendarios.id_evento','=','eventos.id')
                                ->where('fechainicio',$hoy)
                                ->distinct('calendarios.id')->get();

        // Envio de notificacion
        foreach($eventossiete as $eventos){
            $notificationData = [
            'title' => 'SALA - Recordatorio de evento',
            'body' => 'Este es un recordatorio que el dia '.$fecha.' tiene un evento',
            'path' => '/calendario',
            ];
            $this->notificationsService->sendToUser($eventos->id_user, $notificationData);
        }
    }
}
