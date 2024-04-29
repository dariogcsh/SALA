<?php

namespace App\Console\Commands;
use App\Services\NotificationsService;
use App\sucursal;
use App\User;
use App\alerta;
use App\organizacion;

use Illuminate\Console\Command;

class alertaNaranja extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerta:naranja';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este tipo de alertas, son referidas a la poca memoria de pantalla por ejemplo, y son dirigidas al equipo de SI tambien.';

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
        $alertasvel = Alerta::where([['notificado','NO'],['descripcion','LIKE','%NARANJA%']])->get();
        foreach ($alertasvel as $alertavel){
            //obtener sucursal donde pertenece el usuario que solicita la asistencia
            $sucursalid = Sucursal::select('sucursals.id', 'organizacions.NombOrga')
                                ->join('organizacions','sucursals.id','=','organizacions.CodiSucu')
                                ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                ->join('alertas','maquinas.NumSMaq','=','alertas.pin')
                                ->where('alertas.id',$alertavel->id)
                                ->first();

            $organizacion = Organizacion::select('organizacions.id')
                                        ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                        ->join('alertas','maquinas.NumSMaq','=','alertas.pin')
                                        ->where('alertas.id',$alertavel->id)->first();


            $matchTheseAnalista = [['puesto_empleados.NombPuEm', 'Analista de soluciones integrales']];
            $matchTheseGerenteSI = [['puesto_empleados.NombPuEm', 'Gerente de soluciones integrales']];
            $especialistaAMS = [['puesto_empleados.NombPuEm', 'Especialista AMS']];
            $matchTheseGerenteTC = [['puesto_empleados.NombPuEm', 'Technical Comunicator']];
            $usersends = User::select('users.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->join('role_user','users.id','=','role_user.user_id')
                            ->join('roles','role_user.role_id','=','roles.id')
                            ->orWhere($matchTheseAnalista)
                            ->orWhere($matchTheseGerenteSI)
                            ->orWhere($especialistaAMS)
                            ->orWhere($matchTheseGerenteTC)
                            ->orWhere('users.CodiOrga', $organizacion->id)
                            ->get();

            // Envio de notificacion
            foreach($usersends as $usersend){
                $notificationData = [
                'title' => 'Alerta - '.$sucursalid->NombOrga.'',
                'body' => $alertavel->descripcion.'',
                'path' => '/alerta/'.$alertavel->id.'',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
            $alertavel->where('id', $alertavel->id)->update(['notificado' => 'SI']);
        }
    }
}
