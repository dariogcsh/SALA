<?php

namespace App\Http\Controllers;

use App\conectividad;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConectividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','conectividad.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Conectividad']);
        $rutavolver = route('internoconfiguracion');
        $conectividads = Conectividad::orderBy('id','desc')->paginate(20);
        return view('conectividad.index', compact('conectividads','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','conectividad.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Conectividad']);
        $rutavolver = route('conectividad.index');
        return view('conectividad.create',compact('rutavolver'));
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
            'nombre' => 'required|max:50|unique:conectividads,nombre'
        ]);
        $conectividads = Conectividad::create($request->all());
        return redirect()->route('conectividad.index')->with('status_success', 'Conectividad creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\conectividad  $conectividad
     * @return \Illuminate\Http\Response
     */
    public function show(conectividad $conectividad)
    {
        //
        Gate::authorize('haveaccess','conectividad.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Conectividad']);
        $rutavolver = route('conectividad.index');
        return view('conectividad.view', compact('conectividad','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\conectividad  $conectividad
     * @return \Illuminate\Http\Response
     */
    public function edit(conectividad $conectividad)
    {
        //
        Gate::authorize('haveaccess','conectividad.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Conectividad']);
        $rutavolver = route('conectividad.index');
        return view('conectividad.edit', compact('conectividad','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\conectividad  $conectividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, conectividad $conectividad)
    {
        //
        Gate::authorize('haveaccess','conectividad.edit');
        $request->validate([
            'nombre'          => 'required|max:50|unique:conectividads,nombre,'.$conectividad->id,
        ]);

        $conectividad->update($request->all());
        return redirect()->route('conectividad.index')->with('status_success', 'Conectividad modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\conectividad  $conectividad
     * @return \Illuminate\Http\Response
     */
    public function destroy(conectividad $conectividad)
    {
        //
        Gate::authorize('haveaccess','conectividad.destroy');
        $conectividad->delete();
        return redirect()->route('conectividad.index')->with('status_success', 'Conectividad eliminada con exito');
    }
}