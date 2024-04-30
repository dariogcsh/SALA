<?php

namespace App\Http\Controllers;

use App\reclamo;
use App\reclamo_accion;
use App\interaccion;
use App\organizacion;
use App\cambio_fecha_cx;
use App\sucursal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;

class ReclamoController extends Controller
{

    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','reclamo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Reclamos']);
        $rutavolver = route('internocx');
        $reclamos = Reclamo::select('reclamos.id','organizacions.NombOrga','sucursals.NombSucu','reclamos.nombre_cliente',
                                    'reclamos.descripcion','reclamos.estado','fecha_registro_causa','fecha_contacto',
                                    'fecha_limite_contingencia','fecha_registro_contingencia')
                            ->join('organizacions','reclamos.id_organizacion','=','organizacions.id')
                            ->join('sucursals','reclamos.id_sucursal','=','sucursals.id')
                            ->orderBy('reclamos.id','desc')->paginate(20);
        
        $hoy_c = Carbon::today();
        $hoy = $hoy_c->format('Y-m-d');
       
        return view('reclamo.index', compact('reclamos','rutavolver','hoy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','reclamo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Reclamos']);
        $rutavolver = route('reclamo.index');
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $sucursales = Sucursal::orderBy('id','asc')->get();
        $usuarios = User::select('users.name','users.last_name','users.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('organizacions.NombOrga','Sala Hnos')
                        ->orderBy('name','asc')->get();
        return view('reclamo.create',compact('rutavolver','organizaciones','usuarios','sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reclamo = Reclamo::create($request->all());

        //
        $organizacion = Organizacion::where('id',$request->id_organizacion)->first();

        //Notificar usuario contingencia
        if (isset($reclamo->id_user_contingencia)) {
         /// ENVIO DE NOTIFICACION
         $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                ->where('users.last_name', 'Garcia Campi');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente posventa');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente General');
                        })
                        ->orWhere(function($query) {
                            $query->Where('puesto_empleados.NombPuEm', 'Encuastas de satisfaccion al cliente');
                        })
                        ->get();

            foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'SALA - Nueva Queja/Reclamo',
                    'body' => 'Se ha registrado una nueva queja/reclamo del cliente '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                    'path' => '/reclamo/'.$reclamo->id.'',
                ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
                        
            $notificationData = [
                'title' => 'SALA - Nueva Quejas/Reclamos',
                'body' => 'Usted ha sido asignado para llevar a cabo la acción de contingencia para el reclamo del cliente '.$reclamo->nombre_cliente.' de la organización  '.$organizacion->NombOrga.'.',
                'path' => '/reclamo/'.$reclamo->id.'',
            ];
            $this->notificationsService->sendToUser($request->id_user_contingencia, $notificationData);

        }

        //Notificar usuario analisis de causa
        if (isset($reclamo->id_user_responsable)) {
            //Envio de notificacion
               $notificationData = [
                   'title' => 'SALA - Quejas/Reclamos',
                   'body' => 'Usted ha sido asignado para llevar a cabo el análisis de causa para el reclamo de '.$organizacion->NombOrga.'.',
                   'path' => '/reclamo/'.$reclamo->id.'',
               ];
               $this->notificationsService->sendToUser($request->id_user_responsable, $notificationData);
   
           }

           //insertar usuarios paraa la accion correctiva
        if (isset($request->id_user_correctiva)) {
            $participantes = $request->id_user_correctiva;
        }
        
        if (isset($participantes)) {
            foreach ($participantes as $par) {
                $correctiva_user = new Reclamo_accion([
                   
                    'id_user_correctiva'   =>  $par,
                    'id_reclamo'  =>  $reclamo->id,
                ]);
                $correctiva_user->save();
              
               $notificationData = [
                   'title' => 'SALA - Quejas/Reclamos',
                   'body' => 'Usted ha sido asignado para llevar a cabo la acción correctiva para el reclamo de '.$organizacion->NombOrga.'.',
                   'path' => '/reclamo/'.$reclamo->id.'',
               ];
               $this->notificationsService->sendToUser($par, $notificationData);
            }
        }

