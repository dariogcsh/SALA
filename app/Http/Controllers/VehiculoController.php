<?php

namespace App\Http\Controllers;

use App\vehiculo;
use App\interaccion;
use App\sucursal;
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
        return view('vehiculo.create',compact('rutavolver','sucursals'));
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
        return view('vehiculo.view', compact('vehiculo','rutavolver','sucursal'));
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
        return view('vehiculo.edit', compact('vehiculo','rutavolver','sucursals'));
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
