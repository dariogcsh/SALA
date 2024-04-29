<?php

namespace App\Http\Controllers;

use App\informe;
use App\utilidad;
use App\horasmotor;
use App\mail;
use App\jdlink;
use App\interaccion;
use App\organizacion;
use App\maquina;
use Illuminate\Http\Request;
use App\User;
use App\Services\NotificationsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class InformeController extends Controller
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
        Gate::authorize('haveaccess','informe.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes de eficiencia de equipos']);
        $nomborg = User::select('organizacions.CodiOrga','organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
        $rutavolver = route('jdlink.menu');
        $filtro="";
        $busqueda="";
        $vista="";

            if($request->buscarpor AND $request->tipo){
                $tipo = $request->get('tipo');
                $busqueda = $request->get('buscarpor');
                $variablesurl=$request->all();
                if ($nomborg->NombOrga == 'Sala Hnos'){
                    $informes = Informe::Buscar($tipo, $busqueda)
                                        ->paginate(20)->appends($variablesurl);
                } else{
                    $informes = Informe::BuscarCliente($tipo, $busqueda, $nomborg->CodiOrga)
                                        ->paginate(20)->appends($variablesurl);
                }
                $filtro = "SI";
            } else{ 
                        
                if ($nomborg->NombOrga == 'Sala Hnos'){
                    $vista= $request->get('sucu');
                    $variablesurl=$request->all();
                    if($vista == "sucursal"){
                        $informes = Informe::select('informes.id','organizacions.CodiOrga','organizacions.NombOrga',
                                            'informes.NumSMaq','informes.FecIInfo','informes.FecFInfo',
                                            'informes.HsTrInfo','informes.CultInfo')
                                    ->join('organizacions','informes.CodiOrga','=','organizacions.CodiOrga')
                                    ->join('maquinas','informes.NumSMaq','=','maquinas.NumSMaq')
                                    ->where([['maquinas.InscMaq','SI'],['informes.FecFInfo','>','2022-03-15'],
                                             ['informes.EstaInfo', 'Enviado'],
                                            ['organizacions.CodiSucu',auth()->user()->CodiSucu]])
                                    ->orderBy('informes.id','desc')
                                   
                                    ->paginate(20);
                    } else {
                        $informes = Informe::select('informes.id','organizacions.CodiOrga','organizacions.NombOrga',
                                            'informes.NumSMaq','informes.FecIInfo','informes.FecFInfo',
                                            'informes.HsTrInfo','informes.CultInfo')
                                    ->join('organizacions','informes.CodiOrga','=','organizacions.CodiOrga')
                                    ->join('maquinas','informes.NumSMaq','=','maquinas.NumSMaq')
                                    ->where([['maquinas.InscMaq','SI'],['informes.FecFInfo','>','2022-03-15'],
                                             ['informes.EstaInfo', 'Enviado']])
                                    ->orderBy('informes.id','desc')
                                   
                                    ->paginate(20);
                                    $vista = "concesionario";
                    }
                } else {
                    $informes = Informe::select('informes.id','organizacions.CodiOrga','organizacions.NombOrga',
                                        'informes.NumSMaq','informes.FecIInfo','informes.FecFInfo',
                                        'informes.HsTrInfo','informes.CultInfo')
                                ->join('organizacions','informes.CodiOrga','=','organizacions.CodiOrga')
                                ->join('maquinas','informes.NumSMaq','=','maquinas.NumSMaq')
                                ->where([['maquinas.InscMaq','SI'],['informes.FecFInfo','>','2022-03-15'],
                                        ['organizacions.CodiOrga', $nomborg->CodiOrga]
                                        , ['informes.EstaInfo', 'Enviado']])
                                ->orderBy('informes.id','desc')
                                ->paginate(20);
                }
            }
        
                            
    return view('informe.index', compact('informes','filtro','busqueda','nomborg','vista','rutavolver'));
    }

    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $organizacion = Organizacion::where('CodiOrga',$value)->first();
        
        $data = Maquina::where($select, $organizacion->id)->get();
        $output = '<option value="">Seleccionar Máquina</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->NumSMaq.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
        }
        echo $output;
    }

    public function enviarInforme()
    {
        Gate::authorize('haveaccess','informe.enviarInforme');
        $hoy = Carbon::today();
        $informes = Jdlink::select('informes.id','organizacions.CodiOrga','organizacions.NombOrga',
                                    'informes.NumSMaq','informes.FecIInfo','informes.FecFInfo','informes.HsTrInfo',
                                    'informes.EstaInfo', 'informes.CultInfo','maquinas.horas','maquinas.TipoMaq')
                            ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                            ->join('informes','maquinas.NumSMaq','=','informes.NumSMaq')
                            ->join('organizacions','informes.CodiOrga','=','organizacions.CodiOrga')
                            ->where([['jdlinks.informes','SI'],['maquinas.TipoMaq','<>','COSECHADORA'],
                            ['jdlinks.vencimiento_contrato','>',$hoy]])
                            ->whereIn('informes.id', function ($sub) {
                                $sub->selectRaw('max(informes.id)')->from('informes')->groupBy('informes.NumSMaq'); // <---- la clave
                            })
                            ->orderBy('organizacions.NombOrga','ASC')
                            ->paginate(20);
        $cantinformes = count($informes);
        $año = date("Y", strtotime($hoy));
        $fechahoras = Horasmotor::distinct('NumSMaq')->orderBy('created_at','desc')->get();
/*      //Ejemplo de groupBy con el ultimo ID registrado
                            $tasks = Task::select('id', 'task_id', 'project_id', 'keyword_id')
                            ->whereIn('id', function ($sub) {
                                $sub->selectRaw('max(id)')->from('tasks')->groupBy('keyword_id'); // <---- la clave
                            })->get();
                            */
        //buscamos el valor mas alto de hs de trilla y su fecha
        
        $i = 0;
        foreach ($informes as $info) {
            $fecha_valor[$i] = Utilidad::select('ValoUtil', 'FecFUtil')
                                        ->where([['CateUtil','Total de horas de separador'], ['NumSMaq',$info->NumSMaq]])
                                        ->orderBy('ValoUtil','desc')
                                        ->first();
            $i++;
        }
        $rutavolver = route('internosoluciones');
        return view('informe.enviarInforme', compact('informes','fecha_valor','fechahoras','hoy','rutavolver','cantinformes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','informe.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes de eficiencia de equipos']);
        $rutavolver = route('informe.index');
        $organizaciones = Organizacion::orderBy('NombOrga', 'asc')->get();
        return view('informe.create',compact('rutavolver','organizaciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeinfo(Request $request)
    {
        //
        Gate::authorize('haveaccess','informe.create');
        $id_orga = Mail::select('mails.UserMail','organizacions.NombOrga')
                        ->join('organizacions','mails.OrgaMail','=','organizacions.id')
                        ->where('organizacions.CodiOrga',$request->CodiOrga)
                        ->get();
                      
        if (isset($id_orga))
        {
            foreach ($id_orga as $id_user) 
            {                 
                $user_send = User::select('users.id', 'users.TokenNotificacion','organizacions.NombOrga')
                                ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                ->where('users.id',$id_user->UserMail)
                                ->first();

                if (isset($user_send->TokenNotificacion))
                {
                    if ($user_send->NombOrga == 'Sala Hnos')
                    {
                        $notificationData = [
                            'title' => 'Sala Hnos.',
                            'body' => 'Nuevo informe de eficiencia de maquina del cliente: '. $id_user->NombOrga .'',
                            'path' => '/informe',
                        ]; 
                        $this->notificationsService->sendToUser($user_send->id, $notificationData);
                    } else { 
                        $notificationData = [
                            'title' => 'Sala Hnos.',
                            'body' => 'Se ha generado un nuevo informe de eficiencia de maquina.',
                            'path' => '/informe',
                        ]; 
                        $this->notificationsService->sendToUser($user_send->id, $notificationData);
                    }
                    
                }  
            }
        }
          
        $informe = informe::create($request->all()); 
        echo('El informe se ha generado correctamente');
        //return view('utilidad.enviarInforme')->with('status_success', 'El informe se ha generado correctamente');
  
    }

    public function store(Request $request)
    {
        Gate::authorize('haveaccess','informe.create');
        $informe = informe::create($request->all()); 
        return redirect()->route('utilidad.enviarInforme')->with('status_success', 'El informe se ha generado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function show(informe $informe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function edit(informe $informe)
    {
        Gate::authorize('haveaccess','informe.edit');
      
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes de eficiencia de equipos']);
        $rutavolver = route('utilidad.enviarInforme');
        $organ = Organizacion::select('organizacions.CodiOrga','organizacions.NombOrga')
                            ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                            ->join('informes','maquinas.NumSMaq','=','informes.NumSMaq')
                            ->where('informes.NumSMAq',$informe->NumSMaq)->first();
        $organizaciones = Organizacion::orderBy('NombOrga', 'asc')->get();
        $maquina = Maquina::join('informes','maquinas.NumSMaq','=','informes.NumSMaq')
                            ->where('informes.id',$informe->id)->first();

        return view('informe.edit', compact('informe','rutavolver','organ','organizaciones','maquina'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\utilidad  $utilidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, informe $informe)
    {
        Gate::authorize('haveaccess','informe.edit');
        $request->validate([
            'NumSMaq'          => 'required',
        ]);

        $informe->update($request->all());
        return redirect()->route('utilidad.enviarInforme')->with('status_success', 'El informe se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function destroy(informe $informe)
    {
        //
    }
}
