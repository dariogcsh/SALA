<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\reclamo;
use App\User;

class reclamoNotificacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reclamo:notificacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esta funcion va a dispoarar una alerta al responsable de una tarea que este es el ultimo dia para ejecutar la tarea antes de que se venza';

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
                            ->where([['fecha_limite_contingencia',$hoy], ['accion_contingencia',null],
                                    ['id_user_contingencia','<>',null],['fecha_registro_contingencia',null]])->get();

        if ($reclamos->count()>0) {
            //Aca actualiza el campo vencido_contingencia y notifica que esta vencido (o que tiene una tarea pendiente en el reclamo)
            foreach ($reclamos as $reclamo) {
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Hoy es el último día para completar la tarea de contingencia del reclamo de '.$reclamo->NombOrga.' antes de su vencimiento.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($reclamo->id_user_contingencia, $notificationData);
                
            }
        }

         //vencimiento causa
        $reclamos_causa = Reclamo::select('reclamos.id','organizacions.NombOrga','reclamos.proceso')
                                ->join('organizacions','reclamos.id_organizacion','=','organizacions.id')
                                ->where([['fecha_contacto',$hoy], ['causa',null],
                                        ['id_user_responsable','<>',null],['fecha_registro_causa',null]])->get();

        if ($reclamos_causa->count()>0) {
            //Aca actualiza el campo vencido_contingencia y notifica que esta vencido (o que tiene una tarea pendiente en el reclamo)
            foreach ($reclamos_causa as $reclamo_causa) {
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Hoy es el último día para completar la tarea de analisis de causa del reclamo de '.$reclamo_causa->NombOrga.' antes de su vencimiento.',
                        'path' => '/reclamo/'.$reclamo_causa->id.'',
                    ];
                    $this->notificationsService->sendToUser($reclamo_causa->id_user_responsable, $notificationData);
                
            }
        }

         //vencimiento correctiva
         $reclamos_correctiva = Reclamo::select('reclamos.id','organizacions.NombOrga','reclamos.proceso')
                            ->join('organizacions','reclamos.id_organizacion','=','organizacions.id')
                            ->where([['fecha_limite_correctiva',$hoy], ['accion_correctiva',null],
                                    ['id_user_correctiva','<>',null]])->get();

        if ($reclamos_correctiva->count()>0) {
            //Aca actualiza el campo vencido_contingencia y notifica que esta vencido (o que tiene una tarea pendiente en el reclamo)
            foreach ($reclamos_correctiva as $reclamo_correctiva) {
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Hoy es el último día para completar la tarea de acción correctiva del reclamo de '.$reclamo_correctiva->NombOrga.' antes de su vencimiento.',
                        'path' => '/reclamo/'.$reclamo_correctiva->id.'',
                    ];
                    $this->notificationsService->sendToUser($reclamo_correctiva->id_user_correctiva, $notificationData);
                
            }
        }

    }
}
