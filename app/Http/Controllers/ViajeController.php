<?php

namespace App\Http\Controllers;

use App\viaje;
use App\organizacion;
use App\vehiculo;
use App\User;
use App\interaccion;
use App\viaje_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ViajeController extends Controller
{

    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }

    public function gestion(Request $request)
    {
       //
       Gate::authorize('haveaccess','viaje.create');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
       $rutavolver = route('viaje.index');
       $filtro="";
        $busqueda="";
        if (($request->fecha_inicio) AND ($request->fecha_fin)) {
            $hasta = $request->fecha_fin;
            $desde = $request->fecha_inicio;
            $busqueda = $desde.' - '.$hasta;
        } else{
            $fecha_h = Carbon::today();
            $hasta = $fecha_h->format('Y-m-d');
            $fecha_d = $fecha_h->subDays(15);
            $desde = $fecha_d->format('Y-m-d');
        }

       $ranking_sucursales = DB::table('viajes')
                            ->selectRaw('COUNT(viajes.id) as cantidad, sucursals.NombSucu')
                            ->join('viaje_users','viaje_users.id_viaje','=','viajes.id')
                            ->join('users','viaje_users.id_user','=','users.id')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->orderBy('cantidad','DESC')
                            ->where([['viajes.created_at','>=',$desde.' 00:00:01'], ['viajes.created_at','<=',$hasta.' 23:59:59']])
                            ->get();

       return view('viaje.gestion', compact('rutavolver','desde','hasta','ranking_sucursales','filtro'));
    }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','viaje.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('internoservicios');
        $viajes = Viaje::select('viajes.created_at','viajes.id','vehiculos.nombre','vehiculos.patente',
                                'viajes.minutos','organizacions.NombOrga','users.name','users.last_name','sucursals.NombSucu')
                        ->join('vehiculos','viajes.id_vehiculo','=','vehiculos.id')
                        ->join('viaje_users','viajes.id','=','viaje_users.id_viaje')
                        ->join('users','viaje_users.id_user','=','users.id')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                        ->groupBy('viajes.id')
                        ->orderBy('viajes.id','desc')->paginate(20);
        return view('viaje.index', compact('viajes','rutavolver'));
    }

    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        
        $data = User::where($select, $value)->get();
        $output = '';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->id.'">'.$row->name.' ' .$row->last_name.'</option>';
        }

        echo $output;
    }

    function lista_vehiculos(){

       $ayer = Carbon::yesterday();
        $fecha = $ayer->subMonth(3);
        $token = "hii35C5UPX5lvdV%2bqHExQZa%2fbb9WywBy3K3dz6lxWosDaDv2voyrzwSlsBWu40l%2f";
        
        $apiEndpoint = "https://vsateq.com.ar/vsat/api/v.1/applications/355/users?FromIndex=0&PageSize=1000&ViewId=525";

        $cont = 0;
        $reg[]="";
        $r = 0;
        $vehiculos_reg = Vehiculo::orderBy('id','desc')->get();
        foreach($vehiculos_reg as $vehiculo_reg){
            $registro[$r] = $vehiculo_reg->id_vsat;
            $r++;
        }

       for ($i=0; $i < 50 ; $i++) { 
            try {
                $ch = curl_init($apiEndpoint);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization:". $token,
                ));

                $response = curl_exec($ch);
                curl_close($ch);

                $decodedResponse = json_decode($response, true);
                
                $prueba = $decodedResponse[$i]["deviceActivity"];  

                if ($prueba > $fecha) {
                    $nombre[$cont] = $decodedResponse[$i]["name"];
                    $id[$cont] = $decodedResponse[$i]["id"];
                    if (isset($registro)) {
                        if(!in_array($id[$cont], $registro)){
                            $vehiculo = Vehiculo::create(['id_vsat'=>$id[$cont], 'nombre'=>$nombre[$cont],'patente'=>'']);
                        } else{
                            $vehiculo = Vehiculo::where('id_vsat', $id[$cont])->first();
                            $vehiculo->update(['nombre' => $nombre[$cont]]);
                        }
                    } else {
                        $vehiculo = Vehiculo::create(['id_vsat'=>$id[$cont], 'nombre'=>$nombre[$cont],'patente'=>'']);
                    }
                    
                    $cont++;
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        dd("Actualizado");
        return view('viaje.lista_vehiculos', compact('enlace'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','viaje.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('viaje.index');
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $vehiculos = Vehiculo::orderBy('nombre','asc')->get();
        return view('viaje.create',compact('rutavolver', 'organizaciones', 'vehiculos'));
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
            'id_user' => 'required',
            'id_vehiculo' => 'required',
            'minutos' => 'required'
        ]);

        $id_vehiculo = $request->get('id_vehiculo');
        $minutos = $request->get('minutos');

        $id_vsat = Vehiculo::where('id',$id_vehiculo)->first();
        //$response = Curl::to('https://vsateq.com.ar/comGpsGate/api/v.1/applications/355/tokens')->get();
        
        $token = "hii35C5UPX5lvdV%2bqHExQZa%2fbb9WywBy3K3dz6lxWosDaDv2voyrzwSlsBWu40l%2f";
        
        $apiEndpoint = "https://vsateq.com.ar/vsat/api/v.1/applications/355/users/".$id_vsat->id_vsat."/publish?expires=".$minutos."&maptype=nativemap";
        
        $ch = curl_init($apiEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization:". $token,
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $decodedResponse = json_decode($response, true);
        $enlace = $decodedResponse['url'];
 
        //insertar 
        if (isset($request->id_user)) {
            $usuarios = $request->id_user;
        }

        $viaje = Viaje::create(['id_vehiculo'=>$id_vehiculo, 'minutos'=>$minutos,'url'=>$enlace, 
                                        'visto'=>'NO']);
        if (isset($usuarios)) {
            foreach ($usuarios as $us) {

                $viaje_user = Viaje_user::create(['id_user'=>$us, 'id_viaje'=>$viaje->id]);

                $notificationData = [
                    'title' => 'SALA - Técnico en camino',
                    'body' => 'Mira el recorrido del vehículo que viaja al campo',
                    'path' => '/home',
                ];
                $this->notificationsService->sendToUser($us, $notificationData);
                }
        }
        
        return redirect()->route('viaje.index')->with('status_success', 'Viaje compartido con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\viaje  $viaje
     * @return \Illuminate\Http\Response
     */
    public function show(viaje $viaje)
    {
        //
        Gate::authorize('haveaccess','viaje.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('viaje.index');
        $horaactual = Carbon::now();
        $horalimite = $viaje->created_at;
        $horalimite = $horalimite->addMinute($viaje->minutos);
        if($horaactual < $horalimite){
            $aux = "conceder";
        } else{
            $aux = "restringir";
        }
        return view('viaje.view', compact('viaje','rutavolver','aux'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\viaje  $viaje
     * @return \Illuminate\Http\Response
     */
    public function edit(viaje $viaje)
    {
        //
        Gate::authorize('haveaccess','viaje.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Viajes a campo']);
        $rutavolver = route('viaje.index');
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $vehiculos = Vehiculo::orderBy('nombre','asc')->get();
        $usuario = User::join('viaje_users','users.id','=','viaje_users.id_user')
                        ->where('viaje_users.id_viaje',$viaje->id)->first();
        $organizacionjd = Organizacion::where('id',$usuario->CodiOrga)->first();
        $usuariosjd = User::where('CodiOrga',$organizacionjd->id)->get();
        $users_selected = User::select('users.id','users.name','users.last_name')
                            ->join('viaje_users','users.id','=','viaje_users.id_user')
                            ->where('viaje_users.id_viaje',$viaje->id)->get();
        $vehiculos = Vehiculo::orderBy('nombre','asc')->get();
        return view('viaje.edit', compact('viaje','rutavolver','organizaciones','vehiculos','organizacionjd','usuariosjd',
                                            'users_selected','vehiculos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\viaje  $viaje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, viaje $viaje)
    {
        //
        Gate::authorize('haveaccess','viaje.edit');
        request()->validate([
            'id_user' => 'required',
            'id_vehiculo' => 'required',
            'minutos' => 'required'
        ]);

        $viaje_users = Viaje_user::where('id_viaje',$viaje->id)->get();

        //Guardo los resultaados en un array en caso que se obtenga algo
        $i=0;
        foreach ($viaje_users as $viaje_us){
            $cal[$i] = $viaje_us->id_user;
            $i++;
        }

        $users_select = $request->id_user;

        // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
        if (isset($users_select)) {
            foreach ($viaje_users as $viaje_user){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                if (!in_array($viaje_user->id_user, $users_select)) {
                    $viaje_user->delete();
                }
            }

            // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
            // lo REGISTRA
            foreach ($users_select as $user_select){
                if (!isset($cal)) {
                    $viaje_insert = Viaje_user::create(['id_user' => $user_select, 'id_viaje' => $viaje->id]);

                    $notificationData = [
                        'title' => 'SALA - Técnico en camino',
                        'body' => 'Mira el recorrido del vehículo que viaja al campo',
                        'path' => '/home',
                    ];
                    $this->notificationsService->sendToUser($user_select, $notificationData);
                }else{
                    if (!in_array($user_select, $cal)) {
                        $viaje_insert = Viaje_user::create(['id_user' => $user_select, 'id_viaje' => $viaje->id]);

                        $notificationData = [
                            'title' => 'SALA - Técnico en camino',
                            'body' => 'Mira el recorrido del vehículo que viaja al campo',
                            'path' => '/home',
                        ];
                        $this->notificationsService->sendToUser($user_select, $notificationData);
                    }
                }
            }
        }

        $viaje->update($request->all());
        return redirect()->route('viaje.index')->with('status_success', 'Viaje modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\viaje  $viaje
     * @return \Illuminate\Http\Response
     */
    public function destroy(viaje $viaje)
    {
        //
        Gate::authorize('haveaccess','viaje.destroy');
        $viaje_users = Viaje_user::where('id_viaje',$viaje->id)->get();
        foreach ($viaje_users as $viaje_user) {
            $viaje_user->delete();
        }
        $viaje->delete();
        return redirect()->route('viaje.index')->with('status_success', 'Viaje eliminado con exito');
    }
}
