<?php

namespace App\Http\Controllers;

use App\asist;
use App\solucion;
use App\asistenciatipo;
use App\organizacion;
use App\interaccion;
use App\maquina;
use App\jdlink;
use App\sucursal;
use App\antena;
use App\guardiasadmin;
use App\pantalla;
use App\User;
use App\Services\NotificationsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AsistController extends Controller
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
       Gate::authorize('haveaccess','asist.edit');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
       $rutavolver = route('asist.index');
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

       $ranking_sucursales = DB::table('asists')
                            ->selectRaw('COUNT(asists.id) as cantidad, sucursals.NombSucu')
                            ->join('users','asists.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->orderBy('cantidad','DESC')
                            ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $ranking_organizaciones = DB::table('asists')
                            ->selectRaw('COUNT(asists.id) as cantidad, organizacions.NombOrga')
                            ->join('users','asists.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->groupBy('organizacions.NombOrga')
                            ->orderBy('cantidad','DESC')
                            ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $ranking_puesto = DB::table('solucions')
                            ->selectRaw('COUNT(solucions.id) as cantidad, puesto_empleados.NombPuEm')
                            ->join('users','solucions.id_user','=','users.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->groupBy('puesto_empleados.NombPuEm')
                            ->orderBy('cantidad','DESC')
                            ->where([['solucions.created_at','>=',$desde.' 00:00:01'], ['solucions.created_at','<=',$hasta.' 23:59:59'],
                                    ['NombPuEm','<>','cliente']])
                            ->get();

        $ranking_colaborador = DB::table('solucions')
                            ->selectRaw('COUNT(solucions.id) as cantidad, users.name, users.last_name')
                            ->join('users','solucions.id_user','=','users.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->groupBy('users.id')
                            ->orderBy('cantidad','DESC')
                            ->where([['solucions.created_at','>=',$desde.' 00:00:01'], ['solucions.created_at','<=',$hasta.' 23:59:59'],
                                    ['NombPuEm','<>','cliente']])
                            ->get();

        $ranking_estados = DB::table('asists')
                            ->selectRaw('COUNT(asists.id) as cantidad, asists.EstaAsis')
                            ->groupBy('asists.EstaAsis')
                            ->orderBy('cantidad','DESC')
                            ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $sucursales_asistencia = Asist::select('sucursals.NombSucu')
                            ->join('users','asists.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $estados_sucursal = DB::table('asists')
                            ->selectRaw('COUNT(asists.id) as cantidad, asists.EstaAsis, sucursals.NombSucu')
                            ->join('users','asists.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->groupBy('asists.EstaAsis')
                            ->orderBy('sucursals.NombSucu','ASC')
                            ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59']])
                            ->get();
        
        $estados = Asist::select('asists.EstaAsis')
                        ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59']])
                        ->groupBy('asists.EstaAsis')
                        ->get();
        $sucursales = Sucursal::get();
        
        // Generar consulta para calcular el tiempo de respuesta y de solucion de asistencias

       return view('asist.gestion', compact('rutavolver','desde','hasta','ranking_sucursales','filtro', 'ranking_organizaciones',
                                            'ranking_puesto','ranking_colaborador','ranking_estados','sucursales_asistencia',
                                            'estados_sucursal','estados','sucursales'));
    }

    public function index(Request $request)
    {
        Gate::authorize('haveaccess','asist.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);

        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        if ($organizacion->NombOrga == "Sala Hnos"){
            $vista= $request->get('sucu');
            $variablesurl=$request->all();
            if($vista == "sucursal"){
                $asistencias = Asist::select('asists.id','asists.EstaAsis','organizacions.NombOrga','organizacions.InscOrga',
                                             'asists.updated_at','asists.id_organizacion','sucursals.NombSucu')
                                    ->join('users','asists.id_user','=','users.id')
                                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where('users.CodiSucu',auth()->user()->CodiSucu)
                                    ->orderBy('asists.id','desc')
                                    ->paginate(10)->appends($variablesurl);
            } else {
                $asistencias = Asist::select('asists.id','asists.EstaAsis','organizacions.NombOrga','organizacions.InscOrga',
                                             'asists.updated_at','asists.id_organizacion','sucursals.NombSucu')
                                    ->join('users','asists.id_user','=','users.id')
                                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->orderBy('asists.id','desc')
                                    ->paginate(10)->appends($variablesurl);
                                    $vista = "concesionario";
                                        
            }
        } else {
            $asistencias = Asist::select('asists.id','asists.EstaAsis','organizacions.NombOrga','organizacions.InscOrga',
                                         'asists.updated_at', 'asists.id_organizacion','sucursals.NombSucu')
                                ->join('users','asists.id_user','=','users.id')
                                ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where('organizacions.id', auth()->user()->CodiOrga)
                                ->orWhere('asists.id_organizacion', auth()->user()->CodiOrga)
                                ->orderBy('asists.id','desc')
                                ->paginate(10);
                                $vista="usuario";
        }

        return view('asist.index', compact('asistencias','vista'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','asist.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
        $asistencias = Asistenciatipo::orderBy('NombTiAs','asc')->get();
        $antenas = Antena::orderBy('NombAnte','asc')->get();
        $pantallas = Pantalla::orderBy('NombPant','asc')->get();
        $maquinas = Maquina::select('maquinas.id', 'maquinas.NumSMaq','maquinas.ModeMaq')
                            ->join('organizacions', 'maquinas.CodiOrga', '=', 'organizacions.id')
                            ->join('users', 'organizacions.id', '=', 'users.CodiOrga')
                            ->where('users.id', auth()->id())
                            ->get();
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderBy('NombOrga', 'asc')->get();
        $rutavolver = route('asist.index');
        return view('asist.create',compact('asistencias','antenas','pantallas','maquinas','organizacion',
                                            'organizaciones','rutavolver'));
    }

    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        
        $data = Maquina::where($select, $value)->get();
        $output = '<option value="">Seleccionar Máquina</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->id.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
        }
        echo $output;

    }

    public function createChat()
    {
        Gate::authorize('haveaccess','asist.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
        $rutavolver = route('asist.index');
        return view('asist.createchat', compact('rutavolver'));
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
            'DescAsis' => 'required',
        ]);
        
        //Comprueba si la carga de la asistencia se hizo desde Sala Hnos
        $id_organizacion = '';
        if(isset($request->id_organizacion)){
            $id_organizacion = $request->id_organizacion;
        }
            if ($id_organizacion <> ''){
                $request->request->add(['id_organizacion' => $id_organizacion,'EstaAsis' => 'Respondido', 
                                        'id_user'=>auth()->id()]);
            } else {
                $request->request->add(['EstaAsis' => 'Solicitud', 'id_user'=>auth()->id()]);
            }

        if ($request->MaPaAsis){
            $request->request->add(['MaPaAsis' => 'SI']);
        }
        if ($request->PrimAsis){
            $request->request->add(['PrimAsis' => 'SI']);
        }
        if ($request->PrueAsis){
            $request->request->add(['PrueAsis' => 'SI']);
        }
        
        //dd($id_organizacion);
        $asist = Asist::create($request->all());

        $name = User::select('name', 'last_name')
                    ->where('id', $asist->id_user)
                    ->first();

        //Comprueba si la carga de la asistencia se hizo desde Sala Hnos
        if ($id_organizacion <> ''){
                $idorg =$request->id_organizacion;
                $organizacion = Organizacion::where('id',$idorg)->first();
                //Ingresa una respuesta automática
                $solucion = Solucion::create(['DescSolu' => 'Esta es una asistencia creada por '.$name->name.' 
                '.$name->last_name.' para la organización/razon social '.$organizacion->NombOrga.''
                , 'id_user' => '999', 'id_asist' => $asist->id, 'tipo' => 'texto']);
        } else {
                //Ingresa una respuesta automática
                
                $solucion = Solucion::create(['DescSolu' => 'Bienvenido '.$name->name.' ya hemos enviado tu solicitud a la
                sucursal. A la brevedad nos estaremos comunicando', 'id_user' => '999', 'id_asist' => $asist->id, 'tipo' => 'texto']);
                
        }

        //obtener sucursal donde pertenece el usuario que solicita la asistencia
        $sucursalid = Sucursal::select('sucursals.id','sucursals.NombSucu')
                            ->join('users','sucursals.id','=','users.CodiSucu')
                            ->join('asists','users.id','=','asists.id_user')
                            ->where('asists.id',$asist->id)
                            ->first();

        //Se comprueba si hoy es un dia de Guardia para administrativo
        $hoy = Carbon::today();
        $guardia = Guardiasadmin::where('fecha',$hoy)->first();
        //Se comprueba si trae algun resultado (quiere decir que si es un dia de guardia)
        if (isset($guardia)) {
            $sucursalguardia = $guardia->id_sucursal;
        } else {
            if ($sucursalid->NombSucu == "Adelia Maria") {
                $sucursalid = Sucursal::select('sucursals.id')
                            ->where('sucursals.NombSucu','Coronel Moldes')
                            ->first();
                $sucursalguardia = $sucursalid->id;
            }else{
                $sucursalguardia = $sucursalid->id;
            }
            
        }
        //Comprueba si la carga de la asistencia se hizo desde Sala Hnos
        if ($id_organizacion <> ''){
            $usersends = User::select('users.id')
                            ->where('CodiOrga',$id_organizacion)
                            ->get();

        //Envio de notificacion
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA',
                'body' => 'Ya podes empezar a visualizar el avance de la solicitud de asistencia/servicio sobre tu unidad.',
                'path' => '/asist',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        } else {
       // $matchTheseAdministrativo = ['puesto_empleados.NombPuEm' => 'Administrativo de servicio', 'users.CodiSucu' => $sucursalid->id];
       // $matchTheseGerente = ['puesto_empleados.NombPuEm' => 'Gerente de sucursal', 'users.CodiSucu' => $sucursalid->id];
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        //->orWhere($matchTheseAdministrativo)
                        //->orWhere($matchTheseGerente)
                        ->Where('roles.name','Admin')
                        ->orWhere(function($q) use ($sucursalid, $sucursalguardia){
                            $q->where(function($query) use ($sucursalguardia){
                                $query->where('puesto_empleados.NombPuEm','Administrativo de servicio')
                                    ->where('users.CodiSucu', $sucursalguardia);      
                            })
                            ->orWhere(function($query) use ($sucursalid){
                                $query->where('puesto_empleados.NombPuEm', 'Gerente de sucursal')
                                    ->where('users.CodiSucu', $sucursalid->id);
                            })
                            ->orWhere(function($query) use ($sucursalid){
                                $query->where('puesto_empleados.NombPuEm', 'Coordinador de servicios')
                                    ->where('users.CodiSucu', $sucursalid->id);
                            })
                            ->orWhere(function($query) use ($sucursalid){
                                $query->where('puesto_empleados.NombPuEm', 'Coordinador de servicios')
                                    ->where('roles.name', 'Coordinador de servicio corporativo');
                            });
                        })
                        ->get();

                        //Envio de notificacion
                        foreach($usersends as $usersend){
                            $notificationData = [
                                'title' => 'SALA',
                                'body' => 'Nueva solicitud de asistencia',
                                'path' => '/asist',
                            ];
                            $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        } 
        }
        
        return redirect()->route('asist.show', $asist);
        //return redirect()->route('asist.index')->with('status_success', 'Asistencia solicitada con exito, en minutos nos estaremos comunicando');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\asist  $asist
     * @return \Illuminate\Http\Response
     */
    public function show(asist $asist)
    {
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);

        $user = User::where('id',$asist->id_user)->first();
        if ($asist->id_organizacion == ''){
            $organizacion = Organizacion::where('id',$user->CodiOrga)->first();
            $organizacionCliente = '';
        } else {
            $organizacion = Organizacion::where('id',$user->CodiOrga)->first();
            $organizacionCliente = Organizacion::where('id',$asist->id_organizacion)->first();
        }
        
        $tipoasistencia = Asistenciatipo::where('id',$asist->id_asistenciatipo)->first();
        $maquina = Maquina::where('id', $asist->id_maquina)->first();
        $pantalla = Pantalla::where('id', $asist->id_pantalla)->first();
        $antena = Antena::where('id', $asist->id_antena)->first();
        $sucursal = Sucursal::where('id',auth()->user()->CodiSucu)->first();
        $solucions = Solucion::select('users.name', 'users.last_name','organizacions.NombOrga','organizacions.id as id_orga',
                                    'solucions.DescSolu', 'solucions.created_at', 'solucions.tipo','solucions.ruta',
                                    'solucions.id')
                ->join('users', 'solucions.id_user', '=', 'users.id')
                ->join('organizacions', 'users.CodiOrga', '=', 'organizacions.id')
                ->where('solucions.id_asist', $asist->id)
                ->orderBy('solucions.created_at','asc')
                ->get();
        
                $rutavolver = route('asist.index');
        return view('solucion.create',compact('asist','user','organizacion','tipoasistencia','maquina','pantalla',
                                            'antena','solucions','sucursal','organizacionCliente','rutavolver')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\asist  $asist
     * @return \Illuminate\Http\Response
     */
    public function edit(asist $asist)
    {
        Gate::authorize('haveaccess','asist.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
        $rutavolver = route('asist.index');
        return view('asist.edit', compact('asist','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\asist  $asist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, asist $asist)
    {
        Gate::authorize('haveaccess','asist.edit');
        $mytime = Carbon::now();
        
        if (($request->ResuAsis == "SI") OR ($request->ResuAsis == "NO") OR ($request->ResuAsis == "ASISTENCIA RECHAZADA")){
            request()->validate([
                'CMinAsis' => 'required',
                'dtac' => 'required',
            ]);
            if ($request->ResuAsis == "ASISTENCIA RECHAZADA"){
                request()->validate([
                    'MotiAsis' => 'required',
                ]);
                $finalizacion = "Asistencia rechazada";
            } else {
                $finalizacion = "Asistencia finalizada";
            } 
            $asist->where('id', $asist->id)->update(['EstaAsis' => $finalizacion,'ResuAsis' => $request->ResuAsis,
                        'CMinAsis' => $request->CMinAsis, 'DeReAsis' => $request->DeReAsis, 'FFinAsis' => $mytime, 
                        'dtac' => $request->dtac, 'ndtac' => $request->ndtac,'MotiAsis' => $request->MotiAsis]);
           
            $hoy = Carbon::today();
            $año = $hoy->format('Y-m-d');

            if(isset($asist->id_maquina)){
                
                $jdlink = Jdlink::where([['id',$asist->id_maquina],['anofiscal',$año]])->first();
                $tiempo_alerta = $jdlink->tiempo_alertas;
                $tiempo_destinado = $request->get('CMinAsis');
                $total = $tiempo_alerta - $tiempo_destinado;
                $jdlink->update(['tiempo_alertas'=>$total]);
            }else{
                $CodiOrga = User::select('organizacions.id')
                                ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                ->where('users.id',$asist->id_user)->first();

                $jdlinks = Jdlink::select('jdlinks.tiempo_alertas','jdlinks.NumSMaq','jdlinks.anofiscal','jdlinks.id')
                                ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                ->where([['maquinas.CodiOrga',$CodiOrga->id],['jdlinks.alertas','SI'],['jdlinks.vencimiento_contrato','>=',$año]])
                                ->distinct('jdlinks.anofiscal')
                                ->orderBy('jdlinks.anofiscal','desc')->get();
                $cantmaq = $jdlinks->count();

                if($cantmaq > 0){
                    $tiempo_destinado = $request->get('CMinAsis');
                    foreach ($jdlinks as $jdlink) {
                        $tiempo_alerta = $jdlink->tiempo_alertas;
                        $tiempo_destinado_por_equipo = $tiempo_destinado / $cantmaq;
                        $total = $tiempo_alerta - $tiempo_destinado_por_equipo;
                        $jdlink->update(['tiempo_alertas' => $total]);
                    }
                }
            }
            


            //Creo el cambio de estado en el modelo de solucion
            $solucion = Solucion::create(['DescSolu' => $finalizacion, 'id_user' => auth()->id(), 'id_asist' => $asist->id, 
                                        'tipo' => 'estado']);
        } else {
            if ($request->ResuAsis == "DERIVACION A CAMPO"){
                $deritipo = 'Derivacion a campo';
                $campo_fecha = "FDerAsis";
            } elseif ($request->ResuAsis == "DERIVACION A TALLER"){
                $deritipo = 'Derivacion a taller';
                $campo_fecha = "FDerAsis";
            } elseif ($request->ResuAsis == "PRESUPUESTADO"){
                $deritipo = 'Presupuestado';
                $campo_fecha = "FPreAsis";
            } elseif ($request->ResuAsis == "EN GESTION - MAQUINA PARADA"){
                $deritipo = 'En gestion - Maquina parada';
                $campo_fecha = "FGesAsis";
            } elseif ($request->ResuAsis == "EN GESTION - MAQUINA FUNCIONANDO"){
                $deritipo = 'En gestion - Maquina funcionando';
                $campo_fecha = "FGesAsis";
            }
            $asist->where('id', $asist->id)->update(['EstaAsis' => $deritipo,'ResuAsis' => $request->ResuAsis,
                                                    'CMinAsis' => $request->CMinAsis, 'DeReAsis' => $request->DeReAsis,
                                                    $campo_fecha => $mytime]);

            $hoy = Carbon::now();
            $año = $hoy->format('Y');

            $jdlink = Jdlink::where([['id',$asist->id_maquina],['anofiscal',$año]])->first();
            $tiempo_alerta = $jdlink->tiempo_alertas;
            $tiempo_destinado = $request->get('CMinAsis');
            $total = $tiempo_alerta - $tiempo_destinado;
            $jdlink->update(['tiempo_alertas'=>$total]);

            //Creo el cambio de estado en el modelo de solucion
            $solucion = Solucion::create(['DescSolu' => $deritipo, 'id_user' => auth()->id(), 'id_asist' => $asist->id, 
                                        'tipo' => 'estado']);
        }
        
        //Envio de notificacion
            if (($request->ResuAsis == "SI")){
                $usersid = User::where('id', $asist->id_user)->get();
                $path = "/calificacion/".$asist->id."";
                foreach($usersid as $userid){
                    $notificationData = [
                        'title' => 'SALA',
                        'body'  => '¿Como calificaria nuestro servicio?',
                        'path'  =>  $path,
                    ];
                $this->notificationsService->sendToUser($userid->id, $notificationData);
                }
            }
         return redirect()->route('asist.index')->with('status_success', 'El estado de la asistencia se cambio correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\asist  $asist
     * @return \Illuminate\Http\Response
     */
    public function destroy(asist $asist)
    {
        //
    }
}
