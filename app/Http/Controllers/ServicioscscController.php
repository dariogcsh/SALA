<?php

namespace App\Http\Controllers;

use App\servicioscsc;
use App\interaccion;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ServicioscscController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','servicioscsc.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('internosoluciones');
        $servicioscscs = Servicioscsc::orderBy('nombre','asc')->paginate(20);
        return view('servicioscsc.index', compact('servicioscscs','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','servicioscsc.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('servicioscsc.index');
        return view('servicioscsc.create',compact('rutavolver'));
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
            'nombre' => 'required|max:50|unique:servicioscscs,nombre'
        ]);
        $servicioscscs = Servicioscsc::create($request->all());
        return redirect()->route('servicioscsc.index')->with('status_success', 'Servicio creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\servicioscsc  $servicioscsc
     * @return \Illuminate\Http\Response
     */
    public function show(servicioscsc $servicioscsc)
    {
        //
        Gate::authorize('haveaccess','servicioscsc.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('servicioscsc.index');
        return view('servicioscsc.view', compact('servicioscsc','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\servicioscsc  $servicioscsc
     * @return \Illuminate\Http\Response
     */
    public function edit(servicioscsc $servicioscsc)
    {
        //
        Gate::authorize('haveaccess','servicioscsc.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('servicioscsc.index');
        return view('servicioscsc.edit', compact('servicioscsc','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\servicioscsc  $servicioscsc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, servicioscsc $servicioscsc)
    {
        //
        Gate::authorize('haveaccess','servicioscsc.edit');
        $request->validate([
            'nombre'          => 'required|max:50|unique:servicioscscs,nombre,'.$servicioscsc->id,
        ]);

        $servicioscsc->update($request->all());
        return redirect()->route('servicioscsc.index')->with('status_success', 'Servicio modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\servicioscsc  $servicioscsc
     * @return \Illuminate\Http\Response
     */
    public function destroy(servicioscsc $servicioscsc)
    {
        //
        Gate::authorize('haveaccess','servicioscsc.destroy');
        $servicioscsc->delete();
        return redirect()->route('servicioscsc.index')->with('status_success', 'Servicio eliminada con exito');
    }
}