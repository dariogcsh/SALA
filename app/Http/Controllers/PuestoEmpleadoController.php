<?php

namespace App\Http\Controllers;

use App\puesto_empleado;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PuestoEmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','puesto_empleado.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usuarios']);
        $rutavolver = route('internoconfiguracion');
        $puestoemps = Puesto_empleado::orderBy('id','desc')->paginate(10);
        return view('puesto_empleado.index', compact('puestoemps','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','puesto_empleado.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usuarios']);
        $rutavolver = route('puesto_empleado.index');
        return view('puesto_empleado.create',compact('rutavolver'));
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
            'NombPuEm' => 'required|max:50|unique:puesto_empleados,NombPuEm'
        ]);
        $puestoemp = Puesto_empleado::create($request->all());
        return redirect()->route('puesto_empleado.index')->with('status_success', 'Puesto creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\puesto_empleado  $puesto_empleado
     * @return \Illuminate\Http\Response
     */
    public function show(puesto_empleado $puesto_empleado)
    {
        //
        Gate::authorize('haveaccess','puesto_empleado.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usuarios']);
        $rutavolver = route('puesto_empleado.index');
        return view('puesto_empleado.view', compact('puesto_empleado','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\puesto_empleado  $puesto_empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(puesto_empleado $puesto_empleado)
    {
        //
        Gate::authorize('haveaccess','puesto_empleado.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usuarios']);
        $rutavolver = route('puesto_empleado.index');
        return view('puesto_empleado.edit', compact('puesto_empleado','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\puesto_empleado  $puesto_empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, puesto_empleado $puesto_empleado)
    {
        //
        Gate::authorize('haveaccess','puesto_empleado.edit');
        $request->validate([
            'NombPuEm'          => 'required|max:50|unique:puesto_empleados,NombPuEm,'.$puesto_empleado->id,
        ]);

        $puesto_empleado->update($request->all());
        return redirect()->route('puesto_empleado.index')->with('status_success', 'Puesto modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\puesto_empleado  $puesto_empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(puesto_empleado $puesto_empleado)
    {
        //
        Gate::authorize('haveaccess','puesto_empleado.destroy');
        $puesto_empleado->delete();
        return redirect()->route('puesto_empleado.index')->with('status_success', 'Puesto eliminado con exito');
    }
}
