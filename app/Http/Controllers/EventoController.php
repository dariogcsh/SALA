<?php

namespace App\Http\Controllers;

use App\evento;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventoController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','evento.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calendario']);
        $rutavolver = route('internoconfiguracion');
        $eventos = Evento::orderBy('nombre','asc')->paginate(20);
        return view('evento.index', compact('eventos','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','evento.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calendario']);
        $rutavolver = route('evento.index');
        return view('evento.create',compact('rutavolver'));
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
            'nombre' => 'required|max:50|unique:eventos,nombre'
        ]);
        $eventos = Evento::create($request->all());
        return redirect()->route('evento.index')->with('status_success', 'Evento creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(evento $evento)
    {
        //
        Gate::authorize('haveaccess','evento.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calendario']);
        $rutavolver = route('evento.index');
        return view('evento.view', compact('evento','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(evento $evento)
    {
        //
        Gate::authorize('haveaccess','evento.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Calendario']);
        $rutavolver = route('evento.index');
        return view('evento.edit', compact('evento','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, evento $evento)
    {
        //
        Gate::authorize('haveaccess','evento.edit');
        $request->validate([
            'nombre'          => 'required|max:50|unique:eventos,nombre,'.$evento->id,
        ]);

        $evento->update($request->all());
        return redirect()->route('evento.index')->with('status_success', 'Evento modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(evento $evento)
    {
        //
        Gate::authorize('haveaccess','evento.destroy');
        $evento->delete();
        return redirect()->route('evento.index')->with('status_success', 'Evento eliminado con exito');
    }
}
