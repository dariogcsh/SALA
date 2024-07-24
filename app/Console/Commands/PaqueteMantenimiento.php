<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use App\mant_maq;
use App\maquina;
use App\sucursal;
use App\User;

class PaqueteMantenimiento extends Command
{
    protected $notificationsService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paquete:mantenimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando tiene la función de avisar 50 horas antes de que una máquina llegue al momento del mantenimiento del paquete y a la hora que le corresponde realizar el mantenimiento';

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

        $paquetes = Mant_maq::select('paquetemants.horas','mant_maqs.pin','mant_maqs.aviso50','mant_maqs.aviso')
                            ->leftjoin('paquetemants','mant_maqs.id_paquetemant','=','paquetemants.id')
                            ->leftjoin('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                            ->Where(function($query) {
                                $query->where('mant_maqs.estado','Aprobado')
                                    ->Where('mant_maqs.pin','not like','%otra%')
                                    ->Where('mant_maqs.aviso50','NO')
                                    ->Where('mant_maqs.realizado','NO');
                            })
                            ->orWhere(function($query) {
                                $query->where('mant_maqs.estado','Aprobado')
                                    ->Where('mant_maqs.pin','not like','%otra%')
                                    ->Where('mant_maqs.aviso','NO')
                                    ->Where('mant_maqs.realizado','NO');
                            })
                            ->distinct('paquetemants.horas')->get();
        
        foreach($paquetes as $paquete){
                $horas_motor = Maquina::where('NumSMaq',$paquete->pin)->first();
                if(isset($horas_motor)){
                    $organizacion = Sucursal::select('organizacions.NombOrga', 'sucursals.id')
                                            ->join('organizacions','sucursals.id','=','organizacions.CodiSucu')
                                            ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                            ->where('maquinas.NumSMaq', $paquete->pin)->first();
                    $diferencia = $paquete->horas - $horas_motor->horas;
                    $usersends = User::select('users.id')
                                ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                                ->join('role_user','users.id','=','role_user.user_id')
                                ->join('roles','role_user.role_id','=','roles.id')
                                ->Where('roles.name','Admin')
                                ->orWhere(function($query) use ($organizacion) {
                                    $query->where('puesto_empleados.NombPuEm', 'Administrativo de servicio')
                                        ->Where('users.CodiSucu', $organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion){
                                    $query->where('puesto_empleados.NombPuEm', 'Coordinador de servicios')
                                    ->where('roles.name', 'Coordinador de servicios')
                                    ->Where('users.CodiSucu', $organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion){
                                    $query->where('puesto_empleados.NombPuEm', 'Gerente de sucursal')
                                    ->Where('users.CodiSucu', $organizacion->id);
                                })
                                ->orWhere(function($query) use ($organizacion){
                                    $query->where('puesto_empleados.NombPuEm', 'Coordinador de servicios')
                                    ->where('roles.name', 'Coordinador de servicio corporativo');
                                })
                                ->get();

                                if(($diferencia > 0) AND ($diferencia <= 50) AND ($paquete->aviso50 == 'NO')){
                                    //Envio de notificacion
                                    foreach($usersends as $usersend){
                                        $notificationData = [
                                            'title' => 'SALA - Plan de mantenimiento',
                                            'body' => 'Quedan menos de 50 hs de motor para el próximo mantenimiento para '.$organizacion->NombOrga.' de '.$horas_motor->TipoMaq.' N° Serie:'.$paquete->pin.' plan de:'.$paquete->horas.' hs',
                                            'path' => '/mant_maq',
                                        ];
                                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                                    
                                    }
                                    $paquete_notifi = Mant_maq::select('mant_maqs.id', 'mant_maqs.aviso50')
                                                            ->join('paquetemants','mant_maqs.id_paquetemant','=','paquetemants.id')
                                                            ->where([['paquetemants.horas',$paquete->horas], 
                                                                    ['mant_maqs.pin', $paquete->pin]])->get();

                                    foreach($paquete_notifi as $paquete_noti){
                                        $paquete_noti->where('id', $paquete_noti->id)->update(['aviso50' => 'SI']);
                                    }
                                }elseif(($diferencia <= 0) AND ($paquete->aviso == 'NO')){
                                    //Envio de notificacion
                                    foreach($usersends as $usersend){
                                        $notificationData = [
                                            'title' => 'SALA - Plan de mantenimiento',
                                            'body' => 'Ya se cumplieron las horas para el próximo mantenimiento para '.$organizacion->NombOrga.' de '.$horas_motor->TipoMaq.' N° Serie:'.$paquete->pin.' plan de:'.$paquete->horas.' hs',
                                            'path' => '/mant_maq',
                                        ];
                                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                                    }
                                    $paquete_notifi = Mant_maq::select('mant_maqs.id', 'mant_maqs.aviso')
                                                            ->join('paquetemants','mant_maqs.id_paquetemant','=','paquetemants.id')
                                                            ->where([['paquetemants.horas',$paquete->horas], 
                                                                    ['mant_maqs.pin', $paquete->pin]])->get();

                                    foreach($paquete_notifi as $paquete_noti){
                                        $paquete_noti->where('id', $paquete_noti->id)->update(['aviso' => 'SI']);
                                    }
                                }
            }
        }

        
    }
}
