<?php

namespace App\Http\Controllers;

use App\maq_breadcrumb;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MaqBreadcrumbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','maq_breadcrumb.index');
        $rutavolver = route('homeinterno');
        $hoy = Carbon::today();
        $maqbrs = Maq_breadcrumb::select('maquinas.TipoMaq','maquinas.ModeMaq','maq_breadcrumbs.estado','maq_breadcrumbs.velocidad',
                                        'maq_breadcrumbs.rumbo','maq_breadcrumbs.direccion','maq_breadcrumbs.pin','maq_breadcrumbs.fecha',
                                        'maq_breadcrumbs.tanque','organizacions.NombOrga')
                                ->join('maquinas','maq_breadcrumbs.pin','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->where([['estado','LIKE','%harvest%'],['maq_breadcrumbs.fecha',$hoy]])
                                //->orWhere('estado','LIKE','%work%')
                                ->whereIn('maq_breadcrumbs.id', function ($sub) {
                                    $sub->selectRaw('max(maq_breadcrumbs.id)')->from('maq_breadcrumbs')->groupBy('maq_breadcrumbs.pin'); // <---- la clave
                                })
                                ->orderBy('maq_breadcrumbs.fecha','DESC')->get();
        $cantreg = count($maqbrs);
        return view('maq_breadcrumb.index', compact('maqbrs','rutavolver','cantreg'));
    }

    public function itractor()
    {
        Gate::authorize('haveaccess','maq_breadcrumb.index');
        $rutavolver = route('homeinterno');
        $hoy = Carbon::today();
        $maqbrs = Maq_breadcrumb::select('maquinas.TipoMaq','maquinas.ModeMaq','maq_breadcrumbs.estado','maq_breadcrumbs.velocidad',
                                        'maq_breadcrumbs.rumbo','maq_breadcrumbs.direccion','maq_breadcrumbs.pin','maq_breadcrumbs.fecha',
                                        'maq_breadcrumbs.tanque','organizacions.NombOrga')
                                ->join('maquinas','maq_breadcrumbs.pin','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->where([['estado','LIKE','%working%'],['maq_breadcrumbs.fecha',$hoy]])
                                //->orWhere('estado','LIKE','%work%')
                                ->whereIn('maq_breadcrumbs.id', function ($sub) {
                                    $sub->selectRaw('max(maq_breadcrumbs.id)')->from('maq_breadcrumbs')->groupBy('maq_breadcrumbs.pin'); // <---- la clave
                                })
                                ->orderBy('maq_breadcrumbs.fecha','DESC')->get();
        $cantreg = count($maqbrs);
        return view('maq_breadcrumb.index', compact('maqbrs','rutavolver','cantreg'));
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
     * @param  \App\maq_breadcrumb  $maq_breadcrumb
     * @return \Illuminate\Http\Response
     */
    public function show(maq_breadcrumb $maq_breadcrumb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\maq_breadcrumb  $maq_breadcrumb
     * @return \Illuminate\Http\Response
     */
    public function edit(maq_breadcrumb $maq_breadcrumb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\maq_breadcrumb  $maq_breadcrumb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, maq_breadcrumb $maq_breadcrumb)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\maq_breadcrumb  $maq_breadcrumb
     * @return \Illuminate\Http\Response
     */
    public function destroy(maq_breadcrumb $maq_breadcrumb)
    {
        //
    }
}
