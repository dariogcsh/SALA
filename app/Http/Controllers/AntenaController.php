<?php

namespace App\Http\Controllers;

use App\antena;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AntenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','antena.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Antenas']);
        $rutavolver = route('internoconfiguracion');
        $antenas = Antena::orderBy('id','desc')->paginate(20);
        return view('antena.index', compact('antenas','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','antena.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Antenas']);
        $rutavolver = route('antena.index');
        return view('antena.create',compact('rutavolver'));
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
            'NombAnte' => 'required|max:50|unique:antenas,NombAnte'
        ]);
        $antenas = Antena::create($request->all());
        return redirect()->route('antena.index')->with('status_success', 'Antena creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function show(antena $antena)
    {
        //
        Gate::authorize('haveaccess','antena.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Antenas']);
        $rutavolver = route('antena.index');
        return view('antena.view', compact('antena','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function edit(antena $antena)
    {
        //
        Gate::authorize('haveaccess','antena.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Antenas']);
        $rutavolver = route('antena.index');
        return view('antena.edit', compact('antena','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, antena $antena)
    {
        //
        Gate::authorize('haveaccess','antena.edit');
        $request->validate([
            'NombAnte'          => 'required|max:50|unique:antenas,NombAnte,'.$antena->id,
        ]);

        $antena->update($request->all());
        return redirect()->route('antena.index')->with('status_success', 'Antena modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function destroy(antena $antena)
    {
        //
        Gate::authorize('haveaccess','antena.destroy');
        $antena->delete();
        return redirect()->route('antena.index')->with('status_success', 'Antena eliminada con exito');
    }
}