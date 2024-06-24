<?php

namespace App\Http\Controllers;

use App\ordentrabajo;
use App\organizacion;
use App\interaccion;
use App\insumo;
use App\mezcla;
use App\mezcla_insu;
use App\User;
use App\lote;
use App\orden_insumo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\NotificationsService;
use Illuminate\Support\Facades\Gate;

class OrdentrabajoController extends Controller
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
        Gate::authorize('haveaccess','ordentrabajo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ordenes de trabajo']);
        $rutavolver = route('home');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        if ($organizacion->NombOrga == "Sala Hnos"){
            $ordentrabajos = Ordentrabajo::select('ordentrabajos.id','id_usuariotrabajo','id_usuarioorden','fechaindicada','fechainicio',
                                                'fechafin','has','estado','tipo','organizacions.NombOrga','lotes.name',
                                                'lotes.client','lotes.farm','organizacions.NombOrga','ordentrabajos.prescripcion')
                                        ->join('lotes','ordentrabajos.id_lote','=','lotes.id')
                                        ->join('organizacions','ordentrabajos.id_organizacion','=','organizacions.id')
                                        ->orderBy('ordentrabajos.id','desc')->paginate(20);
        } else {
            $ordentrabajos = Ordentrabajo::select('ordentrabajos.id','id_usuariotrabajo','id_usuarioorden','fechaindicada','fechainicio',
                                                'fechafin','has','estado','tipo','organizacions.NombOrga','lotes.name',
                                                'lotes.client','lotes.farm','ordentrabajos.prescripcion')
                                        ->join('lotes','ordentrabajos.id_lote','=','lotes.id')
                                        ->join('organizacions','ordentrabajos.id_organizacion','=','organizacions.id')
                                        ->where('id_organizacion',$organizacion->id)
                                        ->orderBy('ordentrabajos.id','desc')->paginate(20);
        }
        return view('ordentrabajo.index', compact('ordentrabajos','rutavolver','organizacion'));
    }

    function flote(Request $request)
    {
        $value = $request->get('value');

        $CodiOrga = Organizacion::where('id',$value)->first();
        
        $data = Lote::where('org_id', $CodiOrga->CodiOrga)->get();
        $output = '<option value="">Seleccionar Lote</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->id.'">'.$row->client.' - ' .$row->farm.' - ' .$row->name.'</option>';
        }
        echo $output;

    }

    function fusuario(Request $request)
    {
        $select = 'CodiOrga';
        $value = $request->get('value');
        
        $data = User::where($select, $value)->get();
        $output = '<option value="">Seleccionar Usuario</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->id.'">'.$row->name.' - ' .$row->last_name.'</option>';
        }
        echo $output;

    }

    function fproducto(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        
        $data = Insumo::where($select, $value)
                        ->orderBy('nombre','asc')->get();
        $output = '<option value="">Seleccionar producto</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->nombre.'">'.$row->categoria.' - ' .$row->nombre.'</option>';
        }
        echo $output;

    }

    public function historial(Request $request)
    {
        Gate::authorize('haveaccess','ordentrabajo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ordenes de trabajo']);
        $rutavolver = route('ordentrabajo.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $filtro="";
        $busqueda="";
        if(($request->id_organizacion) OR ($request->tipo) OR ($request->id_lote) OR ($request->producto) OR 
            ($request->id_usuariotrabajo) OR ($request->estado) OR ($request->fechainicio) OR ($request->fechafin)){
            $tipo = 'id_organizacion';
            $busqueda = $request->get('id_organizacion');
            $fechainicio = $request->get('fechainicio');
            $fechafin = $request->get('fechafin');
            $tipotrabajo = $request->get('tipo');
            $lote = $request->get('id_lote');
            $producto = $request->get('producto');
            $operario = $request->get('id_usuariotrabajo');
            $estado = $request->get('estado');
            $variablesurl=$request->all();
            
            $ordentrabajos = Ordentrabajo::select('ordentrabajos.id','id_usuariotrabajo','users.name as uname','users.last_name',
                                                'fechaindicada','fechainicio','fechafin','has','estado','tipo',
                                                'organizacions.NombOrga','lotes.name','lotes.client','lotes.farm',
                                                'ordentrabajos.prescripcion')
                                        ->join('lotes','ordentrabajos.id_lote','=','lotes.id')
                                        ->join('organizacions','ordentrabajos.id_organizacion','=','organizacions.id')
                                        ->join('users','ordentrabajos.id_usuariotrabajo','=','users.id')
                                        ->Buscar($tipo, $busqueda)
                                        ->Fecha($fechainicio, $fechafin)
                                        ->Lote($lote)
                                        ->Trabajo($tipotrabajo)
                                        ->Producto($producto)
                                        ->Operario($operario)
                                        ->Estado($estado)
                                        ->orderBy('ordentrabajos.id','desc')
                                        ->paginate(20)->appends($variablesurl);
            $filtro = "SI";
            if ($organizacion->NombOrga == "Sala Hnos"){
                $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
            }else{
                $organizaciones = Organizacion::where('id',$organizacion->id);
            }
        } else{
            if ($organizacion->NombOrga == "Sala Hnos"){
                $ordentrabajos = Ordentrabajo::select('ordentrabajos.id','id_usuariotrabajo','users.name as uname','users.last_name',
                                                    'fechaindicada','fechainicio','fechafin','has','estado','tipo',
                                                    'organizacions.NombOrga','lotes.name','lotes.client','lotes.farm',
                                                    'ordentrabajos.prescripcion')
                                            ->join('lotes','ordentrabajos.id_lote','=','lotes.id')
                                            ->join('organizacions','ordentrabajos.id_organizacion','=','organizacions.id')
                                            ->join('users','ordentrabajos.id_usuariotrabajo','=','users.id')
                                            ->orderBy('ordentrabajos.id','desc')->paginate(20);
                $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
            } else {
                $ordentrabajos = Ordentrabajo::select('ordentrabajos.id','id_usuariotrabajo','users.name as uname','users.last_name',
                                                    'fechaindicada','fechainicio','fechafin','has','estado','tipo',
                                                    'organizacions.NombOrga','lotes.name','lotes.client','lotes.farm',
                                                    'ordentrabajos.prescripcion')
                                            ->join('lotes','ordentrabajos.id_lote','=','lotes.id')
                                            ->join('organizacions','ordentrabajos.id_organizacion','=','organizacions.id')
                                            ->join('users','ordentrabajos.id_usuariotrabajo','=','users.id')
                                            ->where('ordentrabajos.id_organizacion',$organizacion->id)
                                            ->orderBy('ordentrabajos.id','desc')->paginate(20);
                $organizaciones = Organizacion::where('id',$organizacion->id)
                                            ->orderBy('NombOrga','asc')->get();
            }
        }

        $total = 0;
        return view('ordentrabajo.historial', compact('ordentrabajos','rutavolver','organizacion', 'organizaciones','filtro',
                                                        'busqueda','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','ordentrabajo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ordenes de trabajo']);
        $rutavolver = route('ordentrabajo.index');
        $organizacion = auth()->user()->CodiOrga;
        $usuarioorden = User::where('id',auth()->user()->id)->first();
        $insumos = Insumo::where('id_organizacion', auth()->user()->CodiOrga)
                        ->orderBy('nombre','asc')->get();
        $mezclas = Mezcla::where('id_organizacion', auth()->user()->CodiOrga)
                        ->orderBy('nombre','asc')->get();
        $usuarios = User::where('CodiOrga',auth()->user()->CodiOrga)->get();
        
        $lotes = Lote::select('lotes.id','lotes.name','lotes.farm','lotes.client')
                    ->join('organizacions','lotes.org_id','=','organizacions.CodiOrga')
                    ->where('organizacions.id',auth()->user()->CodiOrga)
                    ->orderBy('lotes.name','asc')
                    ->get();
                
        

        return view('ordentrabajo.create',compact('rutavolver','organizacion','insumos','mezclas','usuarioorden','usuarios',
                                                'lotes'));
    }

    function insumezcla(Request $request)
    {
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ordenes de trabajo']);
        $value = $request->get('value');
        $iddiv = $request->get('iddiv');
        $nombrecampo = $request->get('nombrecampo');
        $st = stripos($nombrecampo, "id_mezcla");

        if ($st === false){
            $datos = 'Insumo';
            $arr = explode("o",$iddiv);
            $id = $arr[1];
            $data = Insumo::where('id',$value)->first();
            $cbox = '<option value="'.$data->unidades_medidas.'">'.$data->unidades_medidas.'</option>';
                    $cbox .= '<option value="semillas/ha">semillas/ha</option>';
                    $cbox .= '<option value="lts/ha">lts/ha</option>';
                    $cbox .= '<option value="kg/ha">kg/ha</option>';
            $unidades_medidas = $cbox;
            return response()->json(["datos"=>$datos, 'unidades_medidas'=>$unidades_medidas, 'id'=>$id]);
        } else {
            $datos = 'Mezcla';
            $data = Mezcla::select('insumos.id as id','insumos.nombre as nombreinsu','marcainsumos.nombre as nombremarca',
                                    'mezcla_insus.cantidad', 'mezclas.id as id_mezcla','insumos.unidades_medidas')
                            ->join('mezcla_insus','mezclas.id','=','mezcla_insus.id_mezcla')
                            ->join('insumos','mezcla_insus.id_insumo','=','insumos.id')
                            ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                            ->where('mezclas.id', $value)->get();
            
            $i=1;
            $x=$iddiv;
            if (isset($data)) {
                foreach ($data as $row)
                {
                    $id[$i] = $row->id;
                    $id_mezcla[$i] = $row->id_mezcla;
                    $nombreinsu[$i] = $row->nombreinsu;
                    $nombremarca[$i] = $row->nombremarca;
                    $cantidad[$i] = $row->cantidad;
                    $cbox = '<option value="'.$row->unidades_medidas.'">'.$row->unidades_medidas.'</option>';
                    $cbox .= '<option value="semillas/ha">semillas/ha</option>';
                    $cbox .= '<option value="lts/ha">lts/ha</option>';
                    $cbox .= '<option value="kg/ha">kg/ha</option>';
                    $unidades_medidas[$i] = $cbox;
                    $i++;
                    $x++;
                }
                return response()->json(["id"=>$id,"nombreinsu"=>$nombreinsu,"nombremarca"=>$nombremarca,"cantidad"=>$cantidad,'i'=>$i,
                                        "datos"=>$datos,'x'=>$x,'id_mezcla'=>$id_mezcla, 'unidades_medidas'=>$unidades_medidas]);
            } else {
                return response()->json(["No se ha encontrado ningun insumo para la mezcla de tanque seleccionada"]);
            }
   
        }

    }

    function iniciar(Request $request)
    {
        $id = $request->get('id');
        $hoy = Carbon::today();
        $orden_trabajo = Ordentrabajo::where('id',$id)->first();
        $orden_trabajo->update(['estado' => "En ejecucion", 'fechainicio' => $hoy]);
        $info_trabajo = Ordentrabajo::select('lotes.name as namelote','users.name as nameuser','users.last_name','ordentrabajos.tipo',
                                            'lotes.farm','lotes.client','ordentrabajos.id_usuarioorden')
                                    ->join('lotes','ordentrabajos.id_lote','=','lotes.id')
                                    ->join('users','ordentrabajos.id_usuarioorden','=','users.id')
                                    ->where('ordentrabajos.id',$id)->first();
        //Envio de notificacion
            $notificationData = [
                'title' => 'SALA',
                'body' => ''.$info_trabajo->nameuser.' '.$info_trabajo->last_name.' ha INICIADO el trabajo de '.$info_trabajo->tipo.' en el lote '.$info_trabajo->namelote.' de la granja '.$info_trabajo->farm.' del cliente '.$info_trabajo->client.'',
                'path' => '/ordentrabajo',
            ];
            $this->notificationsService->sendToUser($info_trabajo->id_usuarioorden, $notificationData);
    }

    function terminar(Request $request)
    {
        $id = $request->get('id');
        $hoy = Carbon::today();
        $orden_trabajo = Ordentrabajo::where('id',$id)->first();
        $orden_insumos = Orden_insumo::where('id_ordentrabajo',$id)->get();

        if($orden_trabajo->tipo <> "Cosecha"){
            //Aviso de finalización de trabajo
            $info_trabajo = Ordentrabajo::select('lotes.name as namelote','users.name as nameuser','users.last_name','ordentrabajos.tipo',
                                                'lotes.farm','lotes.client','ordentrabajos.id_usuarioorden', 'orden_insumos.insumo')
                                        ->join('lotes','ordentrabajos.id_lote','=','lotes.id')
                                        ->join('users','ordentrabajos.id_usuariotrabajo','=','users.id')
                                        ->join('orden_insumos','ordentrabajos.id','=','orden_insumos.id_ordentrabajo')
                                        ->where('ordentrabajos.id',$id)->first();
        
            foreach ($orden_insumos as $orden_insumo) {
                
                if($orden_insumo->unidades>0){
                    $insumo_stock = Insumo::where([['id_organizacion',$orden_trabajo->id_organizacion], ['nombre',$orden_insumo->insumo]])->first();
                    if($orden_insumo->dosis_variable == "SI"){
                        $cantidad_total = $orden_insumo->unidades * $orden_insumo->has_variable;
                    }else{
                        $cantidad_total = $orden_insumo->unidades * $orden_trabajo->has;
                    }
                    $bultos_usados =  $cantidad_total / $insumo_stock->semillas;
                    $total = $insumo_stock->bultos - $bultos_usados;
                    $insumo_stock->update(['bultos' => $total]);
                } elseif($orden_insumo->lts>0){
                    $insumo_stock = Insumo::where([['id_organizacion',$orden_trabajo->id_organizacion], ['nombre',$orden_insumo->insumo]])->first();
                    if($orden_insumo->dosis_variable == "SI"){
                        $cantidad_total = $orden_insumo->lts * $orden_insumo->has_variable;
                    }else{
                        $cantidad_total = $orden_insumo->lts * $orden_trabajo->has;
                    }
                    $total = $insumo_stock->litros - $cantidad_total;
                    $insumo_stock->update(['litros' => $total]);
                }elseif($orden_insumo->kg>0){
                    $insumo_stock = Insumo::where([['id_organizacion',$orden_trabajo->id_organizacion], ['nombre',$orden_insumo->insumo]])->first();
                    if($orden_insumo->dosis_variable == "SI"){
                        $cantidad_total = $orden_insumo->kg * $orden_insumo->has_variable;
                    }else{
                        $cantidad_total = $orden_insumo->kg * $orden_trabajo->has;
                    }
                    $total = $insumo_stock->peso - $cantidad_total;
                    $insumo_stock->update(['peso' => $total]);
                }
                if ($total < 0){
                    //Envio de notificacion en caso de no tener stock
                    $notificationData = [
                        'title' => 'SALA',
                        'body' => 'El insumo/producto '.$info_trabajo->insumo.' se ha agotado de su depósito y puede que el stock del mismo quede negativo.',
                        'path' => '/ordentrabajo',
                    ];
                    $this->notificationsService->sendToUser($info_trabajo->id_usuarioorden, $notificationData);
                }
            }
        }else{
            //Aviso de finalización de trabajo
            $info_trabajo = Ordentrabajo::select('lotes.name as namelote','users.name as nameuser','users.last_name','ordentrabajos.tipo',
                                                'lotes.farm','lotes.client','ordentrabajos.id_usuarioorden')
                                        ->join('lotes','ordentrabajos.id_lote','=','lotes.id')
                                        ->join('users','ordentrabajos.id_usuariotrabajo','=','users.id')
                                        ->where('ordentrabajos.id',$id)->first();
        }

        $orden_trabajo->update(['estado' => "Finalizado", 'fechafin' => $hoy]);

        //Envio de notificacion
            $notificationData = [
                'title' => 'SALA',
                'body' => ''.$info_trabajo->nameuser.' '.$info_trabajo->last_name.' ha FINALIZADO el trabajo de '.$info_trabajo->tipo.' en el lote '.$info_trabajo->namelote.' de la granja '.$info_trabajo->farm.' del cliente '.$info_trabajo->client.'',
                'path' => '/ordentrabajo',
            ];
            $this->notificationsService->sendToUser($info_trabajo->id_usuarioorden, $notificationData);
            
    }

    function has_lote(Request $request)
    {
        $id_lote = $request->get('value');
        $lote = Lote::where('id',$id_lote)->first();
        echo ($lote->field_ha);
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
        $request->request->add(['estado' => 'Enviado']);
        if ($request->prescripcion){
            $request->request->add(['prescripcion' => 'SI']);
        }
        $ordentrabajos = Ordentrabajo::create($request->all());

        if ($request->dosis_variable){
            $variable = "SI";
        } else{
            $variable = "NO";
        }

        //Insumos
        for ($i=1; $i <= 20; $i++) { 
            $id_insumo = $request->get('id_insumo'.$i);
            $insumo_elegido = Insumo::where('id',$id_insumo)->first();
            
            if(isset($insumo_elegido)){
                $nombre_insumo = $insumo_elegido->nombre;
                $precio_insumo = $insumo_elegido->precio;
            } else {
                $nombre_insumo = "";
                $precio_insumo = "";
            }
            
            $cantidad = $request->get('cantidad'.$i);
            $has_variable = $request->get('has_variable'.$i);
            if (($nombre_insumo <> "") AND ($cantidad <> "")) {
                $medida = $request->get('unidades_medidas'.$i);
                if($medida == 'lts/ha'){
                    $unidad_medida = 'lts';
                }elseif($medida == 'kg/ha'){
                    $unidad_medida = 'kg';
                }else{
                    $unidad_medida = 'unidades';
                }

                $insumos = Orden_insumo::create(['id_ordentrabajo' => $ordentrabajos->id, 'insumo' => $nombre_insumo, 
                                                $unidad_medida => $cantidad, 'precio' => $precio_insumo, 
                                                'dosis_variable' => $variable, 'has_variable' => $has_variable]);
            }
            $insumo = "";
            $cantidad = "";
            $unidad_medida = "";
            $has_variable = "";
        }

        //Mezclas de tanque
        for ($i=1; $i <= 20; $i++) { 
            $id_mezcla = $request->get('id_mezcla'.$i);
            $insumos = Mezcla_insu::select('insumos.nombre','mezcla_insus.cantidad','insumos.precio')
                                    ->join('insumos','mezcla_insus.id_insumo','=','insumos.id')
                                    ->where('mezcla_insus.id_mezcla',$id_mezcla)->get();
            if ($id_mezcla <> "") {
                foreach ($insumos as $insumo) {
                    
                    $medida = Insumo::where([['nombre',$insumo->nombre], ['id_organizacion', $ordentrabajos->id_organizacion]])->first();
                    if($medida->unidades_medidas == 'lts/ha'){
                        $unidad_medida = 'lts';
                    }elseif($medida->unidades_medidas == 'kg/ha'){
                        $unidad_medida = 'kg';
                    }else{
                        $unidad_medida = 'unidades';
                    }
                    $has_variable_mez = $request->get('has_variable_mez'.$i);
                    $orden_insumo = Orden_insumo::create(['id_ordentrabajo' => $ordentrabajos->id, 'insumo' => $insumo->nombre, 
                                                $unidad_medida => $insumo->cantidad, 'id_mezcla' => $id_mezcla, 
                                                'precio' => $insumo->precio, 'dosis_variable' => $variable, 
                                                'has_variable' => $has_variable_mez]);
                }
            }
            $insumos = "";
            $unidad_medida = "";
            $has_variable_mez = "";
        }

        // selecciono el usuario que va a cumplir la orden y enviar la notificacion
        $usuariotrabajo = $request->get('id_usuariotrabajo');

        //Envio de notificacion
            $notificationData = [
                'title' => 'SALA',
                'body' => 'Tiene una nueva órden de trabajo',
                'path' => '/ordentrabajo',
            ];
            $this->notificationsService->sendToUser($usuariotrabajo, $notificationData);
        

        return redirect()->route('ordentrabajo.index')->with('status_success', 'Orden de trabajo creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ordentrabajo  $ordentrabajo
     * @return \Illuminate\Http\Response
     */
    public function show(ordentrabajo $ordentrabajo)
    {
        //
        Gate::authorize('haveaccess','ordentrabajo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ordenes de trabajo']);
        $rutavolver = route('ordentrabajo.index');
        $organizacion = auth()->user()->CodiOrga;
        $usuarioorden = User::where('id',$ordentrabajo->id_usuarioorden)->first();
        $usuariotrabajo = User::where('id',$ordentrabajo->id_usuariotrabajo)->first();
        $insumos = Orden_insumo::where('id_ordentrabajo', $ordentrabajo->id)->get();
   
        $lote = Lote::select('lotes.id','lotes.name','lotes.farm','lotes.client')
                    ->where('lotes.id',$ordentrabajo->id_lote)
                    ->first();
                  //dd($insumos);

        return view('ordentrabajo.view',compact('ordentrabajo','rutavolver','organizacion','insumos','mezclas','usuarioorden',
                    'usuariotrabajo','lote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ordentrabajo  $ordentrabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(ordentrabajo $ordentrabajo)
    {
        //
        Gate::authorize('haveaccess','ordentrabajo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ordenes de trabajo']);
        $rutavolver = route('ordentrabajo.index');
        $organizacion = auth()->user()->CodiOrga;
        $usuarioorden = User::where('id',$ordentrabajo->id_usuarioorden)->first();
        $usuariotrabajo = User::where('id',$ordentrabajo->id_usuariotrabajo)->first();
        $orden_insumos = Orden_insumo::where('id_ordentrabajo', $ordentrabajo->id)->get();
        $orden_mezclas = Orden_insumo::where([['id_ordentrabajo', $ordentrabajo->id], ['id_mezcla','<>','']])->get();
        $lotetrabajo = Lote::where('id',$ordentrabajo->id_lote)->first();
        $usuarios = User::where('CodiOrga',auth()->user()->CodiOrga)->get();
        $insumos = Insumo::where('id_organizacion', auth()->user()->CodiOrga)
                        ->orderBy('nombre','asc')->get();
        $mezclas = Mezcla::where('id_organizacion', auth()->user()->CodiOrga)
                        ->orderBy('nombre','asc')->get();

        $lotes = Lote::select('lotes.id','lotes.name','lotes.farm','lotes.client')
                        ->join('organizacions','lotes.org_id','=','organizacions.CodiOrga')
                        ->where('organizacions.id',auth()->user()->CodiOrga)
                        ->orderBy('lotes.name','asc')
                        ->get();
   
        return view('ordentrabajo.edit', compact('ordentrabajo','rutavolver','usuariotrabajo','lotetrabajo','lotes',
                                                'usuarios','lotetrbajo','organizacion','usuarioorden','insumos',
                                                'usuarios','orden_insumos','mezclas','orden_mezclas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ordentrabajo  $ordentrabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ordentrabajo $ordentrabajo)
    {
        //
        Gate::authorize('haveaccess','ordentrabajo.edit');
        $request->validate([
            'id_lote'          => 'required',
        ]);

        if ($request->prescripcion){
            $request->request->add(['prescripcion' => 'SI']);
        } else {
            $request->request->add(['prescripcion' => 'NO']);
        }

        if ($request->dosis_variable){
            $variable = "SI";
        } else{
            $variable = "NO";
        }
        $alerta_mezcla = 0;
        $alerta_insumo = 0;
     

        //Insumos
        for ($i=1; $i <= 20; $i++) { 
            $nombre_insumo = $request->get('id_insumo'.$i);
            $cantidad = $request->get('cantidad'.$i);
            $id_orden_insumo = $request->get('id_orden_insumo'.$i);
            $has_variable = $request->get('has_variable'.$i);
            
            if (($nombre_insumo <> "") AND ($cantidad <> "")) {
                $medida = $request->get('unidades_medidas'.$i);
                if($medida == 'lts/ha'){
                    $unidad_medida = 'lts';
                }elseif($medida == 'kg/ha'){
                    $unidad_medida = 'kg';
                }elseif($medida == 'semillas/ha'){
                    $unidad_medida = 'unidades';
                }
                //Controlo en la base de datos si la mezcla de tanque indicada se encuentra en la orden de trabajo
                $insumo_registrado = Orden_insumo::where('id',$id_orden_insumo)->first();
                $organiz = Ordentrabajo::where('id',$insumo_registrado->id_ordentrabajo)->first();
                $insumo_precio = Insumo::where([['id_organizacion', $organiz->id_organizacion], ['nombre', $nombre_insumo]])->first();
                if(isset($insumo_registrado)){
                    $alerta_insumo++;
                    $insumo_registrado->update(['lts'=>""]);
                    $insumo_registrado->update(['kg'=>""]);
                    $insumo_registrado->update(['unidades'=>""]);
                    $insumo_registrado->update([$unidad_medida => $cantidad, 'precio' => $insumo_precio->precio,
                                                'dosis_variable' => $variable,'has_variable' => $has_variable]);
                } else{
                    $insumos = Orden_insumo::create(['id_ordentrabajo' => $ordentrabajo->id, 'insumo' => $nombre_insumo, 
                                                $unidad_medida => $cantidad, 'precio' => $insumo_precio->precio]);
                }
            }
            $insumo = "";
            $cantidad = "";
            $unidad_medida = "";
        }

        //Mezclas de tanque
        for ($i=1; $i <= 200; $i++) { 
            $mezclaid = $request->get('delete_mezcla_id'.$i);
            $id_insumo_mez = $request->get('id_insumo_mez'.$i);
            $cantidad = $request->get('cantidad_mez'.$i);
            $has_variable_mez = $request->get('has_variable_mez'.$i);
            $id_orden_insumo_mez = $request->get('id_orden_insumo_mez'.$i);
           
            if (($mezclaid <> "") AND ($cantidad <> "")) {
                $medida = $request->get('unidades_medidas_mez'.$i);
                if($medida == 'lts/ha'){
                    $unidad_medida = 'lts';
                }elseif($medida == 'kg/ha'){
                    $unidad_medida = 'kg';
                }elseif($medida == 'semillas/ha'){
                    $unidad_medida = 'unidades';
                }
                //Controlo en la base de datos si la mezcla de tanque indicada se encuentra en la orden de trabajo
                $insumo_registrado_mezcla = Orden_insumo::where('id',$id_orden_insumo_mez)->first();
               
                    if(isset($insumo_registrado_mezcla)){
                        $organiz = Ordentrabajo::where('id',$insumo_registrado_mezcla->id_ordentrabajo)->first();
                        $insumo_precio_mez = Insumo::where([['id_organizacion', $organiz->id_organizacion], ['nombre', $id_insumo_mez]])->first();

                        $alerta_mezcla++;
                        $insumo_registrado_mezcla->update(['lts'=>""]);
                        $insumo_registrado_mezcla->update(['kg'=>""]);
                        $insumo_registrado_mezcla->update(['unidades'=>""]);
                        $insumo_registrado_mezcla->update([$unidad_medida => $cantidad, 'precio' => $insumo_precio_mez->precio,
                                                            'dosis_variable' => $variable,'has_variable' => $has_variable_mez]);
                    } else {
                    
                        $orden_insumo_mezcla_sql = Orden_insumo::create(['id_ordentrabajo' => $ordentrabajo->id, 'insumo' => $id_insumo_mez, 
                                                    $unidad_medida => $cantidad, 'id_mezcla' => $mezclaid, 
                                                    'precio' => $insumo_precio_mez->precio,'dosis_variable' => $variable,
                                                    'has_variable' => $has_variable_mez]);
                        $mezclaid = "";
                        $cantidad = "";
                        $unidad_medida = "";
                    }
            }
        }

        if (($alerta_insumo == 0) AND ($alerta_mezcla == 0)) {
            $status = 'status_success';
            $mensaje = 'Orden de trabajo modificada con exito';
        } elseif (($alerta_insumo > 0) AND ($alerta_mezcla == 0)){
            $status = 'status_warning';
            $mensaje = 'Puede que algunos insumos ya se encuentren en la orden de trabajo, puede modificar la cantidad del mismo sin tener que agregar nuevamente el insumo. Si así lo hizo desestime esta advertencia';
        } elseif (($alerta_insumo == 0) AND ($alerta_mezcla > 0)){
            $status = 'status_warning';
            $mensaje = 'Puede que algunas mezclas de tanque ya se encuentren en la orden de trabajo, puede modificar la cantidad de la misma sin tener que agregar nuevamente la mezcla de tanque. Si así lo hizo desestime esta advertencia';
        } else{
            $status = 'status_warning';
            $mensaje = 'Puede que algunas mezclas de tanque e insumos ya se encuentren en la orden de trabajo, puede modificar la cantidad de los mismos sin tener que agregar nuevamente la mezcla de tanque y el insumo. Si así lo hizo desestime esta advertencia';
        }
        
        $ordentrabajo->update($request->all());
        return redirect()->route('ordentrabajo.index')->with($status, $mensaje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ordentrabajo  $ordentrabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ordentrabajo $ordentrabajo)
    {
        //
        Gate::authorize('haveaccess','ordentrabajo.destroy');
        $orden_insumo = Orden_insumo::where('id_ordentrabajo',$ordentrabajo->id)->get();
        if(isset($orden_insumo)){
            foreach ($orden_insumo as $orden) {
                $orden->delete();
            }   
        }
        $ordentrabajo->delete();
        return redirect()->route('ordentrabajo.index')->with('status_success', 'Orden de trabajo eliminada con exito');
    }
}
