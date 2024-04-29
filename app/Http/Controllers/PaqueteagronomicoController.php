<?php

namespace App\Http\Controllers;

use App\paqueteagronomico;
use Carbon\Carbon;
use App\jdlink;
use App\maquina;
use App\organizacion;
use App\paquete_maquina;
use App\sucursal;
use App\interaccion;
use App\User;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;
use Illuminate\Http\Request;


class PaqueteagronomicoController extends Controller
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
    public function menu()
    {
        return view('paqueteagronomico.menu');
    }
    public function index()
    {
        Gate::authorize('haveaccess','paqueteagronomico.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquete agronomico']);
        $rutavolver = route('internosoluciones');
        $paqueteagronomicos = Paqueteagronomico::select('paqueteagronomicos.id','organizacions.NombOrga','sucursals.NombSucu',
                                            'paqueteagronomicos.altimetria','paqueteagronomicos.suelo',
                                            'paqueteagronomicos.compactacion','paqueteagronomicos.hectareas',
                                            'paqueteagronomicos.vencimiento','paqueteagronomicos.anofiscal',
                                            'paqueteagronomicos.costo','paqueteagronomicos.lotes')
                                    ->join('organizacions','paqueteagronomicos.id_organizacion','=','organizacions.id')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->orderBy('organizacions.NombOrga','asc')->paginate(20);
        
        return view('paqueteagronomico.index', compact('paqueteagronomicos','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','paqueteagronomico.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquete agronomico']);
        $nomborg = User::select('organizacions.NombOrga','organizacions.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
        if ($nomborg->NombOrga == 'Sala Hnos'){
            $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        } else {
            $organizaciones = Organizacion::where('id',$nomborg->id)->get();
        }
        $asesores = User::join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->where('organizacions.NombOrga',"Sala Hnos")
                        ->where(function($q){
                            $q->where(function($query){
                                $query->where('puesto_empleados.NombPuEm','Vendedor');      
                            })
                            ->orWhere(function($query){
                                $query->where('puesto_empleados.NombPuEm', 'Gerente de sucursal');
                            })
                            ->orWhere(function($query){
                                $query->where('puesto_empleados.NombPuEm', 'Analista de soluciones integrales');
                            })
                            ->orWhere(function($query){
                                $query->where('puesto_empleados.NombPuEm', 'Especialista AMS');
                            })
                            ->orWhere(function($query){
                                $query->where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                            });
                        })
                        ->orderBy('users.last_name')->get();
                        $rutavolver = url()->previous();
        return view('paqueteagronomico.create',compact('organizaciones','rutavolver','asesores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function fetchtractor(Request $request)
    {
        //Verifico año fiscal actual
        $hoy = Carbon::now();
        $año = $hoy->format('Y');
        if (($hoy > $año."-10-31") AND ($hoy <= $año."-12-31")){
            $año = $año + 1;
        }

        $select = $request->get('select');
        $value = $request->get('value');
        $orga = Organizacion::where('id',$value)->first();
        
        $data = Maquina::where([[$select, $value], ['TipoMaq','TRACTOR']])
                        ->orWhere([[$select, $value], ['TipoMaq','PULVERIZADORA']])->get();
        $output = '';
        foreach ($data as $row)
        {
            //Verifico si la maquina tiene monitoreo para no sobreescribirlo
            $maquina = Jdlink::where([['NumSMaq',$row->NumSMaq], ['anofiscal',$año]])->first();
            if(isset($maquina)){
                if($maquina->monitoreo == "SI"){

                } else {
                    $output .='<option value="'.$row->NumSMaq.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
                }
            } else {
                $output .='<option value="'.$row->NumSMaq.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
            }
        }
        echo $output;

    }

    public function store(Request $request)
    {
        Gate::authorize('haveaccess','paqueteagronomico.create');
        request()->validate([
            'hectareas' => 'required',
            'asesor' => 'required',
            'lotes'     => 'required',
        ]);

        $arr="";
        //Verifico año fiscal actual
        $hoy = Carbon::now();
        $año = $hoy->format('Y');
        if (($hoy > $año."-10-31") AND ($hoy <= $año."-12-31")){
            $año = $año + 1;
        }
        $diasuscripcion = Carbon::today();
        $vencimiento = $diasuscripcion->addYear();

        $request->request->add(['vencimiento' => $vencimiento]);
        $request->request->add(['anofiscal' => $año]);
        $request->request->add(['compactacion' => 'NO']);
        $request->request->add(['altimetria' => 'NO']);
        $request->request->add(['suelo' => 'NO']);

        $paquete = Paqueteagronomico::create($request->all());
    
       if ($request->NumSMaq) {
            $maquinas = $request->NumSMaq;
            foreach ($maquinas as $maquina) {
                $arr=(['vencimiento_contrato' => $vencimiento, 'anofiscal' => $año, 'conectado' => 'SI', 'monitoreo' => 'SI', 
                'informes' => 'SI', 'alertas' => 'SI', 'mantenimiento' => 'SI', 'contrato_firmado' => 'NO', 'factura' => 'NO',
                'apivinculada' => 'Auravant', 'capacitacion_op' => 'NO', 'ordenamiento_agro' => 'SI', 'ensayo' => 'NO', 
                'check_list' => 'NO', 'analisis_final' => 'SI', 'actualizacion_comp' => 'SI', 'visita_inicial' => 'NO', 
                'calibracion_implemento' => 'SI', 'capacitacion_asesor' => 'SI', 'limpieza_inyectores' => 'NO', 'NumSMaq' => $maquina]);

                //Busca si ya tiene creada una conectividad
                $maqdestroy = Jdlink::where([['NumSMaq', $maquina], ['anofiscal',$año]])->first();
                if(isset($maqdestroy)){
                    //Elimina la conectividad para colocar la nueva
                    $maqdestroy->delete();
                }
                $jdlinks = Jdlink::create($arr);
                $paquete_maquina = Paquete_maquina::create(['id_paquete' => $paquete->id, 'id_jdlink'=> $jdlinks->id]);
            }
        }

        //Buscar que organizacion es la que solicita el soporte
        $organizacion = Organizacion::where('id',$request->id_organizacion)->first();
        //obtener sucursal donde pertenece el usuario que solicita la asistencia
        $sucursalid = Sucursal::select('sucursals.id')
                            ->where('id',$organizacion->CodiSucu)
                            ->first();

        $matchTheseAdministrativo = [['puesto_empleados.NombPuEm', 'Administrativo de servicio'], ['users.CodiSucu', $sucursalid->id]];
        $matchTheseGerente = [['puesto_empleados.NombPuEm', 'Gerente de sucursal'], ['users.CodiSucu', $sucursalid->id]];

        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where('roles.name','Admin')
                        ->orWhere($matchTheseAdministrativo)
                        ->orWhere($matchTheseGerente)->get();
                        
        //Envio de notificacion
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'Sala Hnos. - Paquete agronómico',
                'body' => 'Se ha registrado un nuevo paquete agronómico de: '.$organizacion->NombOrga.'',
                'path' => '/jdlink',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        return redirect()->route('home')->with('status_success', 'Conectividad registrada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\paqueteagronomico  $paqueteagronomico
     * @return \Illuminate\Http\Response
     */
    public function show(paqueteagronomico $paqueteagronomico)
    {
        Gate::authorize('haveaccess','paqueteagronomico.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquete agronomico']);
        $rutavolver = route('paqueteagronomico.index');
        $maquinas = Maquina::select('paquete_maquinas.id as idpaqmaq','maquinas.ModeMaq','maquinas.NumSMaq')
                            ->join('jdlinks','maquinas.NumSMaq','=','jdlinks.NumSMaq')
                            ->join('paquete_maquinas','jdlinks.id','=','paquete_maquinas.id_jdlink')
                            ->where('paquete_maquinas.id_paquete', $paqueteagronomico->id)->get();
        $organizacion = Organizacion::join('paqueteagronomicos','organizacions.id','=','paqueteagronomicos.id_organizacion')
                                    ->where('organizacions.id',$paqueteagronomico->id_organizacion)->first();

        return view('paqueteagronomico.view', compact('paqueteagronomico','rutavolver','maquinas','organizacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\paqueteagronomico  $paqueteagronomico
     * @return \Illuminate\Http\Response
     */
    public function edit(paqueteagronomico $paqueteagronomico)
    {
        //
        Gate::authorize('haveaccess','paqueteagronomico.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquete agronomico']);
        $rutavolver = route('paqueteagronomico.index');
        $maquinas = Maquina::select('paquete_maquinas.id as idpaqmaq','maquinas.ModeMaq','maquinas.NumSMaq')
                            ->join('jdlinks','maquinas.NumSMaq','=','jdlinks.NumSMaq')
                            ->join('paquete_maquinas','jdlinks.id','=','paquete_maquinas.id_jdlink')
                            ->where('paquete_maquinas.id_paquete', $paqueteagronomico->id)->get();
        $organizacion = Organizacion::join('paqueteagronomicos','organizacions.id','=','paqueteagronomicos.id_organizacion')
                                    ->where('organizacions.id',$paqueteagronomico->id_organizacion)->first();
         
         $maqs = Maquina::where([['CodiOrga', $paqueteagronomico->id_organizacion], ['TipoMaq','TRACTOR']])
                         ->orWhere([['CodiOrga', $paqueteagronomico->id_organizacion], ['TipoMaq','PULVERIZADORA']])->get();

        return view('paqueteagronomico.edit', compact('paqueteagronomico','rutavolver','organizacion','maquinas','maqs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\paqueteagronomico  $paqueteagronomico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, paqueteagronomico $paqueteagronomico)
    {
        //
        Gate::authorize('haveaccess','paqueteagronomico.edit');
        $request->validate([
            'vencimiento'     => 'required',
            'hectareas'     => 'required',
            'lotes'     => 'required',
        ]);
        
        $arr="";
        //Verifico año fiscal actual
        $hoy = Carbon::now();
        $año = $hoy->format('Y');
        if (($hoy > $año."-10-31") AND ($hoy <= $año."-12-31")){
            $año = $año + 1;
        }

        $vencimiento = $request->get('vencimiento');

        if ($request->pin) {
            $maquinas = $request->pin;
            foreach ($maquinas as $maquina) {
                $arr=(['vencimiento_contrato' => $vencimiento, 'anofiscal' => $año, 'conectado' => 'SI', 'monitoreo' => 'SI', 
                'informes' => 'SI', 'alertas' => 'SI', 'mantenimiento' => 'SI', 'contrato_firmado' => 'NO', 'factura' => 'NO',
                'apivinculada' => 'Auravant', 'capacitacion_op' => 'NO', 'ordenamiento_agro' => 'SI', 'ensayo' => 'NO', 
                'check_list' => 'NO', 'analisis_final' => 'SI', 'actualizacion_comp' => 'SI', 'visita_inicial' => 'NO', 
                'calibracion_implemento' => 'SI', 'capacitacion_asesor' => 'SI', 'limpieza_inyectores' => 'NO', 'NumSMaq' => $maquina]);

                //Busca si ya tiene creada una conectividad
                $maqdestroy = Jdlink::where([['NumSMaq', $maquina], ['anofiscal',$año]])->first();
                if(isset($maqdestroy)){
                    //Elimina la conectividad para colocar la nueva
                    $maqdestroy->delete();
                }
                $jdlinks = Jdlink::create($arr);
                $paquete_maquina = Paquete_maquina::create(['id_paquete' => $paqueteagronomico->id, 'id_jdlink'=> $jdlinks->id]);
            }
        }

        if ($request->altimetria){
            $request->request->add(['altimetria' => 'SI']);
        } else {
            $request->request->add(['altimetria' => 'NO']);
        }
        if ($request->compactacion){
            $request->request->add(['compactacion' => 'SI']);
        } else {
            $request->request->add(['compactacion' => 'NO']);
        }
        if ($request->suelo){
            $request->request->add(['suelo' => 'SI']);
        } else {
            $request->request->add(['suelo' => 'NO']);
        }

        $paqueteagronomico->update($request->all());
        return redirect()->route('paqueteagronomico.index')->with('status_success', 'Paquete agronómico modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\paqueteagronomico  $paqueteagronomico
     * @return \Illuminate\Http\Response
     */
    public function destroy(paqueteagronomico $paqueteagronomico)
    {
        Gate::authorize('haveaccess','paqueteagronomico.destroy');
        //Se modifica el monitoreo de las maquinas que participan en el paquete de soporte agronómico para que ya no sean monitoreadas
        $arr=(['vencimiento_contrato' => '', 'conectado' => 'SI', 'monitoreo' => 'NO', 'informes' => 'NO', 'alertas' => 'NO', 
        'mantenimiento' => 'NO', 'contrato_firmado' => 'NO', 'factura' => 'NO','apivinculada' => '', 'capacitacion_op' => 'NO', 
        'ordenamiento_agro' => 'NO', 'ensayo' => 'NO', 'check_list' => 'NO', 'analisis_final' => 'NO', 'actualizacion_comp' => 'NO',
        'visita_inicial' => 'NO', 'calibracion_implemento' => 'NO', 'capacitacion_asesor' => 'NO', 'limpieza_inyectores' => 'NO']);
        //Selecciono las máquinas que estaban adheridas al paquete agronómico
        $jdlinks = Jdlink::join('paquete_maquinas','jdlinks.id','=','paquete_maquinas.id_jdlink')
                        ->where('paquete_maquinas.id_paquete',$paqueteagronomico->id)->get();
     
        foreach ($jdlinks as $jdlink) {
            $jdlink->where('id',$jdlink->id_jdlink)->update($arr);
        }
        //elimina las máquinas que se relacionan con el paquete agronómico a eliminar
        $paqueteagronomico->paquete_maquinas()->delete();
        $paqueteagronomico->delete();
        return redirect()->route('paqueteagronomico.index')->with('status_success', 'Paquete agronómico eliminado con exito, también han sido eliminadas las máquinas del paquete de monitoreo');
    }

    public function destroymaq(Request $request)
    {
        Gate::authorize('haveaccess','paqueteagronomico.destroy');
        $idpaqmaq = $request->get('idpaqmaq');
        //Se modifica el monitoreo de las maquinas que participan en el paquete de soporte agronómico para que ya no sean monitoreadas
        $arr=(['vencimiento_contrato' => '', 'conectado' => 'SI', 'monitoreo' => 'NO', 'informes' => 'NO', 'alertas' => 'NO', 
        'mantenimiento' => 'NO', 'contrato_firmado' => 'NO', 'factura' => 'NO','apivinculada' => '', 'capacitacion_op' => 'NO', 
        'ordenamiento_agro' => 'NO', 'ensayo' => 'NO', 'check_list' => 'NO', 'analisis_final' => 'NO', 'actualizacion_comp' => 'NO',
        'visita_inicial' => 'NO', 'calibracion_implemento' => 'NO', 'capacitacion_asesor' => 'NO', 'limpieza_inyectores' => 'NO']);
        //Selecciono las máquinas que estaban adheridas al paquete agronómico
        $jdlink = Jdlink::join('paquete_maquinas','jdlinks.id','=','paquete_maquinas.id_jdlink')
                        ->where('paquete_maquinas.id',$idpaqmaq)->first();
        $paquete_maquina = Paquete_maquina::where('id',$idpaqmaq)->first();
        $jdlink->where('id',$jdlink->id_jdlink)->update($arr);
        $idpaqueteagro = Paqueteagronomico::where('id',$paquete_maquina->id_paquete)->first();
        $paquete_maquina->delete();
        return response()->json(["success"=>true,"url"=> route("paqueteagronomico.edit",$idpaqueteagro)]);
    }
}
