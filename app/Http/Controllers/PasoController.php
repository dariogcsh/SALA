<?php

namespace App\Http\Controllers;

use App\paso;
use App\etapa;
use App\interaccion;
use App\puesto_empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PasoController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            //
            Gate::authorize('haveaccess','paso.index');
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
            $rutavolver = route('internoconfiguracion');
            $pasos = Paso::select('pasos.nombre','pasos.orden','pasos.id','puesto_empleados.NombPuEm',
                                'etapas.nombre as nombreetapa','etapas.tipo_unidad')
                        ->join('etapas','pasos.id_etapa','=','etapas.id')
                        ->join('puesto_empleados','pasos.id_puesto','=','puesto_empleados.id')
                        ->orderBy('etapas.tipo_unidad','asc')
                        ->orderBy('pasos.orden','asc')->paginate(20);
            return view('paso.index', compact('pasos','rutavolver'));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            Gate::authorize('haveaccess','paso.create');
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
            $rutavolver = route('paso.index');
            $etapas = Etapa::orderBy('etapas.tipo_unidad','asc')->orderBy('orden','asc')->get();
            $puestos = Puesto_empleado::orderBy('NombPuEm','asc')->get();
            return view('paso.create',compact('rutavolver','etapas','puestos'));
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
                'nombre' => 'required|max:150',
                'orden' => 'required|max:50'
            ]);
            $pasos = Paso::create($request->all());
            return redirect()->route('paso.index')->with('status_success', 'Paso creado con exito');
        }
    
        /**
         * Display the specified resource.
         *
         * @param  \App\paso  $paso
         * @return \Illuminate\Http\Response
         */
        public function show(paso $paso)
        {
            //
            Gate::authorize('haveaccess','paso.show');
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
            $rutavolver = route('paso.index');
            $etapas = Etapa::orderBy('orden','asc')->get();
            $puestos = Puesto_empleado::orderBy('NombPuEm','asc')->get();
            return view('paso.view',compact('rutavolver','etapas','puestos','paso'));
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  \App\paso  $paso
         * @return \Illuminate\Http\Response
         */
        public function edit(paso $paso)
        {
            //
            Gate::authorize('haveaccess','paso.edit');
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Entrega ideal']);
            $rutavolver = route('paso.index');
            $etapas = Etapa::orderBy('etapas.tipo_unidad','asc')->orderBy('orden','asc')->get();
            $puestos = Puesto_empleado::orderBy('NombPuEm','asc')->get();
            return view('paso.edit',compact('rutavolver','etapas','puestos','paso'));
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\paso  $paso
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, paso $paso)
        {
            //
            Gate::authorize('haveaccess','paso.edit');
            $request->validate([
                'nombre'          => 'required|max:150',
                'orden'          => 'required|max:50',
            ]);
    
            $paso->update($request->all());
            return redirect()->route('paso.index')->with('status_success', 'Paso modificado con exito');
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\paso  $paso
         * @return \Illuminate\Http\Response
         */
        public function destroy(paso $paso)
        {
            //
            Gate::authorize('haveaccess','paso.destroy');
            $paso->delete();
            return redirect()->route('paso.index')->with('status_success', 'Paso eliminado con exito');
        }
}
