<?php

namespace App\Http\Controllers;

use App\entrega;
use App\paso;
use App\interaccion;
use App\etapa;
use App\sucursal;
use App\User;
use App\organizacion;
use App\entrega_paso;
use App\entrega_archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EntregaController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','entrega.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('internoentregas');
        $entregas = Entrega::select('entregas.id','entregas.tipo','entregas.marca','entregas.modelo','entregas.pin',
                                    'organizacions.NombOrga','sucursals.NombSucu','entregas.detalle',
                                    'etapas.nombre as nombreetapa','entregas.toma_usado')
                        ->leftjoin('organizacions','entregas.id_organizacion','=','organizacions.id')
                        ->leftjoin('sucursals','entregas.id_sucursal','=','sucursals.id')
                        ->join('entrega_pasos','entregas.id','=','entrega_pasos.id_entrega')
                        ->join('pasos','entrega_pasos.id_paso','=','pasos.id')
                        ->join('etapas','pasos.id_etapa','=','etapas.id')
                        ->groupBy('entregas.id')
                        ->orderBy('entregas.id','desc')
                        ->where('entregas.tipo_unidad','Nueva')->paginate(20);
        $pasostotales = Paso::select('pasos.id')
                        ->join('etapas','pasos.id_etapa','=','etapas.id')
                        ->where('etapas.tipo_unidad','Nueva')->count();
        return view('entrega.index', compact('entregas','rutavolver','pasostotales'));
    }

    public function indexusado()
    {
        //
        Gate::authorize('haveaccess','entrega.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('internoentregas');
        $entregas = Entrega::select('entregas.id','entregas.tipo','entregas.marca','entregas.modelo','entregas.pin',
                                    'organizacions.NombOrga','sucursals.NombSucu','entregas.detalle',
                                    'etapas.nombre as nombreetapa','entregas.toma_usado','entregas.tipo_unidad')
                        ->leftjoin('organizacions','entregas.id_organizacion','=','organizacions.id')
                        ->leftjoin('sucursals','entregas.id_sucursal','=','sucursals.id')
                        ->leftjoin('entrega_pasos','entregas.id','=','entrega_pasos.id_entrega')
                        ->leftjoin('pasos','entrega_pasos.id_paso','=','pasos.id')
                        ->leftjoin('etapas','pasos.id_etapa','=','etapas.id')
                        ->groupBy('entregas.id')
                        ->orderBy('entregas.id','desc')
                        ->where('entregas.tipo_unidad','Usada')->paginate(20);

        // Para calcular el porcentaje de avance debo seleccionar el primer registro y el ultimo segun el órden en la tabla Paso y calcular ese avance en base al orden actual que se registro.
        $ultimopaso_avance = Paso::select('pasos.orden')
                            ->join('etapas','pasos.id_etapa','=','etapas.id')
                            ->where('etapas.tipo_unidad','Usada')
                            ->orderBy('pasos.orden','DESC')->first();
        return view('entrega.indexusado', compact('entregas','rutavolver','ultimopaso_avance'));
    }

    public function files($id)
    {
        //
        Gate::authorize('haveaccess','mezcla.create');
        $rutavolver = route('entrega.index');
        return view('entrega.files', compact('rutavolver','id'));
    }


    public function subir(Request $request){
        //Obtengo el id_calendario
        $id_entrega = $request->get('id_entrega');
        //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
        foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
        {
            //Validamos que el archivo exista
            if($_FILES["archivo"]["name"][$key]) {
                $filename = time().'1'.rand().$_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo + random
                $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                
                $directorio = public_path('img/entregas/'); //Declaramos un  variable con la ruta donde guardaremos los archivos
                
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                }
                
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(move_uploaded_file($source, $target_path)) {	
                }
                closedir($dir); //Cerramos el directorio de destino

                //Guardamos la ruta de los archivos en la tabla calendario_archivos
                $archivo = Entrega_archivo::create(['id_entrega'=>$id_entrega, 'path'=>$filename]);

            }
        }
        return redirect()->route('entrega.index')->with('status_success', 'Los archivos se han cargado con éxito');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','entrega.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('entrega.index');
        $pasos = Paso::orderBy('orden','asc')->get();
        $organizacions = Organizacion::orderBy('NombOrga','asc')->get();
        $sucursals = Sucursal::orderBy('id','asc')->get();
        $puesto = User::select('puesto_empleados.NombPuEm','puesto_empleados.id')
                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                    ->where('users.CodiPuEm', auth()->user()->CodiPuEm)->first();
        $rol = User::select('roles.name')
                    ->join('role_user','users.id','=','role_user.user_id')
                    ->join('roles','role_user.role_id','=','roles.id')
                    ->where('users.id',auth()->user()->id)->first();
        $vendedor = User::where('id',auth()->user()->id)->first();
        return view('entrega.create',compact('rutavolver','pasos','organizacions','sucursals','puesto','rol','vendedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entregas = Entrega::create($request->all()); 
        $paso = Paso::select('pasos.id')
                    ->join('etapas','pasos.id_etapa','=','etapas.id')
                    ->where('etapas.tipo_unidad',$entregas->tipo_unidad)
                    ->orderBy('pasos.orden','ASC')->first();

        $entrega_paso = Entrega_paso::create(['id_entrega' => $entregas->id, 'id_paso' => $paso->id, 
                                                'id_user' => auth()->user()->id, 'valor_condicion' => $entregas->toma_usado]);
        if($request->tipo_unidad == "Nueva"){
            return redirect()->route('entrega.index')->with('status_success', 'Proceso de venta y entrega iniciado con éxito');
        }else{
            return redirect()->route('entrega.indexusado')->with('status_success', 'Proceso de venta y entrega iniciado con éxito');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function show(entrega $entrega)
    {
        //
        Gate::authorize('haveaccess','entrega.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('entrega.index');
        $organizacions = Organizacion::orderBy('NombOrga','asc')->get();
        $sucursals = Sucursal::orderBy('id','asc')->get();
        $entrega_pasos = Entrega_paso::where('id_entrega',$entrega->id)->get();
        $entrega_pasos_restantes = Paso::orderBy('id_etapa','asc')->get();
        $imagenes = Entrega_archivo::where('id_entrega',$entrega->id)->get();
        return view('entrega.view', compact('entrega','rutavolver','organizacions','sucursals','entrega_pasos',
                                            'entrega_pasos_restantes','imagenes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function edit(entrega $entrega)
    {
        //
        Gate::authorize('haveaccess','entrega.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('entrega.index');
        if($entrega->tipo_unidad == "Nueva"){
            $pasos = Paso::select('pasos.id','pasos.id_etapa','pasos.id_puesto','pasos.nombre','pasos.orden',
                                'pasos.created_at','pasos.updated_at','condicion','pasos.id_paso_anterior',
                                'pasos.valor_condicion_anterior')
            ->join('etapas','pasos.id_etapa','=','etapas.id')
            ->where('etapas.tipo_unidad','Nueva')
            ->orderBy('orden','asc')->get();
        }else{
            $pasos = Paso::select('pasos.id','pasos.id_etapa','pasos.id_puesto','pasos.nombre','pasos.orden',
                                'pasos.created_at','pasos.updated_at','condicion','pasos.id_paso_anterior',
                                'pasos.valor_condicion_anterior')
            ->join('etapas','pasos.id_etapa','=','etapas.id')
            ->where('etapas.tipo_unidad','Usada')
            ->orderBy('orden','asc')->get();
        }
        
        $organizacions = Organizacion::orderBy('NombOrga','asc')->get();
        $sucursals = Sucursal::orderBy('id','asc')->get();
        $entrega_pasos = Entrega_paso::where('id_entrega', $entrega->id)->get();
        
        $puesto = User::select('puesto_empleados.NombPuEm','puesto_empleados.id')
                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                    ->where('users.CodiPuEm', auth()->user()->CodiPuEm)->first();
        $rol = User::select('roles.name')
                    ->join('role_user','users.id','=','role_user.user_id')
                    ->join('roles','role_user.role_id','=','roles.id')
                    ->where('users.id',auth()->user()->id)->first();
        $vendedor = User::where('id',$entrega->id_vendedor)->first();

        return view('entrega.edit',compact('entrega','rutavolver','organizacions','sucursals','pasos','entrega_pasos','puesto','rol','vendedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, entrega $entrega)
    {
        //
        Gate::authorize('haveaccess','entrega.edit');

        $entrega->update($request->all());
        $pasos = Paso::orderBy('orden','asc')->get();
        foreach ($pasos as $paso) {
            $variable = $request->get($paso->id);
            $det = 'detalle'.$paso->id;
            $cond = 'condicion'.$paso->id;
            $detalle = $request->get($det);
            $condicion = $request->get($cond);
            if ($variable == "on") {
                $verificacion = 0;
                $verificacion = Entrega_paso::where([['id_entrega', $entrega->id], ['id_paso', $paso->id]])->count();
                if ($verificacion == 0) {
                    $entrega_paso = Entrega_paso::create(['id_entrega'=>$entrega->id, 'id_paso'=>$paso->id, 
                                                'id_user'=>auth()->user()->id,'detalle'=>$detalle,
                                                'valor_condicion'=>$condicion]);
                    $etapa = Etapa::select('etapas.orden','etapas.id')
                                    ->join('pasos','etapas.id','=','pasos.id_etapa')
                                    ->where('pasos.id',$paso->id)->first();
                    $ultimopaso = Paso::where('id_etapa',$etapa->id)
                                        ->orderBy('orden','desc')->first();
                    
                    if($paso->id == $ultimopaso->id){
                        $etapanueva = Etapa::where('orden','>',$etapa->orden)
                                            ->orderBy('orden','asc')->first();
                        // AQUI ENVIAR NOTIFICACION A EL/LOS USUARIOS CORRESPONDIENTES SEGUN SUCURSAL Y PUESTO
                    }
                }
            }
            $variable = "";
            $detalle = "";
            
        }
        if($request->tipo_unidad == "Nueva"){
            return redirect()->route('entrega.index')->with('status_success', 'Proceso modificado con exito');
        }else{
            return redirect()->route('entrega.indexusado')->with('status_success', 'Proceso modificado con exito');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function destroy(entrega $entrega)
    {
        //
        Gate::authorize('haveaccess','entrega.destroy');
        $entrega->delete();
        return redirect()->route('entrega.index')->with('status_success', 'Recepción eliminada con exito');
    }
}
