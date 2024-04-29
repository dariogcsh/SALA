<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\maquina;
use App\horasmotor;
use App\User;
use App\Services\NotificationsService;


class horasDeMotor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horas:motor';

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
        $this->notificationsService = $notificationsService;
        
        $horasmotores = Maquina::select('NumSMaq','horas')
                                ->where('horas','>',0)
                                ->get();

        foreach($horasmotores as $horasmotor)
        {
            $ultimahora = Horasmotor::where('NumSMaq', $horasmotor->NumSMaq)
                                    ->orderBy('horas','desc')
                                    ->first();
            if(isset($ultimahora)){
                if($horasmotor->horas > $ultimahora->horas){
                $horasdemotor = Horasmotor::create(['NumSMaq' => $horasmotor->NumSMaq, 
                                                    'horas' => $horasmotor->horas]);
                }
            } else {
                $horasdemotor = Horasmotor::create(['NumSMaq' => $horasmotor->NumSMaq, 
                                                    'horas' => $horasmotor->horas]);
            }
        }
    }
}
