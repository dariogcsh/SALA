<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use App\sucursal;
use App\User;
use App\alerta;
use App\maquina;

class notifAlerta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:alerta';

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


            $alertas = Alerta::select('alertas.id','alertas.id_alert','alertas.fecha','alertas.hora','alertas.codigo',
                                    'alertas.descripcion','alertas.pin','alertas.accion','alertas.lat','alertas.lon',
                                    'alertas.presupuesto','alertas.cor','alertas.notificado')
                                ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                                ->where([['alertas.notificado','NO']])->get();
                                
            foreach ($alertas as $alerta){
                if($alerta->accion == ""){
                    //obtener sucursal donde pertenece el usuario que solicita la asistencia
                    $sucursalid = Sucursal::select('sucursals.id', 'organizacions.NombOrga')
                                        ->join('organizacions','sucursals.id','=','organizacions.CodiSucu')
                                        ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                        ->join('alertas','maquinas.NumSMaq','=','alertas.pin')
                                        ->where('alertas.id',$alerta->id)
                                        ->first();
                
                    // Selecciona a los usuarios correspondientes a enviar notificacion de recordatorio
                    $matchTheseAdministrativo = [['puesto_empleados.NombPuEm', 'Administrativo de servicio'], ['users.CodiSucu', $sucursalid->id]];
                    $matchTheseGerente = [['puesto_empleados.NombPuEm', 'Gerente de sucursal'], ['users.CodiSucu', $sucursalid->id]];
                    $matchTheseGerenteTC = [['puesto_empleados.NombPuEm', 'Technical Comunicator']];
                    $usersends = User::select('users.id')
                                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                                    ->join('role_user','users.id','=','role_user.user_id')
                                    ->join('roles','role_user.role_id','=','roles.id')
                                    ->orWhere($matchTheseAdministrativo)
                                    ->orWhere($matchTheseGerente)
                                    ->orWhere($matchTheseGerenteTC)
                                    ->get();

                    // Envio de notificacion
                    foreach($usersends as $usersend){
                        $notificationData = [
                        'title' => 'Alerta - '.$sucursalid->NombOrga.'',
                        'body' => $alerta->descripcion.'',
                        'path' => '/alerta/'.$alerta->id.'',
                        ];
                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }
                } else{
                    
                    $organizacion = Maquina::select('organizacions.id','organizacions.NombOrga')
                                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                            ->where('maquinas.NumSMaq',$alerta->pin)->first();
                                            
                    $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->where('users.CodiOrga',$organizacion->id)
                        //->orWhere('roles.name','Admin')
                        ->get();
                        // Envio de notificacion

                        foreach($usersends as $usersend){
                            $notificationData = [
                            'title' => 'Recomendación de alerta - '.$organizacion->NombOrga.'',
                            'body' => $alerta->descripcion.'. Recomendación: '.$alerta->accion.'',
                            'path' => '/alerta/'.$alerta->id.'',
                            ];
                            $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        }
                }
                $alerta->where('id', $alerta->id)->update(['notificado' => 'SI']);
            }
     
    }
}

