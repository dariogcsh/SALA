<?php

namespace App\Http\Controllers;

use App\etapa;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EtapaController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','etapa.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('internoconfiguracion');
        $etapas = Etapa::orderBy('orden','asc')->paginate(20);
        return view('etapa.index', compact('etapas','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','etapa.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('etapa.index');
        return view('etapa.create',compact('rutavolver'));
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
            'nombre' => 'required|max:50|unique:etapas,nombre',
            'orden' => 'required|max:50|unique:etapas,orden',
        ]);
        $etapas = Etapa::create($request->all());
        return redirect()->route('etapa.index')->with('status_success', 'Etapa creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\etapa  $etapa
     * @return \Illuminate\Http\Response
     */
    public function show(etapa $etapa)
    {
        //
        Gate::authorize('haveaccess','etapa.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('etapa.index');
        return view('etapa.view', compact('etapa','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\etapa  $etapa
     * @return \Illuminate\Http\Response
     */
    public function edit(etapa $etapa)
    {
        //
        Gate::authorize('haveaccess','etapa.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
        $rutavolver = route('etapa.index');
        return view('etapa.edit', compact('etapa','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\etapa  $etapa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, etapa $etapa)
    {
        //
        Gate::authorize('haveaccess','etapa.edit');
        $request->validate([
            'nombre'          => 'required|max:50|unique:etapas,nombre,'.$etapa->id,
            'orden'          => 'required|max:50|unique:etapas,orden,'.$etapa->id,
        ]);

        $etapa->update($request->all());
        return redirect()->route('etapa.index')->with('status_success', 'Etapa modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\etapa  $etapa
     * @return \Illuminate\Http\Response
     */
    public function destroy(etapa $etapa)
    {
        //
        Gate::authorize('haveaccess','etapa.destroy');
        $etapa->delete();
        return redirect()->route('etapa.index')->with('status_success', 'Etapa eliminada con exito');
    }
}
