<?php

namespace App\Http\Controllers;

use App\granja;
use App\organizacion;
use App\cliente;
use App\interaccion;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class GranjaController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','granja.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Granjas']);
        $rutavolver = route('lote.menu');
        $granjas = Granja::select('organizacions.NombOrga','granjas.id','granjas.nombre','clientes.nombre as nombrecliente')
                        ->join('clientes','granjas.id_cliente','=','clientes.id')
                        ->join('organizacions','clientes.id_organizacion','=','organizacions.id')
                        ->orderBy('nombre','asc')->paginate(20);
        return view('granja.index', compact('granjas','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','granja.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Granjas']);
        $rutavolver = route('granja.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        return view('granja.create',compact('rutavolver','organizacion','organizaciones'));
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
        $cliente = $request->get('id_cliente');
        request()->validate([
            'nombre' => ['required',Rule::unique('granjas')->where(function ($query) use($cliente) {
                return $query->where('id_cliente', $cliente);
                })
            ],
        ]);
        $granjas = Granja::create($request->all());
        return redirect()->route('granja.index')->with('status_success', 'Granja creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\granja  $granja
     * @return \Illuminate\Http\Response
     */
    public function show(granja $granja)
    {
        //
        Gate::authorize('haveaccess','granja.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Granjas']);
        $rutavolver = route('granja.index');
        $cliente = Cliente::where('id',$granja->id_cliente)->first();
        $organizacionshow = Organizacion::where('id',$cliente->id_organizacion)->first();
        return view('granja.view', compact('granja','rutavolver','organizacionshow','cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\granja  $granja
     * @return \Illuminate\Http\Response
     */
    public function edit(granja $granja)
    {
        //
        Gate::authorize('haveaccess','granja.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Granjas']);
        $rutavolver = route('granja.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $cliente = Cliente::where('id',$granja->id_cliente)->first();
        $clientes = Cliente::where('id_organizacion',$cliente->id_organizacion)->get();
        $organizacionshow = Organizacion::where('id',$cliente->id_organizacion)->first();
        return view('granja.edit', compact('granja','rutavolver','organizacion','organizaciones','organizacionshow','clientes','cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\granja  $granja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, granja $granja)
    {
        //
        Gate::authorize('haveaccess','granja.edit');
        $cliente = $request->get('id_cliente');
        request()->validate([
            'nombre' => ['required',Rule::unique('granjas')->where(function ($query) use($cliente) {
                return $query->where('id_cliente', $cliente);
                })
            ],
        ]);

        $granja->update($request->all());
        return redirect()->route('granja.index')->with('status_success', 'Granja modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\granja  $granja
     * @return \Illuminate\Http\Response
     */
    public function destroy(granja $granja)
    {
        //
        Gate::authorize('haveaccess','granja.destroy');
        $granja->delete();
        return redirect()->route('granja.index')->with('status_success', 'Granja eliminada con exito');
    }
}
