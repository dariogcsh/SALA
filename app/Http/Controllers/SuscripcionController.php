<?php

namespace App\Http\Controllers;

use App\suscripcion;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SuscripcionController extends Controller
{
    public function index()
    {
        //
        Gate::authorize('haveaccess','suscripcion.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
        $rutavolver = route('internoconfiguracion');
        $suscripciones = Suscripcion::orderBy('id','desc')->paginate(20);
        return view('suscripcion.index', compact('suscripciones','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','suscripcion.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
        $rutavolver = route('suscripcion.index');
        return view('suscripcion.create',compact('rutavolver'));
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
            'nombre' => 'required|max:255|unique:suscripcions,nombre'
        ]);
        $suscripciones = Suscripcion::create($request->all());
        return redirect()->route('suscripcion.index')->with('status_success', 'Suscripcion creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\suscripcion  $suscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(suscripcion $suscripcion)
    {
        //
        Gate::authorize('haveaccess','suscripcion.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
        $rutavolver = route('suscripcion.index');
        return view('suscripcion.view', compact('suscripcion','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\suscripcion  $suscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit(suscripcion $suscripcion)
    {
        //
        Gate::authorize('haveaccess','suscripcion.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Activacion/Suscripcion']);
        $rutavolver = route('suscripcion.index');
        return view('suscripcion.edit', compact('suscripcion','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\suscripcion  $suscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, suscripcion $suscripcion)
    {
        //
        Gate::authorize('haveaccess','suscripcion.edit');
        $request->validate([
            'nombre'          => 'required|max:255|unique:suscripcions,nombre,'.$suscripcion->id,
        ]);

        $suscripcion->update($request->all());
        return redirect()->route('suscripcion.index')->with('status_success', 'Suscripcion modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\suscripcion  $suscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(suscripcion $suscripcion)
    {
        //
        Gate::authorize('haveaccess','suscripcion.destroy');
        $suscripcion->delete();
        return redirect()->route('suscripcion.index')->with('status_success', 'suscripcion eliminada con exito');
    }
}
