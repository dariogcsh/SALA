<?php

namespace App\Http\Controllers;

use App\cliente;
use App\organizacion;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule; 

class ClienteController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','cliente.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Cliente']);
        $rutavolver = route('lote.menu');
        $clientes = Cliente::select('clientes.id','clientes.nombre','organizacions.NombOrga')
                            ->join('organizacions','clientes.id_organizacion','=','organizacions.id')
                            ->orderBy('nombre','asc')->paginate(20);
        return view('cliente.index', compact('clientes','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','cliente.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Cliente']);
        $rutavolver = route('cliente.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        return view('cliente.create',compact('rutavolver','organizacion','organizaciones'));
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
        $organizacion = $request->get('id_organizacion');
        request()->validate([
            'nombre' => ['required',Rule::unique('clientes')->where(function ($query) use($organizacion) {
                return $query->where('id_organizacion', $organizacion);
                })
            ],
        ]);
        $clientes = Cliente::create($request->all());
        return redirect()->route('cliente.index')->with('status_success', 'Cliente creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(cliente $cliente)
    {
        //
        Gate::authorize('haveaccess','cliente.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Cliente']);
        $rutavolver = route('cliente.index');
        $organizacionshow = Organizacion::where('id',$cliente->id_organizacion)->first();
        return view('cliente.view', compact('cliente','rutavolver','organizacionshow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(cliente $cliente)
    {
        //
        Gate::authorize('haveaccess','cliente.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Cliente']);
        $rutavolver = route('cliente.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $organizacionshow = Organizacion::where('id',$cliente->id_organizacion)->first();
        return view('cliente.edit', compact('cliente','rutavolver','organizacion','organizaciones','organizacionshow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cliente $cliente)
    {
        //
        Gate::authorize('haveaccess','cliente.edit');
        $organizacion = $request->get('id_organizacion');
        request()->validate([
            'nombre' => ['required',Rule::unique('clientes')->where(function ($query) use($organizacion) {
                return $query->where('id_organizacion', $organizacion);
                })
            ],
        ]);

        $cliente->update($request->all());
        return redirect()->route('cliente.index')->with('status_success', 'Cliente modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(cliente $cliente)
    {
        //
        Gate::authorize('haveaccess','cliente.destroy');
        $cliente->delete();
        return redirect()->route('cliente.index')->with('status_success', 'Cliente eliminado con exito');
    }
}
