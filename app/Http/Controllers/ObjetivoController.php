<?php

namespace App\Http\Controllers;

use App\objetivo;
use App\tipoobjetivo;
use App\organizacion;
use App\interaccion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule; 

class ObjetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','objetivo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Objetivos']);
        $nomborg = User::select('organizacions.CodiOrga','organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
        $rutavolver = route('jdlink.menu');
        $filtro="";
        $busqueda="";
        if ($nomborg->NombOrga == 'Sala Hnos'){
            if($request->buscarpor AND $request->tipo){
                $tipo = $request->get('tipo');
                $busqueda = $request->get('buscarpor');
                $variablesurl=$request->all();
                $objetivos = Objetivo::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
                $filtro = "SI";
            } else{
            $objetivos = Objetivo::select('organizacions.NombOrga','tipoobjetivos.nombre','maquinas.NumSMaq',
                                        'objetivos.objetivo','objetivos.id','objetivos.cultivo','objetivos.ano',
                                        'objetivos.establecido','maquinas.ModeMaq','maquinas.nombre as nomb_maq')
                                ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->orderBy('id','desc')->paginate(20);
            }
        } else {
                $objetivos = Objetivo::select('organizacions.NombOrga','tipoobjetivos.nombre','maquinas.NumSMaq',
                                            'objetivos.objetivo','objetivos.id','objetivos.cultivo','objetivos.ano',
                                            'objetivos.establecido','maquinas.ModeMaq','maquinas.nombre as nomb_maq')
                                    ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                                    ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                    ->where('organizacions.CodiOrga', $nomborg->CodiOrga)
                                    ->orderBy('id','desc')->paginate(20);
        }
        return view('objetivo.index', compact('objetivos','filtro','busqueda','nomborg','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','objetivo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Objetivos']);
        $nomborg = User::select('organizacions.CodiOrga','organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
        if ($nomborg->NombOrga == 'Sala Hnos'){
            $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        } else {
            $organizaciones = Organizacion::where('organizacions.CodiOrga', $nomborg->CodiOrga)
                                        ->orderBy('NombOrga','asc')->get();
        }
        $tipoobjetivos = Tipoobjetivo::orderBy('nombre','asc')->get();
        $rutavolver = route('objetivo.index');
        return view('objetivo.create', compact('organizaciones','tipoobjetivos','rutavolver'));
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
        Gate::authorize('haveaccess','objetivo.create');
        $maquina = $request->get('id_maquina');
        $tipoobjetivo = $request->get('id_tipoobjetivo');
        $cultivo = $request->get('cultivo');
        $ano = $request->get('ano');
        request()->validate([
            'objetivo' => 'required:objetivos,objetivo',
            'cultivo' => ['required',Rule::unique('objetivos')->where(function ($query) use($maquina, $tipoobjetivo, $cultivo, $ano) {
                return $query->where([['id_maquina', $maquina], ['id_tipoobjetivo',$tipoobjetivo], ['cultivo', $cultivo], 
                                    ['ano', $ano], ['establecido','Cliente']]);
                })
            ],
            'id_tipoobjetivo' => 'required',
            'id_maquina' => 'required',
            'ano' => 'required',
        ]);

        $objetivos = Objetivo::create($request->all());
        return redirect()->route('objetivo.index')->with('status_success', 'Objetivo creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\objetivo  $objetivo
     * @return \Illuminate\Http\Response
     */
    public function show(objetivo $objetivo)
    {
        //
        Gate::authorize('haveaccess','objetivo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Objetivos']);
        $data = Objetivo::select('organizacions.id as organi','organizacions.NombOrga','maquinas.id','maquinas.NumSMaq',
                            'tipoobjetivos.id as tipoobj','tipoobjetivos.nombre','objetivos.cultivo','objetivos.ano',
                            'objetivos.establecido')
                            ->join('tipoobjetivos','objetivos.id_tipoobjetivo','=','tipoobjetivos.id')
                            ->join('maquinas','objetivos.id_maquina','=','maquinas.id')
                            ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                            ->where('objetivos.id',$objetivo->id)->first();
                            
        $rutavolver = route('objetivo.index');
        return view('objetivo.view', compact('objetivo','data','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\objetivo  $objetivo
     * @return \Illuminate\Http\Response
     */
    public function edit(objetivo $objetivo)
    {
        //
        Gate::authorize('haveaccess','objetivo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Objetivos']);
        $rutavolver = route('objetivo.index');
        return view('objetivo.edit', compact('objetivo','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\objetivo  $objetivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, objetivo $objetivo)
    {
        //
        Gate::authorize('haveaccess','objetivo.edit');
        $request->validate([
            'objetivo' => 'required:objetivos,objetivo',
            'cultivo' => 'required',
        ]);

        $objetivo->update($request->all());
        return redirect()->route('objetivo.index')->with('status_success', 'Objetivo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\objetivo  $objetivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(objetivo $objetivo)
    {
        //
        Gate::authorize('haveaccess','objetivo.destroy');
        $objetivo->delete();
        return redirect()->route('objetivo.index')->with('status_success', 'Objetivo eliminado con exito');
    }
}
