<?php

namespace App\Http\Controllers;

use App\tipo_paquete_mant;
use Illuminate\Http\Request;
use App\interaccion;
use Illuminate\Support\Facades\Gate;

class TipoPaqueteMantController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','tipo_paquete_mant.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('internoconfiguracion');
        $tipo_paquete_mants = Tipo_paquete_mant::orderBy('modelo','asc')
                                                ->orderBy('horas','asc')->paginate(20);
        return view('tipo_paquete_mant.index', compact('tipo_paquete_mants','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','tipo_paquete_mant.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('tipo_paquete_mant.index');
        return view('tipo_paquete_mant.create',compact('rutavolver'));
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
            'modelo' => 'required',
            'horas' => 'required',
            'costo' => 'required',
        ]);

        $tipo_paquete_mants = Tipo_paquete_mant::create($request->all());
        return redirect()->route('tipo_paquete_mant.index')->with('status_success', 'Tipo de paquete de mantenimiento creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipo_paquete_mant  $tipo_paquete_mant
     * @return \Illuminate\Http\Response
     */
    public function show(tipo_paquete_mant $tipo_paquete_mant)
    {
        //
        Gate::authorize('haveaccess','tipo_paquete_mant.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('tipo_paquete_mant.index');
        return view('tipo_paquete_mant.view', compact('tipo_paquete_mant','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipo_paquete_mant  $tipo_paquete_mant
     * @return \Illuminate\Http\Response
     */
    public function edit(tipo_paquete_mant $tipo_paquete_mant)
    {
        //
        Gate::authorize('haveaccess','tipo_paquete_mant.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('tipo_paquete_mant.index');
        return view('tipo_paquete_mant.edit', compact('tipo_paquete_mant','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipo_paquete_mant  $tipo_paquete_mant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipo_paquete_mant $tipo_paquete_mant)
    {
        //
        Gate::authorize('haveaccess','tipo_paquete_mant.edit');
        request()->validate([
            'modelo' => 'required|max:50',
            'horas' => 'required',
            'costo' => 'required',
        ]);

        $tipo_paquete_mant->update($request->all());
        return redirect()->route('tipo_paquete_mant.index')->with('status_success', 'Tipo de paquete de mantenimiento modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipo_paquete_mant  $tipo_paquete_mant
     * @return \Illuminate\Http\Response
     */
    public function destroy(tipo_paquete_mant $tipo_paquete_mant)
    {
        //
        Gate::authorize('haveaccess','tipo_paquete_mant.destroy');
        $tipo_paquete_mant->delete();
        return redirect()->route('tipo_paquete_mant.index')->with('status_success', 'Tipo de paquete de mantenimiento eliminado con exito');
    }
}
