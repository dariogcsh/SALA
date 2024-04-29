<?php

namespace App\Http\Controllers;

use App\asistenciatipo;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AsistenciatipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','asistenciatipo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
        $rutavolver = route('internoconfiguracion');
        $tipoasistencias = Asistenciatipo::orderBy('id','desc')->paginate(10);
        return view('asistenciatipo.index', compact('tipoasistencias','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','asistenciatipo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
        $rutavolver = route('asistenciatipo.index');
        return view('asistenciatipo.create',compact('rutavolver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'NombTiAs' => 'required|max:50|unique:asistenciatipos,NombTiAs'
        ]);
        $tipoasistencia = Asistenciatipo::create($request->all());
        return redirect()->route('asistenciatipo.index')->with('status_success', 'Tipo de asistencia creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\asistenciatipo  $asistenciatipo
     * @return \Illuminate\Http\Response
     */
    public function show(asistenciatipo $asistenciatipo)
    {
        Gate::authorize('haveaccess','asistenciatipo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
        $rutavolver = route('asistenciatipo.index');
        return view('asistenciatipo.view', compact('asistenciatipo','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\asistenciatipo  $asistenciatipo
     * @return \Illuminate\Http\Response
     */
    public function edit(asistenciatipo $asistenciatipo)
    {
        Gate::authorize('haveaccess','asistenciatipo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Asistencia']);
        $rutavolver = route('asistenciatipo.index');
        return view('asistenciatipo.edit', compact('asistenciatipo','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\asistenciatipo  $asistenciatipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, asistenciatipo $asistenciatipo)
    {
        Gate::authorize('haveaccess','asistenciatipo.edit');
        $request->validate([
            'NombTiAs'          => 'required|max:50|unique:tipo_asistencias,NombTiAs,'.$asistenciatipo->id,
        ]);

        $asistenciatipo->update($request->all());
        return redirect()->route('asistenciatipo.index')->with('status_success', 'Tipo de asistencia modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\asistenciatipo  $asistenciatipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(asistenciatipo $asistenciatipo)
    {
        Gate::authorize('haveaccess','asistenciatipo.destroy');
        $asistenciatipo->delete();
        return redirect()->route('asistenciatipo.index')->with('status_success', 'Tipo de asistencia eliminada con exito');
    }
}
