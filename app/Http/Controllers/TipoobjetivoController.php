<?php

namespace App\Http\Controllers;

use App\tipoobjetivo;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TipoobjetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','tipoobjetivo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Objetivos']);
        $rutavolver = route('internoconfiguracion');
        $tipoobjetivos = Tipoobjetivo::orderBy('id','desc')->paginate(10);
        return view('tipoobjetivo.index', compact('tipoobjetivos','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','tipoobjetivo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Objetivos']);
        $rutavolver = route('tipoobjetivo.index');
        return view('tipoobjetivo.create',compact('rutavolver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess','tipoobjetivo.create');
        request()->validate([
            'nombre' => 'required|max:100|unique:tipoobjetivos,nombre'
        ]);
        $tipoobjetivo = Tipoobjetivo::create($request->all());
        return redirect()->route('tipoobjetivo.index')->with('status_success', 'Tipo de objetivo creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipoobjetivo  $tipoobjetivo
     * @return \Illuminate\Http\Response
     */
    public function show(tipoobjetivo $tipoobjetivo)
    {
        Gate::authorize('haveaccess','tipoobjetivo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Objetivos']);
        $rutavolver = route('tipoobjetivo.index');
        return view('tipoobjetivo.view', compact('tipoobjetivo','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipoobjetivo  $tipoobjetivo
     * @return \Illuminate\Http\Response
     */
    public function edit(tipoobjetivo $tipoobjetivo)
    {
        Gate::authorize('haveaccess','tipoobjetivo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Objetivos']);
        $rutavolver = route('tipoobjetivo.index');
        return view('tipoobjetivo.edit', compact('tipoobjetivo','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipoobjetivo  $tipoobjetivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipoobjetivo $tipoobjetivo)
    {
        Gate::authorize('haveaccess','tipoobjetivo.edit');
        $request->validate([
            'nombre'          => 'required|max:50|unique:tipoobjetivos,nombre,'.$tipoobjetivo->id,
        ]);

        $tipoobjetivo->update($request->all());
        return redirect()->route('tipoobjetivo.index')->with('status_success', 'Tipo de objetivo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipoobjetivo  $tipoobjetivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(tipoobjetivo $tipoobjetivo)
    {
        Gate::authorize('haveaccess','tipoobjetivo.destroy');
        $tipoobjetivo->delete();
        return redirect()->route('tipoobjetivo.index')->with('status_success', 'Tipo de objetivo eliminado con exito');
    }
}
