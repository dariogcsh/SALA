<?php

namespace App\Http\Controllers;

use App\organizacion;
use App\interaccion;
use App\sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrganizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        Gate::authorize('haveaccess','organizacion.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Organizaciones']);
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $organizacions = Organizacion::Buscar($tipo, $busqueda)->orderBy('NombOrga','asc')->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
            $organizacions = Organizacion::with('sucursals','users')->orderBy('NombOrga','asc')->paginate(20);
        }
        
        return view('organizacion.index', compact('organizacions','filtro','busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','organizacion.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Organizaciones']);
        $sucursals = Sucursal::orderBy('id','asc')->get();
        $rutavolver = route('organizacion.index');
        return view('organizacion.create',compact('sucursals','rutavolver'));
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
            'NombOrga' => 'required|max:50|unique:organizacions,NombOrga',
            'CodiSucu' => 'required',
            'InscOrga' => 'required'
        ]);
        $organizacion = Organizacion::create($request->all());
        return redirect()->route('organizacion.index')->with('status_success', 'Organización creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\organizacion  $organizacion
     * @return \Illuminate\Http\Response
     */
    public function show(Organizacion $organizacion)
    {
        Gate::authorize('haveaccess','organizacion.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Organizaciones']);
        $sucursals = Sucursal::orderBy('id')->get();
        $rutavolver = route('organizacion.index');
        return view('organizacion.view', compact('organizacion','sucursals','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\organizacion  $organizacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizacion $organizacion)
    {
        Gate::authorize('haveaccess','organizacion.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Organizaciones']);
        $sucursals = Sucursal::orderBy('id')->get();
        $rutavolver = route('organizacion.index');
        return view('organizacion.edit', compact('organizacion','sucursals','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\organizacion  $organizacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizacion $organizacion)
    {
        Gate::authorize('haveaccess','organizacion.edit');
        $request->validate([
            'NombOrga'          => 'required|max:50|unique:organizacions,NombOrga,'.$organizacion->id,
        ]);

        $organizacion->update($request->all());
        return redirect()->route('organizacion.index')->with('status_success', 'Organizacion modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\organizacion  $organizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizacion $organizacion)
    {
        Gate::authorize('haveaccess','organizacion.destroy');
        $organizacion->delete();
        return redirect()->route('organizacion.index')->with('status_success', 'Organizacion eliminada con exito');
    }
}
