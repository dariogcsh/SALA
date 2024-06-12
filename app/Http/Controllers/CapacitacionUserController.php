<?php

namespace App\Http\Controllers;

use App\capacitacion_user;
use App\capacitacion;
use App\calendario_user;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;

class CapacitacionUserController extends Controller
{

    protected $notificationsService;
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
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\capacitacion_user  $capacitacion_user
     * @return \Illuminate\Http\Response
     */
    public function show(capacitacion_user $capacitacion_user)
    {
        //
        Gate::authorize('haveaccess','capacitacion_user.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Capacitacion']);
        $rutavolver = route('capacitacion.index');
        $capacitacion = Capacitacion::where('id',$capacitacion_user->id_capacitacion)->first();
        return view('capacitacion_user.view', compact('capacitacion_user','rutavolver','capacitacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\capacitacion_user  $capacitacion_user
     * @return \Illuminate\Http\Response
     */
    public function edit(capacitacion_user $capacitacion_user)
    {
        //
        Gate::authorize('haveaccess','capacitacion_user.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Capacitacion']);
        $rutavolver = route('capacitacion.index');
        $capacitacion = Capacitacion::where('id', $capacitacion_user->id_capacitacion)->first();
        return view('capacitacion_user.edit', compact('capacitacion_user','rutavolver','capacitacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\capacitacion_user  $capacitacion_user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, capacitacion_user $capacitacion_user)
    {
        //
        Gate::authorize('haveaccess','capacitacion_user.edit');
        $request->validate([
            'estado'          => 'required',
        ]);

        $capacitacion_user->update($request->all());
        return redirect()->route('capacitacion.index')->with('status_success', 'Capacitacion modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\capacitacion_user  $capacitacion_user
     * @return \Illuminate\Http\Response
     */
    public function destroy(capacitacion_user $capacitacion_user)
    {
        //
        Gate::authorize('haveaccess','capacitacion_user.destroy');
        $capacitacion = Capacitacion::where('id',$capacitacion_user->id_capacitacion)->first();

        $calendario_users = Calendario_user::select('calendario_users.id')
                                    ->join('calendarios','calendario_users.id_calendario','=','calendarios.id')
                                    ->where([['calendarios.id_capacitacion',$capacitacion->id], 
                                            ['calendario_users.id_user',$capacitacion_user->id_user]])->get();
            if(isset($calendario_users)){
                foreach ($calendario_users as $calendario_user) {
                    $calendario_user->delete();
                }
            }
        $capacitacion_user->delete();
        $notificationData = [
            'title' => 'SALA - Desvinculado de una capacitación',
            'body' => 'Usted ha sido desvinculado de la capacitacion '.$capacitacion->nombre.', codigo de capacitación '.$capacitacion->codigo.'',
            'path' => '/capacitacion',
        ];
        $this->notificationsService->sendToUser($capacitacion_user->id_user, $notificationData);
        return redirect()->route('capacitacion.index')->with('status_success', 'Usuario desvinculado de la capacitación eliminada con exito');
    }
}
