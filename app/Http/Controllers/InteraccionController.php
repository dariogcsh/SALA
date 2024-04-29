<?php

namespace App\Http\Controllers;

use App\interaccion;
use App\organizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InteraccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function gestion(Request $request)
    {
       //
       Gate::authorize('haveaccess','interaccion.index');
       $rutavolver = route('interaccion.index');
       $filtro="";
        $busqueda="";
        if (($request->fecha_inicio) AND ($request->fecha_fin)) {
            $hasta = $request->fecha_fin;
            $desde = $request->fecha_inicio;
            $busqueda = $desde.' - '.$hasta;
        } else{
            $fecha_h = Carbon::today();
            $hasta = $fecha_h->format('Y-m-d');
            $fecha_d = $fecha_h->subDays(7);
            $desde = $fecha_d->format('Y-m-d');
        }

        $fecha_inicio_f = Carbon::createFromFormat('Y-m-d',$desde);
        $fecha_fin_f = Carbon::createFromFormat('Y-m-d',$hasta);

        $cantidadDias = $fecha_inicio_f->diffInDays($fecha_fin_f);

        for ($i=0; $i < $cantidadDias; $i++) { 
            $fecha_s = $fecha_inicio_f->addDays(1)->format('Y-m-d');
            $fecha_array[$i] = $fecha_s;

            $ranking_visitas = DB::table('interaccions')
                            ->selectRaw('COUNT(interaccions.id) as cantidad')
                            ->join('users','interaccions.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->groupBy('interaccions.id_user')
                            ->orderBy('cantidad','DESC')
                            ->whereDate('interaccions.created_at',$fecha_s)
                            ->where('organizacions.NombOrga','<>','Sala Hnos')
                            ->first();
            if(isset($ranking_visitas)){
                $visitas[$i] = $ranking_visitas->cantidad;
            } else{
                $visitas[$i] = 0;
            }
            
        }
        
        $fecha_inicio_f = Carbon::createFromFormat('Y-m-d',$desde);
        for ($i=0; $i < $cantidadDias; $i++) { 
            $fecha_s = $fecha_inicio_f->addDays(1)->format('Y-m-d');
            $fecha_array[$i] = $fecha_s;

            $ranking_visitas_conce = DB::table('interaccions')
                            ->selectRaw('COUNT(interaccions.id) as cantidad')
                            ->join('users','interaccions.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->groupBy('interaccions.id_user')
                            ->orderBy('cantidad','DESC')
                            ->whereDate('interaccions.created_at',$fecha_s)
                            ->where('organizacions.NombOrga','Sala Hnos')
                            ->first();

            if(isset($ranking_visitas_conce)){
                $visitas_conce[$i] = $ranking_visitas_conce->cantidad;
            } else{
                $visitas_conce[$i] = 0;
            }
        }
        
    

        $ranking_modulos = DB::table('interaccions')
                            ->selectRaw('COUNT(interaccions.id) as cantidad, interaccions.modulo')
                            ->groupBy('interaccions.modulo')
                            ->orderBy('cantidad','DESC')
                            ->where([['interaccions.created_at','>=',$desde.' 00:00:01'], ['interaccions.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

       $ranking_sucursales = DB::table('interaccions')
                            ->selectRaw('COUNT(interaccions.id) as cantidad, sucursals.NombSucu')
                            ->join('users','interaccions.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->orderBy('cantidad','DESC')
                            ->where([['interaccions.created_at','>=',$desde.' 00:00:01'], ['interaccions.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $ranking_organizaciones = DB::table('interaccions')
                            ->selectRaw('COUNT(interaccions.id) as cantidad, organizacions.NombOrga')
                            ->join('users','interaccions.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->groupBy('organizacions.NombOrga')
                            ->orderBy('cantidad','DESC')
                            ->where([['interaccions.created_at','>=',$desde.' 00:00:01'], ['interaccions.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $ranking_puesto = DB::table('interaccions')
                            ->selectRaw('COUNT(interaccions.id) as cantidad, puesto_empleados.NombPuEm')
                            ->join('users','interaccions.id_user','=','users.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->groupBy('puesto_empleados.NombPuEm')
                            ->orderBy('cantidad','DESC')
                            ->where([['interaccions.created_at','>=',$desde.' 00:00:01'], ['interaccions.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

        $ranking_colaborador = DB::table('interaccions')
                            ->selectRaw('COUNT(interaccions.id) as cantidad, users.name, users.last_name')
                            ->join('users','interaccions.id_user','=','users.id')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->groupBy('users.id')
                            ->orderBy('cantidad','DESC')
                            ->where([['interaccions.created_at','>=',$desde.' 00:00:01'], ['interaccions.created_at','<=',$hasta.' 23:59:59'],])
                            ->get();
        
        // Generar consulta para calcular el tiempo de respuesta y de solucion de asistencias

       return view('interaccion.gestion', compact('rutavolver','desde','hasta','ranking_sucursales','filtro', 'ranking_organizaciones',
                                            'ranking_puesto','ranking_colaborador','ranking_modulos','visitas_conce',
                                        'visitas','cantidadDias','fecha_array'));
    }

    public function index(Request $request)
    {
        Gate::authorize('haveaccess','interaccion.index');
        $rutavolver = route('menuinterno');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $vista= $request->get('orga');
        $variablesurl=$request->all();
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $interacciones = Interaccion::Buscar($tipo, $busqueda)->orderBy('id','desc')->paginate(30)->appends($variablesurl);
            $filtro = "SI";
        } else{
            if($vista == "organizacion"){
                $interacciones = Interaccion::select('interaccions.id','users.name','users.last_name','interaccions.created_at',
                                                    'interaccions.enlace','interaccions.modulo','organizacions.NombOrga',
                                                    'sucursals.NombSucu')
                                            ->join('users','interaccions.id_user','=','users.id')
                                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                            ->where('organizacions.NombOrga','=','Sala Hnos')
                                            ->orderBy('id','desc')->paginate(30)->appends($variablesurl);
            } else {
                $interacciones = Interaccion::select('interaccions.id','users.name','users.last_name','interaccions.created_at',
                                                    'interaccions.enlace','interaccions.modulo','organizacions.NombOrga',
                                                    'sucursals.NombSucu')
                                            ->join('users','interaccions.id_user','=','users.id')
                                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                            ->where('organizacions.NombOrga','<>','Sala Hnos')
                                            ->orderBy('id','desc')->paginate(30)->appends($variablesurl);
                                            $vista = "concesionario";
            }
        }
        
        return view('interaccion.index', compact('interacciones','rutavolver','vista','filtro','busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
     * @param  \App\interaccion  $interaccion
     * @return \Illuminate\Http\Response
     */
    public function show(interaccion $interaccion)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\interaccion  $interaccion
     * @return \Illuminate\Http\Response
     */
    public function edit(interaccion $interaccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\interaccion  $interaccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, interaccion $interaccion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\interaccion  $interaccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(interaccion $interaccion)
    {
        //
    }
}
