<?php

namespace App\Http\Controllers;

use App\contacto;
use App\organizacion;
use App\alerta;
use App\interaccion;
use App\sucursal;
use App\asist;
use App\informe;
use App\jdlink;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('haveaccess','contacto.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contactos con el cliente']);
        $rutavolver = route('menuinterno');
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $contactos = Contacto::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
            $contactos = Contacto::select('contactos.id','contactos.id_user','contactos.id_organizacion','organizacions.NombOrga',
                                        'contactos.persona','contactos.tipo','contactos.departamento','contactos.comentarios',
                                        'contactos.created_at')
                                ->join('organizacions','contactos.id_organizacion','=','organizacions.id')
                                ->orderBy('contactos.id','desc')->paginate(20);      
        }
        
        return view('contacto.index', compact('contactos','filtro','busqueda','rutavolver'));
    }


    public function sincontacto(Request $request)
    {
        Gate::authorize('haveaccess','contacto.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contactos con el cliente']);
        $rutavolver = route('contacto.index');
        $filtro="";
        $busqueda="";
        $fecha_h = Carbon::today();
        $hoy = $fecha_h->format('Y-m-d');
        $año = $fecha_h->format('Y');
        $sucursales = Sucursal::all();
        $sucursal = "";
        if (($hoy > $año."-10-31") AND ($hoy <= $año."-12-31")){
            $año = $año + 1;
        }
        if(($request->buscarpor) OR ($request->sucursal)){
            $busqueda = $request->get('buscarpor');
            if($busqueda == ""){
                $busqueda = 15;
            }
            $fecha_d = $fecha_h->subDays($busqueda);
            $filtro = "SI";
            if(isset($request->sucursal)){
                $sucursal = $request->get('sucursal');
                $sucursals = Sucursal::where('id',$sucursal)->first();
                $busqueda_sucu = $sucursals->NombSucu;
            }else{
                $busqueda_sucu = "";
            }
        }else{
            $fecha_d = $fecha_h->subDays(15);
            $busqueda_sucu = "";
        }
        $desde = $fecha_d->format('Y-m-d');
        $contador_orga = 0;
      
        if($filtro == ""){
            $organizaciones_monitoreada = Jdlink::select('organizacions.id','organizacions.NombOrga','sucursals.NombSucu')
                                                ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                ->where([['jdlinks.vencimiento_contrato','>',$hoy], 
                                                        ['jdlinks.monitoreo','SI'], ['maquinas.TipoMaq','COSECHADORA'],
                                                        ['anofiscal',$año]])
                                                ->groupBy('organizacions.id')
                                                ->orderBy('sucursals.id','asc')->get(); 
        }else{
            if($sucursal == ""){
                $organizaciones_monitoreada = Jdlink::select('organizacions.id','organizacions.NombOrga','sucursals.NombSucu')
                                                    ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                    ->where([['jdlinks.vencimiento_contrato','>',$hoy], 
                                                            ['jdlinks.monitoreo','SI'], ['maquinas.TipoMaq','COSECHADORA'],
                                                            ['anofiscal',$año]])
                                                    ->groupBy('organizacions.id')
                                                    ->orderBy('sucursals.id','asc')->get(); 
            }else{
                $organizaciones_monitoreada = Jdlink::select('organizacions.id','organizacions.NombOrga','sucursals.NombSucu')
                                                    ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                    ->where([['jdlinks.vencimiento_contrato','>',$hoy], 
                                                            ['jdlinks.monitoreo','SI'], ['maquinas.TipoMaq','COSECHADORA'],
                                                            ['anofiscal',$año],['sucursals.id',$sucursal]])
                                                    ->groupBy('organizacions.id')
                                                    ->orderBy('sucursals.id','asc')->get(); 
            }
        }
            foreach($organizaciones_monitoreada as $org){
                $contacto = Contacto::select('contactos.id','contactos.id_organizacion','organizacions.NombOrga',
                                                    'contactos.departamento','contactos.created_at','users.name',
                                                    'users.last_name','sucursals.NombSucu')
                                            ->join('organizacions','contactos.id_organizacion','=','organizacions.id')
                                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                            ->join('users','contactos.id_user','=','users.id')
                                            ->where([['contactos.created_at','>=',$desde], ['contactos.id_organizacion',$org->id]])
                                            ->orderBy('contactos.created_at','desc')->first(); 
                if(isset($contacto)){

                }else{
                    $sincontacto = Contacto::select('contactos.id','contactos.id_organizacion','organizacions.NombOrga',
                                                            'contactos.departamento','contactos.created_at','users.name',
                                                            'users.last_name','sucursals.NombSucu')
                                                    ->join('organizacions','contactos.id_organizacion','=','organizacions.id')
                                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                    ->join('users','contactos.id_user','=','users.id')
                                                    ->where([['contactos.created_at','<',$desde], ['contactos.id_organizacion',$org->id]])
                                                    ->orderBy('contactos.created_at','desc')->first(); 
                  
                        $contador_orga++;
                 
                }
            }
        
        return view('contacto.sincontacto', compact('rutavolver','organizaciones_monitoreada','filtro','busqueda',
                                                    'desde','contador_orga','sucursales','busqueda_sucu'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','contacto.create');
                    
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contactos con el cliente']);
        $organizacions = Organizacion::orderBy('NombOrga','asc')->get();
        $rutavolver = route('contacto.index');
        return view('contacto.create', compact('organizacions','rutavolver'));
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
        Gate::authorize('haveaccess','contacto.create');
        request()->validate([
            'id_organizacion'  => 'required',
            'tipo'   => 'required',
            'persona'   => 'required',
            'departamento'   => 'required',
        ]);
        $request->request->add(['id_user' => auth()->id()]);
        $contacto = contacto::create($request->all());
        return redirect()->route('contacto.index')->with('status_success', 'contacto creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function show(contacto $contacto)
    {
        Gate::authorize('haveaccess','contacto.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contactos con el cliente']);
        $organizacion = Organizacion::where('id',$contacto->id_organizacion)->first();
        $rutavolver = route('contacto.index');
        return view('contacto.view', compact('contacto','organizacion','rutavolver'));
    }

    public function historial($id)
    {
        Gate::authorize('haveaccess','contacto.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contactos con el cliente']);
        $contacto = Contacto::where('id',$id)->first();
        $organizacion = Organizacion::where('id',$contacto->id_organizacion)->first();
        $rutavolver = route('contacto.index');
        
        $a = Contacto::select('contactos.id as idclase','contactos.created_at AS creado','organizacions.id',
                    DB::raw("CONCAT(users.name,' ',users.last_name) AS campo2"),'contactos.tipo AS campo3','contactos.departamento AS campo4',
                            'contactos.comentarios AS campo5','contactos.persona AS campo8',
                            DB::raw("CONCAT('contactos') AS tabla"))
                    ->join('users','contactos.id_user','=','users.id')
                    ->join('organizacions','contactos.id_organizacion','=','organizacions.id')
                    ->where('contactos.id_organizacion',$contacto->id_organizacion);

        $b = Alerta::select('alertas.id as idclase','alertas.created_at AS creado','organizacions.id',
                            'alertas.fecha AS campo2','alertas.hora AS campo3','alertas.pin AS campo4',
                            'alertas.accion AS campo5','alertas.descripcion AS campo8',
                            DB::raw("CONCAT('alertas') AS tabla" ))
                    ->join('maquinas','alertas.pin','=','maquinas.NumSMaq')
                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                    ->where([['organizacions.id',$contacto->id_organizacion], ['alertas.accion','<>',''],
                            ['alertas.descripcion','not like','ROJO VMAX 00001.01%']]);

        $c = Asist::select('asists.id AS idclase', 'asists.created_at AS creado', 'organizacions.id',
                            DB::raw("CONCAT(users.name,' ',users.last_name) AS campo2"), 'asists.DescAsis AS campo3',
                            'asists.EstaAsis AS campo4','asists.ResuAsis AS campo5', 'calificacions.puntos AS campo8',
                            DB::raw("CONCAT('asists') AS tabla" ))
                    ->leftjoin('calificacions','asists.id','=','calificacions.id_asist')
                    ->join('users','asists.id_user','=','users.id')
                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                    ->where('organizacions.id',$contacto->id_organizacion);

        $historicos = Informe::select('informes.id AS idclase', 'informes.created_at AS creado', 'organizacions.id',
                            'informes.FecIInfo AS campo2', 'informes.FecFInfo AS campo3',
                            'informes.NumSMaq AS campo4','informes.CultInfo AS campo5', 'informes.HsTrInfo AS campo8',
                            DB::raw("CONCAT('informes') AS tabla" ))
                    ->join('maquinas','informes.NumSMaq','=','maquinas.NumSMaq')
                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                    ->where([['organizacions.id',$contacto->id_organizacion],['informes.EstaInfo','Enviado']])
                    ->union($a)
                    ->union($b)
                    ->union($c)
                    ->orderBy('creado','desc')->get();
                    

        return view('contacto.historial', compact('contacto','organizacion','rutavolver','historicos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function edit(contacto $contacto)
    {
        Gate::authorize('haveaccess','contacto.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contactos con el cliente']);
        $organizacions = Organizacion::orderBy('NombOrga','asc')->get();
        $rutavolver = route('contacto.index');
        return view('contacto.edit', compact('contacto','organizacions','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, contacto $contacto)
    {
        Gate::authorize('haveaccess','contacto.edit'||'haveaccess','contactoown.edit');
        request()->validate([
            'id_organizacion'  => 'required',
            'tipo'   => 'required',
            'persona'   => 'required',
            'departamento'   => 'required',
        ]);
        $request->request->add(['id_user' => auth()->id()]);
        $contacto->update($request->all());
        return redirect()->route('contacto.index')->with('status_success', 'contacto modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function destroy(contacto $contacto)
    {
        Gate::authorize('haveaccess','contacto.destroy');
        $contacto->delete();
        return redirect()->route('contacto.index')->with('status_success', 'Contacto eliminada con exito');
    }
}
