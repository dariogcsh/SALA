<?php

namespace App\Http\Controllers;

use App\mibonificacion;
use App\interaccion;
use App\User;
use App\sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\organizacion;
use App\bonificacion;
use Illuminate\Support\Facades\Session;
use App\Services\NotificationsService;

class MibonificacionController extends Controller
{

    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('haveaccess','mibonificacion.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Bonificaciones']);
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $misbonificaciones = Mibonificacion::Buscar($tipo, $busqueda)->orderBy('id','desc')->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
            $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
            if($organizacion->NombOrga == 'Sala Hnos'){
                $misbonificaciones = Mibonificacion::select('mibonificacions.id','mibonificacions.estado','bonificacions.tipo',
                                                            'bonificacions.descuento','organizacions.NombOrga')
                                                    ->join('bonificacions', 'mibonificacions.id_bonificacion','=','bonificacions.id')
                                                    ->join('organizacions', 'mibonificacions.id_organizacion','=','organizacions.id')
                                                    ->orderBy('id','desc')->paginate(20);

            } else {
                $misbonificaciones = Mibonificacion::select('mibonificacions.id','mibonificacions.estado','bonificacions.tipo',
                                                            'bonificacions.descuento','organizacions.NombOrga')
                                                    ->join('bonificacions', 'mibonificacions.id_bonificacion','=','bonificacions.id')
                                                    ->join('organizacions', 'mibonificacions.id_organizacion','=','organizacions.id')
                                                    ->where('mibonificacions.id_organizacion',$organizacion->id)
                                                    ->orderBy('mibonificacions.estado','desc')->paginate(20);
            }
        }
        $rutavolver = route('bonificacion.index');
        return view('mibonificacion.index', compact('misbonificaciones','filtro','busqueda','rutavolver'));
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
        $id = $request->get('id');
        $mibonificacion = Mibonificacion::create(['id_bonificacion' => $id, 'id_organizacion' => auth()->user()->CodiOrga,
                                                'estado' => 'Solicitado']);

        $organizacion = Organizacion::where('organizacions.id',auth()->user()->CodiOrga)->first();

        //obtener sucursal donde pertenece el usuario que solicita la asistencia
        $sucursalid = Sucursal::select('sucursals.id')
                            ->join('organizacions','sucursals.id','=','organizacions.CodiSucu')
                            ->join('mibonificacions','organizacions.id','=','mibonificacions.id_organizacion')
                            ->where('mibonificacions.id',$mibonificacion->id)
                            ->first();

        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        //->orWhere($matchTheseAdministrativo)
                        //->orWhere($matchTheseGerente)
                        ->Where('roles.name','Admin')
                        ->orWhere(function($q) use ($sucursalid){
                            $q->where(function($query) use ($sucursalid){
                                $query->where('puesto_empleados.NombPuEm','Responsable de Marketing');      
                            });
                        })->get();
                    

         //Envio de notificacion
         foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA - Beneficios',
                'body' => 'La organizacion '. $organizacion->NombOrga .' ha solicitado una bonificación',
                'path' => '/mibonificacion',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        Session::flash('status_success', 'Bonificación solicitada con éxito');
        return route('mibonificacion.index');

        //return redirect()->route('mibonificacion.index')->with('status_success', 'Bonificacion solicitada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mibonificacion  $mibonificacion
     * @return \Illuminate\Http\Response
     */
    public function show(mibonificacion $mibonificacion)
    {
        Gate::authorize('haveaccess','mibonificacion.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Bonificaciones']);
        $bonificacion = Bonificacion::where('id',$mibonificacion->id_bonificacion)->first();
        $organizacion = Organizacion::where('id',$mibonificacion->id_organizacion)->first();
        $rutavolver = route('mibonificacion.index');
        return view('mibonificacion.view', compact('mibonificacion','bonificacion','organizacion','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mibonificacion  $mibonificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(mibonificacion $mibonificacion)
    {
        Gate::authorize('haveaccess','mibonificacion.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Bonificaciones']);
        $bonificacion = Bonificacion::where('id',$mibonificacion->id_bonificacion)->first();
        $organizacion = Organizacion::where('id',$mibonificacion->id_organizacion)->first();
        $rutavolver = route('mibonificacion.index');
        return view('mibonificacion.edit', compact('mibonificacion','bonificacion','organizacion','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mibonificacion  $mibonificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mibonificacion $mibonificacion)
    {
        Gate::authorize('haveaccess','antena.edit');

        $mibonificacion->update($request->all());
        $bonificacion = Bonificacion::where('bonificacions.id',$mibonificacion->id_bonificacion)->first();
        $usersends = User::where('CodiOrga',$mibonificacion->id_organizacion)->get();
      
        //Envio de notificacion
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA - Beneficios',
                'body' => 'Su solicitud para el beneficio de '. $bonificacion->tipo .' con un descuento del '. $bonificacion->descuento .'% ha sido '. $mibonificacion->estado .'',
                'path' => '/mibonificacion',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }

        return redirect()->route('mibonificacion.index')->with('status_success', 'Solicitud de bonificación modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mibonificacion  $mibonificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(mibonificacion $mibonificacion)
    {
        Gate::authorize('haveaccess','mibonificacion.destroy');
        $mibonificacion->delete();
        return redirect()->route('mibonificacion.index')->with('status_success', 'Solicitud de bonificación eliminada con exito');
    }
}
