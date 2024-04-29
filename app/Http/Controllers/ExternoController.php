<?php

namespace App\Http\Controllers;

use App\externo;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExternoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','externo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Externo']);
        $rutavolver = route('internoconfiguracion');
        $externos = Externo::orderBy('id','desc')->paginate(20);
        return view('externo.index', compact('externos','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','externo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Externo']);
        $rutavolver = route('externo.index');
        return view('externo.create',compact('rutavolver'));
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
            'titulo' => 'required',
            'url' => 'required',
        ]);

        $externos = Externo::create($request->all());

        // carga de la imagen
        if($request->hasFile("imagen")){
            $imagen = $request->file('imagen');
            $nombre = time().'1'.rand().'.'.$imagen->getClientOriginalExtension();
            $externos->update(['imagen' => $nombre]);
            $destino = public_path('img/externo/');
            $request->imagen->move($destino, $nombre);
        }

        return redirect()->route('externo.index')->with('status_success', 'URL externo creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\externo  $externo
     * @return \Illuminate\Http\Response
     */
    public function show(externo $externo)
    {
        //
        Gate::authorize('haveaccess','externo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Externo']);
        $rutavolver = route('externo.index');
        return view('externo.view', compact('externo','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\externo  $externo
     * @return \Illuminate\Http\Response
     */
    public function edit(externo $externo)
    {
        //
        Gate::authorize('haveaccess','externo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Externo']);
        $rutavolver = route('externo.index');
        return view('externo.edit', compact('externo','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\externo  $externo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, externo $externo)
    {
        //
        Gate::authorize('haveaccess','externo.edit');
        request()->validate([
            'titulo' => 'required',
            'url' => 'required',
        ]);

        $externo->update($request->all());

        return redirect()->route('externo.index')->with('status_success', 'URL externo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\externo  $externo
     * @return \Illuminate\Http\Response
     */
    public function destroy(externo $externo)
    {
        //
        Gate::authorize('haveaccess','externo.destroy');
        $externo->delete();
        return redirect()->route('externo.index')->with('status_success', 'Externo eliminada con exito');
    }
}
