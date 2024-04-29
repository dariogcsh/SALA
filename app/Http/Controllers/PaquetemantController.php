<?php

namespace App\Http\Controllers;

use App\paquetemant;
use App\tipo_paquete_mant;
use App\interaccion;
use App\repuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaquetemantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','paquetemant.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('internoconfiguracion');
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $paquetemants = Paquetemant::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
        $paquetemants = Paquetemant::select('paquetemants.id','paquetemants.horas','tipo_paquete_mants.modelo',
                                            'tipo_paquete_mants.horas as horasmant','repuestos.codigo','repuestos.nombre',
                                            'cantidad','paquetemants.descripcion')
                                    ->join('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                                    ->join('repuestos','paquetemants.id_repuesto','=','repuestos.id')
                                    ->orderBy('tipo_paquete_mants.modelo','asc')
                                    ->orderBy('paquetemants.horas','asc')
                                    ->orderBy('paquetemants.descripcion','asc')->paginate(20);
        }
        return view('paquetemant.index', compact('paquetemants','rutavolver','filtro','busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','paquetemant.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $tipopaquetes = Tipo_paquete_mant::orderBy('modelo','asc')->get();
        $repuestos = Repuesto::orderBy('nombre','asc')->get();
        $rutavolver = route('paquetemant.index');
        return view('paquetemant.create',compact('rutavolver','tipopaquetes','repuestos'));
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
        $request->validate([
            'id_tipo_paquete_mant'   => 'required',
            'descripcion'   => 'required',
            'horas'   => 'required',
            'cantidad'   => 'required',
        ]);
        $paquetemants = Paquetemant::create($request->all());
        return redirect()->route('paquetemant.index')->with('status_success', 'Paquete de mantenimiento creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\paquetemant  $paquetemant
     * @return \Illuminate\Http\Response
     */
    public function show(paquetemant $paquetemant)
    {
        //
        Gate::authorize('haveaccess','paquetemant.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $rutavolver = route('paquetemant.index');
        return view('paquetemant.view', compact('paquetemant','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\paquetemant  $paquetemant
     * @return \Illuminate\Http\Response
     */
    public function edit(paquetemant $paquetemant)
    {
        //
        Gate::authorize('haveaccess','paquetemant.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Paquetes de mantenimiento']);
        $tipopaquetes = Tipo_paquete_mant::orderBy('modelo','asc')->get();
        $repuestos = Repuesto::orderBy('nombre','asc')->get();
        $rutavolver = route('paquetemant.index');
        return view('paquetemant.edit', compact('paquetemant','rutavolver','tipopaquetes','repuestos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\paquetemant  $paquetemant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, paquetemant $paquetemant)
    {
        //
        Gate::authorize('haveaccess','paquetemant.edit');
        $request->validate([
            'id_tipo_paquete_mant'   => 'required',
            'descripcion'   => 'required',
            'horas'   => 'required',
            'cantidad'   => 'required',
        ]);
        $paquetemant->update($request->all());
        return redirect()->route('paquetemant.index')->with('status_success', 'Paquete de mantenimiento modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\paquetemant  $paquetemant
     * @return \Illuminate\Http\Response
     */
    public function destroy(paquetemant $paquetemant)
    {
        //
        Gate::authorize('haveaccess','paquetemant.destroy');
        $paquetemant->delete();
        return redirect()->route('paquetemant.index')->with('status_success', 'Paquete de mantenimiento eliminado con exito');
    }
}
