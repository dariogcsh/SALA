<?php

namespace App\Http\Controllers;

use App\monitoreo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\interaccion;
use App\User;
use App\monitoreo_maquina;
use App\organizacion;
use Carbon\Carbon;

class MonitoreoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','monitoreo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Facturacion monitoreo']);
        $rutavolver = route('internosoluciones');
        $filtro="";
        $busqueda="";
        
        $nomborg = User::select('organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();

        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $monitoreos = Monitoreo::Buscar($tipo, $busqueda)
                                ->groupBy('monitoreos.id')
                                ->orderBy('monitoreos.id','desc')->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{

            $monitoreos = Monitoreo::select('monitoreos.id', 'maquinas.TipoMaq', 'maquinas.ModeMaq', 'monitoreos.mes_facturacion',
                                            'monitoreos.fecha_solicitada', 'costo_total', 'monitoreos.estado', 'monitoreos.factura',
                                            'monitoreos.fecha_facturada', 'monitoreos.tipo','organizacions.NombOrga',
                                            'sucursals.NombSucu')
                                    ->join('organizacions','monitoreos.id_organizacion','=','organizacions.id')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->join('monitoreo_maquinas','monitoreos.id','=','monitoreo_maquinas.id_monitoreo')
                                    ->leftjoin('maquinas','monitoreo_maquinas.NumSMaq','=','maquinas.NumSMaq')
                                    ->groupBy('monitoreos.id')
                                    ->orderBy('monitoreos.id','desc')->paginate(20);
        }
        return view('monitoreo.index', compact('monitoreos','rutavolver','nomborg','filtro','busqueda'));
    }

    public function index_pendientes()
    {
        //
        Gate::authorize('haveaccess','monitoreo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Facturacion monitoreo']);
        $rutavolver = route('internosoluciones');
        $monitoreos = Monitoreo::select('monitoreos.id', 'maquinas.TipoMaq', 'maquinas.ModeMaq', 'monitoreos.mes_facturacion',
                                        'monitoreos.fecha_solicitada', 'costo_total', 'monitoreos.estado', 'monitoreos.factura',
                                        'monitoreos.fecha_facturada', 'monitoreos.tipo','organizacions.NombOrga')
                                ->join('organizacions','monitoreos.id_organizacion','=','organizacions.id')
                                ->join('monitoreo_maquinas','monitoreos.id','=','monitoreo_maquinas.id_monitoreo')
                                ->join('maquinas','monitoreo_maquinas.NumSMaq','=','maquinas.NumSMaq')
                                ->where('monitoreos.estado', 'Listo para facturar')
                                ->groupBy('monitoreos.id')
                                ->orderBy('monitoreos.id','desc')->paginate(20);
        return view('monitoreo.index_pendientes', compact('monitoreos','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','monitoreo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Facturacion monitoreo']);
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $hoy = Carbon::today();
        $mes = $hoy->format('m');
        $rutavolver = route('monitoreo.index');
        return view('monitoreo.create',compact('rutavolver','organizaciones','mes'));
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
        $monitoreos = Monitoreo::create($request->all());

        for ($i=1; $i <= 20; $i++) { 
            $NumSMaq = $request->get('NumSMaq'.$i);
            $costo = $request->get('costo'.$i);
            if (($NumSMaq <> "") AND ($costo <> "")) {
                $monitoreo_maquina = Monitoreo_maquina::create(['id_monitoreo' => $monitoreos->id, 'NumSMaq' => $NumSMaq, 'costo' => $costo]);
            }
            $NumSMaq = "";
            $costo = "";
        }
        return redirect()->route('monitoreo.index')->with('status_success', 'Facturación de monitoreo creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\monitoreo  $monitoreo
     * @return \Illuminate\Http\Response
     */
    public function show(monitoreo $monitoreo)
    {
        //
        Gate::authorize('haveaccess','monitoreo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Facturacion monitoreo']);
        $organizacion = Organizacion::where('id',$monitoreo->id_organizacion)->first();
        $monitoreo_maquinas = Monitoreo_maquina::where('id_monitoreo',$monitoreo->id)->get();
        $rutavolver = route('monitoreo.index');
        return view('monitoreo.view', compact('monitoreo','rutavolver','organizacion','monitoreo_maquinas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\monitoreo  $monitoreo
     * @return \Illuminate\Http\Response
     */
    public function edit(monitoreo $monitoreo)
    {
        //
        Gate::authorize('haveaccess','monitoreo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Facturacion monitoreo']);
        $hoy = Carbon::today();
        $mes = $hoy->format('m');
        $organizacionjd = Organizacion::where('id',$monitoreo->id_organizacion)->first();
        $organizaciones = Organizacion::all();
        $monitoreo_maquinas = Monitoreo_maquina::where('id_monitoreo',$monitoreo->id)->get();
        $rutavolver = route('monitoreo.index');
        return view('monitoreo.edit', compact('monitoreo','rutavolver','monitoreo_maquinas','organizaciones',
                                                'mes','organizacionjd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\monitoreo  $monitoreo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, monitoreo $monitoreo)
    {
        //
        Gate::authorize('haveaccess','monitoreo.edit');
        $monitoreo_maquinas = Monitoreo_maquina::where('id_monitoreo',$monitoreo->id)->get();

        //Elimino las maquinas creadas antes
        foreach($monitoreo_maquinas as $maquinas){
            $maquinas->delete();
        }
        //Creo nuevamente las maquinas ya con la modificacion si se modifico
        for ($i=0; $i <= 20; $i++) { 
            $NumSMaq = $request->get('NumSMaq'.$i);
            $costo = $request->get('costo'.$i);
            if (($NumSMaq <> "") AND ($costo <> "")) {
                $monitoreo_maquina = Monitoreo_maquina::create(['id_monitoreo' => $monitoreo->id, 'NumSMaq' => $NumSMaq, 'costo' => $costo]);
            }
            $NumSMaq = "";
            $costo = "";
        }

        $monitoreo->update($request->all());
        return redirect()->route('monitoreo.index')->with('status_success', 'Facturación de monitoreo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\monitoreo  $monitoreo
     * @return \Illuminate\Http\Response
     */
    public function destroy(monitoreo $monitoreo)
    {
        //
        Gate::authorize('haveaccess','monitoreo.destroy');
        $monitoreo_maquinas = Monitoreo_maquina::where('id_monitoreo',$monitoreo->id)->get();

        //Elimino las maquinas creadas antes
        foreach($monitoreo_maquinas as $maquinas){
            $maquinas->delete();
        }
        $monitoreo->delete();
        return redirect()->route('monitoreo.index')->with('status_success', 'Facturación de monitoreo eliminada con exito');
    }
}