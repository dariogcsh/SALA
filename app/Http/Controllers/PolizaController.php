<?php

namespace App\Http\Controllers;

use App\poliza;
use App\User;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;

class PolizaController extends Controller
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
        //
        Gate::authorize('haveaccess','poliza.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Polizas']);
        $rutavolver = route('vehiculo.index');
        $polizas = Poliza::orderBy('id','desc')->paginate(20);
        return view('poliza.index', compact('polizas','rutavolver'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','poliza.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Polizas']);
        $rutavolver = route('poliza.index');
        return view('poliza.create',compact('rutavolver'));
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
            'ruta' => 'required'
        ]);
        
        // carga del archivo
        if($request->hasFile("ruta")){
            $imagen = $request->file('ruta');
            $nombre = time().'44'.rand().'.'.$imagen->getClientOriginalExtension();
            $destino = public_path('pdf/polizas/');
            $request->ruta->move($destino, $nombre);
        }
        $radioopt = $request->inlineRadioOptions;
        $titulo = $request->get('titulo');
    
        $polizas = Poliza::create(['titulo'=>$titulo, 'ruta'=>$nombre]);
        $usersends = User::select('users.id')
                        ->join('vehiculo_responsables','users.id','=','vehiculo_responsables.id_user')
                        ->get();
                    

         //Envio de notificacion
         foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA - Poliza cargada',
                'body' => 'Se ha cargado una poliza de '.$titulo.'.',
                'path' => '/poliza',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }


        return redirect()->route('poliza.index')->with('status_success', 'PDF subido con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\poliza  $poliza
     * @return \Illuminate\Http\Response
     */
    public function show(poliza $poliza)
    {
        //
        Gate::authorize('haveaccess','poliza.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Polizas']);
        $rutavolver = route('poliza.index');
        return view('poliza.view', compact('poliza','rutavolver'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\poliza  $poliza
     * @return \Illuminate\Http\Response
     */
    public function destroy(poliza $poliza)
    {
        //
        Gate::authorize('haveaccess','poliza.destroy');
        $poliza->delete();
        return redirect()->route('poliza.index')->with('status_success', 'PDF eliminado con exito');
    }
}
