<?php

namespace App\Http\Controllers;

use App\insumo_compra;
use App\organizacion;
use App\insumo;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InsumoCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','insumo_compra.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('insumo.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        if ($organizacion->NombOrga == "Sala Hnos"){
            $insumo_compras = Insumo_compra::select('insumo_compras.proveedor','insumo_compras.fecha_compra',
                                                    'insumo_compras.bultos','insumo_compras.precio','insumos.nombre as nombreinsumo',
                                                    'insumos.categoria','marcainsumos.nombre as nombremarca','insumo_compras.id',
                                                    'insumo_compras.litros','insumo_compras.peso','insumo_compras.semillas',
                                                    'insumo_compras.nfactura')
                                                    ->join('insumos','insumo_compras.id_insumo','=','insumos.id')
                                                    ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                                                    ->orderBy('id','desc')
                                                    ->paginate(20);
        } else {
            $insumo_compras = Insumo_compra::select('insumo_compras.proveedor','insumo_compras.fecha_compra',
                                                    'insumo_compras.bultos','insumo_compras.precio','insumos.nombre',
                                                    'insumos.categoria','marcainsumos.nombre','insumo_compras.id',
                                                    'insumo_compras.litros','insumo_compras.peso','insumo_compras.semillas',
                                                    'insumo_compras.nfactura')
                                                    ->join('insumos','insumo_compras.id_insumo','=','insumos.id')
                                                    ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                                                    ->where('insumos.id_organizacion',$organizacion->id)
                                                    ->orderBy('id','desc')
                                                    ->paginate(20);

        }

        return view('insumo_compra.index', compact('insumo_compras','rutavolver'));
    }

    public function fetch(Request $request)
    {
        $value = $request->get('value');
        $insumo = $request->get('insumo');
        
        $data = Insumo::select('insumos.nombre as nombreinsu','insumos.id','marcainsumos.nombre as nombremarca')
                        ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                        ->where('insumos.categoria', $value)
                        ->orderBy('insumos.nombre','asc')->get();

        $output = '<option value="">Seleccionar insumo</option>';
        foreach ($data as $row)
        {
            if(isset($insumo))
            {
                if($row->id == $insumo){
                    $output .='<option value="'.$row->id.'" selected>'.$row->nombreinsu.' (' .$row->nombremarca.')</option>';
                } else {
                    $output .='<option value="'.$row->id.'">'.$row->nombreinsu.' (' .$row->nombremarca.')</option>';
                }
                
            } else {
                $output .='<option value="'.$row->id.'">'.$row->nombreinsu.' (' .$row->nombremarca.')</option>';
            }
            
        }
        echo $output;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','insumo_compra.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('insumo_compra.index');
        $insumos = Insumo::select('insumos.nombre','marcainsumos.nombre')
                                        ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                                        ->get();
        return view('insumo_compra.create',compact('rutavolver','insumos'));
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
            'id_insumo' => 'required',
            'fecha_compra' => 'required',
            'precio' => 'required',
        ]);
        //sumo al stock el insumo que se registra en la compra
        $id_insumo = $request->get('id_insumo');
        $precio = $request->get('precio');
        $categoria = $request->get('categoria');
        $litros = $request->get('litros');
        $peso = $request->get('peso');
        $bultos = $request->get('bultos');

        $insumo = Insumo::where('id',$id_insumo)->first();
        $insumo->update(['precio'=>$precio]);
        if($categoria == "Producto quimico"){
            $total = $insumo->litros + $litros;
            $insumo->update(['litros'=>$total]);
        } elseif($categoria == "Fertilizante"){
            $total = $insumo->peso + $peso;
            $insumo->update(['peso'=>$total]);
        } else {
            $total = $insumo->bultos + $bultos;
            $insumo->update(['bultos'=>$total]);
        }

        $insumo_compras = Insumo_compra::create($request->all());
        return redirect()->route('insumo_compra.index')->with('status_success', 'Compra registrada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\insumo_compra  $insumo_compra
     * @return \Illuminate\Http\Response
     */
    public function show(insumo_compra $insumo_compra)
    {
        //
        Gate::authorize('haveaccess','insumo_compra.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('insumo_compra.index');
        $insumo = Insumo::select('insumos.nombre as nombreinsumo','marcainsumos.nombre as nombremarca','insumos.categoria')
                        ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                        ->where('insumos.id',$insumo_compra->id_insumo)->first();
        return view('insumo_compra.view', compact('insumo_compra','rutavolver','insumo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\insumo_compra  $insumo_compra
     * @return \Illuminate\Http\Response
     */
    public function edit(insumo_compra $insumo_compra)
    {
        //
        Gate::authorize('haveaccess','insumo_compra.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Insumos']);
        $rutavolver = route('insumo_compra.index');
        $insumo = Insumo::select('insumos.nombre as nombreinsumo','marcainsumos.nombre as nombremarca','insumos.categoria',
                                'insumos.id')
                        ->join('marcainsumos','insumos.id_marcainsumo','=','marcainsumos.id')
                        ->where('insumos.id',$insumo_compra->id_insumo)->first();
        return view('insumo_compra.edit', compact('insumo_compra','rutavolver','insumo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\insumo_compra  $insumo_compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, insumo_compra $insumo_compra)
    {
        //
        Gate::authorize('haveaccess','insumo_compra.edit');
        request()->validate([
            'id_insumo' => 'required',
            'fecha_compra' => 'required',
            'precio' => 'required',
        ]);

        $id_insumo = $request->get('id_insumo');
        $precio = $request->get('precio');

        $insumo = Insumo::where('id',$id_insumo)->first();
        $insumo->update(['precio'=>$precio]);

        $insumo_compra->update($request->all());
        return redirect()->route('insumo_compra.index')->with('status_success', 'Compra modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\insumo_compra  $insumo_compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(insumo_compra $insumo_compra)
    {
        //
        Gate::authorize('haveaccess','insumo_compra.destroy');
        $insumo_compra->delete();
        return redirect()->route('insumo_compra.index')->with('status_success', 'Insumo_compra eliminada con exito');
    }
}
