<?php

namespace App\Http\Controllers;

use App\bonificacion;
use App\user;
use App\interaccion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;

class BonificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }
    public function index()
    {
        //Gate::authorize('haveaccess','bonificacion.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Bonificaciones']);
        $hoy = Carbon::now();
        $bonificaciones = Bonificacion::where('hasta','>=',$hoy)
                                        ->orderBy('hasta','desc')->paginate(10);
                                        
        return view('bonificacion.index', compact('bonificaciones','hoy'));
    }


    public function administrar(Request $request)
    {
        //
        Gate::authorize('haveaccess','bonificacion.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Bonificaciones']);
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $bonificaciones = Bonificacion::Buscar($tipo, $busqueda)->paginate(10)->appends($variablesurl);
            $filtro = "SI";
            $hoy = Carbon::now();
        } else{
            $bonificaciones = Bonificacion::orderBy('hasta','desc')->paginate(10);
            $hoy = Carbon::now();
        }
        $rutavolver = url()->previous();
        return view('bonificacion.administrar', compact('bonificaciones','hoy','filtro','busqueda','rutavolver'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','bonificacion.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Bonificaciones']);
        $rutavolver = url()->previous();
        return view('bonificacion.create', compact('rutavolver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'tipo' => 'required|unique:bonificacions,tipo',
            'imagen' => 'required',
            'descripcion' => 'required',
            'desde' => 'required',
            'hasta' => 'required'
        ]);

        $bonificaciones = Bonificacion::create($request->all());

        // carga de la imagen
        if($request->hasFile("imagen")){
            $imagen = $request->file('imagen');
            $nombre = time().'1'.rand().'.'.$imagen->getClientOriginalExtension();
            $bonificaciones->update(['imagen' => $nombre]);
            $destino = public_path('img/bonificaciones/');
            $request->imagen->move($destino, $nombre);
        }

        $usersends = User::all();

         //Envio de notificacion
         foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA',
                'body' => 'Mira el nuevo beneficio de '.$request->tipo.' que tenemos para vos',
                'path' => '/bonificacion',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        return redirect()->route('bonificacion.index')->with('status_success', 'Bonificacion creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\bonificacion  $bonificacion
     * @return \Illuminate\Http\Response
     */
    public function show(bonificacion $bonificacion)
    {
        Gate::authorize('haveaccess','bonificacion.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Bonificaciones']);
        $rutavolver = route('bonificacion.administrar');
        return view('bonificacion.view', compact('bonificacion','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\bonificacion  $bonificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(bonificacion $bonificacion)
    {
        Gate::authorize('haveaccess','bonificacion.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Bonificaciones']);
        $rutavolver = url()->previous();
        return view('bonificacion.edit', compact('bonificacion','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bonificacion  $bonificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bonificacion $bonificacion)
    {
        Gate::authorize('haveaccess','bonificacion.edit');
        $request->validate([
            'tipo'          => 'required|unique:bonificacions,tipo,'.$bonificacion->id,
            'descripcion' => 'required',
            'desde' => 'required',
            'hasta' => 'required'
        ]);

        $alldata = $request->except('imagen');

        $bonificacion->update($alldata);
        $imgprev = Bonificacion::where('id',$bonificacion->id)->first();

        if($request->hasFile("imagen")){
            $nombre = $imgprev->imagen;
            $imgstore = Bonificacion::where('id',$imgprev->id)->first();
            $imgstore->update(['imagen' => $nombre]);
            ////////
            $destino = public_path('img/bonificaciones/');
            $request->imagen->move($destino, $nombre);
        }

        return redirect()->route('bonificacion.index')->with('status_success', 'Bonificación modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bonificacion  $bonificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(bonificacion $bonificacion)
    {
        Gate::authorize('haveaccess','bonificacion.destroy');
        $bonificacion->delete();
        return redirect()->route('bonificacion.index')->with('status_success', 'Bonificación eliminada con exito');
    }
}
