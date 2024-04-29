<?php

namespace App\Http\Controllers;

use App\senal;
use App\organizacion;
use App\mibonificacion;
use App\antena;
use App\user;
use App\interaccion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;
use Illuminate\Support\Facades\DB;

class SenalController extends Controller
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

     public function gestion(Request $request)
    {
       //
       $rutavolver = route('internoestadisticas');
   
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alquileres de señal']);
       $fecha_hoy = Carbon::today();
        $dbdate = '2021-01-01';
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

            $alquileres_cant[$i] = Senal::where([['created_at','>',$FY_pasado[$i].'-10-31 23:59:59'], ['created_at','<',$FY[$i].'-11-01'],
                                                ['estado','<>','Cancelado']])
                                        ->count();
 
            $alquileres_usd[$i] = Senal::where([['created_at','>',$FY_pasado[$i].'-10-31 23:59:59'], ['created_at','<',$FY[$i].'-11-01 00:00:01'],
                                                ['estado','<>','Cancelado']])
                                        ->sum('costo');

            for ($x=0; $x < 12 ; $x++) {
                if($mes[$x] == 10){
                    $alquiler_mes[$i][$x] = Senal::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY_pasado[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->count();

                    $alquiler_mes_usd[$i][$x] = Senal::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY_pasado[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->sum('costo');
                                                
                }elseif(($mes[$x] == 11) OR ($mes[$x] == 12)){
                    $alquiler_mes[$i][$x] = Senal::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->count();

                    $alquiler_mes_usd[$i][$x] = Senal::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->sum('costo');
                                              
                }else{
                    $alquiler_mes[$i][$x] = Senal::where([['created_at','>',$FY[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->count();

                    $alquiler_mes_usd[$i][$x] = Senal::where([['created_at','>',$FY[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01'],
                                                        ['estado','<>','Cancelado']])
                                                ->sum('costo');
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

        $senal_estados = DB::table('senals')
                            ->selectRaw('COUNT(senals.id) as cantidad, senals.estado')
                            ->groupBy('senals.estado')
                            ->orderBy('cantidad','DESC')
                            ->where([['senals.created_at','>=',$año_pasado.'-11-01 00:00:01']])
                            ->get();

        $tipos_senal = DB::table('senals')
                            ->selectRaw('COUNT(senals.id) as cantidad, senals.duracion')
                            ->groupBy('senals.duracion')
                            ->orderBy('cantidad','DESC')
                            ->where([['senals.created_at','>=',$año_pasado.'-11-01 00:00:01'], ['estado','<>','Cancelado']])
                            ->get();
        
        $año_FY_pasado = $año_FY - 1;
        $año_FY_antepasado = $año_FY_pasado - 1;
        
        $alquileres_FY_pasado = Senal::select('nserie')
                                    ->where([['created_at','>',$año_FY_antepasado.'-10-31 23:59:59'], 
                                            ['created_at','<',$año_FY_pasado.'-11-01 00:00:01'],
                                            ['estado','<>','Cancelado']])->get();

        $cantidad_alquileres_FY_pasado = $alquileres_FY_pasado->count();
        

        //dd($alquiler_mes);

       return view('senal.gestion', compact('diff','FY','alquileres_cant','alquileres_usd','filtro','mes_nombre','alquiler_mes',
                                            'alquiler_mes_usd','senal_estados','alquileres_FY_pasado','año_FY','año_FY_pasado',
                                            'cantidad_alquileres_FY_pasado','año','busqueda','tipos_senal'));
    }


    public function index(Request $request)
    {
        Gate::authorize('haveaccess','senal.index');
        //Veo a que organizacion pertenece la sesion
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alquileres de señal']);
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
                $senals = Senal::Buscar($tipo, $busqueda)->orderBy('senals.id','desc')->paginate(20)->appends($variablesurl);
                $filtro = "SI";
            } else{
                $senals = Senal::select('senals.id','organizacions.NombOrga','antenas.NombAnte','senals.nserie','senals.created_at',
                                        'senals.activacion','senals.duracion','senals.costo','senals.estado','senals.nfactura',
                                        'users.name','users.last_name')
                                ->leftjoin('users','senals.id_user','=','users.id')
                                ->join('organizacions','senals.id_organizacion','=','organizacions.id')
                                ->join('antenas','senals.id_antena','=','antenas.id')
                                ->orderBy('senals.id','desc')->paginate(20);
            }
        }else{
            $senals = Senal::select('senals.id','organizacions.NombOrga','antenas.NombAnte','senals.nserie','senals.created_at',
                                        'senals.activacion','senals.duracion','senals.costo','senals.estado','senals.nfactura',
                                        'users.name','users.last_name')
                                ->leftjoin('users','senals.id_user','=','users.id')
                                ->join('organizacions','senals.id_organizacion','=','organizacions.id')
                                ->join('antenas','senals.id_antena','=','antenas.id')
                                ->where('senals.id_organizacion', $nomborg->id)
                                ->orderBy('senals.id','desc')->paginate(20);
        }
        $hoy = Carbon::now();
        return view('senal.index', compact('senals','hoy','filtro','busqueda','rutavolver'));
    }

    function buscarbonif(Request $request)
    {
        $value = $request->get('value');
        $select = $request->get('select');
        $data = Mibonificacion::select('mibonificacions.id','bonificacions.tipo','bonificacions.descuento')
                                ->join('bonificacions','mibonificacions.id_bonificacion','=','bonificacions.id')
                                ->where([[$select, $value],['mibonificacions.estado','Aceptado']])->get();
        $output = '<option value="">Seleccionar bonificación</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->id.'">'.$row->tipo.' - '.$row->descuento.'%</option>';
        }
        echo $output;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','senal.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alquileres de señal']);
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $antenas = Antena::orderBy('id','asc')->get();
        $rutavolver = route('senal.index');
        return view('senal.create', compact('organizaciones','antenas','rutavolver'));
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
            'id_organizacion' => 'required',
            'duracion' => 'required',
            'costo' => 'required'
        ]);
        
        $bonif = $request->get('id_mibonificacion');
        if ($bonif <> ''){
            $mibonif = Mibonificacion::where('id',$bonif)->first();
            $mibonif->update(['estado'=>'Aplicado']);
        }
        
        $request->request->add(['id_user' => auth()->id()]);
        $senals = Senal::create($request->all());

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
                                ->where('users.last_name', 'Pellizza');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                ->where('users.last_name', 'Garcia Campi');
                        })
                        ->get();
                    

         //Envio de notificacion
         foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'Alquiler de señal - Solicitud',
                'body' => 'Nuevo alquiler de señal registrado',
                'path' => '/senal',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        return redirect()->route('senal.index')->with('status_success', 'Alquiler de señal registrada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\senal  $senal
     * @return \Illuminate\Http\Response
     */
    public function show(senal $senal)
    {
        Gate::authorize('haveaccess','senal.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alquileres de señal']);
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $antenas = Antena::orderBy('id','asc')->get();
        $misbonificaciones = Mibonificacion::select('mibonificacions.id','bonificacions.tipo','bonificacions.descuento')
                                ->join('bonificacions','mibonificacions.id_bonificacion','=','bonificacions.id')
                                ->where([['mibonificacions.id_organizacion', $senal->id_organizacion],
                                        ['mibonificacions.estado','Aceptado']])
                                ->orWhere([['mibonificacions.id_organizacion', $senal->id_organizacion],
                                        ['mibonificacions.estado','Aplicado'],['mibonificacions.id',$senal->id_mibonificacion]])->get();
        $usuario = User::where('id',$senal->id_user)->first();
        $rutavolver = route('senal.index');
        return view('senal.view', compact('senal','organizaciones','antenas','misbonificaciones','usuario','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\senal  $senal
     * @return \Illuminate\Http\Response
     */
    public function edit(senal $senal)
    {
        Gate::authorize('haveaccess','senal.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Alquileres de señal']);
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $antenas = Antena::orderBy('id','asc')->get();
        $misbonificaciones = Mibonificacion::select('mibonificacions.id','bonificacions.tipo','bonificacions.descuento')
                                ->join('bonificacions','mibonificacions.id_bonificacion','=','bonificacions.id')
                                ->where([['mibonificacions.id_organizacion', $senal->id_organizacion],
                                        ['mibonificacions.estado','Aceptado']])
                                ->orWhere([['mibonificacions.id_organizacion', $senal->id_organizacion],
                                        ['mibonificacions.estado','Aplicado'],['mibonificacions.id',$senal->id_mibonificacion]])->get();
        
        $rutavolver = route('senal.index');
        return view('senal.edit', compact('senal','organizaciones','antenas','misbonificaciones','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\senal  $senal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, senal $senal)
    {
        request()->validate([
            'id_organizacion' => 'required',
            'duracion' => 'required',
            'costo' => 'required'
        ]);
        $bonif = $request->get('id_mibonificacion');
        if (($senal->id_mibonificacion <>'') AND ($senal->id_mibonificacion <> $bonif)){
            $mibonif = Mibonificacion::where('id',$senal->id_mibonificacion)->first();
            $mibonif->update(['estado'=>'Aceptado']);
        }
        if ($bonif <> ''){
            $mibonif = Mibonificacion::where('id',$bonif)->first();
            $mibonif->update(['estado'=>'Aplicado']);
            $alldata = $request->all();
        } else {
            if ($senal->id_mibonificacion <>''){
                $mibonif = Mibonificacion::where('id',$senal->id_mibonificacion)->first();
                $mibonif->update(['estado'=>'Aceptado']);
                $alldata = $request->all();
            } else {
                $alldata = $request->except('id_mibonificacion');
            }
        }
        
        $senal->update($alldata);
        //Buscamos la organizacion a la cual le corresponde el alquiler de señal para detallar en la notificacion.
        $orgsenal = Organizacion::where('id',$senal->id_organizacion)->first();
        if(($senal->estado == 'Pagado') OR ($senal->estado == 'Facturado') OR ($senal->estado == 'Activado') OR ($senal->estado == 'Cancelado')){
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
                        ->orWhere(function($query) use ($senal) {
                            $query->where('users.id', $senal->id_user);
                        })
                        ->get();
                    

            //Envio de notificacion
            foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'Alquiler de señal - '.$orgsenal->NombOrga.'',
                    'body' => 'Alquiler de señal ha sido '.$senal->estado.'',
                    'path' => '/senal',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
        } elseif($senal->estado == 'Solicitado'){
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
                                $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales')
                                    ->where('users.last_name', 'Garcia Campi');
                            })
                            ->orWhere(function($query) {
                                $query->where('puesto_empleados.NombPuEm', 'Especialista AMS')
                                    ->where('users.last_name', 'Pelliza');
                            })
                            ->get();

            //Envio de notificacion
            foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'Alquiler de señal - '.$senal->estado.'',
                    'body' => 'Alquiler de señal cambio de estado a '.$senal->estado.'',
                    'path' => '/senal',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
        }
        return redirect()->route('senal.index')->with('status_success', 'Alquiler de señal modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\senal  $senal
     * @return \Illuminate\Http\Response
     */
    public function destroy(senal $senal)
    {
        Gate::authorize('haveaccess','senal.destroy');
        $senal->delete();
        return redirect()->route('senal.index')->with('status_success', 'Alquiler de señal eliminado con exito');
    }
}
