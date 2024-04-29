<?php

namespace App\Http\Controllers;

use App\velocidad_limite;
use App\User;
use App\organizacion;
use App\maquina;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VelocidadLimiteController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            //
            Gate::authorize('haveaccess','velocidad_limite.index');
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Limites de velocidad']);
            $rutavolver = route('home');
            $filtro="";
            $busqueda="";
        
            $nomborg = User::select('organizacions.id','organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();

            if ($nomborg->NombOrga == 'Sala Hnos'){
                if($request->buscarpor){
                    $tipo = $request->get('tipo');
                    $busqueda = $request->get('buscarpor');
                    $variablesurl=$request->all();
                    $velocidad_limites = Velocidad_limite::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
                    $filtro = "SI";
                } else{
                    $velocidad_limites = Velocidad_limite::select('velocidad_limites.id', 'velocidad_limites.pin',
                                                        'velocidad_limites.limite','organizacions.NombOrga')
                                                ->join('maquinas','velocidad_limites.pin','=','maquinas.NumSMaq')
                                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                ->orderBy('organizacions.NombOrga','asc')->paginate(20);
                }
            } else {
          
                    $velocidad_limites = Velocidad_limite::select('velocidad_limites.id', 'velocidad_limites.pin',
                                                        'velocidad_limites.limite','organizacions.NombOrga')
                                                ->join('maquinas','velocidad_limites.pin','=','maquinas.NumSMaq')
                                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                ->where('organizacions.id', $nomborg->id)
                                                ->orderBy('organizacions.NombOrga','asc')->paginate(20);
                
            }
            
         
            return view('velocidad_limite.index', compact('velocidad_limites','rutavolver','filtro','busqueda','nomborg'));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            Gate::authorize('haveaccess','velocidad_limite.create');
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Limites de velocidad']);
            $rutavolver = route('velocidad_limite.index');
            $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
            $maquinas = '';
            if ($organizacion->NombOrga == "Sala Hnos") {
                $organizaciones = Organizacion::orderBy('NombOrga', 'asc')->get();
            } else {
                $organizaciones = Organizacion::where('organizacions.id',auth()->user()->CodiOrga)
                                            ->orderBy('NombOrga', 'asc')->get();
                $maquinas = Maquina::where('maquinas.CodiOrga',auth()->user()->CodiOrga)->get();
            }
            return view('velocidad_limite.create',compact('rutavolver','organizacion','organizaciones','maquinas'));
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
                'pin' => 'required|max:50|unique:velocidad_limites,pin',
                'limite' => 'required'
            ]);
            $velocidad_limites = Velocidad_limite::create($request->all());
            return redirect()->route('velocidad_limite.index')->with('status_success', 'Limite de velocidad creado con exito');
        }
    
        /**
         * Display the specified resource.
         *
         * @param  \App\velocidad_limite  $velocidad_limite
         * @return \Illuminate\Http\Response
         */
        public function show(Velocidad_limite $velocidad_limite)
        {
            //
            Gate::authorize('haveaccess','velocidad_limite.show');
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Limites de velocidad']);
            $rutavolver = route('velocidad_limite.index');
            return view('velocidad_limite.view', compact('velocidad_limite','rutavolver'));
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  \App\velocidad_limite  $velocidad_limite
         * @return \Illuminate\Http\Response
         */
        public function edit(Velocidad_limite $velocidad_limite)
        {
            //
            Gate::authorize('haveaccess','velocidad_limite.edit');
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Limites de velocidad']);
            $rutavolver = route('velocidad_limite.index');
            $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
            if ($organizacion->NombOrga == "Sala Hnos") {
                $organizaciones = Organizacion::orderBy('NombOrga', 'asc')->get();
            } else {
                $organizaciones = Organizacion::where('organizacions.id',auth()->user()->CodiOrga)
                                            ->orderBy('NombOrga', 'asc')->get();
            }
            $organ = Velocidad_limite::select('organizacions.id', 'organizacions.NombOrga')
                                    ->join('maquinas','velocidad_limites.pin','=','maquinas.NumSMaq')
                                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                    ->where('velocidad_limites.id',$velocidad_limite->id)->first();
            return view('velocidad_limite.edit', compact('velocidad_limite','rutavolver','organizacion','organizaciones','organ'));
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\velocidad_limite  $velocidad_limite
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Velocidad_limite $velocidad_limite)
        {
            //
            Gate::authorize('haveaccess','velocidad_limite.edit');
            request()->validate([
                'limite' => 'required'
            ]);
    
            $velocidad_limite->update($request->all());
            return redirect()->route('velocidad_limite.index')->with('status_success', 'Limite de velocidad modificado con exito');
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\velocidad_limite  $velocidad_limite
         * @return \Illuminate\Http\Response
         */
        public function destroy(Velocidad_limite $velocidad_limite)
        {
            //
            Gate::authorize('haveaccess','velocidad_limite.destroy');
            $velocidad_limite->delete();
            return redirect()->route('velocidad_limite.index')->with('status_success', 'Limite de velocidad eliminado con exito');
        }
    }