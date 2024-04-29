<?php

namespace App\Http\Controllers;

use App\maquina;
use App\organizacion;
use App\jdlink;
use App\User;
use App\maq_breadcrumb;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MaquinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function gestion()
    {
       //
       $rutavolver = route('internoestadisticas');
       Gate::authorize('haveaccess','maquina.gestion');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Maquinas']);
       $dbdate = '2022-01-01';
        $añoinicial = Carbon::createFromFormat('Y-m-d', $dbdate);
        $año_inicial = $añoinicial->format('Y');
       $fecha_hoy = Carbon::today();
        $hoy = $fecha_hoy->format('Y-m-d');
        $año = $fecha_hoy->format('Y');
        if (($fecha_hoy > $año."-10-31") AND ($fecha_hoy <= $año."-12-31")){
            $añopasado = $año;
            $año = $año + 1;
        }else{
            $año = $año;
            $añopasado = $año - 1;
        }

        $diff = $añoinicial->diffInYears($año);
        for ($i=0; $i <= $diff; $i++) { 
            $año_FY[$i] = $año_inicial + $i;
        }
       $equipos = DB::table('maquinas')
                            ->selectRaw('COUNT(id) as cant_equipo, TipoMaq, MarcMaq')
                            ->groupBy('TipoMaq','MarcMaq')
                            ->where([['MarcMaq','JOHN DEERE'], ['TipoMaq','<>','']])
                            ->orWhere([['MarcMaq','PLA'], ['TipoMaq','<>','']])
                            ->get();

        $cosechadoras_sucu = DB::table('maquinas')
                            ->selectRaw('COUNT(maquinas.TipoMaq) as cantidad, sucursals.NombSucu, TipoMaq, MarcMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->where('maquinas.TipoMaq','COSECHADORA')
                            ->get();
                          
        $tractores_sucu = DB::table('maquinas')
                            ->selectRaw('COUNT(maquinas.TipoMaq) as cantidad, sucursals.NombSucu, TipoMaq, MarcMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->where('maquinas.TipoMaq','TRACTOR')
                            ->get();

        $pulverizadoras_sucu = DB::table('maquinas')
                            ->selectRaw('COUNT(maquinas.TipoMaq) as cantidad, sucursals.NombSucu, TipoMaq, MarcMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['MarcMaq','JOHN DEERE']])
                            ->get();

        $pulverizadoras_pla = DB::table('maquinas')
                            ->selectRaw('COUNT(maquinas.TipoMaq) as cantidad, sucursals.NombSucu, TipoMaq, MarcMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['MarcMaq','PLA']])
                            ->get();

        $matchmonitoreo = ['monitoreo','SI'];

        for ($i=0; $i <= $diff; $i++) { 
            $monitoreo_total[$i] = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([['jdlinks.monitoreo','SI'],['jdlinks.anofiscal',$año_FY[$i]],['maquinas.TipoMaq','COSECHADORA']])->count();
                $actualizacion_comp = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([['monitoreo','SI'],['anofiscal',$año_FY[$i]],['actualizacion_comp','<>','NO'],
                                                    ['maquinas.TipoMaq','COSECHADORA']])->count();
                $capacitacion_op = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([['monitoreo','SI'],['anofiscal',$año_FY[$i]],['capacitacion_op','<>','NO'],
                                                ['maquinas.TipoMaq','COSECHADORA']])->count();
                $capacitacion_asesor = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([['monitoreo','SI'],['anofiscal',$año_FY[$i]],['capacitacion_asesor','<>','NO'],
                                                    ['maquinas.TipoMaq','COSECHADORA']])->count();
                $ordenamiento_agro = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([['monitoreo','SI'],['anofiscal',$año_FY[$i]],['ordenamiento_agro','<>','NO'],
                                                    ['maquinas.TipoMaq','COSECHADORA']])->count();
                $visita_inicial = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([['monitoreo','SI'],['anofiscal',$año_FY[$i]],['visita_inicial','<>','NO'],
                                                ['maquinas.TipoMaq','COSECHADORA']])->count();
                $analisis_final = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([['monitoreo','SI'],['anofiscal',$año_FY[$i]],['analisis_final','<>','NO'],
                                                ['maquinas.TipoMaq','COSECHADORA']])->count();
                $limpieza_inyectores = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([['monitoreo','SI'],['anofiscal',$año_FY[$i]],['limpieza_inyectores','<>','NO'],
                                                    ['maquinas.TipoMaq','COSECHADORA']])->count();
                $check_list = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([['monitoreo','SI'],['anofiscal',$año_FY[$i]],['check_list','<>','NO'],
                                                    ['maquinas.TipoMaq','COSECHADORA']])->count();

            
            if($monitoreo_total[$i] <> 0){
                $cantidad_serv[$i][0] = $actualizacion_comp/$monitoreo_total[$i]*100;
                $cantidad_serv[$i][1] = $capacitacion_op/$monitoreo_total[$i]*100;
                $cantidad_serv[$i][2] = $capacitacion_asesor/$monitoreo_total[$i]*100;
                $cantidad_serv[$i][3] = $ordenamiento_agro/$monitoreo_total[$i]*100;
                $cantidad_serv[$i][4] = $visita_inicial/$monitoreo_total[$i]*100;
                $cantidad_serv[$i][5] = $analisis_final/$monitoreo_total[$i]*100;
                $cantidad_serv[$i][6] = $limpieza_inyectores/$monitoreo_total[$i]*100;
                $cantidad_serv[$i][7] = $check_list/$monitoreo_total[$i]*100;

                //Dolares
                $serv_usd[$i][0] = $actualizacion_comp * 100;
                $serv_usd[$i][1] = $capacitacion_op * 100;
                $serv_usd[$i][2] = $capacitacion_asesor * 100;
                $serv_usd[$i][3] = $ordenamiento_agro * 150;
                $serv_usd[$i][4] = $visita_inicial * 200;
                $serv_usd[$i][5] = $analisis_final * 150;
                $serv_usd[$i][6] = $limpieza_inyectores * 500;
                $serv_usd[$i][7] = $check_list * 200;
            }
        }

        $servicio[0] = 'Actualización de componentes';
        $servicio[1] = 'Capacitación a operarios';
        $servicio[2] = 'Capacitación de Operation Center';
        $servicio[3] = 'Ordenamiento agronómico';
        $servicio[4] = 'Visita inicial';
        $servicio[5] = 'Informe final de campaña';
        $servicio[6] = 'Limpieza de inyectores';
        $servicio[7] = 'Check list';

       return view('maquina.gestion', compact('equipos','rutavolver','cosechadoras_sucu','tractores_sucu','pulverizadoras_sucu',
                                                'pulverizadoras_pla','año','hoy','añopasado','cantidad_serv','servicio',
                                                'diff','año_FY','serv_usd'));
    }

    public function index(Request $request)
    {
        Gate::authorize('haveaccess','maquina.index'||'haveaccess','maquinaown.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Maquinas']);
        
        $filtro="";
        $busqueda="";
        
            $nomborg = User::select('organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
                        
            if ($nomborg->NombOrga == 'Sala Hnos'){
                $rutavolver = route('menuinterno');
                if($request->buscarpor){
                    $tipo = $request->get('tipo');
                    $busqueda = $request->get('buscarpor');
                    $variablesurl=$request->all();
                    $maquinas = Maquina::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
                    $filtro = "SI";
                } else{
                    $maquinas = Maquina::select('maquinas.id','maquinas.TipoMaq','maquinas.ModeMaq','organizacions.NombOrga','maquinas.NumSMaq',
                                                'maquinas.ethernet','maquinas.horas','maquinas.combine_advisor','maquinas.harvest_smart',
                                                'sucursals.NombSucu')
                                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                        ->orderBy('id','desc')
                                        ->paginate(20);
                    }
            } else {
                $rutavolver = url()->previous();
                $maquinas = Maquina::select('maquinas.id','maquinas.TipoMaq','maquinas.ModeMaq','organizacions.NombOrga','maquinas.NumSMaq',
                                            'maquinas.ethernet','maquinas.horas','maquinas.combine_advisor','maquinas.harvest_smart',
                                            'sucursals.NombSucu')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->where('organizacions.NombOrga', $nomborg->NombOrga)
                            ->orderBy('id','desc')
                            ->paginate(20);
            }
        
        
        return view('maquina.index', compact('maquinas','filtro','busqueda','rutavolver','nomborg'));
    }

    public function modelo(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        
        $data = Maquina::select('TipoMaq','ModeMaq')->where($select, $value)->groupBy('ModeMaq')->orderBy('ModeMaq','asc')->orderBy('TipoMaq','asc')->get();
        $output = '<option value="">Seleccionar Modelo</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->ModeMaq.'">'.$row->TipoMaq.' - ' .$row->ModeMaq.'</option>';
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
        Gate::authorize('haveaccess','maquina.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Maquinas']);
        $nomborg = User::select('organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
                    
        if ($nomborg->NombOrga == 'Sala Hnos'){
            $organizacions = Organizacion::all();
        } else {
            $organizacions = Organizacion::where('NombOrga',$nomborg->NombOrga)->get();
        }
        $rutavolver = route('maquina.index');
        return view('maquina.create', compact('organizacions','rutavolver'));
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
        Gate::authorize('haveaccess','maquina.create');
        request()->validate([
            'CodiOrga'  => 'required',
            'TipoMaq'   => 'required',
            'NumSMaq'   => 'required|max:25|unique:maquinas,NumSMaq',
            'MarcMaq'   => 'required',
        ]);
        $maquina = Maquina::create($request->all());
        return redirect()->route('maquina.index')->with('status_success', 'Maquina creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function show(Maquina $maquina)
    {
        Gate::authorize('haveaccess','maquina.show'||'haveaccess','maquinaown.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Maquinas']);
        $organizacions = Organizacion::orderBy('id')->get();
        $ubicacion = Maq_breadcrumb::where('pin', $maquina->NumSMaq)
                                    ->orderBy('fecha', 'desc')->first();
        $rutavolver = route('maquina.index');
        return view('maquina.view', compact('maquina','organizacions','rutavolver','ubicacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function edit(Maquina $maquina)
    {
        Gate::authorize('haveaccess','maquina.edit'||'haveaccess','maquinaown.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Maquinas']);
        $nomborg = User::select('organizacions.NombOrga')
                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                    ->where('users.id', auth()->id())
                    ->first();
                    
        if ($nomborg->NombOrga == 'Sala Hnos'){
            $organizacions = Organizacion::all();
        } else {
            $organizacions = Organizacion::where('NombOrga',$nomborg->NombOrga)->get();
        }
        $rutavolver = route('maquina.index');
        return view('maquina.edit', compact('maquina','organizacions','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maquina $maquina)
    {
        Gate::authorize('haveaccess','maquina.edit'||'haveaccess','maquinaown.edit');
        $request->validate([
            'CodiOrga'  => 'required',
            'TipoMaq'   => 'required',
            'MarcMaq'   => 'required',
        ]);
        $maquina->update($request->all());
        return redirect()->route('maquina.index')->with('status_success', 'Maquina modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maquina $maquina)
    {
        Gate::authorize('haveaccess','maquina.destroy');
        $maquina->delete();
        return redirect()->route('maquina.index')->with('status_success', 'Maquina eliminada con exito');
    }
}
