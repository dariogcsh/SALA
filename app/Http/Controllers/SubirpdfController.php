<?php

namespace App\Http\Controllers;

use App\subirpdf;
use App\User;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;

class SubirpdfController extends Controller
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
        Gate::authorize('haveaccess','subirpdf.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ventas']);
        $rutavolver = route('subirpdf.menu');
        $subirpdfs = Subirpdf::where('ventastipo','Precios')
                            ->orderBy('id','desc')->paginate(20);
        return view('subirpdf.index', compact('subirpdfs','rutavolver'));
    }

    public function indexvarios()
    {
        //
        Gate::authorize('haveaccess','subirpdf.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ventas']);
        $rutavolver = route('subirpdf.menu');
        $subirpdfs = Subirpdf::where('ventastipo','Varios')
                            ->orderBy('id','desc')->paginate(20);
        return view('subirpdf.indexvarios', compact('subirpdfs','rutavolver'));
    }

    public function indexusados()
    {
        //
        Gate::authorize('haveaccess','subirpdf.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ventas']);
        $rutavolver = route('subirpdf.menu');
        $subirpdfs = Subirpdf::where('ventastipo','usados')
                            ->orderBy('id','desc')->paginate(20);
        return view('subirpdf.indexusados', compact('subirpdfs','rutavolver'));
    }

    public function indexams()
    {
        //
        Gate::authorize('haveaccess','subirpdf.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ventas']);
        $rutavolver = route('subirpdf.menu');
        $subirpdfs = Subirpdf::where('ventastipo','ams')
                            ->orderBy('id','desc')->paginate(20);
        return view('subirpdf.indexams', compact('subirpdfs','rutavolver'));
    }

    public function menu()
    {
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ventas']);
        $rutavolver = route('internoventas');
        return view('subirpdf.menu', compact('rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','subirpdf.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ventas']);
        $rutavolver = route('subirpdf.index');
        return view('subirpdf.create',compact('rutavolver'));
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
            'archivo' => 'required'
        ]);
        
        
        // carga del archivo
        if($request->hasFile("archivo")){
            $imagen = $request->file('archivo');
            $nombre = time().'2'.rand().'.'.$imagen->getClientOriginalExtension();
            $destino = public_path('pdf/ventas/');
            $request->archivo->move($destino, $nombre);
        }
        $radioopt = $request->inlineRadioOptions;
        $titulo = $request->get('titulo');
        $tipo = "Venta";
    
        $subirpdfs = Subirpdf::create(['titulo'=>$titulo, 'tipo'=>$tipo, 'ruta'=>$nombre, 'ventastipo'=>$radioopt]);
        $usersends = User::select('users.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->Where('puesto_empleados.NombPuEm', 'Vendedor')
                        ->orWhere(function($query) {
                            $query->where('users.last_name', 'Blanc')
                                  ->Where('puesto_empleados.NombPuEm', 'Gerente de soluciones integrales');
                        })
                        ->orWhere(function($query) {
                            $query->where('puesto_empleados.NombPuEm', 'Especialista AMS')
                                ->where('users.last_name', 'Pellizza');
                        })
                        ->get();

        if ($radioopt == "Precios"){
            $archivo = "lista de precios";
            $ruta = "/subirpdf";
        }elseif ($radioopt == "Varios"){
            $archivo = "varios";
            $ruta = "/subirpdf/indexvarios";
        }elseif ($radioopt == "ams"){
            $archivo = "AMS";
            $ruta = "/subirpdf/indexams";
        }else{
            $archivo = "Usados";
            $ruta = "/subirpdf/indexusados";
        }
                    

         //Envio de notificacion
         foreach($usersends as $usersend){
            $notificationData = [
                'title' => 'SALA - Nuevo archivo de ventas',
                'body' => 'Se ha registrado un nuevo archivo de '.$archivo.'.',
                'path' => ''.$ruta.'',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }


        return redirect()->route('subirpdf.menu')->with('status_success', 'PDF subido con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subirpdf  $subirpdf
     * @return \Illuminate\Http\Response
     */
    public function show(subirpdf $subirpdf)
    {
        //
        Gate::authorize('haveaccess','subirpdf.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ventas']);
        $rutavolver = route('subirpdf.index');
        return view('subirpdf.view', compact('subirpdf','rutavolver'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\subirpdf  $subirpdf
     * @return \Illuminate\Http\Response
     */
    public function destroy(subirpdf $subirpdf)
    {
        //
        Gate::authorize('haveaccess','subirpdf.destroy');
        $subirpdf->delete();
        return redirect()->route('subirpdf.menu')->with('status_success', 'PDF eliminado con exito');
    }
}
