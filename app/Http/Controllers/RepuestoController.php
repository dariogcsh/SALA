<?php

namespace App\Http\Controllers;

use App\repuesto;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RepuestoController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','repuesto.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('internoconfiguracion');
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $repuestos = Repuesto::Buscar($tipo, $busqueda)->orderBy('nombre','asc')->paginate(10)->appends($variablesurl);
            $filtro = "SI";
        } else{
            $repuestos = Repuesto::orderBy('nombre','asc')->paginate(20);
        }
        return view('repuesto.index', compact('repuestos','rutavolver','filtro','busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','repuesto.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('repuesto.index');
        return view('repuesto.create',compact('rutavolver'));
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
            'codigo' => 'required|max:50|unique:repuestos,codigo',
            'nombre' => 'required',
            'costo' => 'required',
            'venta' => 'required',
        ]);
        $repuestos = Repuesto::create($request->all());
        return redirect()->route('repuesto.index')->with('status_success', 'Repuesto creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function show(repuesto $repuesto)
    {
        //
        Gate::authorize('haveaccess','repuesto.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('repuesto.index');
        return view('repuesto.view', compact('repuesto','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(repuesto $repuesto)
    {
        //
        Gate::authorize('haveaccess','repuesto.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('repuesto.index');
        return view('repuesto.edit', compact('repuesto','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, repuesto $repuesto)
    {
        //
        Gate::authorize('haveaccess','repuesto.edit');
        request()->validate([
            'codigo' => 'required|max:50|unique:repuestos,codigo,'.$repuesto->id,
            'nombre' => 'required',
            'costo' => 'required',
            'venta' => 'required',
        ]);

        $repuesto->update($request->all());
        return redirect()->route('repuesto.index')->with('status_success', 'Repuesto modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(repuesto $repuesto)
    {
        //
        Gate::authorize('haveaccess','repuesto.destroy');
        $repuesto->delete();
        return redirect()->route('repuesto.index')->with('status_success', 'Repuesto eliminado con exito');
    }
}
