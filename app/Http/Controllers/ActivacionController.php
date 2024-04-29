<?php

namespace App\Http\Controllers;

use App\activacion;
use App\organizacion;
use App\antena;
use App\pantalla;
use App\interaccion;
use App\suscripcion;
use App\user;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;
use Illuminate\Support\Facades\DB;

class ActivacionController extends Controller
{
    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }


    public function gestion(Request $request)
    {
       //
       $rutavolver = route('internoestadisticas');
   
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
       $fecha_hoy = Carbon::today();
        $dbdate = '2022-01-01';
        $añoinicial = Carbon::createFromFormat('Y-m-d', $dbdate);
        $año_inicial = $añoinicial->format('Y');
        $hoy = $fecha_hoy->format('Y-m-d');
        $año = $fecha_hoy->format('Y');

        if (($fecha_hoy > $año."-10-31") AND ($fecha_hoy <= $año."-12-31")){
            $año = $año + 1;
            $año_pasado = $año;
        }else{
            $año = $año;
            $año_pasado = $año - 1;
        }

        $diff = $añoinicial->diffInYears($año);
        $busqueda = '';
        $mes[0] = 10;
        $mes[1] = 11;
        $mes[2] = 12;
        $mes[3] = 1;
        $mes[4] = 2;
        $mes[5] = 3;
        $mes[6] = 4;
        $mes[7] = 5;
        $mes[8] = 6;
        $mes[9] = 7;
        $mes[10] = 8;
        $mes[11] = 9;
        $mes[12] = 10;
        $mes[13] = 11;

        $mes_nombre[0] = 'Noviembre';
        $mes_nombre[1] = 'Diciembre';
        $mes_nombre[2] = 'Enero';
        $mes_nombre[3] = 'Febrero';
        $mes_nombre[4] = 'Marzo';
        $mes_nombre[5] = 'Abril';
        $mes_nombre[6] = 'Mayo';
        $mes_nombre[7] = 'Junio';
        $mes_nombre[8] = 'Julio';
        $mes_nombre[9] = 'Agosto';
        $mes_nombre[10] = 'Septiembre';
        $mes_nombre[11] = 'Octubre';

        $dia[0] = 31;
        $dia[1] = 30;
        $dia[2] = 31;
        $dia[3] = 31;
        $dia[4] = 28;
        $dia[5] = 31;
        $dia[6] = 30;
        $dia[7] = 31;
        $dia[8] = 30;
        $dia[9] = 31;
        $dia[10] = 31;
        $dia[11] = 30;
        $dia[12] = 31;
        $dia[13] = 30;

        for ($i=0; $i <= $diff ; $i++) { 
            $FY[$i] = $año_inicial + $i;
            $FY_pasado[$i] = $FY[$i] - 1;

            $alquileres_cant[$i] = Activacion::where([['created_at','>',$FY_pasado[$i].'-10-31 23:59:59'], ['created_at','<',$FY[$i].'-11-01'],
                                                ['estado','<>','Cancelado']])
                                        ->count();
 
            $alquileres_usd[$i] = Activacion::where([['created_at','>',$FY_pasado[$i].'-10-31 23:59:59'], ['created_at','<',$FY[$i].'-11-01 00:00:01'],
                                                ['estado','<>','Cancelado']])
                                        ->sum('precio');

            for ($x=0; $x < 12 ; $x++) {
                if($mes[$x] == 10){
                    $alquiler_mes[$i][$x] = Activacion::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY_pasado[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->count();

                    $alquiler_mes_usd[$i][$x] = Activacion::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY_pasado[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->sum('precio');
                                                
                }elseif(($mes[$x] == 11) OR ($mes[$x] == 12)){
                    $alquiler_mes[$i][$x] = Activacion::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->count();

                    $alquiler_mes_usd[$i][$x] = Activacion::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->sum('precio');
                                              
                }else{
                    $alquiler_mes[$i][$x] = Activacion::where([['created_at','>',$FY[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->count();

                    $alquiler_mes_usd[$i][$x] = Activacion::where([['created_at','>',$FY[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->sum('precio');
                }
            }
        }

        if($request->año_fiscal){
            $año_FY = $request->año_fiscal;
            $filtro = 'SI';
            $busqueda = $año_FY;
        }else{
            $año_FY = $año;
            $filtro = 'NO';
        }

        $senal_estados = DB::table('activacions')
                            ->selectRaw('COUNT(activacions.id) as cantidad, activacions.estado')
                            ->groupBy('activacions.estado')
                            ->orderBy('cantidad','DESC')
                            ->where([['activacions.created_at','>=',$año_pasado.'-11-01 00:00:01']])
                            ->get();

        $tipos_senal = DB::table('activacions')
                            ->selectRaw('COUNT(activacions.id) as cantidad, activacions.duracion')
                            ->groupBy('activacions.duracion')
                            ->orderBy('cantidad','DESC')
                            ->where([['activacions.created_at','>=',$año_pasado.'-11-01 00:00:01'], ['estado','<>','Cancelado']])
                            ->get();
        
        $año_FY_pasado = $año_FY - 1;
        $año_FY_antepasado = $año_FY_pasado - 1;
        
        $alquileres_FY_pasado = Activacion::select('nserie')
                                    ->where([['created_at','>',$año_FY_antepasado.'-10-31 23:59:59'], 
                                            ['created_at','<',$año_FY_pasado.'-11-01 00:00:01'],
                                            ['estado','<>','Cancelado']])->get();

        $cantidad_alquileres_FY_pasado = $alquileres_FY_pasado->count();
        

        //dd($alquiler_mes);

       return view('activacion.gestion', compact('diff','FY','alquileres_cant','alquileres_usd','filtro','mes_nombre','alquiler_mes',
                                            'alquiler_mes_usd','senal_estados','alquileres_FY_pasado','año_FY','año_FY_pasado',
                                            'cantidad_alquileres_FY_pasado','año','busqueda','tipos_senal'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('haveaccess','activacion.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);

        $nomborg = User::select('organizacions.CodiOrga','organizacions.NombOrga','organizacions.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();

        $rutavolver = route('internosoluciones');
        $filtro="";
        $busqueda="";
        if ($nomborg->NombOrga == 'Sala Hnos'){
            if($request->buscarpor){
                $tipo = $request->get('tipo');
                $busqueda = $request->get('buscarpor');
                $variablesurl=$request->all();
                $activacions = Activacion::Buscar($tipo, $busqueda)->orderBy('activacions.id','desc')->paginate(20)->appends($variablesurl);
                $filtro = "SI";
            } else{
                $activacions = Activacion::select('activacions.id','organizacions.NombOrga','antenas.NombAnte','activacions.nserie'
                                        ,'activacions.created_at','activacions.fecha','suscripcions.nombre','activacions.duracion'
                                        ,'activacions.precio','activacions.estado','activacions.nfactura','pantallas.NombPant',
                                        'users.name','users.last_name')
                                ->leftjoin('users','activacions.id_user','=','users.id')
                                ->join('organizacions','activacions.organizacion_id','=','organizacions.id')
                                ->leftjoin('antenas','activacions.id_antena','=','antenas.id')
                                ->leftjoin('pantallas','activacions.pantalla_id','=','pantallas.id')
                                ->join('suscripcions','activacions.suscripcion_id','=','suscripcions.id')
                                ->orderBy('activacions.id','desc')->paginate(20);
            }
        }else{
            $activacions = Activacion::select('activacions.id','organizacions.NombOrga','antenas.NombAnte','activacions.nserie'
                                        ,'activacions.created_at','activacions.fecha','suscripcions.nombre','activacions.duracion'
                                        ,'activacions.precio','activacions.estado','activacions.nfactura','pantallas.NombPant',
                                        'users.name','users.last_name')
                                ->leftjoin('users','activacions.id_user','=','users.id')
                                ->join('organizacions','activacions.organizacion_id','=','organizacions.id')
                                ->leftjoin('antenas','activacions.id_antena','=','antenas.id')
                                ->leftjoin('pantallas','activacions.pantalla_id','=','pantallas.id')
                                ->join('suscripcions','activacions.suscripcion_id','=','suscripcions.id')
                                ->where('activacions.organizacion_id', $nomborg->id)
                                ->orderBy('activacions.id','desc')->paginate(20);
        }
        $hoy = Carbon::now();
        return view('activacion.index', compact('activacions','hoy','filtro','busqueda','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','activacion.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $antenas = Antena::orderBy('id','asc')->get();
        $pantallas = Pantalla::orderBy('id','asc')->get();
        $suscripciones = Suscripcion::orderBy('id','asc')->get();
        $rutavolver = route('activacion.index');
        return view('activacion.create', compact('organizaciones','antenas','pantallas','suscripciones','rutavolver'));
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
            'organizacion_id' => 'required',
            'duracion' => 'required',
            'precio' => 'required',
            'suscripcion_id' => 'required'
        ]);

        $request->request->add(['id_user' => auth()->id()]);
        $activacions = Activacion::create($request->all());

        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where('puesto_empleados.NombPuEm', 'Analista de creditos')
                        ->orWhere(function($query) {
                            $query->where('users.last_name', 'Blanc')
                                  ->Where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Especialista AMS')
                                ->where('users.last_name', 'Pelliza');
                        })
                        ->get();
                    

         //Envio de notificacion
         foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'Activacion/Suscripcion - Solicitud',
                'body' => 'Nueva activación/suscripción de señal registrado',
                'path' => '/activacion',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        return redirect()->route('activacion.index')->with('status_success', 'Activación/suscripción registrada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\activacion  $activacion
     * @return \Illuminate\Http\Response
     */
    public function show(activacion $activacion)
    {
        Gate::authorize('haveaccess','activacion.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $antenas = Antena::orderBy('id','asc')->get();
        $usuario = User::where('id',$activacion->id_user)->first();
   
        $rutavolver = route('activacion.index');
        return view('activacion.view', compact('activacion','organizaciones','antenas','rutavolver','usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\activacion  $activacion
     * @return \Illuminate\Http\Response
     */
    public function edit(activacion $activacion)
    {
        Gate::authorize('haveaccess','activacion.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $antenas = Antena::orderBy('id','asc')->get();
        $pantallas = Pantalla::orderBy('id','asc')->get();
        $suscripciones = Suscripcion::orderBy('id','asc')->get();
        $rutavolver = route('activacion.index');
        return view('activacion.edit', compact('activacion','organizaciones','pantallas','suscripciones','antenas','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\activacion  $activacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, activacion $activacion)
    {
        request()->validate([
            'organizacion_id' => 'required',
            'duracion' => 'required',
            'precio' => 'required',
            'suscripcion_id' => 'required'
        ]);
        
        $activacion->update($request->all());
        //Buscamos la organizacion a la cual le corresponde el alquiler de señal para detallar en la notificacion.
        $orgsenal = Organizacion::where('id',$activacion->organizacion_id)->first();
        if(($activacion->estado == 'Pagado') OR ($activacion->estado == 'Facturado') OR ($activacion->estado == 'Activado') OR ($activacion->estado == 'Cancelado')){
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where(function($query) {
                            $query->where('users.last_name', 'Blanc')
                                  ->Where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Especialista AMS')
                                ->where('users.last_name', 'Pelliza');
                        })
                        ->orWhere(function($query) use ($activacion) {
                            $query->where('users.id', $activacion->id_user);
                        })
                        ->get();
                    

            //Envio de notificacion
            foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'Alquiler de señal - '.$orgsenal->NombOrga.'',
                    'body' => 'Alquiler de señal ha sido '.$activacion->estado.'',
                    'path' => '/activacion',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
        } elseif($activacion->estado == 'Solicitado'){
            $usersends = User::select('users.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->join('role_user','users.id','=','role_user.user_id')
                            ->join('roles','role_user.role_id','=','roles.id')
                            ->Where('puesto_empleados.NombPuEm', 'Analista de creditos')
                            ->orWhere(function($query) {
                                $query->where('users.last_name', 'Blanc')
                                    ->Where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                            })
                            ->orWhere(function($query) {
                                $query->where('puesto_empleados.NombPuEm', 'Especialista AMS')
                                    ->where('users.last_name', 'Pelliza');
                            })
                            ->get();

            //Envio de notificacion
            foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'Alquiler de señal - '.$activacion->estado.'',
                    'body' => 'Alquiler de señal cambio de estado a '.$activacion->estado.'',
                    'path' => '/activacion',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
        }
        return redirect()->route('activacion.index')->with('status_success', 'Activación/suscripción modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\activacion  $activacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(activacion $activacion)
    {
        Gate::authorize('haveaccess','activacion.destroy');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
        $activacion->delete();
        return redirect()->route('activacion.index')->with('status_success', 'Activación/suscripción eliminado con exito');
    }
}
