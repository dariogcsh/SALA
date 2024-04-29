<?php

namespace App\Http\Controllers;

use App\mant_maq;
use App\organizacion;
use App\tipo_paquete_mant;
use App\paquetemant;
use App\interaccion;
use App\User;
use App\maquina;
use App\Services\NotificationsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MantMaqController extends Controller
{

    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }

    public function gestion(Request $request)
    {
       //
       Gate::authorize('haveaccess','mant_maq.gestion');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
       $rutavolver = route('mant_maq.index');
       $filtro="";
        $busqueda="";
        if (($request->fecha_inicio) AND ($request->fecha_fin)) {
            $hasta = $request->fecha_fin;
            $desde = $request->fecha_inicio;
            $busqueda = $desde.' - '.$hasta;
        } else{
            $fecha_h = Carbon::today();
            $hasta = $fecha_h->format('Y-m-d');
            $fecha_d = $fecha_h->subDays(365);
            $desde = $fecha_d->format('Y-m-d');
        }

       $ranking_sucursales = DB::table('mant_maqs')
                            ->selectRaw('COUNT(DISTINCT mant_maqs.pin) as cantidad, sucursals.NombSucu')
                            ->join('maquinas','mant_maqs.pin','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->orderBy('cantidad','DESC')
                            ->where([['mant_maqs.created_at','>=',$desde.' 00:00:01'], ['mant_maqs.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $cant_estados = DB::table('mant_maqs')
                            ->selectRaw('COUNT(DISTINCT mant_maqs.pin) as cantidad, mant_maqs.estado')
                            ->join('maquinas','mant_maqs.pin','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('mant_maqs.estado')
                            ->orderBy('cantidad','DESC')
                            ->where([['mant_maqs.created_at','>=',$desde.' 00:00:01'], ['mant_maqs.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $cant_tipos = DB::table('mant_maqs')
                            ->selectRaw('COUNT(DISTINCT mant_maqs.pin) as cantidad, maquinas.TipoMaq')
                            ->join('maquinas','mant_maqs.pin','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('maquinas.TipoMaq')
                            ->orderBy('cantidad','DESC')
                            ->where([['mant_maqs.created_at','>=',$desde.' 00:00:01'], ['mant_maqs.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $cant_modelos = DB::table('mant_maqs')
                            ->selectRaw('COUNT(DISTINCT mant_maqs.pin) as cantidad, maquinas.ModeMaq')
                            ->join('maquinas','mant_maqs.pin','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('maquinas.ModeMaq')
                            ->orderBy('cantidad','DESC')
                            ->where([['mant_maqs.created_at','>=',$desde.' 00:00:01'], ['mant_maqs.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

       return view('mant_maq.gestion', compact('rutavolver','desde','hasta','ranking_sucursales','filtro','cant_estados',
                                                'cant_tipos','cant_modelos'));
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','mant_maq.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $nomborg = User::select('organizacions.NombOrga','organizacions.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
                  
        if ($nomborg->NombOrga == 'Sala Hnos'){
            $mant_maqs = Mant_maq::select('mant_maqs.id','organizacions.NombOrga','sucursals.NombSucu','maquinas.ModeMaq',
                                    'mant_maqs.pin','maquinas.horas','mant_maqs.estado')
                            ->join('paquetemants','mant_maqs.id_paquetemant','=','paquetemants.id')
                            ->join('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                            ->leftjoin('maquinas','mant_maqs.pin','=','maquinas.NumSMaq')
                            ->leftjoin('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->leftjoin('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('mant_maqs.pin')
                            ->groupBy('tipo_paquete_mants.id')
                            //->groupBy('tipo_paquete_mants.horas')
                            ->orderBy('id','desc')->paginate(20);
        } else {
            $mant_maqs = Mant_maq::select('mant_maqs.id','organizacions.NombOrga','sucursals.NombSucu','maquinas.ModeMaq',
                                    'mant_maqs.pin','maquinas.horas','mant_maqs.estado')
                            ->join('paquetemants','mant_maqs.id_paquetemant','=','paquetemants.id')
                            ->join('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                            ->leftjoin('maquinas','mant_maqs.pin','=','maquinas.NumSMaq')
                            ->leftjoin('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->leftjoin('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->where('organizacions.id',$nomborg->id)
                            ->groupBy('mant_maqs.pin')
                            ->groupBy('tipo_paquete_mants.id')
                            //->groupBy('tipo_paquete_mants.horas')
                            ->orderBy('id','desc')->paginate(20);
        }

        $rutavolver = route('home');
        
        return view('mant_maq.index', compact('mant_maqs','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Gate::authorize('haveaccess','mant_maq.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $nomborg = User::select('organizacions.NombOrga','organizacions.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
                  
        if ($nomborg->NombOrga == 'Sala Hnos'){
            $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        } else {
            $organizaciones = Organizacion::where('id',$nomborg->id)->get();
        }
        $rutavolver = url()->previous();
            if(($request->id_tipo_paquete_mant)){
                $organ = $request->id_organizacion;
                $maqs = Maquina::where('CodiOrga',$organ)->get();
                $pinmaq = $request->pin;
                $modelo = Tipo_paquete_mant::where('id',$request->id_tipo_paquete_mant)->first();
                $tipo_paquete_mants = Tipo_paquete_mant::where('modelo', $modelo->modelo)
                                                        ->orderBy('horas','asc')->get();
                return view('mant_maq.create',compact('rutavolver','organizaciones','tipo_paquete_mants','organ','maqs',
                                                    'pinmaq','modelo'));
            } else {
                return view('mant_maq.create',compact('rutavolver','organizaciones'));
            }
        
    }

    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        
        $orga = Organizacion::where('id',$value)->first();
        $data = Maquina::where($select, $value)->get();
        $output = '<option>Seleccionar maquinaria</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->NumSMaq.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
        }
        $output .= '<option value="otra  - '.$orga->id.'">Otra</option>';
        echo $output;
    }

    function tipoPaquete(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $st = stripos($value, "otra");
        if ($st === false){
            $maquina = Maquina::where($select,$value)->first();
            $data = Tipo_paquete_mant::where('modelo','LIKE','%'.$maquina->ModeMaq.'%')
                                    ->groupBy('modelo')->get();
        } else {
            $data = Tipo_paquete_mant::groupBy('modelo')->get();
        }
        $datacant = count($data);
        
        if($datacant > 0){
            $output = '<option>Seleccionar paquete</option>';
            foreach ($data as $row)
                {
                    $output .='<option value="'.$row->id.'">'.$row->modelo.'</option>';
                }
        } else {
            $output = '<option>No hay paquete de mantenimiento para este equipo</option>';
        }
        echo $output;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((isset($request->chk)) AND (isset($request->maquina))) {
            $servicios = $request->chk;
            $pin = $request->maquina;
            foreach ($servicios as $servicio) {
                $paquetemants = Paquetemant::where('id_tipo_paquete_mant',$servicio)->get();
                foreach ($paquetemants as $paquetemant) {
                    $paqman = Mant_maq::create(['id_paquetemant' => $paquetemant->id, 'pin' => $pin, 'estado'=> 'Solicitado']);
                }
            }
        }

        if (isset($request->organizacion)) {
            $organiz = $request->organizacion;
            $organizacion = Organizacion::where('id',$organiz)->first();
        } else {
            $maquina = Maquina::where('NumSMaq',$pin)->first();
            $organizacion = Organizacion::where('id',$maquina->CodiOrga)->first();
        }
    
        $sucursalid = $organizacion->CodiSucu;

        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        //->orWhere($matchTheseAdministrativo)
                        //->orWhere($matchTheseGerente)
                        ->Where('roles.name','Admin')
                        ->orWhere(function($q) use ($sucursalid){
                            $q->where(function($query) use ($sucursalid){
                                $query->where('puesto_empleados.NombPuEm','Administrativo de servicio')
                                    ->where('users.CodiSucu', $sucursalid);      
                            })
                            ->orWhere(function($query) use ($sucursalid){
                                $query->where('puesto_empleados.NombPuEm', 'Gerente de sucursal')
                                    ->where('users.CodiSucu', $sucursalid);
                            })
                            ->orWhere(function($query) use ($sucursalid){
                                $query->where('puesto_empleados.NombPuEm', 'Coordinador de servicios')
                                    ->where('users.CodiSucu', $sucursalid);
                            })
                            ->orWhere(function($query) use ($sucursalid){
                                $query->where('puesto_empleados.NombPuEm', 'Coordinador de servicios corporativo');
                            });
                        })
                        ->get();

                        //Envio de notificacion
                        foreach($usersends as $usersend){
                            $notificationData = [
                                'title' => 'Nuevo paquete de Mantenimiento',
                                'body' => 'Se ha generado una nueva solicitud de paquete de mantenimiento de '.$organizacion->NombOrga.'',
                                'path' => '/mant_maq',
                            ];
                            $this->notificationsService->sendToUser($usersend->id, $notificationData);
                        } 

        return redirect()->route('home')->with('status_success', 'Paquete de mantenimiento registrado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mant_maq  $mant_maq
     * @return \Illuminate\Http\Response
     */
    public function show(mant_maq $mant_maq)
    {
        Gate::authorize('haveaccess','mant_maq.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimientos']);
        $rutavolver = route('mant_maq.index');
        $tipopaquete = Mant_maq::select('tipo_paquete_mants.id')
                                ->join('paquetemants','mant_maqs.id_paquetemant','=','paquetemants.id')
                                ->join('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                                ->where('mant_maqs.id',$mant_maq->id)->first();
        $paquetemants = Paquetemant::select('paquetemants.id','tipo_paquete_mants.horas as horastipo','tipo_paquete_mants.modelo',
                                    'paquetemants.horas','mant_maqs.realizado','mant_maqs.horas as horasefectivas','mant_maqs.fecha',
                                    'paquetemants.id_tipo_paquete_mant','mant_maqs.cor','mant_maqs.estado')
                            ->join('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                            ->join('mant_maqs','paquetemants.id','=','mant_maqs.id_paquetemant')
                            ->where([['mant_maqs.pin',$mant_maq->pin],['paquetemants.id_tipo_paquete_mant',$tipopaquete->id]])
                            //->groupBy('tipo_paquete_mants.horas')
                            ->groupBy('paquetemants.horas')
                            ->orderBy('horastipo','asc')
                            ->orderBy('horas','asc')->paginate(20);
        $maquina = Maquina::where('NumSMaq',$mant_maq->pin)->first();
        $mant_maq = Mant_maq::select('mant_maqs.id','mant_maqs.id_paquetemant','mant_maqs.pin','mant_maqs.realizado',
                                    'mant_maqs.horas','mant_maqs.fecha','mant_maqs.cor','mant_maqs.estado','mant_maqs.aviso50',
                                    'mant_maqs.aviso','mant_maqs.created_at','mant_maqs.updated_at')
                            ->join('paquetemants','mant_maqs.id_paquetemant','=','paquetemants.id')
                            ->join('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                            ->where([['mant_maqs.pin',$mant_maq->pin],['paquetemants.id_tipo_paquete_mant',$tipopaquete->id]])->first();
        return view('mant_maq.view', compact('paquetemants','rutavolver','maquina','mant_maq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mant_maq  $mant_maq
     * @return \Illuminate\Http\Response
     */
    public function edit(mant_maq $mant_maq)
    {
        //
        Gate::authorize('haveaccess','mant_maq.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimientos']);
        $rutavolver = url()->previous();
        return view('mant_maq.edit', compact('mant_maq','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mant_maq  $mant_maq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mant_maq $mant_maq)
    {
        //
        Gate::authorize('haveaccess','mant_maq.edit');
        $request->validate([
            'horas'   => 'required',
            'fecha'   => 'required',
            'cor'   => 'required',
        ]);
        
        $maquina = $request->get('maquina');
        $id_paquetemant = $request->get('id_paquetemant');
        $pin = $request->get('pin');
        $realizado = $request->get('realizado');
        $horas = $request->get('horas');
        $fecha = $request->get('fecha');
        $cor = $request->get('cor');

        if($maquina<>""){
            if($maquina<>$pin){
                $mant_maqs = Mant_maq::where('pin',$pin)->get();
                foreach ($mant_maqs as $mant) {
                    $mant_maq->where('pin',$pin)->update(['pin'=>$maquina]);
                }
                $pin = $maquina;
            }
        }

        $paquete = Paquetemant::where('id',$id_paquetemant)->first();
        
        $tipos = Paquetemant::where([['id_tipo_paquete_mant',$paquete->id_tipo_paquete_mant], ['horas',$paquete->horas]])->get();
        foreach ($tipos as $tipo) { 
            $mant_maq->where([['id_paquetemant', $tipo->id],['pin',$pin]])->update(['realizado'=>$realizado, 'horas'=>$horas, 'fecha'=>$fecha, 'cor'=>$cor]); // change all except pin, id_paquetemant
        }

        //$mant_maq->update($request->all());
        return redirect()->route('mant_maq.index')->with('status_success', 'Mantenimiento registrado con exito');
    }


    public function modificarestado(Request $request)
    {
        Gate::authorize('haveaccess','mant_maq.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimientos']);
        $estado = $request->get('estado');
        $id_paquetemant = $request->get('idpaquete');
        $pin = $request->get('pin');

        $paquete = Paquetemant::where('id',$id_paquetemant)->first();
        
        $tipos = Paquetemant::where('id_tipo_paquete_mant',$paquete->id_tipo_paquete_mant)->get();
        foreach ($tipos as $tipo) { 
            $mant_maq = Mant_maq::where([['id_paquetemant', $tipo->id],['pin',$pin]])->first();
            $mant_maq->update(['estado'=>$estado]); // change all except pin, id_paquetemant
        }

        return response()->json(["success"=>true,"url"=> route("mant_maq.index")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mant_maq  $mant_maq
     * @return \Illuminate\Http\Response
     */
    public function destroy(mant_maq $mant_maq)
    {
        //
        Gate::authorize('haveaccess','mant_maq.destroy');
        $mant_maq->delete();
        return redirect()->route('mant_maq.index')->with('status_success', 'Mantenimiento eliminado con exito');
    }
}
