<?php

namespace App\Http\Controllers;

use App\calificacion;
use App\asist;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CalificacionController extends Controller
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
        Gate::authorize('haveaccess','calificacion.gestion');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calificaciones']);
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
 
             $calificaciones_cant[$i] = Calificacion::where([['created_at','>',$FY_pasado[$i].'-10-31 23:59:59'], ['created_at','<',$FY[$i].'-11-01']])
                                         ->count();
            $asistencias_cant[$i] = Asist::where([['FFinAsis','>',$FY_pasado[$i].'-10-31 23:59:59'], ['FFinAsis','<',$FY[$i].'-11-01'],
                                                ['EstaAsis','LIKE','%finalizada%']])
                                         ->count();
            $puntos_prom[$i] = Calificacion::where([['created_at','>',$FY_pasado[$i].'-10-31 23:59:59'], ['created_at','<',$FY[$i].'-11-01']])
                                         ->avg('puntos');
            if(!isset($puntos_prom[$i])){
                $puntos_prom[$i] = 0;
            }
            
             for ($x=0; $x < 12 ; $x++) {
                 if($mes[$x] == 10){
                     $calificacion_mes[$i][$x] = Calificacion::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY_pasado[$i].'-'.$mes[$x+2].'-01 00:00:01']])
                                                 ->count();

                    $puntos_mes[$i][$x] = Calificacion::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY_pasado[$i].'-'.$mes[$x+2].'-01 00:00:01']])
                                                 ->avg('puntos');

                    if(!isset($puntos_mes[$i][$x])){
                        $puntos_mes[$i][$x] = 0;
                    }
                                                 
                 }elseif(($mes[$x] == 11) OR ($mes[$x] == 12)){
                     $calificacion_mes[$i][$x] = Calificacion::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01']])
                                                 ->count();
 
                    $puntos_mes[$i][$x] = Calificacion::where([['created_at','>',$FY_pasado[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01']])
                                                 ->avg('puntos');

                    if(!isset($puntos_mes[$i][$x])){
                        $puntos_mes[$i][$x] = 0;
                    }
                                               
                 }else{
                     $calificacion_mes[$i][$x] = Calificacion::where([['created_at','>',$FY[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01']])
                                                 ->count();
 
                    $puntos_mes[$i][$x] = Calificacion::where([['created_at','>',$FY[$i].'-'.$mes[$x].'-'.$dia[$i].' 23:59:59'], ['created_at','<',$FY[$i].'-'.$mes[$x+2].'-01 00:00:01']])
                                                 ->avg('puntos');

                    if(!isset($puntos_mes[$i][$x])){
                        $puntos_mes[$i][$x] = 0;
                    }
                 }
             }
         }
        
 
        return view('calificacion.gestion', compact('diff','FY','calificaciones_cant','asistencias_cant','calificacion_mes',
                                             'puntos_mes','año', 'mes_nombre','puntos_prom'));
     }

    public function index(Request $request)
    {
        Gate::authorize('haveaccess','calificacion.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calificaciones']);
        $rutavolver = route('menuinterno');
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $calificaciones = Calificacion::Buscar($tipo, $busqueda)->paginate(10)->appends($variablesurl);
            $filtro = "SI";
        }else {
        
        $calificaciones = Calificacion::select('organizacions.NombOrga', 'users.name', 'users.last_name',
                                            'calificacions.puntos', 'calificacions.descripcion', 'calificacions.id',
                                            'calificacions.created_at')
                                        ->join('users','calificacions.id_user','=', 'users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->orderby('calificacions.id', 'desc')
                                        ->paginate(10);
        }
        return view('calificacion.index', compact('calificaciones','filtro','busqueda','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        Gate::authorize('haveaccess','calificacion.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calificaciones']);
        $asistencia = $id;
        return view('calificacion.create', compact('asistencia'));
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
            'id_asist' => 'required',
            'id_user' => 'required',
            'puntos' => 'required|in:1,2,3,4,5',
        ]);
        $calificacion = Calificacion::create($request->all());
        return redirect()->route('asist.index')->with('status_success', 'Gracias por calificar nuestros servicios');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function show(calificacion $calificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(calificacion $calificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, calificacion $calificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(calificacion $calificacion)
    {
        //
    }
}
