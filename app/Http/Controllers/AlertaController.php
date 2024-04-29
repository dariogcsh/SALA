<?php

namespace App\Http\Controllers;

use App\alerta;
use App\jdlink;
use App\sucursal;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\User;
use Carbon\Carbon;
use App\Services\NotificationsService;
use Illuminate\Support\Facades\DB;


class AlertaController extends Controller
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

    public function gestion(Request $request)
    {
       //
       Gate::authorize('haveaccess','alerta.gestion');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
       $rutavolver = route('alerta.index');
       $filtro="";
        $busqueda="";
        if (($request->fecha_inicio) AND ($request->fecha_fin)) {
            $hasta = $request->fecha_fin;
            $desde = $request->fecha_inicio;
            $busqueda = $desde.' - '.$hasta;
        } else{
            $fecha_h = Carbon::today();
            $hasta = $fecha_h->format('Y-m-d');
            $fecha_d = $fecha_h->subDays(30);
            $desde = $fecha_d->format('Y-m-d');
        }

       $amarillas = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','AMARILLO%']])
                            ->orWhere([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','YELLOW%']])->count();
        $rojas = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','ROJO%']])
                        ->orWhere([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','RED%']])->count();
        $naranjas = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','NARANJA%']])->count();
        $mantenimientos = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','Mantenimiento%']])->count();
        $otro = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','OTRO%']])
                        ->orWhere([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','OTHER%']])->count();
        $verde = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','VERDE%']])->count();
        $test = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','test']])->count();
        $desconocido = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','Unknown%']])->count();
        $manufacture = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['alertas.descripcion','LIKE','%Consult manufacturer%']])->count();
                
                            

        $ranking_organizaciones = DB::table('alertas')
                            ->selectRaw('COUNT(alertas.id) as cantidad, organizacions.NombOrga')
                            ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->groupBy('organizacions.NombOrga')
                            ->orderBy('cantidad','DESC')
                            ->where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59']])
                            ->get();
        
        $ranking_sucursales = DB::table('alertas')
                            ->selectRaw('COUNT(alertas.id) as cantidad, sucursals.NombSucu')
                            ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->orderBy('cantidad','DESC')
                            ->where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59']])
                            ->get();
                            

        $respuesta_user = alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['accion','<>',NULL], ['id_useraccion','<>',NULL]])
                                ->count();

        $respuesta_auto = alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                    ['accion','<>',NULL], ['id_useraccion',NULL]])
                                ->count();

        $sin_respuesta = alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                        ['accion',NULL], ['id_useraccion',NULL]])
                                ->count();

        $respuesta_user_sucu = DB::table('alertas')
                                ->selectRaw('COUNT(alertas.id) as cantidad, sucursals.NombSucu')
                                ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->groupBy('sucursals.NombSucu')
                                ->orderBy('cantidad','DESC')
                                ->where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                        ['accion','<>',NULL], ['id_useraccion','<>',NULL]])->get();
                                       
        $respuesta_auto_sucu = DB::table('alertas')
                                ->selectRaw('COUNT(alertas.id) as cantidad, sucursals.NombSucu')
                                ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->groupBy('sucursals.NombSucu')
                                ->orderBy('cantidad','DESC')
                                ->where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                        ['accion','<>',NULL], ['id_useraccion',NULL]])->get();

        $sin_respuesta_sucu = DB::table('alertas')
                                ->selectRaw('COUNT(alertas.id) as cantidad, sucursals.NombSucu')
                                ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->groupBy('sucursals.NombSucu')
                                ->orderBy('cantidad','DESC')
                                ->where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59'],
                                        ['accion',NULL], ['id_useraccion',NULL]])->get();

        $sucursales = Sucursal::where('NombSucu','<>','Otra')->get();
        $rep_suc_nombre = 0;
        foreach ($sucursales as $sucu) {
            $sucursal_nombre[$rep_suc_nombre] = $sucu->NombSucu;
            $rep_suc_nombre++;
        }

       // $tiempo_a_consumir = Jdlink::where([['jdlinks.vencimiento_contrato','>=',$desde.' 00:00:01']])->count();

       // $tiempo_consumido = Alerta::where([['alertas.created_at','>=',$desde.' 00:00:01'], ['alertas.created_at','<=',$hasta.' 23:59:59']])->sum('tiempo_destinado')
        
        // Generar consulta para calcular el tiempo de respuesta y de solucion de asistencias

       return view('alerta.gestion', compact('rutavolver','desde','hasta','busqueda','filtro', 'amarillas','rojas','naranjas',
                                            'mantenimientos','ranking_organizaciones','ranking_sucursales','respuesta_user',
                                            'respuesta_auto','sin_respuesta','respuesta_user_sucu','respuesta_auto_sucu',
                                            'sin_respuesta_sucu','otro','verde','test','desconocido','manufacture','sucursal_nombre',
                                            'rep_suc_nombre'));
    }
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','alerta.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alertas']);
        $rutavolver = route('home');
        $nomborg = User::select('organizacions.CodiOrga','organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
        $filtro="";
        $busqueda="";
        $vista="";
        if ($nomborg->NombOrga == 'Sala Hnos'){
            if($request->buscarpor AND $request->tipo){
                $tipo = $request->get('tipo');
                $busqueda = $request->get('buscarpor');
                $variablesurl=$request->all();
                $alertas = Alerta::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
                $filtro = "SI";
            } else{
                    $vista= $request->get('sucu');
                    $variablesurl=$request->all();
                    if($vista == "sucursal"){
                        $alertas = Alerta::select('organizacions.NombOrga','alertas.id','alertas.fecha','alertas.hora'
                                            ,'alertas.descripcion', 'alertas.pin','alertas.accion','maquinas.TipoMaq'
                                            ,'maquinas.ModeMaq','sucursals.NombSucu','alertas.descripcion', 'users.name'
                                            ,'users.last_name')
                                        ->leftjoin('users','alertas.id_useraccion','=','users.id')
                                        ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                        ->where([['organizacions.CodiSucu',auth()->user()->CodiSucu], ['InscMaq','SI'], ['descripcion','not like',"%VMAX%"]
                                        ])
                                        ->orderBy('id','desc')->paginate(20);
                    } else {
                    $alertas = Alerta::select('organizacions.NombOrga','alertas.id','alertas.fecha','alertas.hora'
                                            ,'alertas.descripcion', 'alertas.pin','alertas.accion','maquinas.TipoMaq'
                                            ,'maquinas.ModeMaq','sucursals.NombSucu','alertas.descripcion', 'users.name'
                                            ,'users.last_name')
                                        ->leftjoin('users','alertas.id_useraccion','=','users.id')
                                        ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                        ->where([['InscMaq','SI'], ['descripcion','not like',"%VMAX%"]])
                                        ->orderBy('id','desc')->paginate(20);
                                        $vista = "concesionario";
                    }
        }
        } else {
        $alertas = Alerta::select('organizacions.NombOrga','alertas.id','alertas.fecha','alertas.hora'
                                ,'alertas.descripcion', 'alertas.pin','alertas.accion','maquinas.TipoMaq'
                                ,'maquinas.ModeMaq','alertas.descripcion','users.name','users.last_name')
                            ->leftjoin('users','alertas.id_useraccion','=','users.id')
                            ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->where([['organizacions.CodiOrga', $nomborg->CodiOrga], ['InscMaq','SI']])
                            ->orderBy('id','desc')->paginate(20);
        }

        
        return view('alerta.index', compact('alertas','filtro','busqueda','nomborg','vista','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','alerta.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alertas']);
        $rutavolver = url()->previous();
        return view('alerta.create', compact('rutavolver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess','alerta.create');
        request()->validate([
            'hora' => 'required',
            'descripcion' => 'required',
            'pin' => 'required',
        ]);
        $mytime = Carbon::now();
        $request->request->add(['fecha' => $mytime]);
        $alertas = Alerta::create($request->all());
        $organizacion = Alerta::join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->where('alertas.pin', $alertas->pin)
                                ->first();
        $usersends = User::select('users.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->where('roles.name','Admin')->get();

        //Envio de notificacion
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'Sala Hnos.',
                'body' => 'Alerta de gravedad de '.$organizacion->NombOrga.'',
                'path' => '/alerta',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }

        return redirect()->route('alerta.index')->with('status_success', 'Alerta ingresada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\alerta  $alerta
     * @return \Illuminate\Http\Response
     */
    public function show(Alerta $alerta, $id)
    {
        Gate::authorize('haveaccess','alerta.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alertas']);
        $alerta = Alerta::select('organizacions.NombOrga','alertas.fecha','alertas.hora','alertas.id','alertas.descripcion',
                                'alertas.accion','alertas.pin','alertas.pin','alertas.presupuesto','alertas.cor',
                                'alertas.lat','alertas.lon','maquinas.TipoMaq','maquinas.ModeMaq','maquinas.anio','maquinas.horas',
                                'maquinas.nombre','sucursals.NombSucu','users.name','users.last_name','alertas.tiempo_destinado')
                        ->leftjoin('users','alertas.id_useraccion','=','users.id')
                        ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->where('alertas.id', $id)->first();
        $jdlink = Jdlink::where('NumSMaq',$alerta->pin)->first();
                        $rutavolver = url()->previous();
        return view('alerta.view', compact('alerta','rutavolver','jdlink'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\alerta  $alerta
     * @return \Illuminate\Http\Response
     */
    public function edit(Alerta $alerta, $id)
    {
        Gate::authorize('haveaccess','alerta.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alertas']);
        $alerta = Alerta::select('organizacions.NombOrga','alertas.fecha','alertas.hora','alertas.id','alertas.descripcion',
                                'alertas.accion','alertas.pin','alertas.pin','alertas.presupuesto','alertas.cor',
                                'alertas.lat','alertas.lon','maquinas.TipoMaq','maquinas.ModeMaq','anio','horas',
                                'sucursals.NombSucu','users.name','users.last_name','alertas.tiempo_destinado')
                        ->leftjoin('users','alertas.id_useraccion','=','users.id')
                        ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->where('alertas.id', $id)->first();
                        $rutavolver = route('alerta.index');
        $jdlink = Jdlink::where('NumSMaq',$alerta->pin)->first();
        return view('alerta.edit', compact('alerta','rutavolver','jdlink'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\alerta  $alerta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alerta $alerta,$id)
    {
        Gate::authorize('haveaccess','alerta.edit');
        $alerta = Alerta::where('id',$id)->first();
        $request->request->add(['tipo_respuesta' => 'Accion']);
        $request->request->add(['id_useraccion' => auth()->user()->id]);
        $alerta->update($request->all());

        //Modifica y resta el tiempo destinado en tiempo de alerta en jdlink
        $hoy = Carbon::today();
        $año = $hoy->format('Y-m-d');

        $jdlink = Jdlink::where([['NumSMaq',$alerta->pin],['alertas','SI'],['vencimiento_contrato','>=',$año]])->first();
        if(isset($jdlink)){
            $tiempo_alerta = $jdlink->tiempo_alertas;
            $tiempo_destinado = $request->get('tiempo_destinado');
            $total = $tiempo_alerta - $tiempo_destinado;
            $jdlink->update(['tiempo_alertas'=>$total]);
        }

        $organizacion = Alerta::select('organizacions.id') 
                            ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->where('alertas.id', $id)->first();
        
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->where('users.CodiOrga',$organizacion->id)
                        ->orWhere('roles.name','Admin')
                        ->get();

        //Envio de notificacion
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA - Alerta',
                'body' => 'Acción tomada por el concesionario ante una alerta',
                'path' => '/alerta/'.$id.'',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        } 
        return redirect()->route('alerta.index')->with('status_success', 'Alerta modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\alerta  $alerta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alerta $alerta,$id)
    {
        Gate::authorize('haveaccess','alerta.destroy');
        $alerta = Alerta::where('id',$id)->first();
        $alerta->delete();
        return redirect()->route('alerta.index')->with('status_success', 'Alerta eliminada con exito');
    }
    public function destroyAll(Alerta $alerta)
    {
        Gate::authorize('haveaccess','alerta.destroy');
        Alerta::truncate();
        return redirect()->route('alerta.index')->with('status_success', 'Alertas eliminadas con exito');
    }
}
