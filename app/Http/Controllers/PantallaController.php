<?php

namespace App\Http\Controllers;

use App\pantalla;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PantallaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','pantalla.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Pantallas']);
        $rutavolver = route('internoconfiguracion');
        $pantallas = Pantalla::orderBy('id','desc')->paginate(10);
        return view('pantalla.index', compact('pantallas','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','pantalla.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Pantallas']);
        $rutavolver = route('pantalla.index');
        return view('pantalla.create',compact('rutavolver'));
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
            'NombPant' => 'required|max:50|unique:pantallas,NombPant'
        ]);
        $pantallas = Pantalla::create($request->all());
        return redirect()->route('pantalla.index')->with('status_success', 'Pantalla creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pantalla  $pantalla
     * @return \Illuminate\Http\Response
     */
    public function show(pantalla $pantalla)
    {
        //
        Gate::authorize('haveaccess','pantalla.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Pantallas']);
        $rutavolver = route('pantalla.index');
        return view('pantalla.view', compact('pantalla','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pantalla  $pantalla
     * @return \Illuminate\Http\Response
     */
    public function edit(pantalla $pantalla)
    {
        //
        Gate::authorize('haveaccess','pantalla.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Pantallas']);
        $rutavolver = route('pantalla.index');
        return view('pantalla.edit', compact('pantalla','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pantalla  $pantalla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pantalla $pantalla)
    {
        //
        Gate::authorize('haveaccess','pantalla.edit');
        $request->validate([
            'NombPant'          => 'required|max:50|unique:pantallas,NombPant,'.$pantalla->id,
        ]);

        $pantalla->update($request->all());
        return redirect()->route('pantalla.index')->with('status_success', 'Pantalla modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pantalla  $pantalla
     * @return \Illuminate\Http\Response
     */
    public function destroy(pantalla $pantalla)
    {
        //
        Gate::authorize('haveaccess','pantalla.destroy');
        $pantalla->delete();
        return redirect()->route('pantalla.index')->with('status_success', 'Pantalla eliminada con exito');
    }
}