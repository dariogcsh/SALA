<?php

namespace App\Http\Controllers;

use App\reporte_agronomico;
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
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Reportes agronomicos']);
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
            'CodiOrga' => 'required',
            'trabajo' => 'required',
            'año' => 'required',
        ]);

        $CodiOrga = $request->CodiOrga;
        $trabajo = $request->trabajo;
        $año = $request->año;
        $desde = $año.'-01-01';
        $hasta = $año.'-12-31';
        $query = [['OrgaReAg',$CodiOrga], ['TrabReAg', $trabajo], ['FecFReAg','>=',$desde], 
        ['FecFReAg','<=',$hasta]];

        $organizacion = Organizacion::where('CodiOrga', $CodiOrga)->first();

        $clientes = Reporte_agronomico::select('ClieReAg')
                                        ->where($query)
                                        ->groupBy('ClieReAg')
                                        ->orderBy('ClieReAg','ASC')
                                        ->get();
        $cultivos = Reporte_agronomico::select('CultReAg')
                                        ->where($query)
                                        ->groupBy('CultReAg')
                                        ->get();

        $datos = Reporte_agronomico::where($query)
                                    ->orderBy('GranReAg','ASC')
                                    ->get();

   
        return view('reporte_agronomico.informe', compact('clientes','organizacion','trabajo','año','cultivos','datos'));
   
    }

    // funcion a ejecutarse cuando se cambia el Cliente
    public function cambioCliente(Request $request){
        $cultivo = $request->get('cultivo');
        $CodiOrga = $request->get('CodiOrga');
        $trabajo = $request->get('trabajo');
        $año = $request->get('año');
        $cliente = $request->get('cliente');
        $desde = $año.'-01-01';
        $hasta = $año.'-12-31';

        $query = [['TrabReAg',$trabajo], ['OrgaReAg',$CodiOrga], ['ClieReAg', $cliente],
                 ['CultReAg',$cultivo], ['FecFReAg','>=',$desde], ['FecFReAg','<=',$hasta]];

        //Calcula hectareas totales de cada granja
        $hectareas = Reporte_agronomico::select(DB::raw('sum(SupeReAg) as SupeReAg, GranReAg'))
                                        ->where($query)
                                        ->groupBy('GranReAg')
                                        ->get();
                                        
        $i = 0;
        if(isset($hectareas)){
            foreach($hectareas as $hectarea){
                $array[$i][0] = $hectarea->GranReAg;
                $array[$i][1] = $hectarea->SupeReAg*1;
                $i++;
            }
        }

        //Calcula rinde total de cada granja
        $rendimientos = Reporte_agronomico::select(DB::raw('sum(ReSTReAg) as ReSTReAg, GranReAg'))
                                            ->where($query)
                                            ->groupBy('GranReAg')
                                            ->get();      

        $i = 0;
        if(isset($rendimientos)){
            foreach($rendimientos as $rinde){
                $array[$i][2] = $rinde->GranReAg;
                $array[$i][3] = $rinde->ReSTReAg*1;
                $i++;
            }
        }

        //Calcula humedad promedio de cada granja
        $humedades = Reporte_agronomico::select(DB::raw('avg(HumeReAg) as HumeReAg, GranReAg'))
                                        ->where($query)
                                        ->groupBy('GranReAg')
                                        ->get();  
                                        

        $i = 0;
        if(isset($humedades)){
            foreach($humedades as $humedad){
                $array[$i][4] = $humedad->GranReAg;
                $array[$i][5] = $humedad->HumeReAg*1;
                $i++;
            }
        }

        //Calcula rinde promedio de cada granja
        $rendimientosm = Reporte_agronomico::select(DB::raw('sum(SupeReAg) as SupeReAg, sum(ReSTReAg) as ReSTReAg, GranReAg'))
                                            ->where($query)
                                            ->groupBy('GranReAg')
                                            ->get();  

        $i = 0;
        if(isset($rendimientosm)){
            foreach($rendimientosm as $rindem){
                $array[$i][6] = $rindem->GranReAg;
                if($rindem->SupeReAg <> 0){
                    $array[$i][7] = $rindem->ReSTReAg / $rindem->SupeReAg;
                } else {
                    $array[$i][7] = $rindem->ReSTReAg;
                }
                $i++;
            }
        }

        //Calcula rinde promedio de cada variedad
        $rendmvariedades = Reporte_agronomico::select(DB::raw('sum(SupeReAg) as SupeReAg, sum(ReSTReAg) as ReSTReAg, VariReAg'))
                                            ->where($query)
                                            ->groupBy('VariReAg')
                                            ->get(); 

        $i = 0;
        if(isset($rendmvariedades)){
            foreach($rendmvariedades as $rendmvariedad){
                $variedad[$i][0] = $rendmvariedad->VariReAg;
                if ($rendmvariedad->SupeReAg <> 0){
                    $variedad[$i][1] = $rendmvariedad->ReSTReAg / $rendmvariedad->SupeReAg;
                } else {
                    $variedad[$i][1] = $rendmvariedad->ReSTReAg;
                }
                $i++;
            }
        }

        //Calcula rinde total de cada variedad
        $rendvariedades = Reporte_agronomico::select(DB::raw('sum(ReSTReAg) as ReSTReAg, VariReAg'))
                                            ->where($query)
                                            ->groupBy('VariReAg')
                                            ->get(); 
                                        
        $i = 0;
        if(isset($rendvariedades)){
            foreach($rendvariedades as $rendvariedad){
                $variedad[$i][2] = $rendvariedad->VariReAg;
                $variedad[$i][3] = $rendvariedad->ReSTReAg*1;
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
    public function show(reporte_agronomico $reporte_agronomico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\reporte_agronomico  $reporte_agronomico
     * @return \Illuminate\Http\Response
     */
    public function edit(reporte_agronomico $reporte_agronomico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\reporte_agronomico  $reporte_agronomico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reporte_agronomico $reporte_agronomico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reporte_agronomico  $reporte_agronomico
     * @return \Illuminate\Http\Response
     */
    public function destroy(reporte_agronomico $reporte_agronomico)
    {
        //
    }
}
