<?php

namespace App\Http\Controllers;

use App\orden_insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrdenInsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\orden_insumo  $orden_insumo
     * @return \Illuminate\Http\Response
     */
    public function show(orden_insumo $orden_insumo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\orden_insumo  $orden_insumo
     * @return \Illuminate\Http\Response
     */
    public function edit(orden_insumo $orden_insumo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\orden_insumo  $orden_insumo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, orden_insumo $orden_insumo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\orden_insumo  $orden_insumo
     * @return \Illuminate\Http\Response
     */
    public function destroy(orden_insumo $orden_insumo)
    {
        //
    }
    public function destroyinsumo(Request $request)
    {
        Gate::authorize('haveaccess','ordeninsumo.destroy');
        $id_delete_insumo = $request->get('id_delete_insumo');
        $id_ordendetrabajo = $request->get('id_ordendetrabajo');
        $insumo = Orden_insumo::where([['id',$id_delete_insumo], ['id_ordentrabajo',$id_ordendetrabajo]])->first();
        $insumo->delete();

        return response()->json(["success"=>true,"url"=> route("ordentrabajo.edit",$id_ordendetrabajo)]);
    }

    public function destroymezcla(Request $request)
    {
        Gate::authorize('haveaccess','ordeninsumo.destroy');
        $id_delete_mezcla = $request->get('id_delete_mezcla');
        $id_ordendetrabajo = $request->get('id_ordendetrabajo');
        $insumos = Orden_insumo::where([['id_mezcla',$id_delete_mezcla], ['id_ordentrabajo',$id_ordendetrabajo]])->get();
        foreach ($insumos as $insumo) {
            $insumo->delete();
        }  
        
        return response()->json(["success"=>true,"url"=> route("ordentrabajo.edit",$id_ordendetrabajo)]);
    }
}
