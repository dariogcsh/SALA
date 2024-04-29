<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\User;
use App\organizacion;
use App\utilidad;
use Illuminate\Support\Facades\DB;

class informeDiarioMaq extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'informe:diariomaq';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se envia una notificacion diaria si se genera un informe diario al cliente';

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
        $fecha = Carbon::yesterday();
        $fecha = $fecha->format('d-m-Y');
        $diasatras = date("Y-m-d",strtotime($hoy."-1 days"));
        
        $utilidads = Utilidad::select('organizacions.NombOrga','utilidads.FecIUtil','sucursals.NombSucu',
                                            'organizacions.CodiOrga')
                                ->join('maquinas','utilidads.NumsMaq','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['SeriUtil','Trabajando'], ['ValoUtil','>=',1], ['UOMUtil','hr'],
                                        ['FecIUtil',$diasatras]])
                                ->groupBy('organizacions.NombOrga')
                                ->orderBy('utilidads.FecIUtil','desc')->get();
        $i=0;

        foreach($utilidads as $utilidad){
            $organizacion = Organizacion::where([['CodiOrga',$utilidad->CodiOrga], ['InscOrga','SI']])->first();
            if(isset($organizacion)){
                $usersends = User::select('users.id')
                                ->Where('users.CodiOrga', $organizacion->id)
                                //->Where('users.last_name','Garcia Campi')
                                ->get();

                // Envio de notificacion
                foreach($usersends as $usersend){
                    $notificationData = [
                    'title' => 'SALA - Informe diario de máquina',
                    'body' => 'Se ha recibido información del dia '.$fecha,
                    'path' => '/utilidad/indexdiario',
                    ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
            }
        }
    }
}
