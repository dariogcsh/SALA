<?php

namespace App\Http\Controllers;

use App\vehiculo;
use App\interaccion;
use App\sucursal;
use App\vehiculo_responsable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','vehiculo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('internoconfiguracion');

        $filtro="";
        $busqueda="";

        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $vehiculos = Vehiculo::Buscar($tipo, $busqueda)->orderBy('vehiculos.nvehiculo','desc')->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
            $vehiculos = Vehiculo::select('vehiculos.id','vehiculos.nombre','vehiculos.id_vsat','vehiculos.nombre',
                                        'vehiculos.marca','vehiculos.modelo','vehiculos.ano','vehiculos.nvehiculo',
                                        'vehiculos.patente','sucursals.NombSucu','vehiculos.seguro','vehiculos.tipo_registro',
                                        'vehiculos.vto_poliza')
                                ->leftjoin('sucursals','vehiculos.id_sucursal','=','sucursals.id')
                                ->orderBy('vehiculos.nvehiculo','desc')->paginate(20);
            }
        
        return view('vehiculo.index', compact('vehiculos','rutavolver','filtro','busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','vehiculo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('vehiculo.index');
        $sucursals = Sucursal::all();
        $usuarios = User::select('users.id','users.name','users.last_name')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('organizacions.NombOrga','Sala Hnos')->get();
        return view('vehiculo.create',compact('rutavolver','sucursals','usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehiculos = Vehiculo::create($request->all());

        //insertar usuarios paraa la accion correctiva
        if (isset($request->id_user)) {
            $responsables = $request->id_user;
        }
        
        if (isset($responsables)) {
            foreach ($responsables as $resp) {
                $responsable_usar = new Vehiculo_responsable([
                   
                    'id_user'   =>  $resp,
                    'id_vehiculo'  =>  $vehiculos->id,
                ]);
                $responsable_usar->save();
            }
        }
        return redirect()->route('vehiculo.index')->with('status_success', 'Vehiculo creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function show(vehiculo $vehiculo)
    {
        //
        Gate::authorize('haveaccess','vehiculo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('vehiculo.index');
        $sucursal = Sucursal::where('id',$vehiculo->id_sucursal)->first();
        $usuarios = User::select('users.id','users.name','users.last_name')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('organizacions.NombOrga','Sala Hnos')->get();
        $usuarios_responsables = vehiculo_responsable::where('id_vehiculo',$vehiculo->id)->get();
        return view('vehiculo.view', compact('vehiculo','rutavolver','sucursal','usuarios','usuarios_responsables'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(vehiculo $vehiculo)
    {
        //
        Gate::authorize('haveaccess','vehiculo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('vehiculo.index');
        $sucursals = Sucursal::all();
        $usuarios = User::select('users.id','users.name','users.last_name')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('organizacions.NombOrga','Sala Hnos')->get();
        $usuarios_responsables = vehiculo_responsable::where('id_vehiculo',$vehiculo->id)->get();
        return view('vehiculo.edit', compact('vehiculo','rutavolver','sucursals','usuarios','usuarios_responsables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vehiculo $vehiculo)
    {
        //
        Gate::authorize('haveaccess','vehiculo.edit');

        $responsables = Vehiculo_responsable::where('id_vehiculo',$vehiculo->id)->get();

        //Guardo los resultaados en un array en caso que se obtenga algo
        $i=0;
        foreach ($responsables as $resp){
            $calp[$i] = $resp->id_user;
            $i++;
        }

        $participantes = $request->id_user;

        // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
        if (isset($participantes)) {
            foreach ($responsables as $resp_user){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                if (!in_array($resp_user->id_user, $participantes)) {
                    $resp_user->delete();
                }
            }
            // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
            // lo REGISTRA
            foreach ($participantes as $participante){
                if (!isset($calp)) {
                    $nuevos_responsables = Vehiculo_responsable::create(['id_user' => $participante, 'id_vehiculo' => $vehiculo->id]);
                }else{
                    if (!in_array($participante, $calp)) {
                        $nuevos_responsables = Vehiculo_responsable::create(['id_user' => $participante, 'id_vehiculo' => $vehiculo->id]);
                    }
                }
            }
        } elseif(isset($responsables)) {
            foreach ($responsables as $resp_user){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                $resp_user->delete();
            }
        }

        $vehiculo->update($request->all());
        return redirect()->route('vehiculo.index')->with('status_success', 'Vehiculo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(vehiculo $vehiculo)
    {
        //
        Gate::authorize('haveaccess','vehiculo.destroy');
        $vehiculo->delete();
        return redirect()->route('vehiculo.index')->with('status_success', 'Vehiculo eliminado con exito');
    }
}
