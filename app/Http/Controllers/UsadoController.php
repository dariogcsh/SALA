<?php

namespace App\Http\Controllers;

use App\usado;
use App\User;
use App\sucursal;
use App\antena;
use App\pantalla;
use App\conectividad;
use App\imgusado;
use App\organizacion;
use Carbon\Carbon;
use App\interaccion;
use PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;


class UsadoController extends Controller
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
    public function usado_pdf($id){

        Gate::authorize('haveaccess','usado.show');
        $usado = Usado::where('id',$id)->first();
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usados']);
        $imagenes = Imgusado::where('id_usado', $usado->id)->get();
        $sucursal = Sucursal::where('id',$usado->id_sucursal)->first();
        if (isset($usado->id_antena)) {
            $antenas = Antena::where('id', $usado->id_antena)->first();
            $antena = $antenas->NombAnte;
        } else {
            $antena = "";
        }
        if (isset($usado->id_pantalla)) {
            $pantallas = Pantalla::where('id', $usado->id_pantalla)->first();
            $pantalla = $pantallas->NombPant;
        } else {
            $pantalla = "";
        }
        if (isset($usado->id_conectividad)) {
            $conectividads = Conectividad::where('id', $usado->id_conectividad)->first();
            $conectividad = $conectividads->nombre;
        } else {
            $conectividad = "";
        }
        $organizacion = Organizacion::where('id', auth()->user()->CodiOrga)->first();
        

        $data = [
          'imagenes' => count($imagenes),
          'sucursal' => $sucursal->NombSucu,
          'antena' => $antena,
          'pantalla' => $pantalla,
          'conectividad' => $conectividad,
          'organizacion' => $organizacion->NombOrga,
          'ingreso' => $usado->ingreso,
          'excliente' => $usado->excliente,
          'tipo' => $usado->tipo,
          'marca' => $usado->marca,
          'modelo' => $usado->modelo,
          'ano' => $usado->ano,
          'nserie' => $usado->nserie,
          'patente' => $usado->patente,
          'traccion' => $usado->traccion,
          'rodado' => $usado->rodado,
          'horasm' => $usado->horasm,
          'horast' => $usado->horast,
          'desparramador' => $usado->desparramador,
          'agprecision' => $usado->agprecision,
          'nrodado' => $usado->nrodado,
          'nrodadotras' => $usado->nrodadotras,
          'rodadoest' => $usado->rodadoest,
          'rodadoesttras' => $usado->rodadoesttras,
          'plataforma' => $usado->plataforma,
          'cabina' => $usado->cabina,
          'hp' => $usado->hp,
          'transmision' => $usado->transmision,
          'nseriemotor' => $usado->nseriemotor,
          'tomafuerza' => $usado->tomafuerza,
          'bombah' => $usado->bombah,
          'botalon' => $usado->botalon,
          'tanque' => $usado->tanque,
          'picos' => $usado->picos,
          'corte' => $usado->corte,
          'categoria' => $usado->categoria,
          'surcos' => $usado->surcos,
          'monitor' => $usado->monitor,
          'dosificador' => $usado->dosificador,
          'fertilizacion' => $usado->fertilizacion,
          'tolva' => $usado->tolva,
          'fertilizante' => $usado->fertilizante,
          'distancia' => $usado->distancia,
          'reqhidraulico' => $usado->reqhidraulico,
          'estado' => $usado->estado,
          'precio' => $usado->precio,
          'comentarios' => $usado->comentarios,
          'fechafact' => $usado->fechafact,
          'fechareserva' => $usado->fechareserva,
          'fechahasta' => $usado->fechahasta,
          'activacion_antena' => $usado->activacion_antena,
          'activacion_pantalla' => $usado->activacion_pantalla,
          'camaras' => $usado->camaras,
          'prodrive' => $usado->prodrive,
          'configuracion_roto' => $usado->configuracion_roto,
          'cantidad_rollos' => $usado->cantidad_rollos,
          'ancho_plataforma' => $usado->ancho_plataforma,
          'espaciamiento' => $usado->espaciamiento,
          'cutter' => $usado->cutter,
          'monitor_roto' => $usado->monitor_roto,
          'precio_reparacion' => $usado->precio_reparacion,
          'comentario_reparacion' => $usado->comentario_reparacion,
        ];

        for ($i = 1; $i <= count($imagenes); $i++) { 
            $data['imagen'.$i] = $imagenes[$i - 1]->ruta;
        }

        $pdf = PDF::loadView('pdf_usado/usado_pdf', $data);
    
        $nombre_pdf = 'usado' . $id . '.pdf';
        return $pdf->download($nombre_pdf);
    }

    public function index(Request $request)
    {
        Gate::authorize('haveaccess','usado.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usados']);
        $rutavolver = route('internoventas');

        if($request->tipo_maquina){
            if($request->tipo_maquina == "PLATAFORMA"){
                $usados = Usado::where([['tipo','LIKE','%PLATAFORMA%'],['estado','<>','Vendido']])
                                ->orderBy('id','desc')->paginate(20);
            }elseif($request->tipo_maquina == "EQUIPOS VENDIDOS"){
                $usados = Usado::where('estado','Vendido')
                                ->orderBy('id','desc')->paginate(20);
            }else{
                $usados = Usado::where([['tipo',$request->tipo_maquina],['estado','<>','Vendido']])
                                ->orderBy('id','desc')->paginate(20);
            }
            
            $tipo_maquina = $request->tipo_maquina;
        } else {
            $usados = Usado::where([['tipo','COSECHADORA'],['estado','<>','Vendido']])
                            ->orderBy('id','desc')->paginate(20);
            $tipo_maquina = 'COSECHADORA';
        }

        return view('usado.index', compact('usados','rutavolver','tipo_maquina'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','usado.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usados']);
        $sucursales = Sucursal::get();
        $vendedores = User::select('users.id', 'users.name', 'users.last_name')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->where('puesto_empleados.NombPuEm','Vendedor')
                            ->orWhere('puesto_empleados.NombPuEm','Gerente comercial')
                            ->orWhere('puesto_empleados.NombPuEm','Gerente de usados')
                            ->orderBy('users.last_name')
                            ->get();
        $antenas = Antena::orderBy('id','desc')->get();
        $pantallas = Pantalla::orderBy('id','desc')->get();
        $conectividads = Conectividad::orderBy('id','desc')->get();
        $rutavolver = route('usado.index');
        return view('usado.create', compact('sucursales','vendedores','rutavolver','antenas','pantallas','conectividads'));
    }

    public function createUpdate($id_usado)
    {
        Gate::authorize('haveaccess','usado.create');
        // Por defecto si llego a esta función le asigno el paso 2 del formulario
        $tipomaq = '';
        $formimage = '';
      

        //Consulto el registro completo segun el id_usado
        $usado = Usado::where('id',$id_usado)->first();
        $tipomaq = $usado->tipo;
        if ($tipomaq == "COSECHADORA"){
            $paso = 21;
        } elseif ($tipomaq == "TRACTOR"){
            $paso = 22;
        } elseif ($tipomaq == "PULVERIZADORA"){
            $paso = 23;
        } elseif ($tipomaq == "SEMBRADORA"){
            $paso = 24;
        } elseif (($tipomaq == "PLATAFORMA DE MAIZ") OR ($tipomaq == "PLATAFORMA DE GIRASOL")){
            $paso = 35;
        } elseif (($tipomaq == "PLATAFORMA SINFIN") OR ($tipomaq == "PLATAFORMA DRAPER")){
            $paso = 36;
        } elseif ($tipomaq == "ROTOENFARDADORA"){
            $paso = 37;
        }

        //Asigno el paso que le tocaria segun los campos que no estan vacios
        if ((!empty($usado->surcos)) AND ($tipomaq == 'SEMBRADORA')){
            $paso = 32;
        }elseif ((!empty($usado->horasm)) AND ($tipomaq == 'PULVERIZADORA')){
            $paso = 33;
        }elseif ((!empty($usado->horasm)) AND ($tipomaq <> 'SEMBRADORA')){
            $paso = 31;
        }elseif (((!empty($usado->espaciamiento)) AND ($tipomaq == 'PLATAFORMA DE MAIZ')) OR (!empty($usado->espaciamiento)) AND ($tipomaq == 'PLATAFORMA DE GIRASOL')){
            $paso = 4;
        }elseif (((!empty($usado->ancho_plataforma)) AND ($tipomaq == 'PLATAFORMA SINFIN') OR (!empty($usado->ancho_plataforma)) AND ($tipomaq == 'PLATAFORMA DRAPER'))){
            $paso = 4;
        }elseif ((!empty($usado->configuracion_roto)) AND ($tipomaq == 'ROTOENFARDADORA')){
            $paso = 4;
        }
        
        if (!empty($usado->rodadoest)){
            $paso = 4;
        }
       
        // Consulto la cantidad de imagenes que tengo segun el id_usado
        $cantimagenes = Imgusado::where('id_usado',$id_usado)->count();
        if($cantimagenes >= 3){
            $paso = 5;
        }

        
            $sucursales = Sucursal::get();
            $vendedores = User::select('users.id', 'users.name', 'users.last_name')
                                ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                                ->where('puesto_empleados.NombPuEm','Vendedor')
                                ->orWhere('puesto_empleados.NombPuEm','Gerente comercial')
                                ->orWhere('puesto_empleados.NombPuEm','Gerente de usados')
                                ->orderBy('users.last_name')
                                ->get();

        $antenas = Antena::orderBy('id','desc')->get();
        $pantallas = Pantalla::orderBy('id','desc')->get();
        $conectividads = Conectividad::orderBy('id','desc')->get();
        if ($paso == 5){
            $formimage = "paso5";
        }
        $rutavolver = route('usado.index');
        return view('usado.create', compact('sucursales','vendedores','formimage','id_usado', 'paso','rutavolver',
                                            'antenas','pantallas','conectividads','usado'));  
    }

    public function hacerDisponible($id_usado)
    {
        $usado = Usado::where('id',$id_usado)->first();
        $usado->update(['estado' => 'Disponible', 'fechareserva' => null, 'fechahasta' => null, 'reservado_para' => null]);
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
                            $query->where('puesto_empleados.NombPuEm', 'Vendedor');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente general');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de usados');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->Where('puesto_empleados.NombPuEm', 'Gerente comercial');
                        })
                        ->get();

                foreach($usersends as $usersend){
                    $notificationData = [
                        'title' => 'SALA - Usados | DISPONIBLE',
                        'body' => 'Se ha vuelto a disponibilizar un equipo usado '.$usado->tipo.' '.$usado->marca.' '.$usado->modelo.' año '.$usado->ano.' ex '.$usado->excliente.' esta disponible nuevamente',
                        'path' => '/usado/'.$id_usado.'',
                    ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
        return redirect()->route('usado.index')->with('status_success', 'El usado ya se encuentra disponible nuevamente');
    }

    public function vendido($id_usado)
    {
        $usado = Usado::where('id',$id_usado)->first();
        $usado->update(['estado' => 'Vendido', 'fechareserva' => null, 'fechahasta' => null]);
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
                            $query->where('puesto_empleados.NombPuEm', 'Vendedor');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente general');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de usados');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->Where('puesto_empleados.NombPuEm', 'Gerente comercial');
                        })
                        ->get();

                foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'SALA - Usados | VENDIDO',
                    'body' => 'Se ha vendido un equipo usado '.$usado->tipo.' '.$usado->marca.' '.$usado->modelo.' año '.$usado->ano.'',
                    'path' => '/usado/'.$id_usado.'',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
        return redirect()->route('usado.index')->with('status_success', 'Usado marcado como vendido');
    }

    public function reservaVendedor(Request $request)
    {
        $id_usado = $request->id_usado;
        $usado = Usado::where('id',$id_usado)->first();
        $cliente = $request->cliente;
        $hoy = Carbon::now();
        $hasta = $hoy->addDay(2);
        $reserva_hasta = $hasta->format('Y-m-d');
        $id_usuario = auth()->user()->id;
        $usado->update(['estado' => 'Reservado', 'fechareserva' => $hoy, 'fechahasta' => $reserva_hasta, 
                        'id_vreserva' => $id_usuario, 'reservado_para' => $cliente]);

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
                            $query->where('puesto_empleados.NombPuEm', 'Vendedor');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente general');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de usados');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->Where('puesto_empleados.NombPuEm', 'Gerente comercial');
                        })
                        ->get();

                foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'SALA - Usados | RESERVADO',
                    'body' => 'Se ha reservado un equipo usado '.$usado->tipo.' '.$usado->marca.' '.$usado->modelo.' año '.$usado->ano.' para el cliente '.$cliente.'',
                    'path' => '/usado/'.$id_usado.'',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }

            return response()->json(["success"=>true,"result"=>$id_usado,"url"=> route("usado.index")]);
    }

    public function reservaForm($id_usado)
    {
        $rutavolver = route('usado.index');
        return view('usado.reservaForm', compact('id_usado','rutavolver'));
    }

    public function reservado(Request $request)
    {
        request()->validate([
            'fechahasta' => 'required',
        ]);

        $usado = Usado::where('id', $request->id_usado)->first();
        $hoy = Carbon::now();
        $request->request->add(['estado' => 'Reservado']);
        $request->request->add(['fechareserva' => $hoy]);
        $usado->update($request->all());

        return redirect()->route('usado.index')->with('status_success', 'Usado reservado con éxito');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\usado  $usado
     * @return \Illuminate\Http\Response
     */
    public function show(usado $usado)
    {
        Gate::authorize('haveaccess','usado.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usados']);
        $imagenes = Imgusado::where('id_usado', $usado->id)->get();
        $sucursal = Sucursal::where('id',$usado->id_sucursal)->first();
        $antena = Antena::where('id', $usado->id_antena)->first();
        $pantalla = Pantalla::where('id', $usado->id_pantalla)->first();
        $conectividad = Conectividad::where('id', $usado->id_conectividad)->first();
        $organizacion = Organizacion::where('id', auth()->user()->CodiOrga)->first();
        $vendedor = User::where('id', $usado->id_vendedor)->first();
        $vreserva = User::where('id', $usado->id_vreserva)->first();
        $rutavolver = url()->previous();

        return view('usado.view', compact('usado','imagenes','sucursal','organizacion','vendedor','vreserva','rutavolver',
                                        'antena','pantalla','conectividad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\usado  $usado
     * @return \Illuminate\Http\Response
     */
    public function edit(usado $usado)
    {
        Gate::authorize('haveaccess','usado.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usados']);
        $rutavolver = route('usado.index');

        return view('usado.edit', compact('usado','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\usado  $usado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, usado $usado)
    {
        Gate::authorize('haveaccess','usado.edit');
        
        // Controles de checked switch
        if(isset($request->agprecision)){
            $agricprecision = $request->agprecision;
            if($agricprecision == 'on'){
                $request->request->add(['agprecision' => 'SI']);
            } else {
                $request->request->add(['agprecision' => 'NO']);
            }
        } elseif (isset($request->nrodado)) {
            $request->request->add(['agprecision' => 'NO']);
        }

        if(isset($request->camaras)){
            $camara = $request->camaras;
            if($camara == 'on'){
                $request->request->add(['camaras' => 'SI']);
            } else {
                $request->request->add(['camaras' => 'NO']);
            }
        } elseif (isset($request->nrodado)) {
            $request->request->add(['camaras' => 'NO']);
        }

        if(isset($request->prodrive)){
            $harvest_smart = $request->prodrive;
            if($harvest_smart == 'on'){
                $request->request->add(['prodrive' => 'SI']);
            } else {
                $request->request->add(['prodrive' => 'NO']);
            }
        } elseif (isset($request->nrodado)) {
            $request->request->add(['prodrive' => 'NO']);
        }

        if(isset($request->cabina)){
            $scabina = $request->cabina;
            if($scabina == 'on'){
                $request->request->add(['cabina' => 'SI']);
            } else {
                $request->request->add(['cabina' => 'NO']);
            }
        } elseif (isset($request->traccion)) {
            $request->request->add(['cabina' => 'NO']);
        }

        if(isset($request->tomafuerza)){
            $stomafuerza = $request->tomafuerza;
            if($stomafuerza == 'on'){
                $request->request->add(['tomafuerza' => 'SI']);
            } else {
                $request->request->add(['tomafuerza' => 'NO']);
            }
        } elseif (isset($request->traccion)) {
            $request->request->add(['tomafuerza' => 'NO']);
        }

        if(isset($request->corte)){
            $scorte = $request->corte;
            if($scorte == 'on'){
                $request->request->add(['corte' => 'SI']);
            } else {
                $request->request->add(['corte' => 'NO']);
            }
        } elseif (isset($request->tanque)) {
            $request->request->add(['corte' => 'NO']);
        }

        if(isset($request->monitor_roto)){
            $monitor = $request->monitor_roto;
            if($monitor == 'on'){
                $request->request->add(['monitor_roto' => 'SI']);
            } else {
                $request->request->add(['monitor_roto' => 'NO']);
            }
        }  elseif (isset($request->configuracion_roto)) {
            $request->request->add(['monitor_roto' => 'NO']);
        }

        if(isset($request->cutter)){
            $roto_cutter = $request->cutter;
            if($roto_cutter == 'on'){
                $request->request->add(['cutter' => 'SI']);
            } else {
                $request->request->add(['cutter' => 'NO']);
            }
        }  elseif (isset($request->configuracion_roto)) {
            $request->request->add(['cutter' => 'NO']);
        }

        $alldata = $request->except('paso'); // save all exceptthe id_usado
        $usado->update($alldata);
        $paso = $request->get('paso'); 
        $tipomaq = $usado->tipo;

        $imagenes = Imgusado::where('id_usado',$usado->id)->get();
        if($paso == 5){
            return redirect()->route('usado.index')->with('status_success', 'Usado modificado con éxito');
        } elseif($paso == 4){
            $paso = 5;
        } elseif(($paso == 31) OR ($paso == 32) OR ($paso == 33) OR ($paso == 35) OR ($paso == 36) OR ($paso == 37)){
            $paso = 4;
        } elseif (($paso == 21) OR ($paso == 22)){
            $paso = 31;
        } elseif ($paso == 23){
            $paso = 33;
        } elseif ($paso == 24){
            $paso = 32;
        } elseif ($paso == '1'){
            if($tipomaq == "COSECHADORA"){
                $paso = 21;
            } elseif ($tipomaq == "TRACTOR"){
                $paso = 22;
            } elseif ($tipomaq == "PULVERIZADORA"){
                $paso = 23;
            } elseif ($tipomaq == "SEMBRADORA"){
                $paso = 24;
            }
            elseif (($tipomaq == "PLATAFORMA DE MAIZ") OR ($tipomaq == "PLATAFORMA DE GIRASOL")){
                $paso = 35;
            }
            elseif (($tipomaq == "PLATAFORMA SINFIN") OR $tipomaq == "PLATAFORMA DRAPER"){
                $paso = 36;
            }
            elseif ($tipomaq == "ROTOENFARDADORA"){
                $paso = 37;
            }
        }
        $antenas = Antena::orderBy('id','desc')->get();
        $pantallas = Pantalla::orderBy('id','desc')->get();
        $conectividads = Conectividad::orderBy('id','desc')->get();
        return view('usado.edit', compact('usado','paso','imagenes','antenas','pantallas','conectividads'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\usado  $usado
     * @return \Illuminate\Http\Response
     */
    public function destroy(usado $usado)
    {
        //
        Gate::authorize('haveaccess','usado.destroy');
        $fotos = imgusado::where('id_usado',$usado->id)->get();
        if(isset($fotos)){
            foreach ($fotos as $foto) {
                $foto->delete();
            }
        }
        $usado->delete();
        return redirect()->route('usado.index')->with('status_success', 'Usado eliminada con exito');
    }

    public function eliminar_carga(Request $request)
    {
        //
        Gate::authorize('haveaccess','usado.destroy');
        $usado = Usado::where('id',$request->id_usado)->first();
        $fotos = imgusado::where('id_usado',$usado->id)->get();
        if(isset($fotos)){
            foreach ($fotos as $foto) {
                $foto->delete();
            }
        }
        $usado->delete();
    }

    // Funcion que rellena el Select de marca
    public function seleccionMarca(Request $request){
        $tipo = $request->get('tipomaq');
        $output = '<option value="">Seleccionar</option>';
        
        if ($tipo == "COSECHADORA"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="MASSEY FERGUSON">MASSEY FERGUSON</option>';
            $output .='<option value="CASE IH">CASE IH</option>';
            $output .='<option value="NEW HOLLAND">NEW HOLLAND</option>';
            $output .='<option value="CLASS">CLASS</option>';
            $output .='<option value="OTRA">OTRA</option>';
        } elseif ($tipo == "TRACTOR"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="MASSEY FERGUSON">MASSEY FERGUSON</option>';
            $output .='<option value="CASE IH">CASE IH</option>';
            $output .='<option value="NEW HOLLAND">NEW HOLLAND</option>';
            $output .='<option value="PAUNY">PAUNY</option>';
            $output .='<option value="VALTRA">VALTRA</option>';
            $output .='<option value="AGCO ALIS">AGCO ALIS</option>';
            $output .='<option value="OTRA">OTRA</option>';
        } elseif($tipo == "PULVERIZADORA"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="PLA">PLA</option>';
            $output .='<option value="METALFOR">METALFOR</option>';
            $output .='<option value="CAIMAN">CAIMAN</option>';
            $output .='<option value="JACTO">JACTO</option>';
            $output .='<option value="OTRA">OTRA</option>';
        } elseif($tipo == "SEMBRADORA"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="PLA">PLA</option>';
            $output .='<option value="AGROMETAL">AGROMETAL</option>';
            $output .='<option value="PIEROBON">PIEROBON</option>';
            $output .='<option value="CRUCIANELLI">CRUCIANELLI</option>';
            $output .='<option value="CELA">CELA</option>';
            $output .='<option value="ASCANELLI">ASCANELLI</option>';
            $output .='<option value="FERCAM">FERCAM</option>';
            $output .='<option value="SUPER WALTER">SUPER WALTER</option>';
            $output .='<option value="TANZZI">TANZZI</option>';
            $output .='<option value="ERCA">ERCA</option>';
            $output .='<option value="APACHE">APACHE</option>';
            $output .='<option value="FABIGAM">FABIGAM</option>';
            $output .='<option value="OTRA">OTRA</option>';
        } elseif($tipo == "PLATAFORMA DE MAIZ"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="CASE">CASE</option>';
            $output .='<option value="NEW HOLLAND">NEW HOLLAND</option>';
            $output .='<option value="MAINERO">MAINERO</option>';
            $output .='<option value="ALLOCHIS">ALLOCHIS</option>';
            $output .='<option value="MAZCO">MAZCO</option>';
            $output .='<option value="OMBU">OMBU</option>';
            $output .='<option value="PIERSANTI">PIERSANTI</option>';
            $output .='<option value="DEGRANDE">DEGRANDE</option>';
            $output .='<option value="STARA">STARA</option>';
            $output .='<option value="OTRA">OTRA</option>';
        } elseif($tipo == "PLATAFORMA DE GIRASOL"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="CASE">CASE</option>';
            $output .='<option value="NEW HOLLAND">NEW HOLLAND</option>';
            $output .='<option value="MAINERO">MAINERO</option>';
            $output .='<option value="YHOMEL">YHOMEL</option>';
            $output .='<option value="ALLOCHIS">ALLOCHIS</option>';
            $output .='<option value="MAZCO">MAZCO</option>';
            $output .='<option value="OMBU">OMBU</option>';
            $output .='<option value="PIERSANTI">PIERSANTI</option>';
            $output .='<option value="DEGRANDE">DEGRANDE</option>';
            $output .='<option value="STARA">STARA</option>';
            $output .='<option value="OTRA">OTRA</option>';
        } elseif($tipo == "PLATAFORMA SIN FIN"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="CASE">CASE</option>';
            $output .='<option value="NEW HOLLAND">NEW HOLLAND</option>';
            $output .='<option value="MAINERO">MAINERO</option>';
            $output .='<option value="ALLOCHIS">ALLOCHIS</option>';
            $output .='<option value="MAZCO">MAZCO</option>';
            $output .='<option value="OMBU">OMBU</option>';
            $output .='<option value="PIERSANTI">PIERSANTI</option>';
            $output .='<option value="DEGRANDE">DEGRANDE</option>';
            $output .='<option value="STARA">STARA</option>';
            $output .='<option value="OTRA">OTRA</option>';
        } elseif($tipo == "PLATAFORMA DRAPER"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="CASE">CASE</option>';
            $output .='<option value="NEW HOLLAND">NEW HOLLAND</option>';
            $output .='<option value="MAINERO">MAINERO</option>';
            $output .='<option value="ALLOCHIS">ALLOCHIS</option>';
            $output .='<option value="MAZCO">MAZCO</option>';
            $output .='<option value="OMBU">OMBU</option>';
            $output .='<option value="PIERSANTI">PIERSANTI</option>';
            $output .='<option value="DEGRANDE">DEGRANDE</option>';
            $output .='<option value="STARA">STARA</option>';
            $output .='<option value="OTRA">OTRA</option>';
        } elseif($tipo == "ROTOENFARDADORA"){
            $output .='<option value="JOHN DEERE">JOHN DEERE</option>';
            $output .='<option value="CASE">CASE</option>';
            $output .='<option value="VALTRA">VALTRA</option>';
            $output .='<option value="MAINERO">MAINERO</option>';
            $output .='<option value="YOMEL">YOMEL</option>';
            $output .='<option value="MASSEY FERGUSON">MASSEY FERGUSON</option>';
            $output .='<option value="NEW HOLLAND">NEW HOLLAND</option>';
            $output .='<option value="IMPLECOR">IMPLECOR</option>';
            $output .='<option value="KRONE">KRONE</option>';
            $output .='<option value="KUHN">KUHN</option>';
            $output .='<option value="CHALLENGER">CHALLENGER</option>';
            $output .='<option value="AGCO ALLIS">AGCO ALLIS</option>';
            $output .='<option value="MAIZCO">MAIZCO</option>';
            $output .='<option value="OTRA">OTRA</option>';
        }

        echo $output;
    }

    public function pasoUno(Request $request){

        $request->request->add(['estado' => 'Progreso']);
        $crear = Usado::create($request->all());

        //echo $crear->id;
        return response()->json(["success"=>true,"result"=>$crear->id,"url"=> route("usado.createUpdate",$crear->id)]);
    }

    public function pasoDosTresCuatro(Request $request, usado $usado)
    {
        
        $id_usado = $request->get('id_usado');

        // verifico un atributo que se encuentra en el último paso (Paso5)
        if (isset($request->precio))
        {
            $request->request->add(['estado' => 'Disponible']); // Agrego la modificacion del estado

            // Aqui deberia notificar a todos los clientes
        }

        $alldata = $request->except('id_usado'); // save all exceptthe id_usado
        $usado = Usado::where('id', $id_usado)->first();

        //verifico que haya tenido precio anteriormente para saber si es nuevo registro o modificacion
        $precio_usado = $usado->precio;

        $usado->update($alldata); // change all except id_usado

        // verifico un atributo que se encuentra en el último paso (Paso5)
        if (isset($request->id_vendedor))
        {
            if(!isset($precio_usado)){
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
                            $query->where('puesto_empleados.NombPuEm', 'Vendedor');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente general');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de usados');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->Where('puesto_empleados.NombPuEm', 'Gerente comercial');
                        })
                        ->get();

                foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'SALA - Usados',
                    'body' => 'Se ha registrado un equipo usado '.$usado->tipo.' '.$usado->marca.' '.$usado->modelo.' año '.$usado->ano.'',
                    'path' => '/usado/'.$id_usado.'',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
                }
            }
            Session::flash('status_success', 'Usado registrado exitosamente');
            return route('usado.index');
           
        }

        return response()->json(["success"=>true,"result"=>$id_usado,"url"=> route("usado.createUpdate",$id_usado)]);
    }
}
