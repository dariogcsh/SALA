<?php

namespace App\Http\Controllers;

use App\utilidad;
use App\horasmotor;
use App\maquina;
use App\organizacion;
use App\objetivo;
use App\informe;
use App\cosecha;
//use PDF;
use Carbon\Carbon;
use App\interaccion;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UtilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','utilidad.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes de eficiencia de equipos']);
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderby('NombOrga','asc')->get();
        $maquinas = Maquina::where('CodiOrga', $organizacion->id)->get();
        $habilitar = "SI";
        $rutavolver = route('jdlink.menu');
        return view('utilidad.index', compact('organizaciones', 'organizacion','maquinas','habilitar','rutavolver'));
    }
    public function acarreo()
    {
        Gate::authorize('haveaccess','utilidad.informeAcarreo');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderby('NombOrga','asc')->get();
        $maquinas = Maquina::where('CodiOrga', $organizacion->id)->get();
        $rutavolver = route('jdlink.menu');
        return view('utilidad.acarreo', compact('organizaciones', 'organizacion','maquinas','rutavolver'));
    } 
    public function comparar()
    {
        Gate::authorize('haveaccess','utilidad.informe');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderby('NombOrga','asc')->get();
        $maquinas = Maquina::where('CodiOrga', $organizacion->id)->get();
        $habilitar = "SI";
        $rutavolver = route('utilidad.menu');
        return view('utilidad.comparar', compact('organizaciones', 'organizacion','maquinas','habilitar','rutavolver'));
    } 
    public function generar($id)
    {
        Gate::authorize('haveaccess','utilidad.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderby('NombOrga','asc')->get();
        $habilitar = "NO";
        if ($id <> 0){
            $informe = Informe::where('id', $id)->first();
            $maquinas = Maquina::where('NumSMaq', $informe->NumSMaq)->first();
        }
        $rutavolver = route('utilidad.menu');
        return view('utilidad.index', compact('organizaciones', 'organizacion','maquinas','informe','habilitar','maquinas','rutavolver'));
    } 

    public function indexdiario(Request $request){
        Gate::authorize('haveaccess','utilidad.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes diarios de eficiencia de equipos']);
        $filtro="";
        $busqueda="";
        $rutavolver = route('jdlink.menu');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $hoy = Carbon::today();
        $diasatras = date("Y-m-d",strtotime($hoy."- 5 days"));
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $utilidads = Utilidad::Buscar($tipo, $busqueda)
                                ->groupBy('organizacions.NombOrga','utilidads.FecIUtil')
                                ->orderBy('utilidads.FecIUtil','desc')
                                ->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
            if ($organizacion->NombOrga == "Sala Hnos") {
                $utilidads = Utilidad::select('organizacions.NombOrga','utilidads.FecIUtil','sucursals.NombSucu',
                                            'organizacions.CodiOrga')
                                ->join('maquinas','utilidads.NumsMaq','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['SeriUtil','Trabajando'], ['ValoUtil','>=',1], ['UOMUtil','hr'],
                                        ['FecIUtil','>=',$diasatras]])
                                ->groupBy('organizacions.NombOrga','utilidads.FecIUtil')
                                ->orderBy('utilidads.FecIUtil','desc')->paginate(20);
            }
            else{
                $utilidads = Utilidad::select('organizacions.NombOrga','utilidads.FecIUtil','sucursals.NombSucu',
                                            'organizacions.CodiOrga')
                                ->join('maquinas','utilidads.NumsMaq','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['organizacions.CodiOrga',$organizacion->CodiOrga], ['SeriUtil','Trabajando'],
                                         ['ValoUtil','>=',1], ['UOMUtil','hr']])
                                ->groupBy('organizacions.NombOrga','utilidads.FecIUtil')
                                ->orderBy('utilidads.FecIUtil','desc')->paginate(20);
            }
            
        }
        
        return view('utilidad.indexdiario', compact('utilidads','filtro','busqueda','organizacion','rutavolver'));
    }

    public function showdiario($id)
    {
        //
        Gate::authorize('haveaccess','utilidad.showdiario');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes diarios de eficiencia de equipos']);
        $valuefec = $id;
        $value = explode("_", $valuefec);
        $fecha = $value[0];
        $CodiOrga = $value[1];
        $organizacion = Organizacion::where('CodiOrga',$CodiOrga)->first();
        $maquinas = Maquina::join('utilidads','maquinas.NumSMaq','=','utilidads.NumSMaq')
                            ->where([['maquinas.CodiOrga',$organizacion->id], ['utilidads.SeriUtil','Trabajando'], 
                                    ['utilidads.ValoUtil','>=',0.5], ['utilidads.UOMUtil','hr']])
                            ->groupBy('maquinas.NumSMaq')
                            ->get();
        $rutavolver = route('utilidad.indexdiario');
        return view('utilidad.viewdiario', compact('maquinas','fecha','rutavolver','organizacion'));
    }

    public function enviarInforme()
    {
        Gate::authorize('haveaccess','utilidad.enviarInforme');
        $hoy = Carbon::today();
        $informes = Informe::select('informes.id','organizacions.CodiOrga','organizacions.NombOrga','informes.NumSMaq','informes.FecIInfo',
                                    'informes.FecFInfo','informes.HsTrInfo', 'informes.EstaInfo', 'informes.CultInfo')
                            ->join('organizacions','informes.CodiOrga','=','organizacions.CodiOrga')
                            ->join('maquinas','informes.NumSMaq','=','maquinas.NumSMaq')
                            ->join('jdlinks','maquinas.NumSMaq','=','jdlinks.NumSMaq')
                            ->where([['jdlinks.informes','SI'],['maquinas.TipoMaq','COSECHADORA'],
                                    ['jdlinks.vencimiento_contrato','>',$hoy]])
                            ->whereIn('informes.id', function ($sub) {
                                $sub->selectRaw('max(informes.id)')->from('informes')->groupBy('informes.NumSMaq'); // <---- la clave
                            })
                            ->orderBy('organizacions.NombOrga','ASC')
                            ->paginate(20);
            
        $cantinformes = Informe::select('informes.id')
                                ->join('maquinas','informes.NumSMaq','=','maquinas.NumSMaq')
                                ->join('jdlinks','maquinas.NumSMaq','=','jdlinks.NumSMaq')
                                ->where([['jdlinks.informes','SI'],['maquinas.TipoMaq','COSECHADORA'],
                                        ['jdlinks.vencimiento_contrato','>',$hoy]])
                                ->whereIn('informes.id', function ($sub) {
                                    $sub->selectRaw('max(informes.id)')->from('informes')->groupBy('informes.NumSMaq'); // <---- la clave
                                })
                                ->count();

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
        return view('utilidad.enviarInforme', compact('informes','fecha_valor','rutavolver','cantinformes'));
    }

    public function menu()
    {
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes de eficiencia de equipos']);
        $rutavolver = route('jdlink.menu');
        return view('utilidad.menu', compact('rutavolver'));
    }

    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        
        $data = Maquina::where($select, $value)->get();
        $output = '<option value="">Seleccionar Máquina</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->NumSMaq.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
        }
        echo $output;

    }
    function fetchss(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        //Con esta consulta trae unicamente maquinas cosechadora, para el resto de las máquinas se debe sacar la condicion TipoMaq.
        $data = Maquina::where([[$select, $value],['TipoMaq','COSECHADORA']])->get();
        $output = '';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->NumSMaq.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
        }
        echo $output;

    }
    //selecciona las maquinas de la organizacion y las envia por ajjax al select y envia ID en el value
    function fetchidmaq(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        
        $data = Maquina::where($select, $value)->get();
        $output = '<option value="">Seleccionar Máquina</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->id.'">'.$row->NumSMaq.'</option>';
        }
        echo $output;

    }

    function verificaTipoMaquina(Request $request)
    {
        $NumSMaq = $request->get('NumSMaq');
        $maquina = Maquina::where('NumSMaq', $NumSMaq)->first();

        echo $maquina->TipoMaq;
    }

    function verificaTipoMaquinaApero(Request $request)
    {
        if (isset($request->NumSMaq)) {
            $maquinas = $request->NumSMaq;
        }

        if (isset($request->cultivo)) {
            $cultivo = $request->cultivo;
        }

        if (isset($maquinas)) {
            $i=0;
            foreach ($maquinas as $maquina) {
                $caracteristicasmaq = Maquina::where('NumSMaq', $maquina)->first();
                $carac[$i][0]= $caracteristicasmaq->NumSMaq;
                $carac[$i][1]= $caracteristicasmaq->CanPMaq;
                $carac[$i][2]= $caracteristicasmaq->MaicMaq;
                $i++;
                }
        }
        echo json_encode($carac);
    }

    function cargaImplemento(Request $request)
    {
        $nserie = $request->get('NumSMaq');
        $maquina = Maquina::where('NumSMaq', $nserie)->first();
        $cultivo = $request->get('cultivo');
        if ($maquina->TipoMaq == "COSECHADORA"){
            if (($cultivo == "maíz") OR ($cultivo == "girasol")){
                echo $maquina->MaicMaq;
            } else {
                echo $maquina->CanPMaq;
            }
        } else {
            echo $maquina->MaicMaq;
        }
    }

    function detalle_tractor_ralenti(Request $request)
    {
        $indicador = $request->get('element_id');
        $valuefec = $request->get('value');
        $maquina = $request->get('maquina');
        $value = explode("/", $valuefec);
        $fechainicial = $value[0];
        $fechafinal = $value[1];
        
        //Consulta de fechas
        $sqlfechas = [['NumSMaq', $maquina], ['FecIUtil','>=',$fechainicial],['FecIUtil','<=',$fechafinal]];

        //obtengo desde la fecha mas baja
        $fechamin = Utilidad::where($sqlfechas)
                        ->orderBy('FecIUtil','asc')
                        ->groupBy('FecIUtil')
                        ->get();

        if (empty($fechamin))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas para el cultivo seleccionado');
        }
        $i=0;
        foreach ($fechamin as $fecha)
        {
            if ($indicador == "detallefactor") {
                $factor = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                    ['UOMUtil', '%']])->avg('ValoUtil');
                $factor_carga[$i][1]= $fecha->FecIUtil;
                $factor_carga[$i][0] = $factor*1;
            }
            if ($indicador == "detallerpm") {
                $rpmvalor = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                    ['UOMUtil', 'RPM']])->avg('ValoUtil');
                $rpm[$i][1]= $fecha->FecIUtil;
                $rpm[$i][0] = $rpmvalor*1;
            }
            
                $trabajando = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                        ['UOMUtil', 'hr']])->sum('ValoUtil');
                $transporte = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Transporte'],
                                        ['UOMUtil', 'hr']])->sum('ValoUtil');
                $ralenti = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Ralentí'],
                                        ['UOMUtil', 'hr']])->sum('ValoUtil');

                $hrtotal = $trabajando + $transporte + $ralenti;
                $ralenti_total = $ralenti / $hrtotal * 100;

                
                $ralenti_total_t[$i][1] = $fecha->FecIUtil;
                $ralenti_total_t[$i][0] = $ralenti_total;
                $i++;
            
        }
        if ($indicador == "detallefactor") {
            $resultado = $factor_carga;
        }
        if ($indicador == "detallerpm") {
            $resultado = $rpm;
        }
        if ($indicador == "detalleralenti") {
            $resultado = $ralenti_total_t;
        }
        
        echo json_encode($resultado);
    }

    function detalle_superficie_consumo_vel_tractor(Request $request)
    {
        $indicador = $request->get('element_id');
        $valuefec = $request->get('value');
        $maquina = $request->get('maquina');
        $implemento = $request->get('implemento');

        $value = explode("/", $valuefec);
        $fechainicial = $value[0];
        $fechafinal = $value[1];
        
        //Consulta de fechas
        $sqlfechas = [['NumSMaq', $maquina], ['FecIUtil','>=',$fechainicial],['FecIUtil','<=',$fechafinal]];

        //obtengo desde la fecha mas baja
        $fechamin = Utilidad::where($sqlfechas)
                        ->orderBy('FecIUtil','asc')
                        ->groupBy('FecIUtil')
                        ->get();

        if (empty($fechamin))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas para el cultivo seleccionado');
        }
        $i=0;
        foreach ($fechamin as $fecha)
        {
            $velocidad[$i] = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                    ['UOMUtil', 'km/hr']])->avg('ValoUtil');
            $consumoph[$i] = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq],['SeriUtil','Trabajando'], 
                                    ['UOMUtil', 'l/hr']])->avg('ValoUtil');
            

            $arrfecha[$i] = $fecha->FecIUtil;
            $superficie[$i][0] = $implemento*$velocidad[$i]*0.1;
            $superficie[$i][1] = $arrfecha[$i];
            $consumo[$i][1] = $arrfecha[$i];
            $velocidad_avance[$i][1]= $arrfecha[$i];
            $velocidad_avance[$i][0] = $velocidad[$i]*1;
            if (empty($superficie[$i][0]) OR empty($superficie[$i][1]))
            {
                continue;
            }
                        if ($superficie[$i] <> 0){
                        //Calcula el consumo por hectarea
                            $consumo[$i][0] = $consumoph[$i] / $superficie[$i][0];
                        }else{
                            $consumo[$i][0] = 0; 
                        }
                        $i++;
        }
        if ($indicador == "detallesuperficie") {
            $resultado = $superficie;
        }
        if ($indicador == "detalleconsumo") {
            $resultado = $consumo;
        }
        if ($indicador == "detallevelocidad") {
            $resultado = $velocidad_avance;
        }
        echo json_encode($resultado);
    }

    function detalle_superficie_consumo_vel_tractor_acarreo(Request $request)
    {
        $indicador = $request->get('element_id');
        $valuefec = $request->get('value');
        $maquina = $request->get('maquina');

        $value = explode("/", $valuefec);
        $fechainicial = $value[0];
        $fechafinal = $value[1];
        
        //Consulta de fechas
        $sqlfechas = [['NumSMaq', $maquina], ['FecIUtil','>=',$fechainicial],['FecIUtil','<=',$fechafinal]];

        //obtengo desde la fecha mas baja
        $fechamin = Utilidad::where($sqlfechas)
                        ->orderBy('FecIUtil','asc')
                        ->groupBy('FecIUtil')
                        ->get();

        if (empty($fechamin))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas para el cultivo seleccionado');
        }
        $i=0;
        foreach ($fechamin as $fecha)
        {
            $velocidad[$i] = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                    ['UOMUtil', 'km/hr']])->avg('ValoUtil');
            

            $arrfecha[$i] = $fecha->FecIUtil;
            $velocidad_avance[$i][1] = $arrfecha[$i];
            $velocidad_avance[$i][0] = $velocidad[$i]*1;

            $consumo[$i] = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                    ['UOMUtil', 'l/hr']])->avg('ValoUtil');
            

            $consumos[$i][1] = $arrfecha[$i];
            $consumos[$i][0] = $consumo[$i]*1;
            $i++;
        }
        if ($indicador == "detallevelocidad") {
            $resultado = $velocidad_avance;
        }
        if ($indicador == "detalleconsumo") {
            $resultado = $consumos;
        }
        echo json_encode($resultado);
    }

    function detalle_superficie_consumo_vel(Request $request)
    {
        $indicador = $request->get('element_id');
        $valuefec = $request->get('value');
        $cultivo = $request->get('cultivo');
        $maquina = $request->get('maquina');
        $maicero = $request->get('maicero');
        $draper = $request->get('draper');
        $value = explode("/", $valuefec);
        $fechainicial = $value[0];
        $fechafinal = $value[1];
        if (($cultivo == "Maíz") OR ($cultivo == "Girasol")){
            $plataforma = $maicero;
        } else {
            $plataforma = $draper * 0.3048;
        }
        //Consulta de fechas
        $sqlfechas = [['NumSMaq', $maquina], ['FecIUtil','>=',$fechainicial],['FecIUtil','<=',$fechafinal], ['CateUtil','LIKE','Tiempo en '.$cultivo.'']];

        //obtengo desde la fecha mas baja
        $fechamin = Utilidad::where($sqlfechas)
                        ->orderBy('FecIUtil','asc')
                        ->get();

        if (empty($fechamin))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas para el cultivo seleccionado');
        }
        $i=0;
        foreach ($fechamin as $fecha)
        {
            $velocidad[$i] = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                    ['UOMUtil', 'km/hr']])->avg('ValoUtil');
            $consumoph[$i] = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq],['SeriUtil','Trabajando'], 
                                    ['UOMUtil', 'l/hr']])->avg('ValoUtil');
            

            $arrfecha[$i] = $fecha->FecIUtil;
            $superficie[$i][0] = $plataforma*$velocidad[$i]*0.1;
            $superficie[$i][1] = $arrfecha[$i];
            $consumo[$i][1] = $arrfecha[$i];
            $velocidad_avance[$i][1]= $arrfecha[$i];
            $velocidad_avance[$i][0] = $velocidad[$i]*1;
            if (empty($superficie[$i][0]) OR empty($superficie[$i][1]))
            {
                continue;
            }
                        if ($superficie[$i] <> 0){
                        //Calcula el consumo por hectarea
                            $consumo[$i][0] = $consumoph[$i] / $superficie[$i][0];
                        }else{
                            $consumo[$i][0] = 0; 
                        }
                        $i++;
        }
        if ($indicador == "detallesuperficie") {
            $resultado = $superficie;
        }
        if ($indicador == "detalleconsumo") {
            $resultado = $consumo;
        }
        if ($indicador == "detallevelocidad") {
            $resultado = $velocidad_avance;
        }
        echo json_encode($resultado);
    }

    function detalle_tecnologia(Request $request)
    {
        $indicador = $request->get('element_id');
        $valuefec = $request->get('value');
        $cultivo = $request->get('cultivo');
        $maquina = $request->get('maquina');
        $value = explode("/", $valuefec);
        $fechainicial = $value[0];
        $fechafinal = $value[1];
        
        //Consulta de fechas
        $sqlfechas = [['NumSMaq', $maquina], ['FecIUtil','>=',$fechainicial],['FecIUtil','<=',$fechafinal], ['CateUtil','LIKE','Tiempo en '.$cultivo.'']];

        //obtengo desde la fecha mas baja
        $fechamin = Utilidad::where($sqlfechas)
                        ->orderBy('FecIUtil','asc')
                        ->get();

        if (empty($fechamin))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas para el cultivo seleccionado');
        }
        $i=0;
        foreach ($fechamin as $fecha)
        {
            $horasencultivo = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['CateUtil','LIKE','%Tiempo en '.$cultivo.'%'], ['UOMUtil','hr']])->sum('ValoUtil');

            if ($indicador == "detalleautomation") {
                $automation_dia = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['CateUtil','LIKE','%Mantener automáticamente%'],
                                                    ['SeriUtil','Enc'],['UOMUtil', 'hr']])->sum('ValoUtil');
                if($horasencultivo > 0){
                    $automation_d[$i][1]= $fecha->FecIUtil;
                    $automation_d[$i][0] = $automation_dia / $horasencultivo * 100;
                }else{
                    $automation_d[$i][1]= $fecha->FecIUtil;
                    $automation_d[$i][0] = 0;
                }
            }

            if ($indicador == "detalleharvest") {
                $harvest_dia = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['CateUtil','LIKE','%Harvest Smart activado%'],
                                                    ['SeriUtil','Enc'],['UOMUtil', 'hr']])->sum('ValoUtil');
                if($horasencultivo > 0){
                    $harvest_d[$i][1]= $fecha->FecIUtil;
                    $harvest_d[$i][0] = $harvest_dia / $horasencultivo * 100;
                }else{
                    $harvest_d[$i][1]= $fecha->FecIUtil;
                    $harvest_d[$i][0] = 0;
                }
            }

            if ($indicador == "detallemolinete") {
                $molinete_dia = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['CateUtil','LIKE','%Velocidad auto de molinetes%'],
                                                    ['SeriUtil','Enc'],['UOMUtil', 'hr']])->sum('ValoUtil');
                if($horasencultivo > 0){
                    $molinete_d[$i][1]= $fecha->FecIUtil;
                    $molinete_d[$i][0] = $molinete_dia / $horasencultivo * 100;
                }else{
                    $molinete_d[$i][1]= $fecha->FecIUtil;
                    $molinete_d[$i][0] = 0;
                }
            }

            if ($indicador == "detalleatta") {
                $atta_dia = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['CateUtil','LIKE','%Active Terrain Adjustment%'],
                                                    ['SeriUtil','Enc'],['UOMUtil', 'hr']])->sum('ValoUtil');
                if($horasencultivo > 0){
                    $atta_d[$i][1]= $fecha->FecIUtil;
                    $atta_d[$i][0] = $atta_dia / $horasencultivo * 100;
                }else{
                    $atta_d[$i][1]= $fecha->FecIUtil;
                    $atta_d[$i][0] = 0;
                }
            }

            if ($indicador == "detalleautotrac") {
                $autotrac_dia = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['CateUtil','AutoTrac™'],
                                                    ['SeriUtil','Enc'],['UOMUtil', 'hr']])->sum('ValoUtil');
                if($horasencultivo > 0){
                    $autotrac_d[$i][1]= $fecha->FecIUtil;
                    $autotrac_d[$i][0] = $autotrac_dia / $horasencultivo * 100;
                }else{
                    $autotrac_d[$i][1]= $fecha->FecIUtil;
                    $autotrac_d[$i][0] = 0;
                }
            }

            if ($indicador == "detallegiros") {
                $giros_dia = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['CateUtil','AutoTrac™ Turn Automation'],
                                                    ['SeriUtil','Enc'],['UOMUtil', 'hr']])->sum('ValoUtil');
                if($horasencultivo > 0){
                    $giros_d[$i][1]= $fecha->FecIUtil;
                    $giros_d[$i][0] = $giros_dia / $horasencultivo * 100;
                }else{
                    $giros_d[$i][1]= $fecha->FecIUtil;
                    $giros_d[$i][0] = 0;
                }
            }
            $i++;
        }
        if ($indicador == "detalleautomation") {
            $resultado = $automation_d;
        }
        if ($indicador == "detalleharvest") {
            $resultado = $harvest_d;
        }
        if ($indicador == "detallemolinete") {
            $resultado = $molinete_d;
        }
        if ($indicador == "detalleatta") {
            $resultado = $atta_d;
        }
        if ($indicador == "detalleautotrac") {
            $resultado = $autotrac_d;
        }
        if ($indicador == "detallegiros") {
            $resultado = $giros_d;
        }
        
        echo json_encode($resultado);
    }

    function detalle_tporha_lport(Request $request)
    {
        $indicador = $request->get('element_id');
        $valuefec = $request->get('value');
        $cultivo = $request->get('cultivo');
        $maquina = $request->get('maquina');
        $value = explode("/", $valuefec);
        $fechainicial = $value[0];
        $fechafinal = $value[1];
        
        //Consulta de fechas
        $sqlfechas = [['pin', $maquina], ['inicio','>=',$fechainicial],['inicio','<=',$fechafinal], ['cultivo',$cultivo]];

        //obtengo desde la fecha mas baja
        $fechamin = Cosecha::where($sqlfechas)
                        ->groupBy('inicio')
                        ->orderBy('inicio','asc')
                        ->get();

        if (empty($fechamin))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas para el cultivo seleccionado');
        }
        $i=0;
        foreach ($fechamin as $fecha)
        {
            //Indicadores de productividad (t/ha y t/l)

            if ($indicador == "detalletporha") {
                $has = Cosecha::where([['pin', $maquina], ['inicio',$fecha->inicio], ['cultivo',$cultivo]])->sum('superficie');
                $rendimiento = Cosecha::where([['pin', $maquina], ['inicio',$fecha->inicio], ['cultivo',$cultivo]])->sum('rendimiento');
                if(($has > 0) AND ($rendimiento > 0)){
                    $tporha_d[$i][1] = $fecha->inicio;
                    $tporha_d[$i][0] = $rendimiento / $has;
                }else{
                    $tporha_d[$i][1] = $fecha->inicio;
                    $tporha_d[$i][0] = 0;
                }
            }

            if ($indicador == "detallelport") {
                $rendimiento = Cosecha::where([['pin', $maquina], ['inicio',$fecha->inicio], ['cultivo',$cultivo]])->sum('rendimiento');
                $combustible = Cosecha::where([['pin', $maquina], ['inicio',$fecha->inicio], ['cultivo',$cultivo]])->sum('combustible');
                if(($combustible > 0) AND ($rendimiento > 0)){
                    $lport_d[$i][1] = $fecha->inicio;
                    $lport_d[$i][0] = $combustible / $rendimiento;
                }else{
                    $lport_d[$i][1] = $fecha->inicio;
                    $lport_d[$i][0] = 0;
                }
            }

            $i++;
        }
        if ($indicador == "detalletporha") {
            $resultado = $tporha_d;
        }
        if ($indicador == "detallelport") {
            $resultado = $lport_d;
        }
        
        echo json_encode($resultado);
    }

    function detalle_carga_cabecero_ralenti(Request $request)
    {
        $indicador = $request->get('element_id');
        $valuefec = $request->get('value');
        $cultivo = $request->get('cultivo');
        $maquina = $request->get('maquina');
        $value = explode("/", $valuefec);
        $fechainicial = $value[0];
        $fechafinal = $value[1];
        
        //Consulta de fechas
        $sqlfechas = [['NumSMaq', $maquina], ['FecIUtil','>=',$fechainicial],['FecIUtil','<=',$fechafinal], ['CateUtil','LIKE','Tiempo en '.$cultivo.'']];

        //obtengo desde la fecha mas baja
        $fechamin = Utilidad::where($sqlfechas)
                        ->orderBy('FecIUtil','asc')
                        ->get();

        if (empty($fechamin))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas para el cultivo seleccionado');
        }
        $i=0;
        foreach ($fechamin as $fecha)
        {
            if ($indicador == "detallefactor") {
                $factor = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                    ['UOMUtil', '%']])->avg('ValoUtil');
                $factor_carga[$i][1]= $fecha->FecIUtil;
                $factor_carga[$i][0] = $factor*1;
            }
            $trabajando = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Trabajando'],
                                    ['UOMUtil', 'hr']])->sum('ValoUtil');
            $transporte = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Transporte'],
                                    ['UOMUtil', 'hr']])->sum('ValoUtil');
            $ralenti = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Ralentí'],
                                    ['UOMUtil', 'hr']])->sum('ValoUtil');

            $hrtotal = $trabajando + $transporte + $ralenti;
            $ralenti_total = $ralenti / $hrtotal * 100;

            if ($indicador == "detalleralentilleno") {
                $ralenti_tllena = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Ralentí con depósito de grano lleno'],
                                    ['UOMUtil', 'hr']])->sum('ValoUtil');
                $ralenti_lleno[$i][1] = $fecha->FecIUtil;
                $ralenti_lleno[$i][0] = $ralenti_tllena / $hrtotal * 100;
            }
            if ($indicador == "detalleralentivacio") {
                $ralenti_tvacia = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Ralentí con depósito de grano no lleno'],
                                    ['UOMUtil', 'hr']])->sum('ValoUtil');
                $ralenti_vacio[$i][1] = $fecha->FecIUtil;
                $ralenti_vacio[$i][0] = $ralenti_tvacia / $hrtotal * 100;
            }
            if ($indicador == "detalleseparador") {
                $separador_virajes = Utilidad::where([['FecIUtil', $fecha->FecIUtil], ['NumSMaq', $fecha->NumSMaq], ['SeriUtil','Separador de virajes en cabecero engranado'],
                                    ['UOMUtil', 'hr']])->sum('ValoUtil');
                $separador[$i][1] = $fecha->FecIUtil;
                $separador[$i][0] = $separador_virajes / $hrtotal * 100;
            }

            
            $ralenti_total_t[$i][1] = $fecha->FecIUtil;
            $ralenti_total_t[$i][0] = $ralenti_total;
            $i++;
        }
        if ($indicador == "detallefactor") {
            $resultado = $factor_carga;
        }
        if ($indicador == "detalleralenti") {
            $resultado = $ralenti_total_t;
        }
        if ($indicador == "detalleralentivacio") {
            $resultado = $ralenti_vacio;
        }
        if ($indicador == "detalleralentilleno") {
            $resultado = $ralenti_lleno;
        }
        if ($indicador == "detalleseparador") {
            $resultado = $separador;
        }
        
        echo json_encode($resultado);
    }


    public function informe(Request $request)
    {
        Gate::authorize('haveaccess','utilidad.informe');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes de eficiencia de equipos (Generacion)']);
        request()->validate([
            'NumSMaq' => 'required',
            'desde' => 'required',
            'hasta' => 'required',
            'horas' => 'required|integer|min:30',
        ]);
        $numsmaq = $request->NumSMaq;
        $finicio = $request->desde;
        $ffin = $request->hasta;
        $horas = $request->horas;

        $maquina = Maquina::where('NumSMaq',$numsmaq)->first();

        if ($maquina->TipoMaq == "COSECHADORA"){
            $cultivo = $request->inlineRadioOptions;
            if (($cultivo == 'maíz') OR ($cultivo == 'girasol')){
                request()->validate([
                    'apero' => 'required|numeric|min:0|not_in:0',
                ]);
                $implemento = $request->apero;
            } else {
                request()->validate([
                    'plataforma' => 'required|numeric|min:0|not_in:0',
                ]);
                $implemento = $request->plataforma;
            }

            return $this->informeCosechadora($maquina, $finicio, $ffin, $cultivo, $horas, $implemento);

        }elseif ($maquina->TipoMaq == "TRACTOR"){
                request()->validate([
                    'apero' => 'required',
                ]);
                $implemento = $request->apero;
            return $this->informeTractor($maquina, $finicio, $ffin, $horas, $implemento);

        }elseif ($maquina->TipoMaq == "PULVERIZADORA"){
                request()->validate([
                    'apero' => 'required',
                ]);
                $implemento = $request->apero;
            return $this->informeTractor($maquina, $finicio, $ffin, $horas, $implemento);

        }

    }



    public function informeComparar(Request $request)
    {
        Gate::authorize('haveaccess','utilidad.informe');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Informes de eficiencia de equipos (Generacion comparativo)']);
        request()->validate([
            'NumSMaq' => 'required',
        ]);
        $nseriemaquinas = $request->NumSMaq;
        $finicio = $request->desde;
        $ffin = $request->hasta;
        $maquina = Maquina::where('NumSMaq',$nseriemaquinas)->first();
        
        if ($maquina->TipoMaq == "COSECHADORA"){
            $cultivo = $request->inlineRadioOptions;
            $i=0;
            if (($cultivo == 'maíz') OR ($cultivo == 'girasol')){
                foreach ($nseriemaquinas as $nseriemaquina){
                    $valido = $request->get('apero'.$i);
                    if(empty($valido)){
                        return redirect()->back()->with('status_danger', 'Vuelva a completar el formulario y procure rellenar los campos de ancho de plataforma/cabezal o implemento');
                    }
                    $implemento[$i] = $valido;
                    $i++;
                }
            } else {
                foreach ($nseriemaquinas as $nseriemaquina){
                    $valido = $request->get('plataforma'.$i);
                    if(empty($valido)){
                        return redirect()->back()->with('status_danger', 'Vuelva a completar el formulario y procure rellenar los campos de ancho de plataforma/cabezal o implemento');
                    }
                    $implemento[$i] = $valido;
                    $i++;
                }
            }
            return $this->informeCompararCosechadora($nseriemaquinas, $finicio, $ffin, $cultivo, $implemento);

        }elseif ($maquina->TipoMaq == "TRACTOR"){
                request()->validate([
                    'apero' => 'required',
                ]);
                $implemento = $request->apero;
            //return $this->informeTractor($maquina, $finicio, $ffin, $implemento);

        }elseif ($maquina->TipoMaq == "PULVERIZADORA"){
                request()->validate([
                    'apero' => 'required',
                ]);
                $implemento = $request->apero;
           // return $this->informeTractor($maquina, $finicio, $ffin, $implemento);

        }
    }



    public function informeCompararCosechadora($maquinas, $finicio, $ffin, $cultivo, $implemento)
    {
        $m = 0;
        //Consultamos nombre de organizacion y sucursal
        foreach ($maquinas as $maquina){
        $datosmaq = Maquina::select('organizacions.NombOrga','sucursals.NombSucu')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->where('maquinas.NumSMaq',$maquina)->first();

        $maq[$m] = Maquina::where('NumSMaq',$maquina)->first();
        

        //Obtengo la hora de trilla inicial y final segun el rango de fechas para luego calcular los periodos
        $horasdetrillainicial[$m] = Utilidad::where([['NumSMaq',$maq[$m]->NumSMaq], 
                                                    ['CateUtil', 'Total de horas de separador'], 
                                                    ['FecIUtil','>=', $finicio]])
                                            ->orderBy('ValoUtil','asc')->first();

        $horasdetrillafinal[$m] = Utilidad::where([['NumSMaq',$maq[$m]->NumSMaq], 
                                                ['CateUtil', 'Total de horas de separador'], 
                                                ['FecIUtil','<=', $ffin]])
                                            ->orderBy('ValoUtil','desc')->first();
        
        if((isset($horasdetrillainicial[$m])) OR (isset($horasdetrillafinal[$m]))){
            //Calculo diferencia entre hs de trilla final y hs de trilla inicial para saber cuanto trillo acumulado
            $diftrilla[$m] = $horasdetrillafinal[$m]->ValoUtil - $horasdetrillainicial[$m]->ValoUtil;
        }else{
            $diftrilla[$m] = 0;
        }

        //definimos el ancho de plataforma segun el cultivo
        if (($cultivo == "maíz") OR ($cultivo == "girasol")){
            $plataforma[$m] = $implemento[$m];
        } else {
            $plataforma[$m] = $implemento[$m] * 0.3048;
        }
            $m++;
        }  
        $cantidad = $m-1;

            /////////////////// INICIO DE CALCULOS DE EFICIENCIA DE MAQUINA /////////////////////
 
            //Utilizo repetitiva para calcular indicadores para cada uno de los periodos
            for ($i=0; $i < $m; $i++) { 
                
                //-----------------------ZONA DE CONSULTAS----------------------
                    
                $consulta = [['NumSMaq', $maq[$i]->NumSMaq], ['FecIUtil','>=',$horasdetrillainicial[$i]->FecIUtil],
                            ['FecIUtil','<=',$horasdetrillafinal[$i]->FecIUtil]];
                $consulta_productividad = [['pin',$maq[$i]->NumSMaq],['inicio','>=',$horasdetrillainicial[$i]->FecIUtil],['inicio','<=',$horasdetrillafinal[$i]->FecIUtil],
                            ['cultivo',$cultivo]];

                
                //Consulta promedio de velocidad promedio, consumo y factor de carga del motor
                $velocidad[$i] = Utilidad::where([[$consulta], ['SeriUtil','Cosecha'], ['ValoUtil','>','3'],
                                            ['UOMUtil', 'km/hr']])->avg('ValoUtil');

                $consumoph = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','10'],
                                            ['UOMUtil', 'l/hr']])->avg('ValoUtil');

                $factordecarga[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','50'],
                                                    ['UOMUtil', '%']])->avg('ValoUtil');

                //Consulta tiempo trabajando, en ralenti y en transporte
                $trabajandohs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');

                $transportehs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');
                        
                $ralentihs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');

                //Consulta ralenti con tolva llena y con tolva vacia
                $ralentillenahs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Ralentí con depósito de grano lleno']
                                                                ,['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');

                $ralentivaciahs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Ralentí con depósito de grano no lleno']
                                                                ,['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');

                $separadordevirajeshs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Separador de virajes en cabecero engranado']
                                                                        ,['UOMUtil', 'hr']])
                                                    ->sum('ValoUtil');

                //Indicadores de productividad (t/ha y t/l)
                $has = Cosecha::where($consulta_productividad)->sum('superficie');
                $rendimiento = Cosecha::where($consulta_productividad)->sum('rendimiento');
                $combustible = Cosecha::where($consulta_productividad)->sum('combustible');

                if(($has > 0) AND ($rendimiento > 0)){
                    $tporha[$i] = $rendimiento / $has;
                }else{
                    $tporha[$i] = 0;
                }

                if(($rendimiento > 0) AND ($combustible > 0)){
                    $lport[$i] = $combustible / $rendimiento;
                }else{
                    $lport[$i] = 0;
                }


                $horasencultivos[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Tiempo en '.$cultivo.'%'], ['UOMUtil','hr']])->sum('ValoUtil');
                $autotracs[$i] = Utilidad::where([[$consulta], ['CateUtil','AutoTrac'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                if (($cultivo <> "maíz") OR ($cultivo <> "girasol")){
                    $velmolinetes[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Velocidad auto de molinetes%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                } else {
                    $velmolinetes[$i] = 0;
                }
                $harvests[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Harvest Smart activado%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $alturaplataformas[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Altura autom de plataforma de corte%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $mantenerautos[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Mantener automáticamente%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                
                if (!empty($horasencultivos[$i]) OR ($horasencultivos[$i] <> 0)) {
                    $autotrac[$i] = ($autotracs[$i] / $horasencultivos[$i]) * 100;
                    $velmolinete[$i] =( $velmolinetes[$i] / $horasencultivos[$i]) * 100;
                    $harvest[$i] = ($harvests[$i] / $horasencultivos[$i]) * 100;
                    $alturaplataforma[$i] = ($alturaplataformas[$i] / $horasencultivos[$i]) * 100;
                    $mantenerauto[$i] = ($mantenerautos[$i] / $horasencultivos[$i]) * 100;
                } else {
                    $autotrac[$i] = 0;
                    $velmolinete[$i] = 0;
                    $harvest[$i] = 0;
                    $alturaplataforma[$i] = 0;
                    $mantenerauto[$i] = 0;
                }

                //CONSUMOS DE COMBUSTIBLE SEGUN ESTADO: RALENTI, TRANSPORTE Y TRABAJANDO
                $ralentilts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Ralentí'], ['UOMUtil','l']])->sum('ValoUtil');
                $transportelts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Transporte'], ['UOMUtil','l']])->sum('ValoUtil');
                $trabajandolts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Trabajando'], ['UOMUtil','l']])->sum('ValoUtil');
                $ralentillenolts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Ralentí con depósito de grano lleno'], ['UOMUtil','l']])->sum('ValoUtil');
                $ralentivaciolts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Ralentí con depósito de grano no lleno'], ['UOMUtil','l']])->sum('ValoUtil');
                $separadorlts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Separador de virajes en cabecero engranado'], ['UOMUtil','l']])->sum('ValoUtil');
                
                
                //-------------------ZONA DE CALCULOS Y RESULTADOS---------------------------


                //Calcula la superficie cosechada por hora
                $superficie[$i] = $plataforma[$i]*$velocidad[$i]*0.1;
                if ($superficie[$i] <> 0){
                     //Calculam el consumo por hectarea
                    $consumo[$i] = $consumoph / $superficie[$i];
                }else{
                    $consumo[$i] = 0; 
                }
               

                //Calcula el ralenti en % y con tolva llena y vacia y separador de virajes con cabecero engranado
                $totalhs[$i] = $ralentihs[$i] + $trabajandohs[$i] + $transportehs[$i];
                if ($totalhs[$i] <> 0){
                    $ralenti[$i] = $ralentihs[$i] * 100 / $totalhs[$i];
                    $ralentillena[$i] = $ralentillenahs[$i] * 100 / $totalhs[$i];
                    $ralentivacia[$i] = $ralentivaciahs[$i] * 100 / $totalhs[$i];
                    $separadordevirajes[$i] = $separadordevirajeshs[$i] * 100 / $totalhs[$i];
                } else {
                    $ralenti[$i] = 0;
                    $ralentillena[$i] = 0;
                    $ralentivacia[$i] = 0;
                    $separadordevirajes[$i] = 0;
                }
            }//endfor

        $rutavolver = route('utilidad.menu');
        return view('utilidad.informeCompararCosechadora', compact('datosmaq','maquina','cultivo','velocidad','superficie','consumo',
                                        'factordecarga','trabajandohs','transportehs','ralentihs','ralenti',
                                        'ralentillena','ralentivacia','separadordevirajes','horasdetrillainicial',
                                        'horasdetrillafinal','trabajandolts','ralentilts','transportelts','diftrilla',
                                        'autotrac','velmolinete','harvest','alturaplataforma','mantenerauto','implemento',
                                        'rutavolver','cantidad','ffin','finicio','maq','tporha','lport')); 
        }





    public function informeAcarreo(Request $request)
    {
        Gate::authorize('haveaccess','utilidad.informeAcarreo');
        request()->validate([
            'NumSMaq' => 'required',
            'desde' => 'required',
            'hasta' => 'required',
            'horas' => 'required|integer|min:30',
        ]);
        $numsmaq = $request->NumSMaq;
        $finicio = $request->desde;
        $ffin = $request->hasta;
        $horas = $request->horas;

        $maquina = Maquina::where('NumSMaq',$numsmaq)->first();
                
        return $this->informeTractorAcarreo($maquina, $finicio, $ffin, $horas);
    }


    public function informeTractorAcarreo($maquina, $finicio, $ffin, $horas)
    {
        //Consultamos nombre de organizacion y sucursal
        $datosmaq = Maquina::select('organizacions.NombOrga','sucursals.NombSucu')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->where('maquinas.NumSMaq',$maquina->NumSMaq)->first();
        
         //Consulta de fechas
         $sqlfechas = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$finicio],['FecIUtil','<=',$ffin]];

         //obtengo la fecha mas baja que realmente trabajo el tractor/pulverizadora
         $fechamin = Utilidad::where($sqlfechas)
                             ->orderBy('FecIUtil','asc')
                             ->first();
                             
         //obtengo la fecha mas alta que realmente trabajo el tractor/pulverizadora
         $fechamax = Utilidad::where($sqlfechas)
                             ->orderBy('FecIUtil','desc')
                             ->first();

        

        if (empty($fechamin) || empty($fechamax))
        {
            return redirect()->route('utilidad.acarreo')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas seleccionado desde:'.$fechamin.' hasta: '.$fechamax.'');
        }
        
        //Obtengo la hora de trilla inicial y final segun el rango de fechas para luego calcular los periodos
        $horasdemotorinicial = Horasmotor::where([['NumSMaq',$maquina->NumSMaq], 
                                    ['created_at','>=', date($fechamin->FecIUtil." 00:00:01")]])
                                    ->orderBy('horas','asc')->first();

        $horasdemotorfinal = Horasmotor::where([['NumSMaq',$maquina->NumSMaq],  
                                    ['created_at','<=', date($fechamax->FecIUtil." 23:59:59")]])
                                    ->orderBy('horas','desc')->first();

        if (isset($horasdemotorfinal->horas) AND isset($horasdemotorinicial->horas)) {
           //Calculo diferencia entre hs de motor final y hs de motor inicial para saber cuanto trillo acumulado
            $horasmotorenperiodo = $horasdemotorfinal->horas - $horasdemotorinicial->horas;  
        } else {
            return redirect()->route('utilidad.acarreo')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas seleccionado ');
        }

    
        
        if ($horasmotorenperiodo > 0){
            $periodos = $horasmotorenperiodo / $horas;
        } else {
            return redirect()->route('utilidad.acarreo')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas seleccionado');
        }
        
        $registros = Utilidad::where(function($q) use ($sqlfechas){
                            $q->where(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Ralentí')
                                ->where('UOMUtil','hr');      
                            })
                            ->orWhere(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Trabajando')
                                ->where('UOMUtil','hr');
                            })
                            ->orWhere(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Transporte')
                                ->where('UOMUtil','hr');
                            });
                            })->count();
        
        $datos = Utilidad::where(function($q) use ($sqlfechas){
                            $q->where(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Ralentí')
                                ->where('UOMUtil','hr');      
                            })
                            ->orWhere(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Trabajando')
                                ->where('UOMUtil','hr');
                            })
                            ->orWhere(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Transporte')
                                ->where('UOMUtil','hr');
                            });
                            })->orderBy('FecIUtil','asc')->get();
        
        $y=0;
        //variable acumulativa hasta llegar a las horas definidas de motor para cada período
        $hsenperiodo = 0;
        $fechainicio[0] = $datos[0]->FecIUtil;
        //Repetitiva para ir guardando en un array cada hora de motor de cada periodo
        for ($i=0; $i <= $periodos; $i++) { 
            for ($z=$y; $z < $registros; $z++) { 
                if($hsenperiodo > $horas){
                    $fechainicio[$i + 1] = $datos[$z]->FecIUtil;
                    break 1; 
                } else{
                    $hsenperiodo = $hsenperiodo + $datos[$z]->ValoUtil;
                    $fecha = $datos[$z]->FecIUtil;
                }
                
            }
            $fechafin[$i] = $fecha;
            $horasenperiodo[$i] = $hsenperiodo;
            $hsenperiodo = 0;
            $y = $z;
        }
        
        

        /////////////////// INICIO DE CALCULOS DE EFICIENCIA DE TRACTOR/PULVERIZADORA /////////////////////

            //Utilizo repetitiva para calcular indicadores para cada uno de los periodos
            for ($i=0; $i <= $periodos + 2; $i++) { 
                
                //-----------------------ZONA DE CONSULTAS----------------------

                //Condicion si es la ultima iteración del "for", calcula todo con las fechas acumuladas.Hace un promedio.
                if ($i >= $periodos + 1){
                    
                $consulta = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$fechamin->FecIUtil],
                            ['FecIUtil','<=',$fechamax->FecIUtil]];

                $acumralentihs = Utilidad::where([[$consulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil'); 
                $acumtrabajandohs = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');
                $acumtransportehs = Utilidad::where([[$consulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');  
                $autotrac = Utilidad::where([[$consulta], ['CateUtil','LIKE','AutoTrac%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $fieldcruise = Utilidad::where([[$consulta], ['CateUtil','LIKE','FieldCruise%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');

                //TEMPERATURAS
                $temppromhidraulico = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp promedio de aceite hidráulico%'], ['SeriUtil', 'Temperatura']])->avg('ValoUtil');
                $tempmaxhidraulico = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx de aceite hidráulico%'], ['SeriUtil', 'Temperatura']])->max('ValoUtil');
                $diahidraulicomax = Utilidad::select('FecIUtil')
                                            ->where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx de aceite hidráulico%'], ['SeriUtil', 'Temperatura'], ['ValoUtil', $tempmaxhidraulico]])->first();
                $temppromrefrigerante = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp de refrigerante promedio%'], ['SeriUtil', 'Temperatura']])->avg('ValoUtil');
                $tempmaxrefrigerante = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx refrigerante%'], ['SeriUtil', 'Temperatura']])->max('ValoUtil');
                $diarefrigerantemax =  Utilidad::select('FecIUtil')
                                            ->where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx refrigerante%'], ['SeriUtil', 'Temperatura'], ['ValoUtil', $tempmaxrefrigerante]])->first();

                //$temppromtransmision = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp promedio aceite transm%'], ['SeriUtil', 'Temperatura']])->avg('ValoUtil');
                //$tempmaxtransmision = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx de aceite transmisión%'], ['SeriUtil', 'Temperatura']])->max('ValoUtil');
                //$diatransmisionmax =  Utilidad::select('FecIUtil')
                                         //   ->where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx de aceite transmisión%'], ['SeriUtil', 'Temperatura'], ['ValoUtil', $tempmaxtransmision]])->first();
                
                
                $valor = 'objetivo';

                $objetivoralenti = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Ralenti (%)']])
                                            ->avg($valor);
                                                   
            } else {
                
                    //Consulta que se realizara para completar todas las demas consultas a futuro
                    if (empty($fechainicio[$i])){
                        $fechainicio[$i] = $fechamin->FecIUtil;
                    } 
                    if(empty($fechafin[$i])){
                        $fechafin[$i] = $fechamax->FecIUtil;
                        $ultimoperiodo = $i;
                    } 
                    
                $consulta = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$fechainicio[$i]],
                ['FecIUtil','<=', $fechafin[$i]]];
                
                }
                
                //Consulta promedio de velocidad promedio, consumo y factor de carga del motor
                $velocidad[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','2'],
                                            ['UOMUtil', 'km/hr']])->avg('ValoUtil');

                $consumo[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['UOMUtil', 'l/hr']])->avg('ValoUtil');
                
                $factordecarga[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'],
                                                    ['UOMUtil', '%']])->avg('ValoUtil');

                $rpm[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['UOMUtil', 'RPM']])->avg('ValoUtil');
        
                //Consulta tiempo trabajando, en ralenti y en transporte
                $trabajandohs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');
                
                $transportehs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');
                        
                $ralentihs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');


                //CONSUMOS DE COMBUSTIBLE SEGUN ESTADO: RALENTI, TRANSPORTE Y TRABAJANDO
                $ralentilts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Ralentí'], ['UOMUtil','l']])->sum('ValoUtil');
                $transportelts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Transporte'], ['UOMUtil','l']])->sum('ValoUtil');
                $trabajandolts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Trabajando'], ['UOMUtil','l']])->sum('ValoUtil');
               
                

                //-------------------ZONA DE CALCULOS Y RESULTADOS---------------------------
               

                //Calcula el ralenti en % y con tolva llena y vacia y separador de virajes con cabecero engranado
                $totalhs[$i] = $ralentihs[$i] + $trabajandohs[$i] + $transportehs[$i];
                if ($totalhs[$i] <> 0){
                    $ralenti[$i] = $ralentihs[$i] * 100 / $totalhs[$i];
                } else {
                    $ralenti[$i] = 0;
                }
            }//endfor

            //VALORES DE REFERENCIA
            $refconsulta = [['maquinas.ModeMaq', $maquina->ModeMaq], ['FecIUtil','>=',$fechamin->FecIUtil],
            ['FecIUtil','<=',$fechamax->FecIUtil]];

            $refralentihs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                    ->where([[$refconsulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                    ->inRandomOrder()->take(10)
                                    ->sum('ValoUtil'); 
            $reftrabajandohs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)
                                        ->sum('ValoUtil');
            $reftransportehs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)
                                        ->sum('ValoUtil');

            $reftotalhs = $refralentihs + $reftrabajandohs + $reftransportehs;
            if ($reftotalhs <> 0){
                $refralenti = $refralentihs * 100 / $reftotalhs;
            } else {
                $refralenti = 0;
                //$refralentillena[$i] = 0;
                //$refralentivacia[$i] = 0;
                //$refseparadordevirajes[$i] = 0;
            }

            $reffactordecarga_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta], ['SeriUtil','Trabajando'],
                                                    ['UOMUtil', '%']])->inRandomOrder()->take(10)
                                                    ->avg('ValoUtil');

            if ($reffactordecarga_sql <> 0){
                $reffactordecarga = $reffactordecarga_sql;
            } else {
                $reffactordecarga = 0;
            }

            $refconsumo_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta], ['SeriUtil','Trabajando'],
                                                    ['UOMUtil', 'l/hr']])->inRandomOrder()->take(10)
                                                    ->avg('ValoUtil');

            if ($refconsumo_sql <> 0){
                $refconsumo = $refconsumo_sql;
            } else {
                $refconsumo = 0;
            }
            $refrpm_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                    ->where([[$refconsulta], ['SeriUtil','Trabajando'], ['UOMUtil', 'RPM']])
                                    ->inRandomOrder()->take(10)
                                    ->avg('ValoUtil');
            if ($refrpm_sql <> 0){
                $refrpm = $refrpm_sql;
            } else {
                $refrpm = 0;
            }
            
            //Se cuenta la cantidad de registros (maquinas) para iterar el For
            $refcantidad = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                ->where($refconsulta)
                                ->inRandomOrder()->take(10)
                                ->distinct('utilidads.NumSMaq')->get();

            $ivelocidad = 0;
            $totalrefvelocidad = 0;
            $i = 0;
            //Guardo datos
            foreach ($refcantidad as $refcant) {
                //Consulta promedio de velocidad promedio, consumo y factor de carga del motor
                $refvelocidad_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta],['utilidads.NumSMaq',$refcant->NumSMaq], 
                                                    ['SeriUtil','Trabajando'], ['ValoUtil','>','3'],
                                                    ['UOMUtil', 'km/hr']])->avg('ValoUtil');

                if ($refvelocidad_sql <> 0){
                    $refvelocidad[$i] = $refvelocidad_sql;
                    $ivelocidad++;
                } else {
                    $refvelocidad[$i] = 0;
                }



                //Acumulo los valores que va obteniendo para luego hacer el calculo del promedio
                $totalrefvelocidad = $totalrefvelocidad + $refvelocidad[$i];
                $i++;
            }

            //Calcula los valores promedio
            if(($totalrefvelocidad <> 0) AND ($ivelocidad <> 0)){
                $totalrefvelocidad = $totalrefvelocidad / $ivelocidad;
            } else {
                $totalrefvelocidad = 0;
            }
            

            //Calculo de consumos de combustible cosechando, ralenti y separador de virajes
            $consumoralenti = $ralentilts[$ultimoperiodo];
            
            if((isset($objetivoralenti)) && (isset($ralenti[$ultimoperiodo]))){
                $consumoralentiobjetivo = $objetivoralenti * $consumoralenti / $ralenti[$ultimoperiodo];
            } else {
                $consumoralentiobjetivo = 0;
            }
            
         
        $rutavolver = route('utilidad.menu');
        return view('utilidad.informeTractorAcarreo', compact('datosmaq','maquina','fechainicio','fechafin','periodos'
                                        ,'velocidad','consumo','factordecarga','trabajandohs'
                                        ,'transportehs','ralentihs','ralenti','acumtrabajandohs'
                                        ,'acumtransportehs','horasdemotorinicial','horasdemotorfinal'
                                        ,'autotrac'
                                        ,'temppromhidraulico','tempmaxhidraulico','temppromrefrigerante'
                                        ,'tempmaxrefrigerante','objetivoralenti','consumoralenti'
                                        ,'consumoralentiobjetivo','diahidraulicomax','diarefrigerantemax','refconsumo'
                                        ,'acumralentihs','acumtrabajandohs'
                                        ,'acumtransportehs','rpm','refralenti','reffactordecarga','refrpm'
                                        ,'fieldcruise','totalrefvelocidad','rutavolver'));
    
    }


    public function informeTractor($maquina, $finicio, $ffin, $horas, $implemento)
    {
        //Consultamos nombre de organizacion y sucursal
        $datosmaq = Maquina::select('organizacions.NombOrga','sucursals.NombSucu')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->where('maquinas.NumSMaq',$maquina->NumSMaq)->first();
        
         //Consulta de fechas
         $sqlfechas = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$finicio],['FecIUtil','<=',$ffin]];
         

         //obtengo la fecha mas baja que realmente trabajo el tractor/pulverizadora
         $fechamin = Utilidad::where($sqlfechas)
                             ->orderBy('FecIUtil','asc')
                             ->first();
                             
         //obtengo la fecha mas alta que realmente trabajo el tractor/pulverizadora
         $fechamax = Utilidad::where($sqlfechas)
                             ->orderBy('FecIUtil','desc')
                             ->first();


        if (empty($fechamin) || empty($fechamax))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas seleccionado desde:'.$fechamin.' hasta: '.$fechamax.'');
        }
        
        //Obtengo la hora de trilla inicial y final segun el rango de fechas para luego calcular los periodos
        $horasdemotorinicial = Horasmotor::where([['NumSMaq',$maquina->NumSMaq], 
                                    ['created_at','>=', date($fechamin->FecIUtil." 00:00:01")]])
                                    ->orderBy('horas','asc')->first();

        $horasdemotorfinal = Horasmotor::where([['NumSMaq',$maquina->NumSMaq],  
                                    ['created_at','<=', date($fechamax->FecIUtil." 23:59:59")]])
                                    ->orderBy('horas','desc')->first();

        if (isset($horasdemotorfinal->horas) AND isset($horasdemotorinicial->horas)) {
           //Calculo diferencia entre hs de motor final y hs de motor inicial para saber cuanto trillo acumulado
            $horasmotorenperiodo = $horasdemotorfinal->horas - $horasdemotorinicial->horas;  
        } else {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas seleccionado ');
        }

    
        
        if ($horasmotorenperiodo > 0){
            $periodos = $horasmotorenperiodo / $horas;
        } else {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas seleccionado');
        }
        
        $registros = Utilidad::where(function($q) use ($sqlfechas){
                            $q->where(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Ralentí')
                                ->where('UOMUtil','hr');      
                            })
                            ->orWhere(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Trabajando')
                                ->where('UOMUtil','hr');
                            })
                            ->orWhere(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Transporte')
                                ->where('UOMUtil','hr');
                            });
                            })->count();
        
        $datos = Utilidad::where(function($q) use ($sqlfechas){
                            $q->where(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Ralentí')
                                ->where('UOMUtil','hr');      
                            })
                            ->orWhere(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Trabajando')
                                ->where('UOMUtil','hr');
                            })
                            ->orWhere(function($query) use ($sqlfechas){
                                $query->where($sqlfechas)
                                ->where('SeriUtil','Transporte')
                                ->where('UOMUtil','hr');
                            });
                            })->orderBy('FecIUtil','asc')->get();
        
        $y=0;
        //variable acumulativa hasta llegar a las horas definidas de motor para cada período
        $hsenperiodo = 0;
        $fechainicio[0] = $datos[0]->FecIUtil;
        //Repetitiva para ir guardando en un array cada hora de motor de cada periodo
        for ($i=0; $i <= $periodos; $i++) { 
            for ($z=$y; $z < $registros; $z++) { 
                if($hsenperiodo > $horas){
                    $fechainicio[$i + 1] = $datos[$z]->FecIUtil;
                    break 1; 
                } else{
                    $hsenperiodo = $hsenperiodo + $datos[$z]->ValoUtil;
                    $fecha = $datos[$z]->FecIUtil;
                }
                
            }
            $fechafin[$i] = $fecha;
            $horasenperiodo[$i] = $hsenperiodo;
            $hsenperiodo = 0;
            $y = $z;
        }
        
        

        /////////////////// INICIO DE CALCULOS DE EFICIENCIA DE TRACTOR/PULVERIZADORA /////////////////////

            //definimos el ancho de implemento
            $plataforma = $implemento;
            
            
            //Utilizo repetitiva para calcular indicadores para cada uno de los periodos
            for ($i=0; $i <= $periodos + 2; $i++) { 
                
                //-----------------------ZONA DE CONSULTAS----------------------

                //Condicion si es la ultima iteración del "for", calcula todo con las fechas acumuladas.Hace un promedio.
                if ($i >= $periodos + 1){
                    
                $consulta = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$fechamin->FecIUtil],
                            ['FecIUtil','<=',$fechamax->FecIUtil]];

                $acumralentihs = Utilidad::where([[$consulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil'); 
                $acumtrabajandohs = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');
                $acumtransportehs = Utilidad::where([[$consulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');  
                $autotrac = Utilidad::where([[$consulta], ['CateUtil','LIKE','AutoTrac%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');

                //TEMPERATURAS
                $temppromhidraulico = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp promedio de aceite hidráulico%'], ['SeriUtil', 'Temperatura']])->avg('ValoUtil');
                $tempmaxhidraulico = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx de aceite hidráulico%'], ['SeriUtil', 'Temperatura']])->max('ValoUtil');
                $diahidraulicomax = Utilidad::select('FecIUtil')
                                            ->where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx de aceite hidráulico%'], ['SeriUtil', 'Temperatura'], ['ValoUtil', $tempmaxhidraulico]])->first();
                $temppromrefrigerante = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp de refrigerante promedio%'], ['SeriUtil', 'Temperatura']])->avg('ValoUtil');
                $tempmaxrefrigerante = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx refrigerante%'], ['SeriUtil', 'Temperatura']])->max('ValoUtil');
                $diarefrigerantemax =  Utilidad::select('FecIUtil')
                                            ->where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx refrigerante%'], ['SeriUtil', 'Temperatura'], ['ValoUtil', $tempmaxrefrigerante]])->first();

                $temppromtransmision = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp promedio aceite transm%'], ['SeriUtil', 'Temperatura']])->avg('ValoUtil');
                $tempmaxtransmision = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx de aceite transmisión%'], ['SeriUtil', 'Temperatura']])->max('ValoUtil');
                $diatransmisionmax =  Utilidad::select('FecIUtil')
                                            ->where([[$consulta], ['CateUtil', 'LIKE', 'Temp máx de aceite transmisión%'], ['SeriUtil', 'Temperatura'], ['ValoUtil', $tempmaxtransmision]])->first();
                
                
                $valor = 'objetivo';
                
                //Consulta de objetivos
                $objetivosuperficie = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Superficie cosechada por hora (Has)']])
                                            ->avg($valor);
                                            
                $objetivoconsumo = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Consumo de combustible por hectarea (lts)']])
                                            ->avg($valor);

                $objetivoralenti = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Ralenti (%)']])
                                            ->avg($valor);
                                                   
            } else {
                
                    //Consulta que se realizara para completar todas las demas consultas a futuro
                    if (empty($fechainicio[$i])){
                        $fechainicio[$i] = $fechamin->FecIUtil;
                    } 
                    if(empty($fechafin[$i])){
                        $fechafin[$i] = $fechamax->FecIUtil;
                        $ultimoperiodo = $i;
                    } 
                    
                $consulta = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$fechainicio[$i]],
                ['FecIUtil','<=', $fechafin[$i]]];
                
                }
                
                //Consulta promedio de velocidad promedio, consumo y factor de carga del motor
                $velocidad[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','3'],
                                            ['UOMUtil', 'km/hr']])->avg('ValoUtil');
                

                $consumoph = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','3'],
                                            ['UOMUtil', 'l/hr']])->avg('ValoUtil');
                
                $factordecarga[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','15'],
                                                    ['UOMUtil', '%']])->avg('ValoUtil');

                $rpm[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['UOMUtil', 'RPM']])->avg('ValoUtil');
        
                //Consulta tiempo trabajando, en ralenti y en transporte
                $trabajandohs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');
                
                $transportehs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');
                        
                $ralentihs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');


                //CONSUMOS DE COMBUSTIBLE SEGUN ESTADO: RALENTI, TRANSPORTE Y TRABAJANDO
                $ralentilts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Ralentí'], ['UOMUtil','l']])->sum('ValoUtil');
                $transportelts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Transporte'], ['UOMUtil','l']])->sum('ValoUtil');
                $trabajandolts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Trabajando'], ['UOMUtil','l']])->sum('ValoUtil');
               
                

                //-------------------ZONA DE CALCULOS Y RESULTADOS---------------------------


                //Calcula la superficie cosechada por hora
                $superficie[$i] = $plataforma*$velocidad[$i]*0.1;
                if ($superficie[$i] <> 0){
                     //Calculam el consumo por hectarea
                    $consumo[$i] = $consumoph / $superficie[$i];
                }else{
                    $consumo[$i] = 0; 
                }
               

                //Calcula el ralenti en % y con tolva llena y vacia y separador de virajes con cabecero engranado
                $totalhs[$i] = $ralentihs[$i] + $trabajandohs[$i] + $transportehs[$i];
                if ($totalhs[$i] <> 0){
                    $ralenti[$i] = $ralentihs[$i] * 100 / $totalhs[$i];
                } else {
                    $ralenti[$i] = 0;
                    $ralentillena[$i] = 0;
                    $ralentivacia[$i] = 0;
                    $separadordevirajes[$i] = 0;
                }
            }//endfor

            //VALORES DE REFERENCIA
            $refconsulta = [['maquinas.ModeMaq', $maquina->ModeMaq], ['FecIUtil','>=',$fechamin->FecIUtil],
            ['FecIUtil','<=',$fechamax->FecIUtil]];

            $refralentihs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                    ->where([[$refconsulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                    ->inRandomOrder()->take(10)
                                    ->sum('ValoUtil'); 
            $reftrabajandohs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)
                                        ->sum('ValoUtil');
            $reftransportehs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)
                                        ->sum('ValoUtil');

            $reftotalhs = $refralentihs + $reftrabajandohs + $reftransportehs;
            if ($reftotalhs <> 0){
                $refralenti = $refralentihs * 100 / $reftotalhs;
            } else {
                $refralenti = 0;
                //$refralentillena[$i] = 0;
                //$refralentivacia[$i] = 0;
                //$refseparadordevirajes[$i] = 0;
            }

            $reffactordecarga_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','20'],
                                                    ['UOMUtil', '%']])->inRandomOrder()->take(10)
                                                    ->avg('ValoUtil');
            if ($reffactordecarga_sql <> 0){
                $reffactordecarga = $reffactordecarga_sql;
            } else {
                $reffactordecarga = 0;
            }
            $refrpm_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                    ->where([[$refconsulta], ['SeriUtil','Trabajando'], ['UOMUtil', 'RPM']])
                                    ->inRandomOrder()->take(10)
                                    ->avg('ValoUtil');
            if ($refrpm_sql <> 0){
                $refrpm = $refrpm_sql;
            } else {
                $refrpm = 0;
            }
            
            //Se cuenta la cantidad de registros (maquinas) para iterar el For
            $refcantidad = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                ->where($refconsulta)
                                ->inRandomOrder()->take(10)
                                ->distinct('utilidads.NumSMaq')->get();

            $isuperficie = 0;
            $ivelocidad = 0;
            $iconsumo = 0;
            $totalrefvelocidad = 0;
            $totalrefsuperficie = 0;
            $totalrefconsumo = 0;
            $i = 0;
            //Guardo datos
            foreach ($refcantidad as $refcant) {
                //Consulta promedio de velocidad promedio, consumo y factor de carga del motor
                $refvelocidad_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta],['utilidads.NumSMaq',$refcant->NumSMaq], 
                                                    ['SeriUtil','Trabajando'], ['ValoUtil','>','3'],
                                                    ['UOMUtil', 'km/hr']])->avg('ValoUtil');
                //Consulto que implemento tiene la maquina
                $implem = Maquina::where('NumSMaq',$refcant->NumSMaq)->first();

                if ($refvelocidad_sql <> 0){
                    $refvelocidad[$i] = $refvelocidad_sql;
                    $ivelocidad++;
                } else {
                    $refvelocidad[$i] = 0;
                }

                $refsuperficie[$i] = $implem->MaicMaq*$refvelocidad[$i]*0.1;
                if ($refsuperficie[$i] <> 0){
                    $isuperficie++;
                }
                $refconsumoph_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta], ['SeriUtil','Trabajando'], 
                                            ['ValoUtil','>','10'],['UOMUtil', 'l/hr']])->avg('ValoUtil');
                if (($refconsumoph_sql <> 0) AND ($refsuperficie[$i] <> 0)){
                    $refconsumo[$i] = $refconsumoph_sql/$refsuperficie[$i];
                    $iconsumo++;
                } else {
                    $refconsumo[$i] = 0;
                }

                //Acumulo los valores que va obteniendo para luego hacer el calculo del promedio
                $totalrefvelocidad = $totalrefvelocidad + $refvelocidad[$i];
                $totalrefsuperficie = $totalrefsuperficie + $refsuperficie[$i];
                $totalrefconsumo = $totalrefconsumo + $refconsumo[$i];
                $i++;
            }

            //Calcula los valores promedio
            if(($totalrefvelocidad <> 0) AND ($ivelocidad <> 0)){
                $totalrefvelocidad = $totalrefvelocidad / $ivelocidad;
            } else {
                $totalrefvelocidad = 0;
            }
            if($totalrefsuperficie <> 0){
                $totalrefsuperficie = $totalrefsuperficie / $isuperficie;
            } else {
                $totalrefsuperficie = 0;
            }
            if($totalrefconsumo <> 0){
                $totalrefconsumo = $totalrefconsumo / $iconsumo;
            } else {
                $totalrefconsumo = 0;
            }
            

            //Calculo de consumos de combustible cosechando, ralenti y separador de virajes
            $hectareas = ($totalhs[$ultimoperiodo]) * $superficie[$ultimoperiodo];
            $consumosiembratotal = $consumo[$ultimoperiodo] * $hectareas;
            $consumosiembraobjetivo = $objetivoconsumo * $hectareas;
            $consumoralenti = $ralentilts[$ultimoperiodo];
            
            if((isset($objetivoralenti)) && (isset($ralenti[$ultimoperiodo]))){
                $consumoralentiobjetivo = $objetivoralenti * $consumoralenti / $ralenti[$ultimoperiodo];
            } else {
                $consumoralentiobjetivo = 0;
            }
            
         
        $rutavolver = route('utilidad.menu');
        return view('utilidad.informeTractor', compact('datosmaq','maquina','fechainicio','fechafin','periodos'
                                        ,'velocidad','superficie','consumo','factordecarga','trabajandohs'
                                        ,'transportehs','ralentihs','ralenti','acumtrabajandohs'
                                        ,'acumtransportehs','horasdemotorinicial','horasdemotorfinal'
                                        ,'autotrac','trabajandolts','ralentilts','transportelts'
                                        ,'temppromhidraulico','tempmaxhidraulico','temppromrefrigerante'
                                        ,'tempmaxrefrigerante','temppromtransmision','tempmaxtransmision'
                                        ,'objetivosuperficie','objetivoconsumo','objetivoralenti' ,'hectareas'
                                        ,'consumosiembratotal','consumosiembraobjetivo','consumoralenti'
                                        ,'consumoralentiobjetivo','diahidraulicomax','diarefrigerantemax'
                                        ,'diatransmisionmax','implemento','acumralentihs','acumtrabajandohs'
                                        ,'acumtransportehs','rpm','refralenti','reffactordecarga','refrpm'
                                        ,'totalrefvelocidad','totalrefsuperficie','totalrefconsumo','rutavolver'));
    
    }


    public function informeCosechadora($maquina, $finicio, $ffin, $cultivo, $horas, $implemento)
    {
        //Consultamos nombre de organizacion y sucursal
        $datosmaq = Maquina::select('organizacions.NombOrga','sucursals.NombSucu')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->where('maquinas.NumSMaq',$maquina->NumSMaq)->first();
        
        //Consulta de fechas
        $sqlfechas = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$finicio],['FecIUtil','<=',$ffin], ['CateUtil','LIKE','%Tiempo en '.$cultivo.'%']];

        //obtengo la fecha mas baja
        $fechamin = Utilidad::where($sqlfechas)
                            ->orderBy('FecIUtil','asc')
                            ->first();
        //obtengo la fecha mas alta
        $fechamax = Utilidad::where($sqlfechas)
                            ->orderBy('FecIUtil','desc')
                            ->first();


        if (empty($fechamin) || empty($fechamax))
        {
            return redirect()->route('utilidad.index')->with('status_danger', 'No se encontraron trabajos realizados en el intervalo de fechas para el cultivo seleccionado');
        }

        //Obtengo la hora de trilla inicial y final segun el rango de fechas para luego calcular los periodos
        $horasdetrillainicial = Utilidad::where([['NumSMaq',$maquina->NumSMaq], 
                                    ['CateUtil', 'Total de horas de separador'], 
                                    ['FecIUtil', $fechamin->FecIUtil]])
                                    ->orderBy('ValoUtil','asc')->first();

        $horasdetrillafinal = Utilidad::where([['NumSMaq',$maquina->NumSMaq], 
                                    ['CateUtil', 'Total de horas de separador'], 
                                    ['FecIUtil', $fechamax->FecIUtil]])
                                    ->orderBy('ValoUtil','desc')->first();

        
        
        //Calculo diferencia entre hs de trilla final y hs de trilla inicial para saber cuanto trillo acumulado
        $diftrilla = $horasdetrillafinal->ValoUtil - $horasdetrillainicial->ValoUtil;   
   
        //Calculamos fechas inicial y final para cada uno de los periodos
        $fsqls = Utilidad::where([['NumSMaq',$maquina->NumSMaq], 
                                    ['CateUtil', 'Total de horas de separador'],
                                    ['ValoUtil', '>=',$horasdetrillainicial->ValoUtil],
                                    ['ValoUtil', '<=', $horasdetrillafinal->ValoUtil]])
                            ->orderBy('ValoUtil','asc')->get();
        $i = 0;
        $cambiar = "NO";
        $x=0;
        $totalcultivo = 0;
        $cultivocorrecto = 0;
        $otroscultivos = 0;
        $ceros = 0;
        //Recorre cada registro con hs de separador dentro de toda la fecha
        
        foreach ($fsqls as $fsql) {

            // se revisa para cada uno de los registros, que no haya trillado otro cultivo distinto al seleccionado
            //en caso afirmativo, este registro no se tiene en cuenta para dicho informe.
            $tiempoencultivo = Utilidad::where([['NumSMaq',$maquina->NumSMaq],
                                                ['FecIUtil',$fsql->FecIUtil],
                                                ['CateUtil','LIKE','%Tiempo en '.$cultivo.'%']])->first();
            $tiempoens = Utilidad::where([['NumSMaq',$maquina->NumSMaq],
                                        ['FecIUtil',$fsql->FecIUtil]])
                                        ->where(function($q){
                                            $q->where('CateUtil','LIKE','%Tiempo en maíz%')
                                            ->orWhere('CateUtil','LIKE','%Tiempo en soja%')
                                            ->orWhere('CateUtil','LIKE','%Tiempo en trigo%')
                                            ->orWhere('CateUtil','LIKE','%Tiempo en cebada%')
                                            ->orWhere('CateUtil','LIKE','%Tiempo en colza%')
                                            ->orWhere('CateUtil','LIKE','%Tiempo en centeno%');
                                        })->get();
                                        
            //guardamos la cantidad de tiempo en cada cultivo para calcular la tasa de precision
            if (isset($tiempoencultivo)){
                $cultivocorrecto = $cultivocorrecto + $tiempoencultivo->ValoUtil;
            } 
            if (isset($tiempoens)){
                foreach ($tiempoens as $tiempoen){
                    $totalcultivo = $totalcultivo + $tiempoen->ValoUtil;
                }
            } 
            if ($x == 0){
                $pinicial[$i] = $fsql->FecIUtil;
                $valorinicial = $fsql->ValoUtil;
            }
            
            
            if($cambiar == "SI"){
                $valorinicial = $fsql->ValoUtil;
                $cambiar = "NO";
                $pinicial[$i] = $fsql->FecIUtil;
            }
            
            $valoractual = $fsql->ValoUtil;
            $valorif = $valorinicial + $horas;
            
            if ($valoractual >= $valorif){
                $cambiar = "SI";
                $pfinal[$i] = $fsql->FecIUtil;
                $hstrillaf[$i] = $valoractual;
                $otroscultivos = $totalcultivo - $cultivocorrecto;
                if ($otroscultivos > 0){
                    $tasaprecision[$i] = $cultivocorrecto * 100 / $totalcultivo;
                    $otroscultivos = 0;
                    $cultivocorrecto = 0;
                    $totalcultivo = 0;
                   
                } else {
                    $tasaprecision[$i] = 100;
                }
                if ($i <> 0) {
                    $hstrilla[$i] = $hstrillaf[$i] - $hstrillaf[$i-1];
                } else {
                    
                    //Se debe obtener el ultimo valor de trilla registrado antes del periodo seleccionado
                    $hstrillasql = Utilidad::where([['NumSMaq',$maquina->NumSMaq], 
                                                    ['CateUtil', 'Total de horas de separador'],
                                                    ['ValoUtil', '<', $valorinicial]])
                                                    ->orderBy('ValoUtil','desc')->first();

                    // Si no encuentra ningun valor de hs de separador anterior al valor inicial, 
                    //usamos el valor inicial en su defecto
                    if (isset($hstrillasql)){
                        $hstrilla[$i] = $hstrillaf[$i] - $hstrillasql->ValoUtil;
                    } else {
                        $hstrilla[$i] = $hstrillaf[$i] - $valorinicial;
                    }
                    
                }
                
                $i = $i + 1;
            }
            $x = $x + 1;
        }
        
        $otroscultivos = $totalcultivo - $cultivocorrecto;
        if ($otroscultivos > 0){
            $tasaprecision[$i] = $cultivocorrecto * 100 / $totalcultivo;
            $otroscultivos = 0;
            $cultivocorrecto = 0;
        } else {
            $tasaprecision[$i] = 100;
        }
        
            $pfinal[$i] = $horasdetrillafinal->FecIUtil;
            $hstrillaf[$i] = $valoractual;
            if ($i <> 0) {
                $hstrilla[$i] = $hstrillaf[$i] - $hstrillaf[$i - 1];
            } else {
                $hstrilla[$i] = $valoractual;
            }
                $hstrillaf[$i + 1] = $valoractual;
                
        if (isset($hstrillasql)){
            $hstrilla[$i + 1] = $hstrillaf[$i + 1] - $hstrillasql->ValoUtil;
        }
        else {
            $hstrilla[$i + 1] = $hstrillaf[$i + 1] - $valorinicial;
        }
        $periodos = $i;
            /////////////////// INICIO DE CALCULOS DE EFICIENCIA DE MAQUINA /////////////////////

            //definimos el ancho de plataforma segun el cultivo
            if (($cultivo == "maíz") OR ($cultivo == "girasol")){
                $plataforma = $implemento;
            } else {
                $plataforma = $implemento * 0.3048;
            }
            
            //Utilizo repetitiva para calcular indicadores para cada uno de los periodos
            for ($i=0; $i <= $periodos + 1; $i++) { 
                
                //-----------------------ZONA DE CONSULTAS----------------------

                //Condicion si es la ultima iteración del "for", calcula todo con las fechas acumuladas.Hace un promedio.
                if ($i == $periodos + 1){
                    
                $consulta = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$horasdetrillainicial->FecIUtil],
                            ['FecIUtil','<=',$horasdetrillafinal->FecIUtil]];
                $consulta_productividad = [['pin',$maquina->NumSMaq],['inicio','>=',$horasdetrillainicial->FecIUtil],['inicio','<=',$horasdetrillafinal->FecIUtil],
                            ['cultivo',$cultivo]];

                $acumcosechahs = Utilidad::where([[$consulta], ['SeriUtil','Cosecha'],['UOMUtil', 'hr']])
                            ->sum('ValoUtil');
                $acumcosechaydescargahs = Utilidad::where([[$consulta], ['SeriUtil','Cosecha y Descarga'],['UOMUtil', 'hr']])
                            ->sum('ValoUtil');
                $acumdescargahs = Utilidad::where([[$consulta], ['SeriUtil','Descarga no cosechando'],['UOMUtil', 'hr']])
                            ->sum('ValoUtil');
                $acumseparadorhs = Utilidad::where([[$consulta], ['SeriUtil','Separador de virajes en cabecero engranado'],['UOMUtil', 'hr']])
                            ->sum('ValoUtil');
                $acumralentillenohs = Utilidad::where([[$consulta], ['SeriUtil','Ralenti con depósito de grano lleno'],['UOMUtil', 'hr']])
                            ->sum('ValoUtil'); 
                $acumralentivaciohs = Utilidad::where([[$consulta], ['SeriUtil','Ralenti con depósito de grano no lleno'],['UOMUtil', 'hr']])
                            ->sum('ValoUtil'); 
                $acumtransportemas16hs = Utilidad::where([[$consulta], ['SeriUtil','Transporte - Desconexión para carretera activada'],['UOMUtil', 'hr']])
                                                //->orWhere([[$consulta], ['Transporte a menos de 16 km/h (10 mph), separador desconectado'],['UOMUtil', 'hr']])
                                                ->sum('ValoUtil');
                $acumtransportemenos16hs = Utilidad::where([[$consulta], ['SeriUtil','Transporte - Desconexión para carretera desactivada'],['UOMUtil', 'hr']])
                                                //->orWhere([[$consulta], ['Transporte a menos de 16 km/h (10 mph), separador desconectado'],['UOMUtil', 'hr']])                    
                                                ->sum('ValoUtil');  
                $horasencultivo = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Tiempo en '.$cultivo.'%'], ['UOMUtil','hr']])->sum('ValoUtil');
                $autotrac = Utilidad::where([[$consulta], ['CateUtil','AutoTrac™'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $autotrac_automation = Utilidad::where([[$consulta], ['CateUtil','AutoTrac™ Turn Automation'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                if (($cultivo <> "maíz") OR ($cultivo <> "girasol")){
                    $velmolinete = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Velocidad auto de molinetes%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                } else {
                    $velmolinete = 0;
                }
                
                $harvest = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Harvest Smart activado%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $alturaplataforma = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Control de altura autom. de plataforma (flexible)%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                
                $mantenerauto = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Mantener automáticamente%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                
                //TEMPERATURAS
                $temppromhidraulico = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', '%Temp promedio de aceite hidráulico%'], ['SeriUtil', 'Temperatura']])->avg('ValoUtil');
                $tempmaxhidraulico = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', '%Temp máx de aceite hidráulico%'], ['SeriUtil', 'Temperatura']])->max('ValoUtil');
                $diahidraulicomax = Utilidad::select('FecIUtil')
                                            ->where([[$consulta], ['CateUtil', 'LIKE', '%Temp máx de aceite hidráulico%'], ['SeriUtil', 'Temperatura'], ['ValoUtil', $tempmaxhidraulico]])->first();
                $temppromrefrigerante = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', '%Temp de refrigerante promedio%'], ['SeriUtil', 'Temperatura']])->avg('ValoUtil');
                $tempmaxrefrigerante = Utilidad::where([[$consulta], ['CateUtil', 'LIKE', '%Temp máx refrigerante%'], ['SeriUtil', 'Temperatura']])->max('ValoUtil');
                $diarefrigerantemax =  Utilidad::select('FecIUtil')
                                            ->where([[$consulta], ['CateUtil', 'LIKE', '%Temp máx refrigerante%'], ['SeriUtil', 'Temperatura'], ['ValoUtil', $tempmaxrefrigerante]])->first();

                $valor = 'objetivo';
                $hoy = Carbon::today();
                $anopasado = date("Y",strtotime($hoy."- 1 year"));
                
                //Consulta de objetivos
                /*
                $objetivosuperficie = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                                    ['tipoobjetivos.nombre','Superficie cosechada por hora (Has)'],
                                                    ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                                    ['objetivos.cultivo',$cultivo]])
                                                    ->avg($valor);

                if (!isset($objetivosuperficie)) {
                    $objetivosuperficie = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Superficie cosechada por hora (Has)'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }
                
                
                $objetivoconsumo = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                                    ['tipoobjetivos.nombre','Consumo de combustible por hectarea (lts)'],
                                                    ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                                    ['objetivos.cultivo',$cultivo]])
                                                    ->avg($valor);

                if (!isset($objetivoconsumo)) {
                    $objetivoconsumo = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Consumo de combustible por hectarea (lts)'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }
                */

                $objetivo_automation = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Mantener automaticamente'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivo_automation)) {
                    $objetivo_automation = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Mantener automaticamente'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }

                $objetivo_harvest = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Harvest Smart'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivo_harvest)) {
                    $objetivo_harvest = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Harvest Smart'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }

                $objetivo_molinete = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Velocidad automatica de molinete'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivo_molinete)) {
                    $objetivo_molinete = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Velocidad automatica de molinete'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }


                $objetivo_atta = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Active Terrain Adjustment'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivo_atta)) {
                    $objetivo_atta = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Active Terrain Adjustment'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }

                $objetivo_autotrac = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Autotrac'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivo_autotrac)) {
                    $objetivo_autotrac = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Autotrac'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }

                $objetivoralenti = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Ralenti (%)'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivoralenti)) {
                    $objetivoralenti = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Ralenti (%)'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }

                $objetivoralentilleno = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Ralenti con tolva llena (%)'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivoralentilleno)) {
                    $objetivoralentilleno = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Ralenti con tolva llena (%)'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }

                $objetivoralentivacio = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Ralenti con tolva vacia (%)'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivoralentivacio)) {
                    $objetivoralentivacio = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Ralenti con tolva vacia (%)'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                            ->avg($valor);
                }

                $objetivoseparador = Objetivo::select('objetivos.objetivo')
                                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                            ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                                            ['tipoobjetivos.nombre','Separador de virajes con cabecero engranado (%)'],
                                            ['objetivos.ano',$anopasado], ['objetivos.establecido','Cliente'],
                                            ['objetivos.cultivo',$cultivo]])
                                            ->avg($valor);

                if (!isset($objetivoseparador)) {
                    $objetivoseparador = Objetivo::select('objetivos.objetivo')
                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                    ->where([['maquinas.NumSMaq',$maquina->NumSMaq], 
                            ['tipoobjetivos.nombre','Separador de virajes con cabecero engranado (%)'],
                            ['objetivos.ano',$anopasado], ['objetivos.establecido','App'],
                            ['objetivos.cultivo',$cultivo]])
                    ->avg($valor);
                }

                $objetivofactor = 80;
                                            
                
            } else {
                    //Consulta que se realizara para completar todas las demas consultas a futuro
                    if (empty($pinicial[$i])){
                        $pinicial[$i] = $pfinal[$i-1];
                    } elseif(empty($pfinal[$i])){
                        $pfinal[$i] = $pfinal[$i - 1];
                    }
                $consulta = [['NumSMaq', $maquina->NumSMaq], ['FecIUtil','>=',$pinicial[$i]],
                ['FecIUtil','<=', $pfinal[$i]]];
                $consulta_productividad = [['pin',$maquina->NumSMaq],['inicio','>=',$pinicial[$i]],['inicio','<=',$pfinal[$i]],
                ['cultivo',$cultivo]];
                }
                
                //Consulta promedio de velocidad promedio, consumo y factor de carga del motor
                $velocidad[$i] = Utilidad::where([[$consulta], ['SeriUtil','Cosecha'], ['ValoUtil','>','3'],
                                            ['UOMUtil', 'km/hr']])->avg('ValoUtil');

                $consumoph = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','10'],
                                            ['UOMUtil', 'l/hr']])->avg('ValoUtil');

                $factordecarga[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','40'],
                                                    ['UOMUtil', '%']])->avg('ValoUtil');

                //Consulta tiempo trabajando, en ralenti y en transporte
                $trabajandohs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');

                $transportehs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');
                        
                $ralentihs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                        ->sum('ValoUtil');

                //Consulta ralenti con tolva llena y con tolva vacia
                $ralentillenahs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Ralentí con depósito de grano lleno']
                                                                ,['UOMUtil', 'hr']])
                                                                ->sum('ValoUtil');

                $ralentivaciahs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Ralentí con depósito de grano no lleno']
                                                                ,['UOMUtil', 'hr']])
                                                                ->sum('ValoUtil');

                $separadordevirajeshs[$i] = Utilidad::where([[$consulta], ['SeriUtil','Separador de virajes en cabecero engranado']
                                                                        ,['UOMUtil', 'hr']])
                                                                        ->sum('ValoUtil');

                $horasencultivohs[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Tiempo en '.$cultivo.'%'], ['UOMUtil','hr']])->sum('ValoUtil');
                $autotrachs[$i] = Utilidad::where([[$consulta], ['CateUtil','AutoTrac™'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $autotrac_automationhs[$i] = Utilidad::where([[$consulta], ['CateUtil','AutoTrac™ Turn Automation'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                if (($cultivo <> "maíz") OR ($cultivo <> "girasol")){
                    $velmolinetehs[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Velocidad auto de molinetes%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                } else {
                    $velmolinetehs[$i] = 0;
                }
                
                $harvesths[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Harvest Smart activado%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $attahs[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Active Terrain Adjustment%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $mantenerautohs[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Mantener automáticamente%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');
                $activeYieldhs[$i] = Utilidad::where([[$consulta], ['CateUtil','LIKE','%Active Yield%'], ['SeriUtil','Enc'], ['UOMUtil','hr']])->sum('ValoUtil');

          
                //Indicadores de productividad (t/ha y t/l)
                $has = Cosecha::where($consulta_productividad)->sum('superficie');
                $rendimiento = Cosecha::where($consulta_productividad)->sum('rendimiento');
                $combustible = Cosecha::where($consulta_productividad)->sum('combustible');

                if(($has > 0) AND ($rendimiento > 0)){
                    $tporha[$i] = $rendimiento / $has;
                }else{
                    $tporha[$i] = 0;
                }

                if(($rendimiento > 0) AND ($combustible > 0)){
                    $lport[$i] = $combustible / $rendimiento;
                }else{
                    $lport[$i] = 0;
                }

                //CONSUMOS DE COMBUSTIBLE SEGUN ESTADO: RALENTI, TRANSPORTE Y TRABAJANDO
                $ralentilts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Ralentí'], ['UOMUtil','l']])->sum('ValoUtil');
                $transportelts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Transporte'], ['UOMUtil','l']])->sum('ValoUtil');
                $trabajandolts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Trabajando'], ['UOMUtil','l']])->sum('ValoUtil');
                $ralentillenolts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Ralentí con depósito de grano lleno'], ['UOMUtil','l']])->sum('ValoUtil');
                $ralentivaciolts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Ralentí con depósito de grano no lleno'], ['UOMUtil','l']])->sum('ValoUtil');
                $separadorlts[$i] = Utilidad::where([[$consulta], ['SeriUtil', 'Separador de virajes en cabecero engranado'], ['UOMUtil','l']])->sum('ValoUtil');
                

                //-------------------ZONA DE CALCULOS Y RESULTADOS---------------------------


                //Calcula la superficie cosechada por hora
                $superficie[$i] = $plataforma*$velocidad[$i]*0.1;
                if ($superficie[$i] <> 0){
                     //Calculam el consumo por hectarea
                    $consumo[$i] = $consumoph / $superficie[$i];
                }else{
                    $consumo[$i] = 0; 
                }
               

                //Calcula el ralenti en % y con tolva llena y vacia y separador de virajes con cabecero engranado
                $totalhs[$i] = $ralentihs[$i] + $trabajandohs[$i] + $transportehs[$i];
                if ($totalhs[$i] <> 0){
                    $ralenti[$i] = $ralentihs[$i] * 100 / $totalhs[$i];
                    $ralentillena[$i] = $ralentillenahs[$i] * 100 / $totalhs[$i];
                    $ralentivacia[$i] = $ralentivaciahs[$i] * 100 / $totalhs[$i];
                    $separadordevirajes[$i] = $separadordevirajeshs[$i] * 100 / $totalhs[$i];
                    $mantenerauto_p[$i] = $mantenerautohs[$i] * 100 / $horasencultivohs[$i];
                    $harvest_p[$i] = $harvesths[$i] * 100 / $horasencultivohs[$i];
                    $autotrac_p[$i] = $autotrachs[$i] * 100 / $horasencultivohs[$i];
                    $autotrac_automation_p[$i] = $autotrac_automationhs[$i] * 100 / $horasencultivohs[$i];
                    $velmolinete_p[$i] = $velmolinetehs[$i] * 100 / $horasencultivohs[$i];
                    $atta_p[$i] = $attahs[$i] * 100 / $horasencultivohs[$i];
                    $activeYield_p[$i] = $activeYieldhs[$i] * 100 / $horasencultivohs[$i];
                } else {
                    $ralenti[$i] = 0;
                    $ralentillena[$i] = 0;
                    $ralentivacia[$i] = 0;
                    $separadordevirajes[$i] = 0;
                    $mantenerauto_p[$i] = 0;
                    $harvest_p[$i] = 0;
                    $autotrac_p[$i] = 0;
                    $autotrac_automation_p[$i] = 0;
                    $velmolinete_p[$i] = 0;
                    $atta_p[$i] = 0;
                    $activeYield_p[$i] = 0;
                }
            }//endfor

            //VALORES DE REFERENCIA
            $refconsulta = [['maquinas.ModeMaq', $maquina->ModeMaq], ['FecIUtil','>=',$fechamin->FecIUtil],
            ['FecIUtil','<=',$fechamax->FecIUtil]];

            $refralentihs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                    ->where([[$refconsulta], ['SeriUtil','Ralentí'],['UOMUtil', 'hr']])
                                    ->inRandomOrder()->take(10)
                                    ->sum('ValoUtil'); 
            $refralentivaciohs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Ralentí con depósito de grano no lleno'],
                                        ['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)->sum('ValoUtil'); 
            $refralentillenohs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Ralentí con depósito de grano lleno'],
                                        ['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)->sum('ValoUtil'); 
            $refseparadordevirajeshs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Separador de virajes en cabecero engranado'],
                                        ['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)->sum('ValoUtil'); 
            $reftrabajandohs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Trabajando'],['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)
                                        ->sum('ValoUtil');
            $reftransportehs = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                        ->where([[$refconsulta], ['SeriUtil','Transporte'],['UOMUtil', 'hr']])
                                        ->inRandomOrder()->take(10)
                                        ->sum('ValoUtil');

            $reftotalhs = $refralentihs + $reftrabajandohs + $reftransportehs;
            if ($reftotalhs <> 0){
                $refralenti = $refralentihs * 100 / $reftotalhs;
                $refralentivacio = $refralentivaciohs * 100 / $reftotalhs;
                $refralentilleno = $refralentillenohs * 100 / $reftotalhs;
                $refseparadordevirajes = $refseparadordevirajeshs * 100 / $reftotalhs;
            } else {
                $refralenti = 0;
                $refralentilleno = 0;
                $refralentivacio = 0;
                $refseparadordevirajes = 0;
            }

            $reffactordecarga_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta], ['SeriUtil','Trabajando'], ['ValoUtil','>','40'],
                                                    ['UOMUtil', '%']])
                                                    ->inRandomOrder()->take(10)->avg('ValoUtil');
            if ($reffactordecarga_sql <> 0){
                $reffactordecarga = $reffactordecarga_sql;
            } else {
                $reffactordecarga = 0;
            }
            
            //Se cuenta la cantidad de registros (maquinas) para iterar el For
            $refcantidad = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                ->where($refconsulta)
                                ->inRandomOrder()->take(5)
                                ->distinct('utilidads.NumSMaq')->get();

            $isuperficie = 0;
            $ivelocidad = 0;
            $iconsumo = 0;
            $totalrefvelocidad = 0;
            $totalrefsuperficie = 0;
            $totalrefconsumo = 0;
            $i = 0;
            //Guardo datos
            foreach ($refcantidad as $refcant) {
                //Consulta promedio de velocidad promedio, consumo y factor de carga del motor
                $refvelocidad_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta],['utilidads.NumSMaq',$refcant->NumSMaq], 
                                                    ['SeriUtil','Trabajando'], ['ValoUtil','>','3'],
                                                    ['UOMUtil', 'km/hr']])->avg('ValoUtil');

                if (($cultivo == "maíz") OR ($cultivo == "girasol")){
                    $implem = Maquina::where('NumSMaq',$refcant->NumSMaq)->first();
                    $imp = $implem->MaicMaq;
                } else {
                    $implem = Maquina::where('NumSMaq',$refcant->NumSMaq)->first();
                    $imp = $implem->CanPMaq * 0.3048;
                }
                //Consulto que implemento tiene la maquina
                

                if ($refvelocidad_sql <> 0){
                    $refvelocidad[$i] = $refvelocidad_sql;
                    $ivelocidad++;
                } else {
                    $refvelocidad[$i] = 0;
                }

                $refsuperficie[$i] = $imp*$refvelocidad[$i]*0.1;
                if ($refsuperficie[$i] <> 0){
                    $isuperficie++;
                }
                $refconsumoph_sql = Utilidad::join('maquinas','utilidads.NumSMaq','=','maquinas.NumSMaq')
                                            ->where([[$refconsulta], ['SeriUtil','Trabajando'], 
                                            ['ValoUtil','>','10'],['UOMUtil', 'l/hr']])->avg('ValoUtil');
                if (($refconsumoph_sql <> 0) AND ($refsuperficie[$i] <> 0)){
                    $refconsumo[$i] = $refconsumoph_sql/$refsuperficie[$i];
                    $iconsumo++;
                } else {
                    $refconsumo[$i] = 0;
                }

                //Acumulo los valores que va obteniendo para luego hacer el calculo del promedio
                $totalrefvelocidad = $totalrefvelocidad + $refvelocidad[$i];
                $totalrefsuperficie = $totalrefsuperficie + $refsuperficie[$i];
                $totalrefconsumo = $totalrefconsumo + $refconsumo[$i];
                $i++;
            }

            //Calcula los valores promedio
            if(($totalrefvelocidad <> 0) AND ($ivelocidad <> 0)){
                $totalrefvelocidad = $totalrefvelocidad / $ivelocidad;
            } else {
                $totalrefvelocidad = 0;
            }
            if($totalrefsuperficie <> 0){
                $totalrefsuperficie = $totalrefsuperficie / $isuperficie;
            } else {
                $totalrefsuperficie = 0;
            }
            if($totalrefconsumo <> 0){
                $totalrefconsumo = $totalrefconsumo / $iconsumo;
            } else {
                $totalrefconsumo = 0;
            }


            //Calculo de consumos de combustible cosechando, ralenti y separador de virajes
            $hectareas = ($acumcosechaydescargahs + $acumcosechahs) * $superficie[$periodos + 1];
            $consumocosechatotal = $consumo[$periodos + 1] * $hectareas;
            //$consumocosechaobjetivo = $objetivoconsumo * $hectareas;
            $consumoralenti = $ralentilts[$periodos + 1];
            if((isset($objetivoralenti)) && (!empty($ralenti[$periodos + 1]))){
                $consumoralentiobjetivo = $objetivoralenti * $consumoralenti / $ralenti[$periodos + 1];
            } else {
                $consumoralentiobjetivo = 0;
            }
            $consumoralentilleno = $ralentillenolts[$periodos + 1];
            if((isset($objetivoralentilleno)) && (!empty($ralentillena[$periodos + 1]))){
                $consumoralentillenoobjetivo = $objetivoralentilleno * $consumoralentilleno / $ralentillena[$periodos + 1];
            } else {
                $consumoralentillenoobjetivo = 0;
            }
            $consumoralentivacio = $ralentivaciolts[$periodos + 1];
            if((isset($objetivoralentivacio)) && (!empty($ralentivacia[$periodos + 1]))){
                $consumoralentivacioobjetivo = $objetivoralentivacio * $consumoralentivacio / $ralentivacia[$periodos + 1];
            } else {
                $consumoralentivacioobjetivo = 0;
            }
            $consumoseparador = $separadorlts[$periodos + 1];
            if((isset($objetivoseparador)) && (!empty($separadordevirajes[$periodos + 1]))){
                $consumoseparadorobjetivo = $objetivoseparador * $consumoseparador / $separadordevirajes[$periodos + 1];
            } else {
                $consumoseparadorobjetivo = 0;
            }
          
        $rutavolver = route('utilidad.menu');
        return view('utilidad.informe', compact('datosmaq','maquina','cultivo','pinicial','pfinal','periodos'
                                        ,'velocidad','superficie','consumo','factordecarga','trabajandohs'
                                        ,'transportehs','ralentihs','ralenti','ralentillena','ralentivacia'
                                        ,'separadordevirajes','acumcosechahs','acumcosechaydescargahs'
                                        ,'acumdescargahs','acumseparadorhs','acumralentillenohs'
                                        ,'acumralentivaciohs','acumtransportemas16hs','acumtransportemenos16hs'
                                        ,'horasdetrillainicial','horasdetrillafinal','hstrilla','tasaprecision'
                                        ,'horasencultivo','autotrac','autotrac_automation','velmolinete','harvest','alturaplataforma'
                                        ,'mantenerauto','trabajandolts','ralentilts','transportelts'
                                        ,'temppromhidraulico','tempmaxhidraulico','temppromrefrigerante'
                                        ,'tempmaxrefrigerante','objetivofactor','objetivo_automation','objetivo_harvest'
                                        ,'objetivoralenti','objetivoralentilleno','objetivoralentivacio'
                                        ,'objetivoseparador','objetivo_molinete','hectareas','consumocosechatotal'
                                        ,'consumoralenti','consumoralentiobjetivo','objetivo_atta','objetivo_autotrac'
                                        ,'consumoralentilleno','consumoralentillenoobjetivo'
                                        ,'consumoralentivacio','consumoralentivacioobjetivo','consumoseparador'
                                        ,'consumoseparadorobjetivo','diftrilla','diahidraulicomax'
                                        ,'diarefrigerantemax','mantenerauto_p','harvest_p','autotrac_p','autotrac_automation_p'
                                        ,'velmolinete_p','atta_p','activeYield_p','refralenti','refralentivacio','refralentilleno'
                                        ,'refseparadordevirajes','reffactordecarga','totalrefvelocidad','tporha','lport'
                                        ,'totalrefsuperficie','totalrefconsumo'
                                        ,'implemento','rutavolver'));
    }


    public function informePulverizadora($maquina, $finicio, $ffin, $horas)
    {

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
     * @param  \App\utilidad  $utilidad
     * @return \Illuminate\Http\Response
     */
    public function show(utilidad $utilidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\utilidad  $utilidad
     * @return \Illuminate\Http\Response
     */
    public function edit(utilidad $utilidad)
    {
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\utilidad  $utilidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, utilidad $utilidad)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\utilidad  $utilidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(utilidad $utilidad)
    {
        //
    }

}
