<?php

namespace App\Http\Controllers;

use App\guardiasadmin;
use App\sucursal;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GuardiasadminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','guardiasadmin.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Guardias de servicio']);
        $rutavolver = route('internoservicios');
        $guardiasadmins = Guardiasadmin::orderBy('id','desc')->paginate(10);
        return view('guardiasadmin.index', compact('guardiasadmins','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','guardiasadmin.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Guardias de servicio']);
        $sucursals = Sucursal::orderBy('id')->get();
        $rutavolver = route('guardiasadmin.index');
        return view('guardiasadmin.create',compact('rutavolver','sucursals'));
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
            'fecha' => 'required|unique:guardiasadmins,fecha',
            'id_sucursal' => 'required'
        ]);
        $guardiasadmins = guardiasadmin::create($request->all());
        return redirect()->route('guardiasadmin.index')->with('status_success', 'Guardia registrada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\guardiasadmin  $guardiasadmin
     * @return \Illuminate\Http\Response
     */
    public function show(guardiasadmin $guardiasadmin)
    {
        Gate::authorize('haveaccess','guardiasadmin.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Guardias de servicio']);
        $sucursals = Sucursal::orderBy('id')->get();
        $rutavolver = route('guardiasadmin.index');
        return view('guardiasadmin.view', compact('guardiasadmin','rutavolver','sucursals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\guardiasadmin  $guardiasadmin
     * @return \Illuminate\Http\Response
     */
    public function edit(guardiasadmin $guardiasadmin)
    {
        Gate::authorize('haveaccess','guardiasadmin.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Guardias de servicio']);
        $sucursals = Sucursal::orderBy('id')->get();
        $rutavolver = route('guardiasadmin.index');
        return view('guardiasadmin.edit', compact('guardiasadmin','rutavolver','sucursals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\guardiasadmin  $guardiasadmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, guardiasadmin $guardiasadmin)
    {
        request()->validate([
            'fecha' => 'required',
            'id_sucursal' => 'required'
        ]);

        $guardiasadmin->update($request->all());
        return redirect()->route('guardiasadmin.index')->with('status_success', 'Guardia modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\guardiasadmin  $guardiasadmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(guardiasadmin $guardiasadmin)
    {
        Gate::authorize('haveaccess','guardiasadmin.destroy');
        $guardiasadmin->delete();
        return redirect()->route('guardiasadmin.index')->with('status_success', 'Registro eliminado con exito');
    }
}
