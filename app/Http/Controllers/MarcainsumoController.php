<?php

namespace App\Http\Controllers;

use App\marcainsumo;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MarcainsumoController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','marcainsumo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('internoconfiguracion');
        $marcainsumos = Marcainsumo::orderBy('id','desc')->paginate(20);
        return view('marcainsumo.index', compact('marcainsumos','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','marcainsumo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('marcainsumo.index');
        return view('marcainsumo.create',compact('rutavolver'));
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
            'nombre' => 'required|max:50|unique:marcainsumos,nombre'
        ]);
        $marcainsumos = Marcainsumo::create($request->all());
        return redirect()->route('marcainsumo.index')->with('status_success', 'Marca creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\marcainsumo  $marcainsumo
     * @return \Illuminate\Http\Response
     */
    public function show(Marcainsumo $marcainsumo)
    {
        //
        Gate::authorize('haveaccess','marcainsumo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('marcainsumo.index');
        return view('marcainsumo.view', compact('marcainsumo','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\marcainsumo  $marcainsumo
     * @return \Illuminate\Http\Response
     */
    public function edit(Marcainsumo $marcainsumo)
    {
        //
        Gate::authorize('haveaccess','marcainsumo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('marcainsumo.index');
        return view('marcainsumo.edit', compact('marcainsumo','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\marcainsumo  $marcainsumo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marcainsumo $marcainsumo)
    {
        //
        Gate::authorize('haveaccess','marcainsumo.edit');
        $request->validate([
            'nombre'          => 'required|max:50|unique:marcainsumos,nombre,'.$marcainsumo->id,
        ]);

        $marcainsumo->update($request->all());
        return redirect()->route('marcainsumo.index')->with('status_success', 'Marca modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\marcainsumo  $marcainsumo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marcainsumo $marcainsumo)
    {
        //
        Gate::authorize('haveaccess','marcainsumo.destroy');
        $marcainsumo->delete();
        return redirect()->route('marcainsumo.index')->with('status_success', 'Marca eliminada con exito');
    }
}
