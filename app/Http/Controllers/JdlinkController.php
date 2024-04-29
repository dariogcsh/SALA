<?php

namespace App\Http\Controllers;

use App\jdlink;
use App\organizacion;
use App\maquina;
use App\mibonificacion;
use App\interaccion;
use App\monitoreo;
use App\monitoreo_maquina;
use App\sucursal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;

class JdlinkController extends Controller
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
        return view('jdlink.menu');
    }
    public function index(Request $request)
    {
        Gate::authorize('haveaccess','jdlink.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Monitoreo']);
        $rutavolver = route('internosoluciones');
        $filtro="";
        $busqueda="";
        $hoy = Carbon::now();
        $sucursales = Sucursal::orderby('id','asc')->get();
        $csi = "";//conectado
        $cno = "";
        $msi = "";//monitoreado
        $mno = "";
        $ssi = "";//soporte_siembra
        $sno = "";
        $isi = "";//informes
        $ino = "";
        $ordensi = "";//Ordenamiento de datos
        $ordenno = "";
        $mantsi = "";//Mantenimiento
        $mantno = "";
        $mantcargado = "";
        $actsi = "";//actualizacion de componentes
        $actno = "";
        $actrealizado = "";
        $actbonificado = "";
        $actbonificado = "";
        $capsi = "";//capacitacion a operarios
        $capno = "";
        $vsi = "";//visita inicial
        $vno = "";
        $vrealizada = "";
        $vbonificado = "";
        $ensayosi = "";//ensayo de combine advisor
        $ensayono = "";
        $ensayorealizado = "";
        $lsi = "";//limpieza de inyectores
        $lno = "";
        $lrealizada = "";
        $chsi = "";//check list
        $chno = "";
        $chrealizado="";
        $chbonificado = "";
        $analisissi = "";//analisis combine advisor
        $analisisno = "";
        $analisisbonificado = "";
        $analisisrealizado = "";
        $contsi = "";//contrato
        $contno = "";
        $contvalidado = "";
        $contfirmado = "";
        $contenviado = "";
        $fsi = "";//facturado
        $fno = "";
        $fpagada = "";
        $fenviada = "";
        

        if(($request->buscarpor) OR ($request->tipo) OR ($request->conectado) OR ($request->monitoreado)
            OR ($request->informes) OR ($request->ordenamiento_agro) OR ($request->mantenimiento) OR ($request->vinicial)
            OR ($request->check) OR ($request->limpieza) OR ($request->contrato) OR ($request->factura)
            OR ($request->sucursales) OR ($request->tipomaq) OR ($request->modelos) OR ($request->anofiscal)){
            $sucursal = $request->get('sucursales');
            $tipomaq = $request->get('tipomaq');
            $modelos = $request->get('modelos');
            $anofiscal = $request->get('anofiscal');

            if($request->conectado){
                if (in_array("si",$request->get('conectado'))) {
                    $csi = "si";
                }if (in_array("no",$request->get('conectado'))) {
                    $cno = "no";
                }
            }
            if($request->monitoreado){
                if (in_array("si",$request->get('monitoreado'))) {
                    $msi = "si";
                }if (in_array("no",$request->get('monitoreado'))) {
                    $mno = "no";
                }
            }
            if($request->soporte_siembra){
                if (in_array("si",$request->get('soporte_siembra'))) {
                    $ssi = "si";
                }if (in_array("no",$request->get('soporte_siembra'))) {
                    $sno = "no";
                }
            }
            if($request->informes){
                if (in_array("si",$request->get('informes'))) {
                    $isi = "si";
                }if (in_array("no",$request->get('informes'))) {
                    $ino = "no";
                }
            }
            if($request->ordenamiento_agro){
                if (in_array("si",$request->get('ordenamiento_agro'))) {
                    $ordensi = "si";
                }if (in_array("no",$request->get('ordenamiento_agro'))) {
                    $ordenno = "no";
                }
            }
            if($request->mantenimiento){
                if (in_array("si",$request->get('mantenimiento'))) {
                    $mantsi = "si";
                }if (in_array("no",$request->get('mantenimiento'))) {
                    $mantno = "no";
                }
                if (in_array("cargado",$request->get('mantenimiento'))) {
                    $mantcargado = "cargado";
                }
            }  
            if($request->actualizacion_comp){
                if (in_array("si",$request->get('actualizacion_comp'))) {
                    $actsi = "si";
                }if (in_array("no",$request->get('actualizacion_comp'))) {
                    $actno = "no";
                }
                if (in_array("realizado",$request->get('actualizacion_comp'))) {
                    $actrealizado = "realizado";
                }
                if (in_array("bonificado",$request->get('actualizacion_comp'))) {
                    $actbonificado = "bonificado";
                }
            }  
            if($request->capacitacion_op){
                if (in_array("si",$request->get('capacitacion_op'))) {
                    $capsi = "si";
                }if (in_array("no",$request->get('capacitacion_op'))) {
                    $capno = "no";
                }
            }  
            if($request->vinicial){
                if (in_array("si",$request->get('vinicial'))) {
                    $vsi = "si";
                }if (in_array("no",$request->get('vinicial'))) {
                    $vno = "no";
                }if (in_array("realizada",$request->get('vinicial'))) {
                    $vrealizada = "realizada";
                }
                if (in_array("bonificado",$request->get('vinicial'))) {
                    $vbonificado = "bonificado";
                }
            }
            if($request->ensayo){
                if (in_array("si",$request->get('ensayo'))) {
                    $ensayosi = "si";
                }if (in_array("no",$request->get('ensayo'))) {
                    $ensayono = "no";
                }
                if (in_array("realizado",$request->get('ensayo'))) {
                    $ensayorealizado = "realizado";
                }
            }  
            if($request->check){
                if (in_array("si",$request->get('check'))) {
                    $chsi = "si";
                }if (in_array("no",$request->get('check'))) {
                    $chno = "no";
                }if (in_array("realizado",$request->get('check'))) {
                    $chrealizado = "realizado";
                }if (in_array("bonificado",$request->get('check'))) {
                    $chbonificado = "bonificado";
                }
            }
            if($request->limpieza){
                if (in_array("si",$request->get('limpieza'))) {
                    $lsi = "si";
                }if (in_array("no",$request->get('limpieza'))) {
                    $lno = "no";
                }if (in_array("realizada",$request->get('limpieza'))) {
                    $lrealizada = "realizada";
                }
            }
            if($request->analisis){
                if (in_array("si",$request->get('analisis'))) {
                    $analisissi = "si";
                }if (in_array("no",$request->get('analisis'))) {
                    $analisisno = "no";
                }
                if (in_array("realizado",$request->get('analisis'))) {
                    $analisisrealizado = "realizado";
                }
                if (in_array("bonificado",$request->get('analisis'))) {
                    $analisisbonificado = "bonificado";
                }
            }  
            if($request->contrato){
                if (in_array("confeccionado",$request->get('contrato'))) {
                    $contsi = "confeccionado";
                }
                if (in_array("no",$request->get('contrato'))) {
                    $contno = "no";
                }
                if (in_array("enviado al cliente",$request->get('contrato'))) {
                    $contenviado = "enviado al cliente";
                }
                if (in_array("firmado",$request->get('contrato'))) {
                    $contfirmado = "firmado";
                }
                if (in_array("validado",$request->get('contrato'))) {
                    $contvalidado = "validado";
                }
            }
            if($request->factura){
                if (in_array("si",$request->get('factura'))) {
                    $fsi = "si";
                }if (in_array("no",$request->get('factura'))) {
                    $fno = "no";
                }
                if (in_array("pagada",$request->get('factura'))) {
                    $fpagada = "pagada";
                }
                if (in_array("enviada al cliente",$request->get('factura'))) {
                    $fenviada = "enviada al cliente";
                }
            }

            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $jdlinks = Jdlink::select('jdlinks.id','organizacions.NombOrga','maquinas.TipoMaq','maquinas.ModeMaq','jdlinks.NumSMaq',
                                    'jdlinks.vencimiento_contrato','jdlinks.monitoreo','jdlinks.visita_inicial','jdlinks.fecha_visita','jdlinks.check_list',
                                    'jdlinks.contrato_firmado','jdlinks.factura','jdlinks.anofiscal','jdlinks.fecha_comienzo')
                            ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->Buscar($tipo,$busqueda)
                            ->AnoFiscal($anofiscal)
                            ->Sucursal($sucursal)
                            ->TipoMaq($tipomaq)
                            ->ModeMaq($modelos)
                            ->Conectado($csi, $cno)
                            //->Conectado($cno)
                            ->Monitoreo($msi, $mno)
                            //->Monitoreo($mno)
                            ->Ssiembra($ssi, $sno)
                            //->Ssiembra($sno)
                            ->Informes($isi, $ino)
                            //->Informes($ino)
                            ->Ordenamiento($ordensi, $ordenno)
                            //->Alertas($ano)
                            ->Mantenimiento($mantsi, $mantno, $mantcargado)
                            //->Mantenimiento($mantno)
                            //->Mantenimiento($mantcargado)
                            ->Actualizacion($actsi, $actno, $actrealizado, $actbonificado)
                            //->Actualizacion($actno)
                            //->Actualizacion($actrealizado)
                            //->Actualizacion($actbonificado)
                            ->Capacitacion($capsi, $capno)
                            //->Capacitacion($capno)
                            ->VisitaInicial($vsi, $vbonificado, $vno, $vrealizada)
                            //->VisitaInicial($vno)
                            //->VisitaInicial($vrealizada)
                            //->VisitaInicial($vbonificado)
                            ->Ensayo($ensayosi, $ensayono, $ensayorealizado)
                            //->Ensayo($ensayono)
                            //->Ensayo($ensayorealizado)
                            ->CheckList($chsi, $chrealizado, $chno, $chbonificado)
                            //->CheckList($chrealizado)
                            //->CheckList($chsi)
                            //->CheckList($chbonificado)
                            ->Limpieza($lsi, $lno, $lrealizada)
                            //->Limpieza($lno)
                            //->Limpieza($lrealizada)
                            ->Analisis($analisissi, $analisisno, $analisisrealizado, $analisisbonificado)
                            //->Analisis($analisisno)
                            //->Analisis($analisisrealizado)
                            ->ContratoFirmado($contsi, $contno, $contvalidado, $contenviado, $contfirmado)
                            //->ContratoFirmado($contno)
                            //->ContratoFirmado($contvalidado)
                            ->Factura($fsi, $fno, $fpagada, $fenviada)
                            //->Factura($fno)
                            //->Factura($fpagada)
                            ->orderBy('organizacions.NombOrga','asc')
                            ->get();
            //$jdlinks = Jdlink::Buscar($tipo, $busqueda)->orderBy('organizacions.NombOrga','asc')->paginate(10)->appends($variablesurl);
            $filtro = "SI";
        } else{
            $jdlinks = Jdlink::select('jdlinks.id','organizacions.NombOrga','maquinas.TipoMaq','maquinas.ModeMaq','jdlinks.NumSMaq',
                                    'jdlinks.vencimiento_contrato','jdlinks.monitoreo','jdlinks.visita_inicial','jdlinks.fecha_visita','jdlinks.check_list',
                                    'jdlinks.contrato_firmado','jdlinks.factura','jdlinks.anofiscal','jdlinks.fecha_comienzo')
                            ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->orderBy('organizacions.NombOrga','asc')->get();
        }

        $cantreg = count($jdlinks);

        return view('jdlink.index', compact('jdlinks','filtro','busqueda','rutavolver','sucursales','hoy','cantreg'));
    }

    function fetch(Request $request)
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
        
        $data = Maquina::where([[$select, $value], ['TipoMaq','COSECHADORA']])->get();
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
        $output .= '<option value="otra  - '.$orga->NombOrga.'">Otra</option>';
        echo $output;

    }

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
        $output .= '<option value="otra  - '.$orga->NombOrga.'">Otra</option>';
        echo $output;

    }

    function solotractor(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $orga = Organizacion::where('id',$value)->first();
        
        $data = Maquina::where([[$select, $value], ['TipoMaq','TRACTOR']])->get();
        $output = '';
        foreach ($data as $row)
        {
            if(isset($maquina)){
                $output .='<option value="'.$row->NumSMaq.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
            } else {
                $output .='<option value="'.$row->NumSMaq.'">'.$row->ModeMaq.' - ' .$row->NumSMaq.'</option>';
            }
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
        Gate::authorize('haveaccess','jdlink.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Monitoreo']);
        $hoy = Carbon::today();
        $mes = $hoy->format('m');
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
                                $query->where('puesto_empleados.NombPuEm', 'RAC');
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
        return view('jdlink.create',compact('organizaciones','rutavolver','asesores','mes'));
    }

    public function createtractorsolo()
    {
        Gate::authorize('haveaccess','jdlink.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Monitoreo']);
        $hoy = Carbon::today();
        $mes = $hoy->format('m');
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
                                $query->where('puesto_empleados.NombPuEm', 'RAC');
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
        return view('jdlink.createtractorsolo',compact('organizaciones','rutavolver','asesores','mes'));
    }

    public function createconect()
    {
        Gate::authorize('haveaccess','jdlink.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Monitoreo']);
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
                                                $query->where('puesto_empleados.NombPuEm', 'RAC');
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
        return view('jdlink.createconect',compact('organizaciones','rutavolver','asesores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeconect(Request $request)
    {
        Gate::authorize('haveaccess','jdlink.create');
        request()->validate([
            'NumSMaq' => 'required|max:50',
            'costo' => 'required',
            'anofiscal' => 'required',
        ]);

        if ($request->conectado){
            $request->request->add(['conectado' => 'SI']);
        } else {
            $request->request->add(['conectado' => 'NO']);
        }
        if ($request->monitoreo){
            $request->request->add(['monitoreo' => 'SI']);
        } else {
            $request->request->add(['monitoreo' => 'NO']);
        }
        if ($request->informes){
            $request->request->add(['informes' => 'SI']);
        } else {
            $request->request->add(['informes' => 'NO']);
        }
        if ($request->alertas){
            $request->request->add(['alertas' => 'SI']);
        } else {
            $request->request->add(['alertas' => 'NO']);
        }
        if ($request->capacitacion_op){
            $request->request->add(['capacitacion_op' => 'SI']);
        } else {
            $request->request->add(['capacitacion_op' => 'NO']);
        }
        if ($request->capacitacion_asesor){
            $request->request->add(['capacitacion_asesor' => 'SI']);
        } else {
            $request->request->add(['capacitacion_asesor' => 'NO']);
        }
        if ($request->ordenamiento_agro){
            $request->request->add(['ordenamiento_agro' => 'SI']);
        } else {
            $request->request->add(['ordenamiento_agro' => 'NO']);
        }
        if ($request->apivinculada){
            $request->request->add(['apivinculada' => 'SI']);
        } else {
            $request->request->add(['apivinculada' => 'NO']);
        }
        if ($request->calibracion_implemento){
            $request->request->add(['calibracion_implemento' => 'SI']);
        } else {
            $request->request->add(['calibracion_implemento' => 'NO']);
        }

        $maquina = $request->get('NumSMaq');
        $año = $request->get('anofiscal');

        //Busca si ya tiene creada una conectividad
        $maqdestroy = Jdlink::where([['NumSMaq', $maquina], ['anofiscal',$año]])->first();
        if(isset($maqdestroy)){
            //Da aviso que ya existe esa conectividad
            return redirect()->route('jdlink.index')->with('status_danger', 'Ya existe una conectividad para esta máquina en este año fiscal');
        } else {
            $jdlinks = Jdlink::create($request->all());
            return redirect()->route('jdlink.index')->with('status_success', 'Conectividad registrada con éxito');
        }

    }

    public function storetractor(Request $request)
    {
        Gate::authorize('haveaccess','jdlink.create');
        request()->validate([
            'NumSMaq' => 'required|max:50',
            'costo' => 'required',
            'asesor' => 'required',
        ]);
        //Verifico año fiscal actual
        $hoy = Carbon::now();
        $año = $hoy->format('Y');
        if (($hoy > $año."-10-31") AND ($hoy <= $año."-12-31")){
            $año = $año + 1;
        }
        $diasuscripcion = Carbon::today();
        $vencimiento = $diasuscripcion->addYear();

        $request->request->add(['vencimiento_contrato' => $vencimiento]);
        $request->request->add(['anofiscal' => $año]);
        $request->request->add(['conectado' => 'SI']);
        $request->request->add(['monitoreo' => 'SI']);
        $request->request->add(['informes' => 'SI']);
        $request->request->add(['ordenamiento_agro' => 'SI']);
   
        $request->request->add(['mantenimiento' => 'SI']);
        $request->request->add(['contrato_firmado' => 'NO']);
        $request->request->add(['factura' => 'NO']);
        $request->request->add(['ensayo' => 'NO']);
        $request->request->add(['apivinculada' => 'NO']);
        $request->request->add(['check_list' => 'NO']);

        if ($request->alertas){
            $request->request->add(['alertas' => 'SI']);
            $request->request->add(['tiempo_alertas' => '120']);
        } else {
            $request->request->add(['alertas' => 'NO']);
        }
        if ($request->actualizacion_comp){
            $request->request->add(['actualizacion_comp' => 'SI']);
        } else {
            $request->request->add(['actualizacion_comp' => 'NO']);
        }
        if ($request->calidad_siembra){
            $request->request->add(['calidad_siembra' => 'SI']);
        } else {
            $request->request->add(['calidad_siembra' => 'NO']);
        }
        if ($request->muestreo){
            $request->request->add(['muestreo' => 'SI']);
        } else {
            $request->request->add(['muestreo' => 'NO']);
        }
        if ($request->actualizacion_comp){
            $request->request->add(['actualizacion_comp' => 'SI']);
        } else {
            $request->request->add(['actualizacion_comp' => 'NO']);
        }
        if ($request->visita_inicial){
            $request->request->add(['visita_inicial' => 'SI']);
            $request->request->add(['calibracion_implemento' => 'SI']);
        } else {
            $request->request->add(['visita_inicial' => 'NO']);
            $request->request->add(['calibracion_implemento' => 'NO']);
        }
        if ($request->capacitacion_asesor){
            $request->request->add(['capacitacion_asesor' => 'SI']);
        } else {
            $request->request->add(['capacitacion_asesor' => 'NO']);
        }
        if ($request->limpieza_inyectores){
            $request->request->add(['limpieza_inyectores' => 'SI']);
        } else {
            $request->request->add(['limpieza_inyectores' => 'NO']);
        }
        $request->request->add(['capacitacion_op' => 'NO']);
        $request->request->add(['analisis_final' => 'NO']);
        $request->request->add(['soporte_siembra' => 'NO']);

       
        $mes = $request->get('mes');
        $id_orga = $request->get('id_organizacion');
        $tipo = "Oro";
       //dd($tipo);
        $monitoreo = Monitoreo::create(['id_organizacion'=>$id_orga, 'mes_facturacion'=>$mes, 'tipo'=>$tipo, 
                                        'estado'=>'Pendiente','anofiscal'=>$año]);

        $costo_paq = 0;
        $maquinas = $request->NumSMaq;
        foreach ($maquinas as $maquina) {
            $request->request->add(['NumSMaq' => $maquina]);

            //Busca si ya tiene creada una conectividad
            $maqdestroy = Jdlink::where([['NumSMaq', $maquina], ['anofiscal',$año]])->first();
            if(isset($maqdestroy)){
                //Elimina la conectividad para colocar la nueva
                $maqdestroy->delete();
            }
            $jdlinks = Jdlink::create($request->all());
            //Inseto en la table monitoreo maquinas
    
            $monitoreo_maquina = Monitoreo_maquina::create(['id_monitoreo'=>$monitoreo->id, 'NumSMaq'=>$jdlinks->NumSMaq,
                                                            'costo'=>$jdlinks->costo]);
            $costo_paq = $costo_paq + $jdlinks->costo;
        }
        $monitoreo->update(['costo_total'=>$costo_paq]);

        //Buscar que organizacion es la que solicita el soporte
        $organizacion = Organizacion::where('id',$request->id_organizacion)->first();
        //obtener sucursal donde pertenece el usuario que solicita la asistencia
        $sucursalid = Sucursal::select('sucursals.id')
                            ->where('id',$organizacion->CodiSucu)
                            ->first();

        $matchTheseAdministrativo = [['puesto_empleados.NombPuEm', 'Administrativo de servicio'], ['users.CodiSucu', $sucursalid->id]];
        $matchTheseGerente = [['puesto_empleados.NombPuEm', 'Gerente de sucursal'], ['users.CodiSucu', $sucursalid->id]];
        $matchTheseEspecialista = [['puesto_empleados.NombPuEm', 'Analista de soluciones integrales'], ['users.CodiSucu', $sucursalid->id]];
        
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where('roles.name','Admin')
                        ->orWhere($matchTheseAdministrativo)
                        ->orWhere($matchTheseEspecialista)
                        ->orWhere($matchTheseGerente)->get();
        //Envio de notificacion
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA - Nuevo monitoreo de tractor',
                'body' => 'Se ha registrado una nueva conectividad de monitoreo de tractor de: '.$organizacion->NombOrga.'',
                'path' => '/jdlink',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        return redirect()->route('home')->with('status_success', 'Conectividad registrada con éxito');

    }

    public function store(Request $request)
    {
        Gate::authorize('haveaccess','jdlink.create');
        request()->validate([
            'NumSMaq' => 'required|max:50',
            'costo' => 'required',
            'asesor' => 'required',
        ]);

        //Verifico año fiscal actual
        $hoy = Carbon::now();
        $año = $hoy->format('Y');

        if (($hoy > $año."-10-31") AND ($hoy <= $año."-12-31")){
            $año = $año + 1;
        }
        $diasuscripcion = Carbon::today();
        $vencimiento = $diasuscripcion->addYear();

        $request->request->add(['vencimiento_contrato' => $vencimiento]);
        $request->request->add(['anofiscal' => $año]);
        $request->request->add(['conectado' => 'SI']);
        $request->request->add(['monitoreo' => 'SI']);
        $request->request->add(['informes' => 'SI']);
        $request->request->add(['alertas' => 'SI']);
        $request->request->add(['ordenamiento_agro' => 'SI']);
        $request->request->add(['tiempo_alertas' => '120']);
        $request->request->add(['mantenimiento' => 'SI']);
        $request->request->add(['contrato_firmado' => 'NO']);
        $request->request->add(['factura' => 'NO']);
        $request->request->add(['apivinculada' => 'NO']);
        $request->request->add(['calibracion_implemento' => 'NO']);

        if ($request->actualizacion_comp){
            $request->request->add(['actualizacion_comp' => 'SI']);
        } else {
            $request->request->add(['actualizacion_comp' => 'NO']);
        }
        if ($request->visita_inicial){
            $request->request->add(['visita_inicial' => 'SI']);
        } else {
            $request->request->add(['visita_inicial' => 'NO']);
        }
        if ($request->capacitacion_op){
            $request->request->add(['capacitacion_op' => 'SI']);
        } else {
            $request->request->add(['capacitacion_op' => 'NO']);
        }
        if ($request->capacitacion_asesor){
            $request->request->add(['capacitacion_asesor' => 'SI']);
        } else {
            $request->request->add(['capacitacion_asesor' => 'NO']);
        }
        if ($request->ensayo){
            $request->request->add(['ensayo' => 'SI']);
        } else {
            $request->request->add(['ensayo' => 'NO']);
        }
        if ($request->check_list){
            $request->request->add(['check_list' => 'SI']);
        } else {
            $request->request->add(['check_list' => 'NO']);
        }
        if ($request->limpieza_inyectores){
            $request->request->add(['limpieza_inyectores' => 'SI']);
        } else {
            $request->request->add(['limpieza_inyectores' => 'NO']);
        }
        if ($request->analisis_final){
            $request->request->add(['analisis_final' => 'SI']);
        } else {
            $request->request->add(['analisis_final' => 'NO']);
        }

        $mes = $request->get('mes');
        $id_orga = $request->get('id_organizacion');
        $tipo = "Oro";
       //dd($tipo);
        $monitoreo = Monitoreo::create(['id_organizacion'=>$id_orga, 'mes_facturacion'=>$mes, 'tipo'=>$tipo, 
                                        'estado'=>'Pendiente','anofiscal'=>$año]);

        $costo_paq = 0;
        $maquinas = $request->NumSMaq;

        foreach ($maquinas as $maquina) {
            $request->request->add(['NumSMaq' => $maquina]);

            //Busca si ya tiene creada una conectividad
            $maqdestroy = Jdlink::where([['NumSMaq', $maquina], ['anofiscal',$año]])->first();
            if(isset($maqdestroy)){
                //Elimina la conectividad para colocar la nueva
                $maqdestroy->delete();
            }
            $jdlinks = Jdlink::create($request->all());

            //Inseto en la table monitoreo maquinas
    
            $monitoreo_maquina = Monitoreo_maquina::create(['id_monitoreo'=>$monitoreo->id, 'NumSMaq'=>$jdlinks->NumSMaq,
                                                            'costo'=>$jdlinks->costo]);
            $costo_paq = $costo_paq + $jdlinks->costo;
        }

        $monitoreo->update(['costo_total'=>$costo_paq]);

        //Buscar que organizacion es la que solicita el soporte
        $organizacion = Organizacion::where('id',$request->id_organizacion)->first();
        //obtener sucursal donde pertenece el usuario que solicita la asistencia
        $sucursalid = Sucursal::select('sucursals.id')
                            ->where('id',$organizacion->CodiSucu)
                            ->first();
                            
        $matchTheseAdministrativo = [['puesto_empleados.NombPuEm', 'Administrativo de servicio'], ['users.CodiSucu', $sucursalid->id]];
        $matchTheseGerente = [['puesto_empleados.NombPuEm', 'Gerente de sucursal'], ['users.CodiSucu', $sucursalid->id]];
        $matchTheseEspecialista = [['puesto_empleados.NombPuEm', 'Analista de soluciones integrales'], ['users.CodiSucu', $sucursalid->id]];
        
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where('roles.name','Admin')
                        ->orWhere($matchTheseAdministrativo)
                        ->orWhere($matchTheseEspecialista)
                        ->orWhere($matchTheseGerente)->get();
                        
        //Envio de notificacion
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA - Paquete de monitoreo',
                'body' => 'Se ha registrado un nuevo paquete de monitoreo de cosecha de: '.$organizacion->NombOrga.'',
                'path' => '/jdlink',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        return redirect()->route('home')->with('status_success', 'Conectividad registrada con éxito');
    }


  

    /**
     * Display the specified resource.
     *
     * @param  \App\jdlink  $jdlink
     * @return \Illuminate\Http\Response
     */
    public function show(jdlink $jdlink)
    {
        Gate::authorize('haveaccess','jdlink.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Monitoreo']);
        $organizacionjd = Maquina::where('NumSMaq',$jdlink->NumSMaq)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $misbonificaciones = Mibonificacion::select('mibonificacions.id','bonificacions.tipo','bonificacions.descuento')
                                ->join('bonificacions','mibonificacions.id_bonificacion','=','bonificacions.id')
                                ->where([['mibonificacions.id_organizacion', $organizacionjd->CodiOrga],
                                        ['mibonificacions.estado','Aceptado']])
                                ->orWhere([['mibonificacions.id_organizacion', $organizacionjd->CodiOrga],
                                        ['mibonificacions.estado','Aplicado'],['mibonificacions.id',$jdlink->id_mibonificacion]])->get();                     
        $rutavolver = route('jdlink.index');
        return view('jdlink.view', compact('jdlink','misbonificaciones','organizacionjd','organizaciones','rutavolver'));
    }

    public function detalle()
    {
        Gate::authorize('haveaccess','jdlink.detalle');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Monitoreo']);
        $nomborg = User::select('organizacions.NombOrga','organizacions.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
        if ($nomborg->NombOrga == 'Sala Hnos'){
            return redirect()->route('jdlink.index');
        } else {
            $organizacion = Organizacion::where('id',$nomborg->id)->first();
        }
        $maquinas = Maquina::where('CodiOrga',$organizacion->id)->get();

        //El dia de hoy
        $hoy = Carbon::today();
        //Damos el formato para realizar calculos entre fechas
        $hoy = $hoy->format('Y-m-d');

        $monitoreo = "NO";
        $soporte_siembra = "NO";
        $actualizacion_comp = "NO";
        $capacitacion_op = "NO";
        $capacitacion_asesor = "NO";
        $ordenamiento_agro = "NO";
        $ensayo = "NO";
        $visita_inicial = "NO";
        $calibracion_implemento = "NO";
        $check_list = "NO";
        $informes = "NO";
        $alertas = "NO";
        $mantenimiento = "NO";
        $apivinculada = "NO";
        $analisis_final = "NO";
        $hectareas = "NO";
        $costo = "NO";
        $limpieza_inyectores = "NO";
        $vencimiento_contrato = "NO";

        //Buscamos que servicios tienen incluidos en el paquete de monitoreo para solo mostrar dichos servicios.
        foreach ($maquinas as $maquina) {
            $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                            ->orderBy('vencimiento_contrato','DESC')->get();
            foreach ($jdlinks as $jdlink) {
                if($jdlink->monitoreo=="SI"){
                    $monitoreo="SI";
                }
                if($jdlink->soporte_siembra=="SI"){
                    $soporte_siembra="SI";
                }
                if(($jdlink->actualizacion_comp=="SI") OR ($jdlink->actualizacion_comp=="Realizado")){
                    $actualizacion_comp="SI";
                }
                if($jdlink->capacitacion_op=="SI"){
                    $capacitacion_op="SI";
                }
                if($jdlink->capacitacion_asesor=="SI"){
                    $capacitacion_asesor="SI";
                }
                if($jdlink->ordenamiento_agro=="SI"){
                    $ordenamiento_agro="SI";
                }
                if(($jdlink->ensayo=="SI") OR ($jdlink->ensayo=="Realizado")){
                    $ensayo="SI";
                }
                if(($jdlink->visita_inicial=="SI") OR ($jdlink->visita_inicial=="Realizada")){
                    $visita_inicial="SI";
                }
                if($jdlink->calibracion_implemento=="SI"){
                    $calibracion_implemento="SI";
                }
                if(($jdlink->check_list=="SI") OR ($jdlink->check_list=="Realizado")){
                    $check_list="SI";
                }
                if(($jdlink->monitoreo=="SI")){
                    $monitoreo="SI";
                }
                if($jdlink->apivinculada=="SI"){
                    $apivinculada="SI";
                }
                if($jdlink->analisis_final=="SI"){
                    $analisis_final="SI";
                }
                if($jdlink->hectareas<>"NO"){
                    $hectareas="SI";
                }
                if($jdlink->costo<>"NO"){
                    $costo="SI";
                }
                if(($jdlink->limpieza_inyectores=="SI") OR ($jdlink->limpieza_inyectores=="Realizada")){
                    $limpieza_inyectores="SI";
                }
            }
        }
        $rutavolver = route('jdlink.menu');
        return view('jdlink.detalle', compact('maquinas','monitoreo','soporte_siembra','rutavolver','hoy',
                                                'actualizacion_comp','capacitacion_op','capacitacion_asesor',
                                            'ordenamiento_agro','ensayo','visita_inicial','calibracion_implemento',
                                            'check_list','apivinculada', 'analisis_final','hectareas','costo',
                                            'limpieza_inyectores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\jdlink  $jdlink
     * @return \Illuminate\Http\Response
     */
    public function edit(jdlink $jdlink)
    {
        Gate::authorize('haveaccess','jdlink.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Monitoreo']);
        $organizacionjd = Maquina::where('NumSMaq',$jdlink->NumSMaq)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $misbonificaciones = Mibonificacion::select('mibonificacions.id','bonificacions.tipo','bonificacions.descuento')
                                ->join('bonificacions','mibonificacions.id_bonificacion','=','bonificacions.id')
                                ->where([['mibonificacions.id_organizacion', $organizacionjd->CodiOrga],
                                        ['mibonificacions.estado','Aceptado']])
                                ->orWhere([['mibonificacions.id_organizacion', $organizacionjd->CodiOrga],
                                        ['mibonificacions.estado','Aplicado'],['mibonificacions.id',$jdlink->id_mibonificacion]])->get();
                                        
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
                                                $query->where('puesto_empleados.NombPuEm', 'RAC');
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
        return view('jdlink.edit', compact('jdlink','misbonificaciones','organizacionjd','organizaciones','rutavolver','asesores'));
    }


        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\jdlink  $jdlink
     * @return \Illuminate\Http\Response
     */
    public function editservicio(jdlink $jdlink)
    {
        Gate::authorize('haveaccess','jdlink.editservicio');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Monitoreo']);
        $organizacionjd = Maquina::where('NumSMaq',$jdlink->NumSMaq)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $misbonificaciones = Mibonificacion::select('mibonificacions.id','bonificacions.tipo','bonificacions.descuento')
                                ->join('bonificacions','mibonificacions.id_bonificacion','=','bonificacions.id')
                                ->where([['mibonificacions.id_organizacion', $organizacionjd->CodiOrga],
                                        ['mibonificacions.estado','Aceptado']])
                                ->orWhere([['mibonificacions.id_organizacion', $organizacionjd->CodiOrga],
                                        ['mibonificacions.estado','Aplicado'],['mibonificacions.id',$jdlink->id_mibonificacion]])->get();
                                        
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
                                                $query->where('puesto_empleados.NombPuEm', 'RAC');
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
        return view('jdlink.editservicio', compact('jdlink','misbonificaciones','organizacionjd','organizaciones','rutavolver','asesores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\jdlink  $jdlink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, jdlink $jdlink)
    {
        $response = Gate::inspect('haveaccess','jdlink.edit');
        if ($response->allowed()) {
            Gate::authorize('haveaccess','jdlink.edit');
            request()->validate([
                'NumSMaq' => 'required|max:50',
                'costo' => 'required',
                'anofiscal' => 'required'
            ]);
        } else {
            Gate::authorize('haveaccess','jdlink.editservicio');
        }
        

        if ($request->conectado){
            $request->request->add(['conectado' => 'SI']);
        } else {
            $request->request->add(['conectado' => 'NO']);
        }
        if ($request->monitoreo){
            $request->request->add(['monitoreo' => 'SI']);
        } else {
            $request->request->add(['monitoreo' => 'NO']);
        }
        if ($request->soporte_siembra){
            $request->request->add(['soporte_siembra' => 'SI']);
        } else {
            $request->request->add(['soporte_siembra' => 'NO']);
        }
        if ($request->informes){
            $request->request->add(['informes' => 'SI']);
        } else {
            $request->request->add(['informes' => 'NO']);
        }
        if ($request->alertas){
            $request->request->add(['alertas' => 'SI']);
        } else {
            $request->request->add(['alertas' => 'NO']);
        }
        if ($request->calibracion_implemento){
            $request->request->add(['calibracion_implemento' => 'SI']);
        } else {
            $request->request->add(['calibracion_implemento' => 'NO']);
        }
        if ($request->capacitacion_op){
            $request->request->add(['capacitacion_op' => 'SI']);
        } else {
            $request->request->add(['capacitacion_op' => 'NO']);
        }
        if ($request->capacitacion_asesor){
            $request->request->add(['capacitacion_asesor' => 'SI']);
        } else {
            $request->request->add(['capacitacion_asesor' => 'NO']);
        }
        if ($request->ordenamiento_agro){
            $request->request->add(['ordenamiento_agro' => 'SI']);
        } else {
            $request->request->add(['ordenamiento_agro' => 'NO']);
        }
        if ($request->apivinculada){
            $request->request->add(['apivinculada' => 'SI']);
        } else {
            $request->request->add(['apivinculada' => 'NO']);
        }
        if ($request->calidad_siembra){
            $request->request->add(['calidad_siembra' => 'SI']);
        } else {
            $request->request->add(['calidad_siembra' => 'NO']);
        }
        if ($request->muestreo){
            $request->request->add(['muestreo' => 'SI']);
        } else {
            $request->request->add(['muestreo' => 'NO']);
        }
        

        $bonif = $request->get('id_mibonificacion');
        if (($jdlink->id_mibonificacion <>'') AND ($jdlink->id_mibonificacion <> $bonif)){
            $mibonif = Mibonificacion::where('id',$jdlink->id_mibonificacion)->first();
            $mibonif->update(['estado'=>'Aceptado']);
        }
        if ($bonif <> ''){
            $mibonif = Mibonificacion::where('id',$bonif)->first();
            $mibonif->update(['estado'=>'Aplicado']);
            $alldata = $request->all();
        } else {
            if ($jdlink->id_mibonificacion <>''){
                $mibonif = Mibonificacion::where('id',$jdlink->id_mibonificacion)->first();
                $mibonif->update(['estado'=>'Aceptado']);
                $alldata = $request->all();
            } else {
                $alldata = $request->except('id_mibonificacion');
            }
        }

        $jdlink->update($alldata);

        $anofiscal = $request->get('anofiscal');
        $NumSMaq = $request->get('NumSMaq');
        $costo_maq = $request->get('costo');
    
        $factura = Monitoreo_maquina::select('monitoreo_maquinas.id','monitoreos.estado','monitoreos.id as idm',
                                    'monitoreo_maquinas.costo')
                            ->join('monitoreos','monitoreo_maquinas.id_monitoreo','=','monitoreos.id')
                            ->where([['anofiscal',$anofiscal], ['NumSMaq',$NumSMaq]])->first();

        if (isset($factura)) {
            if ($factura->estado <> 'Facturado') {
                $total = 0;
                $factura->update(['costo'=>$costo_maq]);
                $monits = Monitoreo_maquina::where('id_monitoreo',$factura->idm)->get();
                foreach ($monits as $monit) {
                    $total = $total + $monit->costo;
                }
                $monitoreo_costo = Monitoreo::where('id',$factura->idm)->first();
                $monitoreo_costo->update(['costo_total'=>$total]);
                $status = 'status_success';
                $msg = 'Registro de conectividad modificado con éxito, si se modifió el monto, por favor revise en el modulo de facturación de monitoreo que tambien se haya modificado';
            } else{
                $status = 'status_warning';
                $msg = 'Registro de conectividad modificado con éxito, contactese con administración para realizar la respectiva NOTA DE CRÉDITO O DÉBITO segun corresponda, ya que existe una factura de monitoreo para este equipo en este año fiscal';
            }
        }else{
            $status = 'status_warning';
            $msg = 'Registro de conectividad modificado con éxito, revisar estados de facturación ya que no se encontró en registro de facturación de paquete para este equipo';
        }

        return redirect()->route('jdlink.index')->with($status, $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\jdlink  $jdlink
     * @return \Illuminate\Http\Response
     */
    public function destroy(jdlink $jdlink)
    {
        Gate::authorize('haveaccess','jdlink.destroy');
        $jdlink->delete();
        return redirect()->route('jdlink.index')->with('status_success', 'Conectividad eliminada con exito');
    }
}