           //Notificar usuario verificacion de implementacion
           if (isset($reclamo->id_user_implementacion)) {
            //Envio de notificacion
               $notificationData = [
                   'title' => 'SALA - Quejas/Reclamos',
                   'body' => 'Usted ha sido asignado para llevar a cabo la verificación de implementación para el reclamo de '.$organizacion->NombOrga.'.',
                   'path' => '/reclamo/'.$reclamo->id.'',
               ];
               $this->notificationsService->sendToUser($request->id_user_implementacion, $notificationData);
   
           }

           //Notificar usuario medición eficiencia
           if (isset($reclamo->id_user_eficiencia)) {
            //Envio de notificacion
               $notificationData = [
                   'title' => 'SALA - Quejas/Reclamos',
                   'body' => 'Usted ha sido asignado para llevar a cabo la medición de eficiencia para el reclamo de '.$organizacion->NombOrga.'.',
                   'path' => '/reclamo/'.$reclamo->id.'',
               ];
               $this->notificationsService->sendToUser($request->id_user_eficiencia, $notificationData);
   
           }

        return redirect()->route('reclamo.index')->with('status_success', 'Reclamo registrado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function show(reclamo $reclamo)
    {
        //
        Gate::authorize('haveaccess','reclamo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Reclamos']);
        $rutavolver = route('reclamo.index');
        $sucursales = Sucursal::orderBy('id','asc')->get();
        $orga_sucu = Organizacion::select('organizacions.NombOrga','sucursals.NombSucu','organizacions.id',
                                        'sucursals.id as ids')
                                    ->join('reclamos','organizacions.id','=','reclamos.id_organizacion')
                                    ->join('sucursals','reclamos.id_sucursal','=','sucursals.id')
                                    ->where('organizacions.id',$reclamo->id_organizacion)->first();
        $usuario_responsable = User::where('id',$reclamo->id_user_responsable)->first();
        $usuario_contingencia = User::where('id',$reclamo->id_user_contingencia)->first();
        $usuarios_correctiva = Reclamo_accion::where('id_reclamo',$reclamo->id)->get();
        $usuario_implementacion = User::where('id',$reclamo->id_user_implementacion)->first();
        $usuario_eficiencia = User::where('id',$reclamo->id_user_eficiencia)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $usuarios = User::select('users.name','users.last_name','users.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('organizacions.NombOrga','Sala Hnos')
                        ->orderBy('name','asc')->get();
        $cant_contingencia = 0;
        $cant_causa = 0;
        $cant_correccion = 0;
        $cant_implementacion = 0;
        $cant_eficiencia = 0;
        $cambios_fecha = Cambio_fecha_cx::where('id_reclamo',$reclamo->id)->get();
        foreach ($cambios_fecha as $cambio) {
            if($cambio->accion == 'Contingencia'){
                $cant_contingencia++;
            }
            if($cambio->accion == 'Analisis de causa'){
                $cant_causa++;
            }
            if($cambio->accion == 'Accion correctiva'){
                $cant_correccion++;
            }
            if($cambio->accion == 'Implementacion'){
                $cant_implementacion++;
            }
            if($cambio->accion == 'Eficiencia'){
                $cant_eficiencia++;
            }
        }
        return view('reclamo.view', compact('reclamo','rutavolver','orga_sucu','usuario_responsable',
                                            'usuario_contingencia','usuarios_correctiva','usuario_implementacion',
                                            'usuario_eficiencia','organizaciones','usuarios','sucursales','cambios_fecha',
                                            'cant_contingencia','cant_causa','cant_correccion','cant_implementacion',
                                            'cant_eficiencia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function edit(reclamo $reclamo)
    {
        //
        Gate::authorize('haveaccess','reclamo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Reclamos']);
        $rutavolver = route('reclamo.index');
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $sucursales = Sucursal::orderBy('id','asc')->get();
        $usuarios = User::select('users.name','users.last_name','users.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('organizacions.NombOrga','Sala Hnos')
                        ->orderBy('name','asc')->get();
        $orga_sucu = Organizacion::select('organizacions.NombOrga','sucursals.NombSucu','organizacions.id',
                                            'sucursals.id as ids')
                                    ->join('reclamos','organizacions.id','=','reclamos.id_organizacion')
                                    ->join('sucursals','reclamos.id_sucursal','=','sucursals.id')
                                    ->where('organizacions.id',$reclamo->id_organizacion)->first();
        $usuario_responsable = User::where('id',$reclamo->id_user_responsable)->first();
        $usuario_contingencia = User::where('id',$reclamo->id_user_contingencia)->first();
        $usuarios_correctiva = Reclamo_accion::where('id_reclamo',$reclamo->id)->get();
        $usuario_implementacion = User::where('id',$reclamo->id_user_implementacion)->first();
        $usuario_eficiencia = User::where('id',$reclamo->id_user_eficiencia)->first();
        return view('reclamo.edit', compact('reclamo','rutavolver','orga_sucu','usuario_responsable',
                                            'usuario_contingencia','usuarios_correctiva','usuario_implementacion',
                                            'usuario_eficiencia','organizaciones','usuarios','sucursales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reclamo $reclamo)
    {
        //
        Gate::authorize('haveaccess','reclamo.edit');
        $organizacion = Organizacion::where('id',$request->id_organizacion)->first();
        $hoy = Carbon::today();

        /// ENVIO DE NOTIFICACION
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                ->where('users.last_name', 'Garcia Campi');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente posventa');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente General');
                        })
                        ->orWhere(function($query) {
                            $query->Where('puesto_empleados.NombPuEm', 'Encuastas de satisfaccion al cliente');
                        })
                        ->get();

        //Notificar usuario contingencia
        if ($request->descripcion <> $reclamo->descripcion) {

                    foreach($usersends as $usersend){
                        $notificationData = [
                            'title' => 'SALA - Queja/Reclamo',
                            'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                            'path' => '/reclamo/'.$reclamo->id.'',
                        ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }
            if(isset($reclamo->id_user_contingencia)){
            //Envio de notificacion
                $notificationData = [
                    'title' => 'SALA - Quejas/Reclamos',
                    'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                    'path' => '/reclamo/'.$reclamo->id.'',
                ];
                $this->notificationsService->sendToUser($request->id_user_contingencia, $notificationData);
            }
            if(isset($reclamo->id_user_responsable)){
                //Envio de notificacion
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($request->id_user_responsable, $notificationData);
                }
            if(isset($reclamo->id_user_implementacion)){
                //Envio de notificacion
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($request->id_user_implementacion, $notificationData);
                }
            if(isset($reclamo->id_user_eficiencia)){
                //Envio de notificacion
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($request->id_user_eficiencia, $notificationData);
                }
        }

        //Notificar usuario contingencia
        if ($request->anexo <> $reclamo->anexo) {

                    foreach($usersends as $usersend){
                        $notificationData = [
                            'title' => 'SALA - Queja/Reclamo',
                            'body' => 'Se ha agregado un anexo a la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                            'path' => '/reclamo/'.$reclamo->id.'',
                        ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }
            if(isset($reclamo->id_user_contingencia)){
            //Envio de notificacion
                $notificationData = [
                    'title' => 'SALA - Quejas/Reclamos',
                    'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                    'path' => '/reclamo/'.$reclamo->id.'',
                ];
                $this->notificationsService->sendToUser($request->id_user_contingencia, $notificationData);
            }
            if(isset($reclamo->id_user_responsable)){
                //Envio de notificacion
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($request->id_user_responsable, $notificationData);
                }
            if(isset($reclamo->id_user_implementacion)){
                //Envio de notificacion
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($request->id_user_implementacion, $notificationData);
                }
            if(isset($reclamo->id_user_eficiencia)){
                //Envio de notificacion
                    $notificationData = [
                        'title' => 'SALA - Quejas/Reclamos',
                        'body' => 'Se ha modificado la descripción de la queja/reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($request->id_user_eficiencia, $notificationData);
                }
        }
        

        //Notificar usuario contingencia
        if ($request->id_user_contingencia <> $reclamo->id_user_contingencia) {
            
                    foreach($usersends as $usersend){
                        $notificationData = [
                            'title' => 'SALA - Queja/Reclamo',
                            'body' => 'Se ha asignado un responsable para llevar a cabo la acción de contingencia para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                            'path' => '/reclamo/'.$reclamo->id.'',
                        ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }

         //Envio de notificacion
            $notificationData = [
                'title' => 'SALA - Quejas/Reclamos',
                'body' => 'Usted ha sido asignado para llevar a cabo la acción de contingencia para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                'path' => '/reclamo/'.$reclamo->id.'',
            ];
            $this->notificationsService->sendToUser($request->id_user_contingencia, $notificationData);
        }

        //Notificar usuario analisis de causa
        if ($request->id_user_responsable <> $reclamo->id_user_responsable) {
           
                    foreach($usersends as $usersend){
                        $notificationData = [
                            'title' => 'SALA - Queja/Reclamo',
                            'body' => 'Se ha asignado un responsable para llevar a cabo el análisis de causa para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                            'path' => '/reclamo/'.$reclamo->id.'',
                        ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }

               $notificationData = [
                   'title' => 'SALA - Quejas/Reclamos',
                   'body' => 'Usted ha sido asignado para llevar a cabo el análisis de causa para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'.',
                   'path' => '/reclamo/'.$reclamo->id.'',
               ];
               $this->notificationsService->sendToUser($request->id_user_responsable, $notificationData);
           }

  

           //Notificar usuario verificacion de implementacion
        if ($request->id_user_implementacion <> $reclamo->id_user_implementacion) {
           
                    foreach($usersends as $usersend){
                        $notificationData = [
                            'title' => 'SALA - Queja/Reclamo',
                            'body' => 'Se ha asignado un responsable para llevar a cabo la verificación de implementación para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                            'path' => '/reclamo/'.$reclamo->id.'',
                        ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }

               $notificationData = [
                   'title' => 'SALA - Quejas/Reclamos',
                   'body' => 'Usted ha sido asignado para llevar a cabo la verificación de implementación para el reclamo de '.$organizacion->NombOrga.'.',
                   'path' => '/reclamo/'.$reclamo->id.'',
               ];
               $this->notificationsService->sendToUser($request->id_user_implementacion, $notificationData);
           }


           //Notificar usuario medición eficiencia
        if ($request->id_user_eficiencia <> $reclamo->id_user_eficiencia) {
          
                    foreach($usersends as $usersend){
                        $notificationData = [
                            'title' => 'SALA - Queja/Reclamo',
                            'body' => 'Se ha asignado un responsable para llevar la medición de eficiencia para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                            'path' => '/reclamo/'.$reclamo->id.'',
                        ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }

               $notificationData = [
                   'title' => 'SALA - Quejas/Reclamos',
                   'body' => 'Usted ha sido asignado para llevar a cabo la medición de eficiencia para el reclamo de '.$organizacion->NombOrga.'.',
                   'path' => '/reclamo/'.$reclamo->id.'',
               ];
               $this->notificationsService->sendToUser($request->id_user_eficiencia, $notificationData);
           }





        //Se controlan los cambios de fecha limite
        if((isset($request->fecha_limite_contingencia) AND (isset($reclamo->fecha_limite_contingencia)))){
            if($request->fecha_limite_contingencia <> $reclamo->fecha_limite_contingencia){

                if(isset($reclamo->fecha_limite_contingencia)){
                    $cambio_fecha = Cambio_fecha_cx::create(['id_reclamo'=>$reclamo->id, 'accion'=>'Contingencia',
                                                            'fecha_vieja'=>$reclamo->fecha_limite_contingencia,
                                                            'fecha_nueva'=>$request->fecha_limite_contingencia]);
                }

                        foreach($usersends as $usersend){
                            $notificationData = [
                                'title' => 'SALA - Queja/Reclamo',
                                'body' => 'Se ha cambiado la fecha límite de la acción de contingencia del '.$reclamo->fecha_limite_contingencia.' a el '.$request->fecha_limite_contingencia.' para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                                'path' => '/reclamo/'.$reclamo->id.'',
                            ];
                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        }
            }
        }

        if((isset($request->fecha_contacto) AND (isset($reclamo->fecha_contacto)))){
            if($request->fecha_contacto <> $reclamo->fecha_contacto){

                if(isset($reclamo->fecha_contacto)){
                    $cambio_fecha = Cambio_fecha_cx::create(['id_reclamo'=>$reclamo->id, 'accion'=>'Analisis de causa',
                                                            'fecha_vieja'=>$reclamo->fecha_contacto,
                                                            'fecha_nueva'=>$request->fecha_contacto]);
                }
               
                        foreach($usersends as $usersend){
                            $notificationData = [
                                'title' => 'SALA - Queja/Reclamo',
                                'body' => 'Se ha cambiado la fecha límite el análisis de causa del '.$reclamo->fecha_contacto.' a el '.$request->fecha_contacto.' para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                                'path' => '/reclamo/'.$reclamo->id.'',
                            ];
                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        }
            }
        }

        if((isset($request->fecha_limite_correctiva) AND (isset($reclamo->fecha_limite_correctiva)))){
            if($request->fecha_limite_correctiva <> $reclamo->fecha_limite_correctiva){

                if(isset($reclamo->fecha_limite_correctiva)){
                    $cambio_fecha = Cambio_fecha_cx::create(['id_reclamo'=>$reclamo->id, 'accion'=>'Accion correctiva',
                                                            'fecha_vieja'=>$reclamo->fecha_limite_correctiva,
                                                            'fecha_nueva'=>$request->fecha_limite_correctiva]);
                }
                
                        foreach($usersends as $usersend){
                            $notificationData = [
                                'title' => 'SALA - Queja/Reclamo',
                                'body' => 'Se ha cambiado la fecha límite de la acción correctiva del '.$reclamo->fecha_limite_correctiva.' a el '.$request->fecha_limite_correctiva.' para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                                'path' => '/reclamo/'.$reclamo->id.'',
                            ];
                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        }
            }
        }

        if((isset($request->fecha_implementacion) AND (isset($reclamo->fecha_implementacion)))){
            if($request->fecha_implementacion <> $reclamo->fecha_implementacion){

                if(isset($reclamo->fecha_implementacion)){
                    $cambio_fecha = Cambio_fecha_cx::create(['id_reclamo'=>$reclamo->id, 'accion'=>'Implementacion',
                                                            'fecha_vieja'=>$reclamo->fecha_implementacion,
                                                            'fecha_nueva'=>$request->fecha_implementacion]);
                }
               
                        foreach($usersends as $usersend){
                            $notificationData = [
                                'title' => 'SALA - Queja/Reclamo',
                                'body' => 'Se ha cambiado la fecha límite de la verificación de implementación del '.$reclamo->fecha_implementacion.' a el '.$request->fecha_implementacion.' para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                                'path' => '/reclamo/'.$reclamo->id.'',
                            ];
                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        }
            }
        }

        if((isset($request->fecha_eficiencia) AND (isset($reclamo->fecha_eficiencia)))){
            if($request->fecha_eficiencia <> $reclamo->fecha_eficiencia){

                if(isset($reclamo->fecha_eficiencia)){
                    $cambio_fecha = Cambio_fecha_cx::create(['id_reclamo'=>$reclamo->id, 'accion'=>'Eficiencia',
                                                            'fecha_vieja'=>$reclamo->fecha_eficiencia,
                                                            'fecha_nueva'=>$request->fecha_eficiencia]);
                }
                
                        foreach($usersends as $usersend){
                            $notificationData = [
                                'title' => 'SALA - Queja/Reclamo',
                                'body' => 'Se ha cambiado la fecha límite de la acción de análisis de eficiencia del '.$reclamo->fecha_eficiencia.' a el '.$request->fecha_eficiencia.' para el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                                'path' => '/reclamo/'.$reclamo->id.'',
                            ];
                        $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        }
            }
        }

       

        if((isset($request->accion_contingencia)) OR (isset($request->causa)) OR (isset($request->accion_correctiva)) OR (isset($request->verificacion_implementacion)) OR (isset($request->medicion_eficiencia))){
            if(($request->accion_contingencia <> $reclamo->accion_contingencia) OR ($request->causa <> $reclamo->causa) OR ($request->accion_correctiva <> $reclamo->accion_correctiva) OR ($request->verificacion_implementacion <> $reclamo->verificacion_implementacion) OR ($request->medicion_eficiencia <> $reclamo->medicion_eficiencia)){
            if(isset($request->accion_contingencia)){
                $reclamo->update(['fecha_registro_contingencia'=>$hoy]);
            }

            if(isset($request->causa)){
                $reclamo->update(['fecha_registro_causa'=>$hoy]);
            }
            
           
                    foreach($usersends as $usersend){
                        $notificationData = [
                            'title' => 'SALA - Queja/Reclamo',
                            'body' => 'Se ha realizado una acción en el reclamo de '.$reclamo->nombre_cliente.' de la organización '.$organizacion->NombOrga.'',
                            'path' => '/reclamo/'.$reclamo->id.'',
                        ];
                    $this->notificationsService->sendToUser($usersend->id, $notificationData);
                    }
        }
    }

 
    $correctiva_usuarios = Reclamo_accion::where('id_reclamo',$reclamo->id)->get();

    //Guardo los resultaados en un array en caso que se obtenga algo
    $i=0;
    foreach ($correctiva_usuarios as $corre_us){
        $calp[$i] = $corre_us->id_user_correctiva;
        $i++;
    }

    $participantes = $request->id_user_correctiva;

    // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
    if (isset($participantes)) {
        foreach ($correctiva_usuarios as $correctiva_user){
            // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
            // lo ELIMINA
            if (!in_array($correctiva_user->id_user_correctiva, $participantes)) {
                $correctiva_user->delete();

                $notificationData = [
                    'title' => 'SALA - Desvinculado de la acción correctiva',
                    'body' => 'Usted ha sido desvinculado de la acción correctiva de la organización '.$organizacion->NombOrga.'',
                    'path' => '/reclamo/'.$reclamo->id.'',
                ];
                $this->notificationsService->sendToUser($correctiva_user->id_user_correctiva, $notificationData);
            }
        }
        // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
        // lo REGISTRA
        foreach ($participantes as $participante){
            if (!isset($calp)) {
                $nuevos_correctiva = Reclamo_accion::create(['id_user_correctiva' => $participante, 'id_reclamo' => $reclamo->id]);
            
                $notificationData = [
                    'title' => 'SALA - Queja/Reclamo',
                    'body' => 'Usted ha sido asignado para llevar a cabo la acción correctiva para el reclamo de '.$organizacion->NombOrga.'.',
                    'path' => '/reclamo/'.$reclamo->id.'',
                ];
                $this->notificationsService->sendToUser($participante, $notificationData);
            }else{
                if (!in_array($participante, $calp)) {
                    $nuevos_correctiva = Reclamo_accion::create(['id_user_correctiva' => $participante, 'id_reclamo' => $reclamo->id]);
            
                    $notificationData = [
                        'title' => 'SALA - Queja/Reclamo',
                        'body' => 'Usted ha sido asignado para llevar a cabo la acción correctiva para el reclamo de '.$organizacion->NombOrga.'.',
                        'path' => '/reclamo/'.$reclamo->id.'',
                    ];
                    $this->notificationsService->sendToUser($participante, $notificationData);
                }
            }
        }
    } elseif(isset($correctiva_usuarios)) {
        foreach ($correctiva_usuarios as $correctiva_user){
            // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
            // lo ELIMINA
            $correctiva_user->delete();

            $notificationData = [
                'title' => 'SALA - Desvinculado de la acción correctiva',
                'body' => 'Usted ha sido desvinculado de la acción correctiva de la organización '.$organizacion->NombOrga.'',
                'path' => '/reclamo/'.$reclamo->id.'',
            ];
            $this->notificationsService->sendToUser($correctiva_user->id_user_correctiva, $notificationData);
        }
    }
    
        $reclamo->update($request->except('fecha_registro_contingencia','fecha_registro_causa'));

        
        return redirect()->route('reclamo.index')->with('status_success', 'Reclamo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(reclamo $reclamo)
    {
        //
        Gate::authorize('haveaccess','reclamo.destroy');
        $reclamos_accion = reclamo_accion::where('id_reclamo',$reclamo->id)->get();
        foreach ($reclamos_accion as $reclamo_a) {
            $reclamo_a->delete();
        }
        $reclamo->delete();
        return redirect()->route('reclamo.index')->with('status_success', 'Reclamo eliminada con exito');
    }
}