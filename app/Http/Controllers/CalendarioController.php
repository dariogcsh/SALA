<?php

namespace App\Http\Controllers;

use App\calendario;
use App\calendario_user;
use App\calendario_archivo;
use App\evento;
use App\sucursal;
use App\interaccion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Services\NotificationsService;

class CalendarioController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      //
      Gate::authorize('haveaccess','calendario.index');
      Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calendario']);
      $anoactual = Carbon::today('Y');
      $mesactual = Carbon::today('m');

      if ($request->ano == $anoactual) {
        $ano = $anoactual;
      }else{
        $ano = $request->ano;
      }

        if ($request->mes == $mesactual) {
            $mes = $mesactual;
        }else{
            $mes = $request->mes;
        }
      
        if ($request->id_usuario) {
            $usuarios_id = $request->id_usuario;
            $usuarios = User::whereIn('id',$usuarios_id)->get();
        }else{
            $usuarios = User::where('id',auth()->user()->id)->get();
        }

        $lista_users = User::select('users.id','users.name','users.last_name','sucursals.NombSucu',
                                    'puesto_empleados.NombPuEm')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->where('organizacions.NombOrga','Sala Hnos')
                            ->orderBy('users.name','asc')->get();

        $rutavolver = route('menuinterno');
      return view('calendario.index', compact('rutavolver','ano','mes','usuarios','lista_users'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      Gate::authorize('haveaccess','calendario.create');
      Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calendario']);
      $rutavolver = route('calendario.index');
      $eventos = Evento::orderBy('nombre','asc')->get();
      $sucursales = Sucursal::orderBy('id','asc')->get();
      $users = User::select('users.id','users.name','users.last_name','sucursals.NombSucu',
                            'puesto_empleados.NombPuEm')
                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                    ->join('sucursals','users.CodiSucu','=','sucursals.id')
                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                    ->where('organizacions.NombOrga','Sala Hnos')
                    ->orderBy('users.name','asc')->get();
      return view('calendario.create',compact('rutavolver', 'eventos', 'sucursales','users'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //
    request()->validate([
        'titulo' => 'required'
    ]);

    if ($request->reserva){
        //$lugar = $request->get('lugar');
        $request->request->add(['reserva' => 'Sala de reunión']);
    } else {
        $request->request->add(['reserva' => '']);
    }
    //Agrego al array el creador del evento
    $request->request->add(['id_user' => auth()->user()->id]);

    $fechainicio = $request->get('fechainicio');
    $fechafin = $request->get('fechafin');
    $currentDate = Carbon::createFromFormat('Y-m-d', $fechainicio);
    $shippingDate = Carbon::createFromFormat('Y-m-d', $fechafin);

    $diferencia_en_dias = $currentDate->diffInDays($shippingDate);

    for ($i=0; $i <= $diferencia_en_dias ; $i++) { 

        $finicio = date("Y-m-d",strtotime($fechainicio."+ ".$i." days"));

        $request->request->add(['fechainicio' => $finicio]);
        $request->request->add(['fechafin' => $finicio]);

        //Agrego al array el creador del evento
        $request->request->add(['id_user' => auth()->user()->id]);

        $calendarios = Calendario::create($request->all());

        $msgfecha = $currentDate->format('d-m-Y');

        //insertar disertantes de la reunion en Calendario_users
        if (isset($request->id_userdis)) {
            $disertantes = $request->id_userdis;
        }
        if (isset($disertantes)) {
            foreach ($disertantes as $dis) {

                $calendardis = new Calendario_user([
                    'id_calendario'  =>  $calendarios->id,
                    'id_user'   =>  $dis,
                    'tipo' => 'Disertante'
                ]);
                $calendardis->save();

                
                $notificationData = [
                    'title' => 'SALA - Nuevo evento',
                    'body' => 'Usted ha sido registrado en un nuevo evento para el dia '.$msgfecha.'',
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
                $calendarpar = new Calendario_user([
                    'id_user'   =>  $par,
                    'id_calendario'  =>  $calendarios->id,
                    'tipo' => 'Participante'
                ]);
                $calendarpar->save();

                $notificationData = [
                    'title' => 'SALA - Nuevo evento',
                    'body' => 'Usted ha sido registrado en un nuevo evento para el dia '.$msgfecha.'',
                    'path' => '/calendario',
                ];
                $this->notificationsService->sendToUser($par, $notificationData);
                }
        }
    }

      return redirect()->route('calendario.index')->with('status_success', 'Evento creado con exito');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\calendario  $calendario
   * @return \Illuminate\Http\Response
   */
  public function show(calendario $calendario)
  {
      //
      Gate::authorize('haveaccess','calendario.show');
      Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calendario']);
      $rutavolver = route('calendario.index');
      return view('calendario.view', compact('calendario','rutavolver'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\calendario  $calendario
   * @return \Illuminate\Http\Response
   */
  public function edit(calendario $calendario)
  {
      //
    Gate::authorize('haveaccess','calendario.edit');
    $rutavolver = route('calendario.index');
    $eventos = Evento::orderBy('nombre','asc')->get();
    $sucursales = Sucursal::orderBy('id','asc')->get();
    $users = User::select('users.id','users.name','users.last_name','sucursals.NombSucu',
                            'puesto_empleados.NombPuEm')
                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                    ->join('sucursals','users.CodiSucu','=','sucursals.id')
                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                    ->where('organizacions.NombOrga','Sala Hnos')
                    ->orderBy('users.name','asc')->get();
    $calendario_users_dis = Calendario_user::where([['id_calendario',$calendario->id], ['tipo', 'disertante']])->get();
    $calendario_users_par = Calendario_user::where([['id_calendario',$calendario->id], ['tipo', 'participante']])->get();
    return view('calendario.edit', compact('calendario','rutavolver','eventos','sucursales','users',
                                            'calendario_users_dis', 'calendario_users_par'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\calendario  $calendario
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, calendario $calendario)
  {
      //
      Gate::authorize('haveaccess','calendario.edit');
      $request->validate([
          'titulo'          => 'required',
      ]);



      $fechaini = $request->get('fechainicio');
      $currentDate = Carbon::createFromFormat('Y-m-d', $fechaini);
      $msgfecha = $currentDate->format('d-m-Y');
   

      $calendario_users_d = Calendario_user::where([['id_calendario',$calendario->id], ['tipo','Disertante']])->get();

        //Guardo los resultaados en un array en caso que se obtenga algo
        $i=0;
        foreach ($calendario_users_d as $cale_us){
            $cal[$i] = $cale_us->id_user;
            $i++;
        }

        $disertantes = $request->id_userdis;

        // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
        if (isset($disertantes)) {
            foreach ($calendario_users_d as $calendario_user){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                if (!in_array($calendario_user->id_user, $disertantes)) {
                    $calendario_user->delete();

                    $notificationData = [
                        'title' => 'SALA - Desvinculado de un evento',
                        'body' => 'Usted ha sido desvinculado de un evento que se realizaría el dia '.$msgfecha.'',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
                }
            }
            // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
            // lo REGISTRA
            foreach ($disertantes as $disertante){
                if (!isset($cal)) {
                    $calen = Calendario_user::create(['id_user' => $disertante, 'id_calendario' => $calendario->id, 'tipo' => 'Disertante']);
                
                    $notificationData = [
                        'title' => 'SALA - Nuevo evento',
                        'body' => 'Usted ha sido registrado en un nuevo evento para el dia '.$msgfecha.'',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($disertante, $notificationData);
                }else{
                    if (!in_array($disertante, $cal)) {
                    $calen = Calendario_user::create(['id_user' => $disertante, 'id_calendario' => $calendario->id, 'tipo' => 'Disertante']);
                    
                    $notificationData = [
                        'title' => 'SALA - Nuevo evento',
                        'body' => 'Usted ha sido registrado en un nuevo evento para el dia '.$msgfecha.'',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($disertante, $notificationData);
                    }
                }
            }
        } elseif(isset($calendario_users_d)) {
            foreach ($calendario_users_d as $calendario_user){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                $calendario_user->delete();

                $notificationData = [
                    'title' => 'SALA - Desvinculado de un evento',
                    'body' => 'Usted ha sido desvinculado de un evento que se realizaría el dia '.$msgfecha.'',
                    'path' => '/calendario',
                ];
                $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
            }
        }

        $calendario_users_p = Calendario_user::where([['id_calendario',$calendario->id], ['tipo','Participante']])->get();

        //Guardo los resultaados en un array en caso que se obtenga algo
        $i=0;
        foreach ($calendario_users_p as $cale_us){
            $calp[$i] = $cale_us->id_user;
            $i++;
        }

        $participantes = $request->id_userpar;

        // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
        if (isset($participantes)) {
            foreach ($calendario_users_p as $calendario_user){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                if (!in_array($calendario_user->id_user, $participantes)) {
                    $calendario_user->delete();

                    $notificationData = [
                        'title' => 'SALA - Desvinculado de un evento',
                        'body' => 'Usted ha sido desvinculado de un evento que se realizaría el dia '.$msgfecha.'',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
                }
            }
            // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
            // lo REGISTRA
            foreach ($participantes as $participante){
                if (!isset($calp)) {
                    $calen = Calendario_user::create(['id_user' => $participante, 'id_calendario' => $calendario->id, 'tipo' => 'Participante']);
                
                    $notificationData = [
                        'title' => 'SALA - Nuevo evento',
                        'body' => 'Usted ha sido registrado en un nuevo evento para el dia '.$msgfecha.'',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($participante, $notificationData);
                }else{
                    if (!in_array($participante, $calp)) {
                    $calen = Calendario_user::create(['id_user' => $participante, 'id_calendario' => $calendario->id, 'tipo' => 'Participante']);
                    
                    $notificationData = [
                        'title' => 'SALA - Nuevo evento',
                        'body' => 'Usted ha sido registrado en un nuevo evento para el dia '.$msgfecha.'',
                        'path' => '/calendario',
                    ];
                    $this->notificationsService->sendToUser($participante, $notificationData);
                    }
                }
            }
        } elseif(isset($calendario_users_p)) {
            foreach ($calendario_users_p as $calendario_user){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                $calendario_user->delete();

                $notificationData = [
                    'title' => 'SALA - Desvinculado de un evento',
                    'body' => 'Usted ha sido desvinculado de un evento que se realizaría el dia '.$msgfecha.'',
                    'path' => '/calendario',
                ];
                $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
            }
        }

        if ($request->reserva){
            //$lugar = $request->get('lugar');
            $request->request->add(['reserva' => 'Sala de reunión']);
        } else {
            $request->request->add(['reserva' => '']);
        }
    
      $calendario->update($request->all());

    $fechainicio = $request->get('fechainicio');
    $fechafin = $request->get('fechafin');
    $currentDate = Carbon::createFromFormat('Y-m-d', $fechainicio);
    $shippingDate = Carbon::createFromFormat('Y-m-d', $fechafin);

    $diferencia_en_dias = $currentDate->diffInDays($shippingDate);

    if($diferencia_en_dias > 0){
        // En el caso de tambien ampliar el rango de fechas se ejecutara el siguiente script

        for ($i=0; $i <= $diferencia_en_dias ; $i++) { 
            if($i == 0){
                $calendario_users = Calendario_user::where('id_calendario',$calendario->id)->get();
                if(isset($calendario_users)){
                    foreach ($calendario_users as $calendario_user){
                        $calendario_user->delete();
                    }
                }
                $calendario->delete();
            }
            $finicio = date("Y-m-d",strtotime($fechainicio."+ ".$i." days"));

            $request->request->add(['fechainicio' => $finicio]);
            $request->request->add(['fechafin' => $finicio]);
            
            //Agrego al array el creador del evento
            $request->request->add(['id_user' => auth()->user()->id]);

            $calendarios = Calendario::create($request->all());

            //insertar disertantes de la reunion en Calendario_users
            if (isset($request->id_userdis)) {
                $disertantes = $request->id_userdis;
            }
            if (isset($disertantes)) {
                foreach ($disertantes as $dis) {

                    $calendardis = new Calendario_user([
                        'id_calendario'  =>  $calendarios->id,
                        'id_user'   =>  $dis,
                        'tipo' => 'Disertante'
                    ]);
                    $calendardis->save();
                    }
            }

            //insertar disertantes de la reunion en Calendario_users
            if (isset($request->id_userpar)) {
                $participantes = $request->id_userpar;
            }
            if (isset($participantes)) {
                foreach ($participantes as $par) {
                    $calendarpar = new Calendario_user([
                        'id_user'   =>  $par,
                        'id_calendario'  =>  $calendarios->id,
                        'tipo' => 'Participante'
                    ]);
                    $calendarpar->save();
                    }
            }
        }
    }

      return redirect()->route('calendario.index')->with('status_success', 'Calendario modificado con exito');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\calendario  $calendario
   * @return \Illuminate\Http\Response
   */

   public function files($id)
    {
        //
        Gate::authorize('haveaccess','calendario.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calendario']);
        $rutavolver = route('calendario.index');
        return view('calendario.files', compact('rutavolver','id'));
    }

    public function subir(Request $request){
        //Obtengo el id_calendario
        $id_calendario = $request->get('id_calendario');
        //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
        foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
        {
            //Validamos que el archivo exista
            if($_FILES["archivo"]["name"][$key]) {
                $filename = time().'1'.rand().$_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo + random
                $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                
                $directorio = public_path('img/eventos/'); //Declaramos un  variable con la ruta donde guardaremos los archivos
                
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                }
                
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(move_uploaded_file($source, $target_path)) {	
                }
                closedir($dir); //Cerramos el directorio de destino

                //Guardamos la ruta de los archivos en la tabla calendario_archivos
                $archivo = Calendario_archivo::create(['id_calendario'=>$id_calendario, 'path'=>$filename]);

            }
        }
        return redirect()->route('calendario.index')->with('status_success', 'Los archivos se han cargado con éxito');
    }

    public function disponibilidad(Request $request){
        $fechainicio = $request->get('fechainicio');
        $fechafin = $request->get('fechafin');
        if ((!empty($fechainicio)) AND (!empty($fechafin))) {
            $nodisponibles = Calendario::select('calendario_users.id_user')
                                        ->join('calendario_users','calendarios.id','=','calendario_users.id_calendario')
                                        ->where([['calendarios.fechainicio','>=',$fechainicio], 
                                                ['calendarios.fechafin','<=',$fechafin]])->get();
        }elseif((!empty($fechainicio)) AND (empty($fechafin))){
            $nodisponibles = Calendario::select('calendario_users.id_user')
                                        ->join('calendario_users','calendarios.id','=','calendario_users.id_calendario')
                                        ->where('calendarios.fechainicio',$fechainicio)->get();
        }elseif((empty($fechainicio)) AND (!empty($fechafin))){
            $nodisponibles = Calendario::select('calendario_users.id_user')
                                        ->join('calendario_users','calendarios.id','=','calendario_users.id_calendario')
                                        ->where('calendarios.fechafin',$fechafin)->get();
        }
        
        $i=0;

        foreach($nodisponibles as $nodispo){
            $id_nodispo[$i] = $nodispo->id_user;
            $i++;
        }
        
        echo json_encode($id_nodispo);
    }

  public function destroy(calendario $calendario)
  {
      //
      Gate::authorize('haveaccess','calendario.destroy');
      //Primero elimino los usuarios asistentes al evento
      $calendario_users = Calendario_user::where('id_calendario',$calendario->id)->get();
        if(isset($calendario_users)){
            foreach ($calendario_users as $calendario_user){
                $calendario_user->delete();

                $fechainicio = $calendario->fechainicio;
                $currentDate = Carbon::createFromFormat('Y-m-d', $fechainicio);
                $msgfecha = $currentDate->format('d-m-Y');

                $notificationData = [
                    'title' => 'SALA - Evento cancelado',
                    'body' => 'El evento previsto para el dia '.$msgfecha.' ('.$calendario->titulo.') ha sido cancelado',
                    'path' => '/calendario',
                ];
                $this->notificationsService->sendToUser($calendario_user->id_user, $notificationData);
            }
        }

        //Segundo elimino los archivos relacionados a un evento
        $calendario_archivos = Calendario_archivo::where('id_calendario',$calendario->id)->get();
        if(isset($calendario_archivos)){
            foreach ($calendario_archivos as $calendario_archivo){
                $calendario_archivo->delete();
            }
        }

        //Tercero elimino el evento
      $calendario->delete();
      return redirect()->route('calendario.index')->with('status_success', 'Registro eliminado con exito');
  }
}
