<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\User;
use App\campo;
use App\organizacion;

class informeDiario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:infodiario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Informe diario de lo que se recibe en Operation Center';

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
        $campos = Campo::where('op_fin',$hoy)
                        ->groupBy('org_id')->get();
        $fecha = $hoy->format('d-m-Y');
        foreach ($campos as $campo){
            $organizacion = Organizacion::where([['CodiOrga',$campo->org_id], ['InscOrga','SI']])->first();
            if(isset($organizacion)){
                $usersends = User::select('users.id')
                                ->Where('users.CodiOrga', $organizacion->id)
                                //->Where('users.last_name','Garcia Campi')
                                ->get();

                // Envio de notificacion
                foreach($usersends as $usersend){
                    $notificationData = [
                    'title' => 'SALA - Informe diario',
                    'body' => 'Se ha recibido información el dia '.$fecha,
                    'path' => '/campo/'.$campo->id,
                    ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
            }
        }
    }
}
