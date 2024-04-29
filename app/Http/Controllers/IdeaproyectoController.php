<?php

namespace App\Http\Controllers;

use App\ideaproyecto;
use App\User;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;

class IdeaproyectoController extends Controller
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
        //
        Gate::authorize('haveaccess','ideaproyecto.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Proyectos']);
        $rutavolver = route('home');
        $vista="";
        $vista= $request->get('concesionario');
        $variablesurl=$request->all();
                    if($vista == "concesionario"){
                        $ideaproyectos = Ideaproyecto::select('ideaproyectos.id','ideaproyectos.descripcion','ideaproyectos.created_at',
                                                        'users.name','users.last_name','organizacions.NombOrga',
                                                        'ideaproyectos.id_proyecto','ideaproyectos.estado')
                                                    //->join('proyectos','ideaproyectos.id_proyecto','=','proyectos.id')
                                                    ->join('users','ideaproyectos.id_user','=','users.id')
                                                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                                    ->where('organizacions.NombOrga','Sala Hnos')
                                                    ->orderBy('ideaproyectos.id','desc')->paginate(20);
                    } elseif(($vista == "organizaciones") OR ($vista == "")){ 
                        $ideaproyectos = Ideaproyecto::select('ideaproyectos.id','ideaproyectos.descripcion','ideaproyectos.created_at',
                                                        'users.name','users.last_name','organizacions.NombOrga',
                                                        'ideaproyectos.id_proyecto','ideaproyectos.estado')
                                                    //->join('proyectos','ideaproyectos.id_proyecto','=','proyectos.id')
                                                    ->join('users','ideaproyectos.id_user','=','users.id')
                                                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                                    ->where('organizacions.NombOrga','<>','Sala Hnos')
                                                    ->orderBy('ideaproyectos.id','desc')->paginate(20);
                        $vista = "organizaciones";
                    }
        return view('ideaproyecto.index', compact('ideaproyectos','rutavolver','vista'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','ideaproyecto.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Guardias de servicio']);
        $rutavolver = route('home');
        return view('ideaproyecto.create',compact('rutavolver'));
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
            'descripcion' => 'required|max:10000'
        ]);
        $request->request->add(['id_user' => auth()->id()]);
        $request->request->add(['estado' => 'Pendiente de aprobacion']);
        $ideaproyectos = Ideaproyecto::create($request->all());
        $usersends = User::select('users.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where('roles.name','Admin')->get();

        //Envio de notificacion
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'Sala Hnos.',
                'body' => 'Nueva propuesta de mejora en la App',
                'path' => '/ideaproyecto',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }

        return redirect()->route('home')->with('status_success', 'Propuesta creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ideaproyecto  $ideaproyecto
     * @return \Illuminate\Http\Response
     */
    public function show(ideaproyecto $ideaproyecto)
    {
        //
        Gate::authorize('haveaccess','ideaproyecto.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Guardias de servicio']);
        $rutavolver = route('ideaproyecto.index');
        return view('ideaproyecto.view', compact('ideaproyecto','rutavolver','propuesta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ideaproyecto  $ideaproyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(ideaproyecto $ideaproyecto)
    {
        //
        Gate::authorize('haveaccess','ideaproyecto.edit');

        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Guardias de servicio']);
        $rutavolver = route('ideaproyecto.index');
        return view('ideaproyecto.edit', compact('ideaproyecto','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ideaproyecto  $ideaproyecto
     * @return \Illuminate\Http\Response
     */
    public function pasarProyecto($ideaproyecto)
    {
        //
        Gate::authorize('haveaccess','ideaproyecto.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Guardias de servicio']);
        $idea_descripcion = Ideaproyecto::where('id',$ideaproyecto)->first();
        $usuarios = User::select('users.id','users.name','users.last_name')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('organizacions.NombOrga','Sala Hnos')
                        ->orderBy('users.name','asc')->get();

        return view('proyecto.create', compact('ideaproyecto','idea_descripcion','usuarios'));
    }

    public function update(Request $request, ideaproyecto $ideaproyecto)
    {
        //
        Gate::authorize('haveaccess','ideaproyecto.edit');
        $request->validate([
            'descripcion'          => 'required|max:10000|unique:ideaproyectos,descripcion,'.$ideaproyecto->id,
        ]);

        $ideaproyecto->update($request->all());
        return redirect()->route('ideaproyecto.index')->with('status_success', 'Propuestao modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ideaproyecto  $ideaproyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ideaproyecto $ideaproyecto)
    {
        //
        Gate::authorize('haveaccess','ideaproyecto.destroy');
        $ideaproyecto->delete();
        return redirect()->route('ideaproyecto.index')->with('status_success', 'Propuesta eliminada con exito');
    }
}