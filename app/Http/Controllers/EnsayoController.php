<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\interaccion;
use App\ensayo;
use App\organizacion;

class EnsayoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','ensayo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ensayos']);
        $rutavolver = route('home');
        $ensayos = Ensayo::orderBy('id','desc')->paginate(20);
        return view('ensayo.index', compact('ensayos','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','ensayo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ensayos']);
        $rutavolver = route('ensayo.index');
        $organizaciones = Organizacion::all();
        return view('ensayo.create',compact('rutavolver','organizaciones'));
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
         // carga del archivo
         if($request->hasFile("archivo")){
            $pdf = $request->file('archivo');
            $nombre = time().'2'.rand().'.'.$pdf->getClientOriginalExtension();
            $destino = public_path('pdf/ensayos/');
            $request->archivo->move($destino, $nombre);
        }
        $request->request->add(['ruta' => $nombre]);
        $ensayos = Ensayo::create($request->all());
        return redirect()->route('ensayo.index')->with('status_success', 'Ensayo creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ensayo  $ensayo
     * @return \Illuminate\Http\Response
     */
    public function show(ensayo $ensayo)
    {
        //
        Gate::authorize('haveaccess','ensayo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ensayos']);
        $rutavolver = route('ensayo.index');
        return view('ensayo.view', compact('ensayo','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ensayo  $ensayo
     * @return \Illuminate\Http\Response
     */
    public function edit(ensayo $ensayo)
    {
        //
        Gate::authorize('haveaccess','ensayo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ensayos']);
        $rutavolver = route('ensayo.index');
        $organizaciones = Organizacion::all();
        return view('ensayo.edit', compact('ensayo','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ensayo  $ensayo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ensayo $ensayo)
    {
        //
        Gate::authorize('haveaccess','ensayo.edit');
        $ensayo->update($request->all());
        return redirect()->route('ensayo.index')->with('status_success', 'Ensayo modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ensayo  $ensayo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ensayo $ensayo)
    {
        //
        Gate::authorize('haveaccess','ensayo.destroy');
        $ensayo->delete();
        return redirect()->route('ensayo.index')->with('status_success', 'Ensayo eliminada con exito');
    }
}