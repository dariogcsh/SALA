<?php

namespace App\Http\Controllers;

use App\cosecha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\organizacion;
use App\interaccion;
use Illuminate\Support\Facades\DB;

class ReporteAgronomicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','reporte_agronomico.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Agronomico']);
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderby('NombOrga','asc')->get();
        $rutavolver = route('jdlink.menu');
   
        return view('reporte_agronomico.index', compact('organizaciones', 'organizacion','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

       /**
     * Show the info.
     *
     * @return \Illuminate\Http\Response
     */
    public function informe(Request $request)
    {
        Gate::authorize('haveaccess','reporte_agronomico.index');
        request()->validate([
            'NombOrga' => 'required',
            'trabajo' => 'required',
            'año' => 'required',
        ]);

        $organizacion = $request->NombOrga;
        $trabajo = $request->trabajo;
        $año = $request->año;
        $desde = $año.'-01-01';
        $hasta = $año.'-12-31';
        $query = [['organizacion',$organizacion], ['inicio','>=',$desde], 
        ['fin','<=',$hasta]];

        $organizacion = Organizacion::where('NombOrga', $organizacion)->first();

        $clientes = Cosecha::select('cliente')
                                        ->where($query)
                                        ->groupBy('cliente')
                                        ->orderBy('cliente','ASC')
                                        ->get();
        $cultivos = Cosecha::select('cultivo')
                                        ->where($query)
                                        ->groupBy('cultivo')
                                        ->get();

        $datos = Cosecha::where($query)
                                    ->orderBy('granja','ASC')
                                    ->get();

   
        return view('reporte_agronomico.informe', compact('clientes','organizacion','año','cultivos','datos'));
   
    }

    // funcion a ejecutarse cuando se cambia el Cliente
    public function cambioCliente(Request $request){
        $cultivo = $request->get('cultivo');
        $organizacion = $request->get('NombOrga');
        $año = $request->get('año');
        $cliente = $request->get('cliente');
        $desde = $año.'-01-01';
        $hasta = $año.'-12-31';

        $query = [['organizacion',$organizacion], ['cliente', $cliente],['cultivo',$cultivo], 
                ['inicio','>=',$desde], ['fin','<=',$hasta]];

        //Calcula hectareas totales de cada granja
        $hectareas = Cosecha::select(DB::raw('sum(superficie) as superficie, granja'))
                                        ->where($query)
                                        ->groupBy('granja')
                                        ->get();
                                        
        $i = 0;
        if(isset($hectareas)){
            foreach($hectareas as $hectarea){
                $array[$i][0] = $hectarea->granja;
                $array[$i][1] = $hectarea->superficie*1;
                $i++;
            }
        }

        //Calcula rinde total de cada granja
        $rendimientos = Cosecha::select(DB::raw('sum(rendimiento) as rendimiento, granja'))
                                            ->where($query)
                                            ->groupBy('granja')
                                            ->get();      

        $i = 0;
        if(isset($rendimientos)){
            foreach($rendimientos as $rinde){
                $array[$i][2] = $rinde->granja;
                $array[$i][3] = $rinde->rendimiento*1;
                $i++;
            }
        }

        //Calcula humedad promedio de cada granja
        $humedades = Cosecha::select(DB::raw('avg(humedad) as humedad, granja'))
                                        ->where($query)
                                        ->groupBy('granja')
                                        ->get();  
                                        

        $i = 0;
        if(isset($humedades)){
            foreach($humedades as $humedad){
                $array[$i][4] = $humedad->granja;
                $array[$i][5] = $humedad->humedad*1;
                $i++;
            }
        }

        //Calcula rinde promedio de cada granja
        $rendimientosm = Cosecha::select(DB::raw('sum(superficie) as superficie, sum(rendimiento) as rendimiento, granja'))
                                            ->where($query)
                                            ->groupBy('granja')
                                            ->get();  

        $i = 0;
        if(isset($rendimientosm)){
            foreach($rendimientosm as $rindem){
                $array[$i][6] = $rindem->granja;
                if($rindem->superficie <> 0){
                    $array[$i][7] = $rindem->rendimiento / $rindem->superficie;
                } else {
                    $array[$i][7] = $rindem->rendimiento;
                }
                $i++;
            }
        }

        //Calcula rinde promedio de cada variedad
        $rendmvariedades = Cosecha::select(DB::raw('sum(superficie) as superficie, sum(rendimiento) as rendimiento, variedad'))
                                            ->where($query)
                                            ->groupBy('variedad')
                                            ->get(); 

        $i = 0;
        if(isset($rendmvariedades)){
            foreach($rendmvariedades as $rendmvariedad){
                $variedad[$i][0] = $rendmvariedad->variedad;
                if ($rendmvariedad->superficie <> 0){
                    $variedad[$i][1] = $rendmvariedad->rendimiento / $rendmvariedad->superficie;
                } else {
                    $variedad[$i][1] = $rendmvariedad->rendimiento;
                }
                $i++;
            }
        }

        //Calcula rinde total de cada variedad
        $rendvariedades = Cosecha::select(DB::raw('sum(rendimiento) as rendimiento, variedad'))
                                            ->where($query)
                                            ->groupBy('variedad')
                                            ->get(); 
                                        
        $i = 0;
        if(isset($rendvariedades)){
            foreach($rendvariedades as $rendvariedad){
                $variedad[$i][2] = $rendvariedad->variedad;
                $variedad[$i][3] = $rendvariedad->rendimiento*1;
                $i++;
            }
        }  

        echo json_encode(array($array,$variedad));
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
     * @param  \App\reporte_agronomico  $reporte_agronomico
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\reporte_agronomico  $reporte_agronomico
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reporte_agronomico  $reporte_agronomico
     * @return \Illuminate\Http\Response
     */

}
