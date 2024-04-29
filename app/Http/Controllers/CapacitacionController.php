<?php

namespace App\Http\Controllers;

use App\capacitacion;
use App\User;
use App\calendario_user;
use App\calendario_archivo;
use App\capacitacion_user;
use App\calendario;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Services\NotificationsService;

class CapacitacionController extends Controller
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
        Gate::authorize('haveaccess','capacitacion.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Capacitaciones']);
        $rutavolver = route('calendario.index');
        $capacitaciones = Capacitacion::orderBy('id','desc')->paginate(20);
        return view('capacitacion.index', compact('capacitaciones','rutavolver'));
    }

    public function index_view($id)
    {
        Gate::authorize('haveaccess','capacitacion.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Capacitaciones']);
        $rutavolver = route('capacitacion.index');
        $capacitaciones = Capacitacion::select('capacitacions.id','capacitacions.nombre','capacitacions.codigo',
                                            'capacitacions.modalidad','capacitacions.fechainicio','capacitacions.fechafin',
                                            'capacitacions.valoracion','capacitacions.horas','capacitacions.tipo',
                                            'capacitacions.costo','users.name','users.last_name','capacitacion_users.estado',
                                            'users.id as id_user')
                                    ->join('capacitacion_users','capacitacions.id','=','capacitacion_users.id_capacitacion')
                                    ->join('users','capacitacion_users.id_user','=','users.id')
                                    ->where('capacitacions.id',$id)
                                    ->orderBy('id','desc')->paginate(20);
        $id_capacitacion = $id;
        return view('capacitacion.index_view', compact('capacitaciones','rutavolver','id_capacitacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','capacitacion.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Capacitaciones']);
        $rutavolver = route('capacitacion.index');
        $users = User::select('users.id','users.name','users.last_name','sucursals.NombSucu',
                                'puesto_empleados.NombPuEm')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->join('sucursals','users.CodiSucu','=','sucursals.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->where('organizacions.NombOrga','Sala Hnos')
                        ->orderBy('users.name','asc')->get();
        return view('capacitacion.create',compact('rutavolver','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'modalidad' => 'required',
            'horas' => 'required',
            'costo' => 'required',
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'tipo' => 'required',
        ]);
        $control = 0;

        $fechainicio = $request->get('fechainicio');
        $fechafin = $request->get('fechafin');

        //Datos para insertar en la tabla "Calendarios"
        $titulo = $request->get('nombre');
        $tipoevento = $request->get('tipo');
        $modalidad = $request->get('modalidad');
        if($tipoevento == "Externa"){
            $tipo_evento = '2';
        } elseif($tipoevento == "Interna") {
            $tipo_evento = '1';
        } else{
            if ($modalidad == "Aula de aprendizaje a distancia") {
                $tipo_evento = '3';
            }elseif($modalidad == "Classroom"){
                $tipo_evento = '4';
            }elseif($modalidad == "Formacion con CDI"){
                $tipo_evento = '5';
            }elseif($modalidad == "Formacion basada en la Web"){
                $control = 1;
            }else{
                $tipo_evento = '1';
            }

        }
        $horainicio = $request->get('horainicio');
        $horafin = $request->get('horafin');

        $currentDate = Carbon::createFromFormat('Y-m-d', $fechainicio);
        $shippingDate = Carbon::createFromFormat('Y-m-d', $fechafin);

        $capacitacion = Capacitacion::create($request->all());
        $id_capa = $capacitacion->id;
       
    
        $diferencia_en_dias = $currentDate->diffInDays($shippingDate);
    
        for ($i=0; $i <= $diferencia_en_dias ; $i++) { 
    
            $finicio = date("Y-m-d",strtotime($fechainicio."+ ".$i." days"));
            
            //Evita el registro de un evento en el calendario al ser curso JDU web
            if($control == 0){
                $calendarios = Calendario::create(['id_capacitacion'=>$id_capa,'id_evento'=>$tipo_evento,
                                                'id_user'=>auth()->user()->id,'titulo'=>$titulo, 
                                                'fechainicio'=>$finicio,'fechafin'=>$finicio, 'horainicio'=>$horainicio, 
                                                'horafin'=>$horafin]);          
            }
    
            $msgfecha = $currentDate->format('d-m-Y');
    
            //insertar disertantes de la reunion en Calendario_users
            if (isset($request->id_userdis)) {
                $disertantes = $request->id_userdis;
            }
            if (isset($disertantes)) {
                foreach ($disertantes as $dis) {
                    if($control == 0){
                        $calendardis = new Calendario_user([
                            'id_calendario'  =>  $calendarios->id,
                            'id_user'   =>  $dis,
                            'tipo' => 'Disertante'
                        ]);
                        $calendardis->save();
                    }
                    //Inserta una sola vez los participantes para el rango de fechas seleccionado
                    if ($i == 0) {
                        $capacitaciondis = new Capacitacion_user([
                            'id_user'   =>  $dis,
                            'id_capacitacion'  =>  $capacitacion->id,
                            'tipo' => 'Capacitador',
                            'estado' => 'Inscripto'
                        ]);
                        $capacitaciondis->save();
                    }
                    
                    $notificationData = [
                        'title' => 'SALA - Nueva capacitación',
                        'body' => 'Usted ha sido registrado a una capacitación para el dia '.$msgfecha.', como capacitador',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($dis, $notificationData);
                    }
            }
    
            //insertar disertantes de la reunion en Calendario_users
            if (isset($request->id_userpar)) {
                $participantes = $request->id_userpar;
            }
            if (isset($participantes)) {
                foreach ($participantes as $par) {
                    if($control == 0){
                        $calendarpar = new Calendario_user([
                            'id_user'   =>  $par,
                            'id_calendario'  =>  $calendarios->id,
                            'tipo' => 'Participante'
                        ]);
                        $calendarpar->save();
                    }
                    //Inserta una sola vez los participantes para el rango de fechas seleccionado
                    if ($i == 0) {
                        $capacitacionpar = new Capacitacion_user([
                            'id_user'   =>  $par,
                            'id_capacitacion'  =>  $capacitacion->id,
                            'tipo' => 'Participante',
                            'estado' => 'Inscripto'
                        ]);
                        $capacitacionpar->save();
                    }
    
                    $notificationData = [
                        'title' => 'SALA - Nueva capacitación',
                        'body' => 'Usted ha sido registrado a una capacitación para el dia '.$msgfecha.'',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($par, $notificationData);
                    }
            }
        }

        return redirect()->route('calendario.index')->with('status_success', 'Capacitación creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\capacitacion  $capacitacion
     * @return \Illuminate\Http\Response
     */
    public function show(Capacitacion $capacitacion)
    {
        Gate::authorize('haveaccess','capacitacion.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Capacitaciones']);
        $rutavolver = url('capacitacion/index_view/'.$capacitacion->id);
        $horarios = Calendario::where('id_capacitacion',$capacitacion->id)->first();
        return view('capacitacion.view', compact('capacitacion','rutavolver','horarios'));
    }

    public function editestado(Request $request)
    {
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Capacitaciones']);

        $id_usuario = json_decode($_POST['id_usuario']);
       $id_capacitacion = $request->get('id_capacitacion');
       $cantidad = $request->get('cantidad');
       $estado = json_decode($_POST['estado']);
        $i = 0;
       for ($i=0; $i < $cantidad; $i++) { 
        $capuser = Capacitacion_user::where([['id_capacitacion',$id_capacitacion], ['id_user', $id_usuario[$i]]])->first();
        $capuser->update(['estado'=>$estado[$i]]);
       }

       return response()->json(["url"=> route("capacitacion.index")]);
       //return redirect()->route('capacitacion.index')->with('status_success', 'Estado de capacitación modificada con éxito');
       //echo ('Se ha modificado el estado con éxito');
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\capacitacion  $capacitacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Capacitacion $capacitacion)
    {
        Gate::authorize('haveaccess','capacitacion.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Capacitaciones']);
        $rutavolver = route('capacitacion.index');
        $users = User::select('users.id','users.name','users.last_name','sucursals.NombSucu',
                                'puesto_empleados.NombPuEm')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->join('sucursals','users.CodiSucu','=','sucursals.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->where('organizacions.NombOrga','Sala Hnos')
                        ->orderBy('users.name','asc')->get();
        $capacitacion_users_dis = Capacitacion_user::where([['id_capacitacion',$capacitacion->id], ['tipo', 'Capacitador']])->get();
        $capacitacion_users_par = Capacitacion_user::where([['id_capacitacion',$capacitacion->id], ['tipo', 'participante']])->get();
        $horarios = Calendario::where('id_capacitacion',$capacitacion->id)->first();
        return view('capacitacion.edit', compact('capacitacion','rutavolver','eventos','sucursales','users',
                                                'capacitacion_users_dis', 'capacitacion_users_par','horarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\capacitacion  $capacitacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Capacitacion $capacitacion)
    {
        //
        Gate::authorize('haveaccess','capacitacion.edit');
  
        $fechaini = $request->get('fechainicio');
        $currentDate = Carbon::createFromFormat('Y-m-d', $fechaini);
        $msgfecha = $currentDate->format('d-m-Y');
        $control = 0;
  
        $capacitacion_users_d = Capacitacion_user::where([['id_capacitacion',$capacitacion->id], ['tipo','Capacitador']])->get();
        $calendarios = Calendario::where('id_capacitacion',$capacitacion->id)->get();
          //Guardo los resultaados en un array en caso que se obtenga algo
          $i=0;
          foreach ($capacitacion_users_d as $capa_us){
              $cal[$i] = $capa_us->id_user;
              $i++;
          }
  
          $disertantes = $request->id_userdis;
  
          // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
          if (isset($disertantes)) {
              foreach ($capacitacion_users_d as $capacitacion_user){
                  // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                  // lo ELIMINA
                  if (!in_array($capacitacion_user->id_user, $disertantes)) {
                      $capacitacion_user->delete();

                      $calendariosarr = Calendario::where('id_capacitacion',$capacitacion->id)->get();
                      foreach ($calendariosarr as $calend) {
                            //Elimino de la tabla de capacitación_user, al usuario que ya no esta incluido en la capacitacion
                            $calendario_user = Calendario_user::where([['id_calendario',$calend->id], 
                                                                    ['id_user',$capacitacion_user->id_user], 
                                                                    ['tipo','Disertante']])->first();
                            $calendario_user->delete();
                      }
  
                      $notificationData = [
                          'title' => 'SALA - Desvinculado de una capacitación',
                          'body' => 'Usted ha sido desvinculado de una capacitación que se realizaría el dia '.$msgfecha.'',
                          'path' => '/calendario',
                      ];
                      $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
                  }
              }
              // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
              // lo REGISTRA
              foreach ($disertantes as $disertante){
                  if (!isset($cal)) {
                    //Busco fechas calendario para insertar los disertantes
                    foreach ($calendarios as $calendario) {
                        $calen = Calendario_user::create(['id_user' => $disertante, 'id_calendario' => $calendario->id, 'tipo' => 'Disertante']);
                    }
                      $capa = Capacitacion_user::create(['id_user' => $disertante, 'id_capacitacion' => $capacitacion->id, 'tipo' => 'Capacitador', 'estado' => 'Inscripto']);

                      $notificationData = [
                          'title' => 'SALA - Nueva capacitación',
                          'body' => 'Usted ha sido registrado en una nueva capacitación para el dia '.$msgfecha.'',
                          'path' => '/calendario',
                      ];
                      $this->notificationsService->sendToUser($disertante, $notificationData);
                  }else{
                      if (!in_array($disertante, $cal)) {
                        foreach ($calendarios as $calendario) {
                            $calen = Calendario_user::create(['id_user' => $disertante, 'id_calendario' => $calendario->id, 'tipo' => 'Disertante']);
                        }
                        $capa = Capacitacion_user::create(['id_user' => $disertante, 'id_capacitacion' => $capacitacion->id, 'tipo' => 'Capacitador', 'estado' => 'Inscripto']);

                      $notificationData = [
                          'title' => 'SALA - Nueva capacitación',
                          'body' => 'Usted ha sido registrado en una nueva capacitación para el dia '.$msgfecha.'',
                          'path' => '/calendario',
                      ];
                      $this->notificationsService->sendToUser($disertante, $notificationData);
                      }
                  }
              }
          } elseif(isset($capacitacion_users_d)) {
              foreach ($capacitacion_users_d as $capacitacion_user){
                  // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                  // lo ELIMINA
                  $capacitacion_user->delete();

                  $calendariosarr = Calendario::where('id_capacitacion',$capacitacion->id)->get();
                      foreach ($calendariosarr as $calend) {
                            //Elimino de la tabla de capacitación_user, al usuario que ya no esta incluido en la capacitacion
                            $calendario_user = Calendario_user::where([['id_calendario',$calend->id], 
                                                                    ['id_user',$capacitacion_user->id_user], 
                                                                    ['tipo','Disertante']])->first();
                            $calendario_user->delete();
                      }
  
                  $notificationData = [
                      'title' => 'SALA - Desvinculado de una capacitación',
                      'body' => 'Usted ha sido desvinculado de una capacitación que se realizaría el dia '.$msgfecha.'',
                      'path' => '/calendario',
                  ];
                  $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
              }
          }
  
          $capacitacion_users_p = Capacitacion_user::where([['id_capacitacion',$capacitacion->id], ['tipo','Participante']])->get();
  
          //Guardo los resultaados en un array en caso que se obtenga algo
          $i=0;
          foreach ($capacitacion_users_p as $capa_us){
              $calp[$i] = $capa_us->id_user;
              $i++;
          }
  
          $participantes = $request->id_userpar;
  
          // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
          if (isset($participantes)) {
              foreach ($capacitacion_users_p as $capacitacion_user){
                  // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                  // lo ELIMINA
                  if (!in_array($capacitacion_user->id_user, $participantes)) {
                      $capacitacion_user->delete();

                      $calendariosarr = Calendario::where('id_capacitacion',$capacitacion->id)->get();
                      foreach ($calendariosarr as $calend) {
                            //Elimino de la tabla de capacitación_user, al usuario que ya no esta incluido en la capacitacion
                            $calendario_user = Calendario_user::where([['id_calendario',$calend->id], 
                                                                    ['id_user',$capacitacion_user->id_user], 
                                                                    ['tipo','Participante']])->first();
                            $calendario_user->delete();
                      }
  
                      $notificationData = [
                          'title' => 'SALA - Desvinculado de una capacitación',
                          'body' => 'Usted ha sido desvinculado de una capacitación que se realizaría el dia '.$msgfecha.'',
                          'path' => '/calendario',
                      ];
                      $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
                  }
              }
              // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
              // lo REGISTRA
              foreach ($participantes as $participante){
                  if (!isset($calp)) {
                    foreach ($calendarios as $calendario) {
                        $calen = Calendario_user::create(['id_user' => $disertante, 'id_calendario' => $calendario->id, 'tipo' => 'Participante']);
                    }
                      $capa = Capacitacion_user::create(['id_user' => $participante, 'id_capacitacion' => $capacitacion->id, 'tipo' => 'Participante', 'estado' => 'Inscripto']);

                      $notificationData = [
                          'title' => 'SALA - Nuevo evento',
                          'body' => 'Usted ha sido registrado en un nuevo evento para el dia '.$msgfecha.'',
                          'path' => '/calendario',
                      ];
                      $this->notificationsService->sendToUser($participante, $notificationData);
                  }else{
                      if (!in_array($participante, $calp)) {
                        foreach ($calendarios as $calendario) {
                            $calen = Calendario_user::create(['id_user' => $participante, 'id_calendario' => $calendario->id, 'tipo' => 'Participante']);
                        }
                      $capa = Capacitacion_user::create(['id_user' => $participante, 'id_capacitacion' => $capacitacion->id, 'tipo' => 'Participante', 'estado' => 'Inscripto']);
                      
                      $notificationData = [
                          'title' => 'SALA - Nuevo evento',
                          'body' => 'Usted ha sido registrado en un nuevo evento para el dia '.$msgfecha.'',
                          'path' => '/calendario',
                      ];
                      $this->notificationsService->sendToUser($participante, $notificationData);
                      }
                  }
              }
          } elseif(isset($capacitacion_users_p)) {
              foreach ($capacitacion_users_p as $capacitacion_user){
                  // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                  // lo ELIMINA
                  $capacitacion_user->delete();
  
                  $calendariosarr = Calendario::where('id_capacitacion',$capacitacion->id)->get();
                      foreach ($calendariosarr as $calend) {
                            //Elimino de la tabla de capacitación_user, al usuario que ya no esta incluido en la capacitacion
                            $calendario_user = Calendario_user::where([['id_calendario',$calend->id], 
                                                                    ['id_user',$capacitacion_user->id_user], 
                                                                    ['tipo','Participante']])->first();
                            $calendario_user->delete();
                      }

                  $notificationData = [
                      'title' => 'SALA - Desvinculado de un evento',
                      'body' => 'Usted ha sido desvinculado de un evento que se realizaría el dia '.$msgfecha.'',
                      'path' => '/calendario',
                  ];
                  $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
              }
          }

        //Datos para insertar en la tabla "Calendarios"
        $titulo = $request->get('nombre');
        $tipoevento = $request->get('tipo');
        $modalidad = $request->get('modalidad');
        if($tipoevento == "Externa"){
            $tipo_evento = '2';
        } elseif($tipoevento == "Interna") {
            $tipo_evento = '1';
        } else{
            if ($modalidad == "Aula de aprendizaje a distancia") {
                $tipo_evento = '3';
            }elseif($modalidad == "Classroom"){
                $tipo_evento = '4';
            }elseif($modalidad == "Formacion con CDI"){
                $tipo_evento = '5';
            }elseif($modalidad == "Formacion basada en la Web"){
                $control = 1;
            }else{
                $tipo_evento = '1';
            }
        }

        $capacitacion->update($request->all());

        
  
      $fechainicio = $request->get('fechainicio');
      $fechafin = $request->get('fechafin');
      $horainicio = $request->get('horainicio');
      $horafin = $request->get('horafin');
      $currentDate = Carbon::createFromFormat('Y-m-d', $fechainicio);
      $shippingDate = Carbon::createFromFormat('Y-m-d', $fechafin);
  
      $diferencia_en_dias = $currentDate->diffInDays($shippingDate);
  
      if($diferencia_en_dias > 0){
          // En el caso de tambien ampliar el rango de fechas se ejecutara el siguiente script
          $control = 0;
  
          for ($i=0; $i <= $diferencia_en_dias ; $i++) { 
              if($i == 0){
                  $capacitacion_users = Capacitacion_user::where('id_capacitacion',$capacitacion->id)->get();
                  if(isset($capacitacion_users)){
                      foreach ($capacitacion_users as $capacitacion_user){
                          $capacitacion_user->delete();
                      }
                  }

                  // Elimina la capacitacion
                  if ($i == 0) {
                    $capacitacion = Capacitacion::where('id',$capacitacion->id)->first();
                    $capacitacion->delete();
                  }
                  
                  $calendariosarr = Calendario::where('id_capacitacion',$capacitacion->id)->get();
                      foreach ($calendariosarr as $calend) {
                            //Elimino de la tabla de capacitación_user, al usuario que ya no esta incluido en la capacitacion
                            $calendario_users = Calendario_user::where('id_calendario',$calend->id)->get();
                            foreach ($calendario_users as $calendario_user){
                                $calendario_user->delete();
                            }
                      }
                  $calendarios = Calendario::where('id_capacitacion',$capacitacion->id)->get();
                  if(isset($calendarios)){
                    foreach ($calendarios as $calendar){
                        $calendar->delete();
                    }
                }
                //Se vuelve a crear la capacitacion con los nuevos rangos de fecha
                $capacitacion = Capacitacion::create($request->all());
              }
              $finicio = date("Y-m-d",strtotime($fechainicio."+ ".$i." days"));
  
              $request->request->add(['fechainicio' => $finicio]);
              $request->request->add(['fechafin' => $finicio]);
              $horainicio = $request->get('horainicio');
                $horafin = $request->get('horafin');

              //Evita el registro de un evento en el calendario al ser curso JDU web
            if($control == 0){
                $calendarios = Calendario::create(['id_capacitacion'=>$capacitacion->id,'id_user'=>auth()->user()->id,
                                                'id_evento'=>$tipo_evento, 'titulo'=>$titulo, 'fechainicio'=>$finicio,
                                                'fechafin'=>$finicio, 'horainicio'=>$horainicio, 'horafin'=>$horafin]);        
            }
    
            $msgfecha = $currentDate->format('d-m-Y');
    
            //insertar disertantes de la reunion en Calendario_users
            if (isset($request->id_userdis)) {
                $disertantes = $request->id_userdis;
            }
            if (isset($disertantes)) {
                foreach ($disertantes as $dis) {
                    if($control == 0){
                        $calendardis = new Calendario_user([
                            'id_calendario'  =>  $calendarios->id,
                            'id_user'   =>  $dis,
                            'tipo' => 'Disertante'
                        ]);
                        $calendardis->save();
                    }
                    if($i == 0){
                        $capacitaciondis = new Capacitacion_user([
                            'id_user'   =>  $dis,
                            'id_capacitacion'  =>  $capacitacion->id,
                            'tipo' => 'Capacitador',
                            'estado' => 'Inscripto'
                        ]);
                        $capacitaciondis->save();
                    }
    
                    
                    $notificationData = [
                        'title' => 'SALA - Nueva capacitación',
                        'body' => 'Usted ha sido registrado a una capacitación para el dia '.$msgfecha.', como capacitador',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($dis, $notificationData);
                    }
            }
    
            //insertar disertantes de la reunion en Calendario_users
            if (isset($request->id_userpar)) {
                $participantes = $request->id_userpar;
            }
            if (isset($participantes)) {
                foreach ($participantes as $par) {
                    if($control == 0){
                        $calendarpar = new Calendario_user([
                            'id_user'   =>  $par,
                            'id_calendario'  =>  $calendarios->id,
                            'tipo' => 'Participante'
                        ]);
                        $calendarpar->save();
                    }
                    if($i == 0){
                        $capacitacionpar = new Capacitacion_user([
                            'id_user'   =>  $par,
                            'id_capacitacion'  =>  $capacitacion->id,
                            'tipo' => 'Participante',
                            'estado' => 'Inscripto'
                        ]);
                        $capacitacionpar->save();
                    }

                    $notificationData = [
                        'title' => 'SALA - Nueva capacitación',
                        'body' => 'Usted ha sido registrado a una capacitación para el dia '.$msgfecha.'',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($par, $notificationData);
                    }
            }
          }
      } else {
        if ($control == 0){
            $calendarioregs = Calendario::where('id_capacitacion',$capacitacion->id)->get();
            if (isset($calendarioregs)) {
                foreach ($calendarioregs as $calendarioreg) {
                    $calendarioreg->update(['id_evento'=>$tipo_evento, 'titulo'=>$titulo, 'fechainicio'=>$fechainicio,
                                    'fechafin'=>$fechafin, 'horainicio'=>$horainicio, 'horafin'=>$horafin]);
                }
            }
        }
      }
  
        return redirect()->route('capacitacion.index')->with('status_success', 'Capacitación modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\capacitacion  $capacitacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Capacitacion $capacitacion)
    {
        Gate::authorize('haveaccess','capacitacion.destroy');

        $calendarios = Calendario::where('id_capacitacion',$capacitacion->id)->get();
            if(isset($calendarios)){
                foreach ($calendarios as $calendario) {
                    //Elimino de la tabla de capacitación_user, al usuario que ya no esta incluido en la capacitacion
                    $calendario_users = Calendario_user::where('id_calendario',$calendario->id)->get();
                    foreach ($calendario_users as $calendario_user) {
                        $calendario_user->delete();
                    }
                    
                    $calendario_archivos = Calendario_archivo::where('id_calendario',$calendario->id)->get();
                        if(isset($calendario_archivos)){
                            foreach ($calendario_archivos as $calendario_archivo){
                                $calendario_archivo->delete();
                            }
                        }
                $calendario->delete();
                }
            }

        $capacitacion = Capacitacion::where('id',$capacitacion->id)->first();

                  $capacitacion_users = Capacitacion_user::where('id_capacitacion', $capacitacion->id)->get();
                  foreach ($capacitacion_users as $capacitacion_user) {
                    $capacitacion_user->delete();
                    $fechainicio = $capacitacion->fechainicio;
                    $currentDate = Carbon::createFromFormat('Y-m-d', $fechainicio);
                    $msgfecha = $currentDate->format('d-m-Y');
    
                    $notificationData = [
                        'title' => 'SALA - Capacitación cancelada',
                        'body' => 'El evento previsto para el dia '.$msgfecha.' ('.$capacitacion->nombre.') ha sido cancelado',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($capacitacion_user->id_user, $notificationData);
                }
              $capacitacion->delete();
  
        return redirect()->route('calendario.index')->with('status_success', 'Registro eliminado con exito');
    }
}