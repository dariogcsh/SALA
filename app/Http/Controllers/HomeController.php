<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationsService;
use App\organizacion;
use App\interaccion;
use App\User;
use Carbon\Carbon;
use App\viaje;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        
        $inter = Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Inicio']);
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $rutavolver = url('/');
        $hoy = Carbon::today();
        $viajes = Viaje::select('viajes.id','viajes.minutos','viajes.url')
                        ->join('viaje_users','viajes.id','=','viaje_users.id_viaje')
                        ->where([['viaje_users.id_user',auth()->user()->id], ['viajes.created_at','>=', $hoy]])->get();
        return view('home',compact('rutavolver','organizacion','viajes'));
    }
    public function indexinterno()
    {   
        $rutavolver = route('menuinterno');
        return view('homeinterno',compact('rutavolver'));
    }
    public function internosoluciones()
    {   
        $rutavolver = route('menuinterno');
        return view('internosoluciones',compact('rutavolver'));
    }
    public function internoestadisticas()
    {   
        $rutavolver = route('menuinterno');
        return view('internoestadisticas',compact('rutavolver'));
    }
    public function internoventas()
    {   
        $rutavolver = route('menuinterno');
        return view('internoventas',compact('rutavolver'));
    }
    public function internoservicios()
    {   
        $rutavolver = route('menuinterno');
        return view('internoservicios',compact('rutavolver'));
    }
    public function internoconfiguracion_user()
    {   
        $rutavolver = route('home');
        return view('internoconfiguracion_user',compact('rutavolver'));
    }
    public function internoconfiguracion()
    {   
        $rutavolver = route('menuinterno');
        return view('internoconfiguracion',compact('rutavolver'));
    }
    public function internocx()
    {   
        $rutavolver = route('menuinterno');
        return view('internocx',compact('rutavolver'));
    }
    public function menuinterno()
    {   
        $rutavolver = route('home');
        return view('menuinterno',compact('rutavolver'));
    }
    public function terminos()
    {   
        $rutavolver = route('configuracion_user');
        return view('terminos',compact('rutavolver'));
    }
    public function ams()
    {   
        $rutavolver = route('insumo.menu');
        return view('ams.menu',compact('rutavolver'));
    }
    public function repuesto()
    {   
        $rutavolver = route('insumo.menu');
        return view('repuesto.menu',compact('rutavolver'));
    }

    public function token(Request $request){
        $tokennuevo = $request->get('tokennuevo');
        $user = User::where('id', auth()->user()->id)->first();
        $user->update(['TokenNotificacion'=> $tokennuevo]);
    }
    
}
