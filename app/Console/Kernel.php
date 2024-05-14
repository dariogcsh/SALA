<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\notificacionSolicitud::class,
        Commands\notificacionGestion::class,
        Commands\notificacionGestionFinde::class,
        //Commands\horasDeMotor::class,
        Commands\recordatorioAlquiler::class,
        Commands\notifAlerta::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       
        //$schedule->command('prueba:sched')->everyMinute();
        $schedule->command('alerta:naranja')->everyMinute();
        $schedule->command('notificacion:alertasvel')->everyMinute();
        $schedule->command('notificacion:alertasvti')->everyMinute();
        //$schedule->command('notificacion:alerta')->everyMinute();
        $schedule->command('notif:alerta')->everyMinute();
        $schedule->command('notificacion:infodiario')->dailyAt('9:00');
        $schedule->command('informe:diariomaq')->dailyAt('11:30');
        $schedule->command('notifi:solicitud')->everyFiveMinutes();
        $schedule->command('notificacion:gestion')->everyFiveMinutes()->weekdays();
        $schedule->command('notificacion:gestionfinde')->everyFiveMinutes()->weekends();
        $schedule->command('horas:motor')->dailyAt('8:00');
        $schedule->command('alquiler:senal')->dailyAt('9:00');
        $schedule->command('Delete:alertas')->dailyAt('1:00');
        $schedule->command('Delete:alertas')->dailyAt('7:00');
        $schedule->command('paquete:mantenimiento')->dailyAt('8:30');
        $schedule->command('actualizar:organizacion')->dailyAt('4:00');
        $schedule->command('recordatorio:evento')->dailyAt('8:00');
        $schedule->command('definir:objetivo')->dailyAt('2:00');
        $schedule->command('usado:disponible')->dailyAt('8:30');
        //$schedule->command('actualizar:vehiculos')->dailyAt('10:00');
        $schedule->command('reclamo:vencido')->dailyAt('8:45');
        $schedule->command('reclamo:notificacion')->dailyAt('8:45');

        //Ejecuta la tearea todos los miercoles a las 9 hs
        $schedule->command('factura:monitoreo')->weeklyOn(3, '9:00');
        $schedule->command('notificacion:viraje')->dailyAt('11:32');
        $schedule->command('notificacion:performance')->dailyAt('11:35');
        $schedule->command('notif:combine')->dailyAt('11:40');
        
        
        //$schedule->command('prueba:sched')->everyMinute();
        //$schedule->command('un:dia')->dailyAt('9:19');
        
        //$schedule->command('delete:ubicaciones')->dailyAt('1:00');
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
