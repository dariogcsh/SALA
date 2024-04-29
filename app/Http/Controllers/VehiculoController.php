<?php

namespace App\Http\Controllers;

use App\vehiculo;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','vehiculo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('internoconfiguracion');
        $vehiculos = Vehiculo::orderBy('id','desc')->paginate(20);
        return view('vehiculo.index', compact('vehiculos','rutavolver'));
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
        return view('vehiculo.create',compact('rutavolver'));
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
        request()->validate([
            'id_vsat' => 'required|max:50|unique:vehiculos,id_vsat',
            'nombre' => 'required|max:50|unique:vehiculos,nombre'
        ]);
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
        return view('vehiculo.view', compact('vehiculo','rutavolver'));
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
        return view('vehiculo.edit', compact('vehiculo','rutavolver'));
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
        $request->validate([
            'id_vsat'          => 'required|max:50|unique:vehiculos,id_vsat,'.$vehiculo->id,
            'nombre'          => 'required|max:50|unique:vehiculos,nombre,'.$vehiculo->id

        ]);

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
