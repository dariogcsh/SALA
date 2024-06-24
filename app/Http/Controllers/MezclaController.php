<?php

namespace App\Http\Controllers;

use App\mezcla;
use App\insumo;
use App\mezcla_insu;
use App\interaccion;
use App\organizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule; 

class MezclaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //
        Gate::authorize('haveaccess','mezcla.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('insumo.menu');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        if ($organizacion->NombOrga == "Sala Hnos"){
            $mezclas = Mezcla::select('mezclas.id','mezclas.nombre','organizacions.NombOrga')
                            ->join('organizacions','mezclas.id_organizacion','=','organizacions.id')
                            ->orderBy('nombre','asc')
                            ->orderBy('organizacions.NombOrga','asc')->paginate(20);
        } else {
            $mezclas = Mezcla::select('mezclas.id','mezclas.nombre')->where('id_organizacion', auth()->user()->CodiOrga)
                            ->orderBy('nombre','asc')->paginate(20);
        }
        return view('mezcla.index', compact('mezclas','rutavolver','organizacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','mezcla.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $insumos = Insumo::where('id_organizacion', auth()->user()->CodiOrga)
                        ->orderBy('nombre','asc')->get();
        $organizacion = auth()->user()->CodiOrga;
        $rutavolver = route('mezcla.index');
        return view('mezcla.create',compact('rutavolver', 'insumos','organizacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organizacion = $request->get('id_organizacion');
        request()->validate([
            'nombre' => ['required',Rule::unique('mezclas')->where(function ($query) use($organizacion) {
                return $query->where('id_organizacion', $organizacion);
                })
            ],
        ]);

        $mezclas = Mezcla::create($request->all());

        for ($i=1; $i <= 20; $i++) { 
            $insumo = $request->get('id_insumo'.$i);
            $cantidad = $request->get('cantidad'.$i);
            if (($insumo <> "") AND ($cantidad <> "")) {
                $insumos = Mezcla_insu::create(['id_mezcla' => $mezclas->id, 'id_insumo' => $insumo, 'cantidad' => $cantidad]);
            }
            $insumo = "";
            $cantidad = "";
        }
       
        return redirect()->route('mezcla.index')->with('status_success', 'Mezcla creada con exito');
    }

    public function storeinsu(Request $request)
    {   
        $mezcla = $request->get('id_mezcla');
        for ($i=1; $i <= 20; $i++) { 
            $insumo = $request->get('id_insumo'.$i);
            $cantidad = $request->get('cantidad'.$i);
            if (($insumo <> "") AND ($cantidad <> "")) {
                $insumos = Mezcla_insu::create(['id_mezcla' => $mezcla, 'id_insumo' => $insumo, 'cantidad' => $cantidad]);
            }
            $insumo = "";
            $cantidad = "";
        }
       
        return redirect()->route('mezcla.index')->with('status_success', 'Insumos agregados con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mezcla  $mezcla
     * @return \Illuminate\Http\Response
     */
    public function show(mezcla $mezcla)
    {
        //
        Gate::authorize('haveaccess','mezcla.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('mezcla.index');
        $mezclainsus = Mezcla_insu::where('id_mezcla',$mezcla->id)->get();
        $insumos = Insumo::orderBy('nombre','asc')->get();
        return view('mezcla.view', compact('mezcla','rutavolver','mezclainsus','insumos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mezcla  $mezcla
     * @return \Illuminate\Http\Response
     */
    public function edit(mezcla $mezcla)
    {
        //
        Gate::authorize('haveaccess','mezcla.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('mezcla.index');
        $mezclainsus = Mezcla_insu::where('id_mezcla',$mezcla->id)->get();
        $insumos = Insumo::orderBy('nombre','asc')->get();
        $organizacion = $mezcla->id_organizacion;
        return view('mezcla.edit', compact('mezcla','rutavolver','mezclainsus','insumos','organizacion'));
    }

    public function agregar($id)
    {
        //
        Gate::authorize('haveaccess','mezcla.create');
        $rutavolver = route('mezcla.index');
        $mezcla = Mezcla::where('id',$id)->first();
        $insumos = Insumo::orderBy('nombre','asc')->get();
        return view('mezcla.agregar', compact('mezcla','rutavolver','insumos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mezcla  $mezcla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mezcla $mezcla)
    {
        //
        Gate::authorize('haveaccess','mezcla.edit');
        $organizacion = $request->get('id_organizacion');
        request()->validate([
            'nombre' => ['required',Rule::unique('mezclas')->where(function ($query) use($organizacion, $mezcla) {
                return $query->where('id_organizacion', $organizacion);
                })->ignore($mezcla->id)
            ],
        ]);

        $mezcla->update($request->all());

        $mezclainsus = Mezcla_insu::where('id_mezcla',$mezcla->id)->get();
        $i = 1;

        foreach($mezclainsus as $mezclainsu){
            $insumo = $request->get('id_insumo'.$i);
            $cantidad = $request->get('cantidad'.$i);
            if (($insumo <> "") AND ($cantidad <> "")) {
                $mezclainsu->update(['id_insumo' => $insumo, 'cantidad' => $cantidad]);
            }
            $insumo = "";
            $cantidad = "";
            $i++;
        }

        return redirect()->route('mezcla.index')->with('status_success', 'Mezcla modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mezcla  $mezcla
     * @return \Illuminate\Http\Response
     */
    public function destroy(mezcla $mezcla)
    {
        //
        Gate::authorize('haveaccess','mezcla.destroy');
        $insumo = Mezcla_insu::where('id_mezcla',$mezcla->id)->first();
        if(isset($insumo)){
            $insumo->delete();
        }
        $mezcla->delete();
        return redirect()->route('mezcla.index')->with('status_success', 'Mezcla eliminada con exito');
    }

    public function destroyinsumo(Request $request)
    {
        Gate::authorize('haveaccess','mezcla.destroy');
        $id_insumo = $request->get('id_insumo');
        $id_mezcla = $request->get('id_mezcla');
        $insumo = Mezcla_insu::where([['id_mezcla',$id_mezcla], ['id',$id_insumo]])->first();
        $insumo->delete();
        return response()->json(["success"=>true,"url"=> route("mezcla.edit",$id_mezcla)]);
    }
}
