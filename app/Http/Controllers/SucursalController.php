<?php

namespace App\Http\Controllers;

use App\sucursal;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ///
        Gate::authorize('haveaccess','sucursal.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Sucursales']);
        $rutavolver = route('internoconfiguracion');
        $sucursals = Sucursal::orderBy('id','desc')->paginate(10);
        return view('sucursal.index', compact('sucursals','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        Gate::authorize('haveaccess','sucursal.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Sucursales']);
        $rutavolver = route('sucursal.index');
        return view('sucursal.create', compact('rutavolver'));
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
            'NombSucu' => 'required|max:50|unique:sucursals,NombSucu'
        ]);
        $sucursal = Sucursal::create($request->all());
        //$datosSucursal = request()->except('_token');
        //Sucursal::insert($datosSucursal);
        //return redirect('sucursal');
        return redirect()->route('sucursal.index')->with('status_success', 'Sucursal creada con exito');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(Sucursal $sucursal)
    {
        //
        Gate::authorize('haveaccess','sucursal.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Sucursales']);
        $rutavolver = route('sucursal.index');
        return view('sucursal.view', compact('sucursal','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function edit(Sucursal $sucursal)
    {
        //
        //$sucursal = Sucursal::findOrFail($CodiSucu);
        //return view('sucursal.edit', compact('sucursal'));
        Gate::authorize('haveaccess','sucursal.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Sucursales']);
        $rutavolver = route('sucursal.index');
        return view('sucursal.edit', compact('sucursal','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sucursal $sucursal)
    {
        //
        //$datosSucursal = request()->except(['_token', '_method']);
        //Sucursal::where('CodiSucu','=',$CodiSucu)->update($datosSucursal);
        //return redirect('sucursal');

        Gate::authorize('haveaccess','sucursal.edit');
        $request->validate([
            'NombSucu'          => 'required|max:50|unique:sucursals,NombSucu,'.$sucursal->id,
        ]);

        $sucursal->update($request->all());
        return redirect()->route('sucursal.index')->with('status_success', 'Sucursal modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sucursal $sucursal)
    {
        //
        //Sucursal::destroy($CodiSucu);
        //return redirect('sucursal');

        Gate::authorize('haveaccess','sucursal.destroy');
        $sucursal->delete();
        return redirect()->route('sucursal.index')->with('status_success', 'Sucursal eliminada con exito');
    }
}
