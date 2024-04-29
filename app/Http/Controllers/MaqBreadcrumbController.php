<?php

namespace App\Http\Controllers;

use App\maq_breadcrumb;
use Carbon\Carbon;
use App\interaccion;
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
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Equipos trabajando']);
        $rutavolver = route('internosoluciones');
        $hoy = Carbon::yesterday();
        $maqbrs = Maq_breadcrumb::select('maquinas.TipoMaq','maquinas.ModeMaq','maq_breadcrumbs.estado','maq_breadcrumbs.velocidad',
                                        'maq_breadcrumbs.rumbo','maq_breadcrumbs.direccion','maq_breadcrumbs.pin','maq_breadcrumbs.fecha',
                                        'maq_breadcrumbs.tanque','organizacions.NombOrga','maq_breadcrumbs.id','maquinas.id as idmaq',
                                        'sucursals.NombSucu')
                                ->join('maquinas','maq_breadcrumbs.pin','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['estado','LIKE','%harvest%'],['maq_breadcrumbs.fecha','>',$hoy]])
                                //->orWhere('estado','LIKE','%work%')
                                ->whereIn('maq_breadcrumbs.id', function ($sub) {
                                    $sub->selectRaw('max(maq_breadcrumbs.id)')->from('maq_breadcrumbs')->groupBy('maq_breadcrumbs.pin'); // <---- la clave
                                })
                                ->orderBy('maquinas.InscMaq','DESC')
                                ->orderBy('sucursals.id','DESC')->paginate(20);
        $cantreg = Maq_breadcrumb::select('maq_breadcrumbs.id')
                                            ->where([['estado','LIKE','%harvest%'],['maq_breadcrumbs.fecha','>',$hoy]])
                                            ->whereIn('maq_breadcrumbs.id', function ($sub) {
                                                $sub->selectRaw('max(maq_breadcrumbs.id)')->from('maq_breadcrumbs')->groupBy('maq_breadcrumbs.pin'); // <---- la clave
                                            })->count();

        return view('maq_breadcrumb.index', compact('maqbrs','rutavolver','cantreg','hoy'));
    }

    public function itractor()
    {
        Gate::authorize('haveaccess','maq_breadcrumb.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Equipos trabajando']);
        $rutavolver = route('internosoluciones');
        $hoy = Carbon::yesterday();
        $maqbrs = Maq_breadcrumb::select('maquinas.TipoMaq','maquinas.ModeMaq','maq_breadcrumbs.estado','maq_breadcrumbs.velocidad',
                                        'maq_breadcrumbs.rumbo','maq_breadcrumbs.direccion','maq_breadcrumbs.pin','maq_breadcrumbs.fecha',
                                        'maq_breadcrumbs.tanque','organizacions.NombOrga','maq_breadcrumbs.id','maquinas.id as idmaq',
                                        'sucursals.NombSucu')
                                ->join('maquinas','maq_breadcrumbs.pin','=','maquinas.NumSMaq')
                                ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maq_breadcrumbs.estado','LIKE','%working%'],['maq_breadcrumbs.fecha','>',$hoy]])
                                ->groupBy('maq_breadcrumbs.pin') // <---- la clave
                                ->orderBy('maquinas.InscMaq','DESC')
                                ->orderBy('sucursals.id','DESC')->paginate(20);
        $cantreg = Maq_breadcrumb::select('maq_breadcrumbs.id')
                                ->where([['maq_breadcrumbs.estado','LIKE','%working%'],['maq_breadcrumbs.fecha','>',$hoy]])
                                ->count();
        return view('maq_breadcrumb.index', compact('maqbrs','rutavolver','cantreg','hoy'));
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
        Gate::authorize('haveaccess','maq_breadcrumb.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Equipos trabajando']);
        $rutavolver = url()->previous();
        return view('maq_breadcrumb.view', compact('maq_breadcrumb','rutavolver'));
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
