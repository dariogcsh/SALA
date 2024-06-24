<?php

namespace App\Http\Controllers;

use App\insumo;
use App\mezcla_insu;
use App\marcainsumo;
use App\organizacion;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule; 

class InsumoController extends Controller
{
    /**menu
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function menu()
    {
        return view('insumo.menu');
    }

    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','insumo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $filtro="";
        $busqueda="";
        if($request->buscarpor AND $request->tipo){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $insumos = Insumo::Buscar($tipo, $busqueda, $organizacion->id)->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
            if ($organizacion->NombOrga == "Sala Hnos"){
                
                $insumos = Insumo::select('marcainsumos.nombre as nombremarca','insumos.nombre','insumos.categoria',
                                        'insumos.litros','insumos.peso','insumos.id','organizacions.NombOrga','insumos.bultos',
                                        'insumos.tipo', 'insumos.tipo_grano','insumos.precio','insumos.semillas','insumos.stock_minimo',
                                        'insumos.unidades_medidas')
                                ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                                ->join('organizacions','insumos.id_organizacion','=','organizacions.id')
                                ->orderBy('nombre','asc')
                                ->orderBy('organizacions.NombOrga','asc')->paginate(20);
            } else {
                $insumos = Insumo::select('marcainsumos.nombre as nombremarca','insumos.nombre','insumos.categoria',
                                        'insumos.litros','insumos.peso','insumos.id','insumos.bultos', 'insumos.tipo',
                                        'insumos.tipo_grano','insumos.precio','insumos.semillas','insumos.stock_minimo',
                                        'insumos.unidades_medidas')
                                ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                                ->join('organizacions','insumos.id_organizacion','=','organizacions.id')
                                ->where('insumos.id_organizacion',$organizacion->id)
                                ->orderBy('nombre','asc')->paginate(20);
            }
        }
        $rutavolver = route('insumo.menu');
        return view('insumo.index', compact('insumos','rutavolver','busqueda','filtro'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','insumo.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $marcas = Marcainsumo::orderBy('nombre','desc')->get();
        $organizacion = auth()->user()->CodiOrga;
        $rutavolver = route('insumo.index');
        return view('insumo.create',compact('rutavolver','marcas','organizacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = $request->get('categoria');
        $organizacion = $request->get('id_organizacion');
        if ($request->marcainsumo) {
            $marca = Marcainsumo::create(['nombre' => $request->marcainsumo]);
            $request->request->add(['id_marcainsumo' => $marca->id]);
            request()->validate([
                'nombre' => ['required',Rule::unique('insumos')->where(function ($query) use($marca, $categoria, $organizacion) {
                                return $query->where([['id_marcainsumo', $marca->id], ['categoria',$categoria], ['id_organizacion', $organizacion]]);
                                })
                            ],
                'categoria' => 'required',
                'marcainsumo' => 'required',
            ]);
        } else {
            $marca = $request->get('id_marcainsumo');
            request()->validate([
                'nombre' => ['required',Rule::unique('insumos')->where(function ($query) use($marca, $categoria, $organizacion) {
                                return $query->where([['id_marcainsumo', $marca], ['categoria',$categoria], ['id_organizacion', $organizacion]]);
                                })
                            ],
                'categoria' => 'required',
                'id_marcainsumo' => 'required',
            ]);
        }

        //Si al momento de crear un producto, le asignamos cantidades que ya tenemos registradas, se evalúa que tipo de producto es para insertar la unidad de medida correspondiente
        $lts = $request->get('litros');
        $kg = $request->get('peso');
        $unidades = $request->get('semillas');
        if(($lts <> "") OR ($kg <> "") OR ($unidades <> "")){
            if($lts <> ""){
                $unidades_medida = 'lts/ha';
            }elseif($kg <> ""){
                $unidades_medida = 'kg/ha';
            }else{
                $unidades_medida = "unidades";
            }
            $request->request->add(['unidades_medidas' => $unidades_medida]);
        }
        $insumos = Insumo::create($request->all());
        return redirect()->route('insumo.index')->with('status_success', 'Insumo creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function show(insumo $insumo)
    {
        //
        Gate::authorize('haveaccess','insumo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $marca = Insumo::select('marcainsumos.id','marcainsumos.nombre')
                        ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                        ->where('marcainsumos.id',$insumo->id_marcainsumo)->first();
        $rutavolver = route('insumo.index');
        return view('insumo.view', compact('insumo','rutavolver','marca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function edit(insumo $insumo)
    {
        //
        Gate::authorize('haveaccess','insumo.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $marcas = Marcainsumo::orderBy('nombre','desc')->get();
        $organizacion = $insumo->id_organizacion;
        $rutavolver = route('insumo.index');
        return view('insumo.edit', compact('insumo','rutavolver','marcas','organizacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, insumo $insumo)
    {
        //
        Gate::authorize('haveaccess','insumo.edit');
        $organizacion = $request->get('id_organizacion');
        $categoria = $request->get('categoria');
        if ($request->marcainsumo) {
            $marca = Marcainsumo::create(['nombre' => $request->marcainsumo]);
            $request->request->add(['id_marcainsumo' => $marca->id]);
            request()->validate([
                'nombre' => ['required',Rule::unique('insumos')->where(function ($query) use($marca, $categoria, $organizacion) {
                    return $query->where([['id_marcainsumo', $marca->id], ['categoria',$categoria], ['id_organizacion', $organizacion]]);
                    })->ignore($insumo->id)
                ],
                'categoria' => 'required',
                'marcainsumo' => 'required',
            ]);
        } else {
            $marca = Marcainsumo::where('id',$insumo->id_marcainsumo)->first();
            request()->validate([
                'nombre' => ['required',Rule::unique('insumos')->where(function ($query) use($marca, $categoria, $organizacion) {
                    return $query->where([['id_marcainsumo', $marca->id], ['categoria',$categoria], ['id_organizacion', $organizacion]]);
                    })->ignore($insumo->id)
                ],
                'categoria' => 'required',
                'id_marcainsumo' => 'required',
            ]);
        }

        //Si al momento de modificar un producto, le asignamos cantidades que ya tenemos registradas, se evalúa que tipo de producto es para insertar la unidad de medida correspondiente
        $lts = $request->get('litros');
        $kg = $request->get('peso');
        $unidades = $request->get('semillas');
        if(($lts <> "") OR ($kg <> "") OR ($unidades <> "")){
            if($lts <> ""){
                $unidades_medida = 'lts/ha';
            }elseif($kg <> ""){
                $unidades_medida = 'kg/ha';
            }else{
                $unidades_medida = "unidades";
            }
            $request->request->add(['unidades_medidas' => $unidades_medida]);
        }
       
        $insumo->update($request->all());

        return redirect()->route('insumo.index')->with('status_success', 'Insumo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function destroy(insumo $insumo)
    {
        //
        Gate::authorize('haveaccess','insumo.destroy');
        $mezcla = Mezcla_insu::where('id_insumo',$insumo->id)->first();
        if(isset($mezcla)){
            $mezcla->delete();
        }
        $insumo->delete();
        return redirect()->route('insumo.index')->with('status_success', 'Insumo eliminado con exito');
    }
}
