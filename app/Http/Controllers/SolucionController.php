<?php

namespace App\Http\Controllers;

use App\solucion;
use App\asist;
use App\sucursal;
use App\user;
use App\organizacion;
use App\interaccion;
use App\guardiasadmin;
use App\Services\NotificationsService;
use Illuminate\Http\Request;
use Carbon\Carbon;


class SolucionController extends Controller
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
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Estanteria de soluciones']);
        return view('solucion.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(solucion $solucion)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, asist $asist)
    {
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        
        //Se comprueba si hoy es un dia de Guardia para administrativo
        $hoy = Carbon::today();
        $guardia = Guardiasadmin::where('fecha',$hoy)->first();

        //Revisa si tiene algun archivo que se adjunto
        if($request->hasFile("adjunto1")){
            $id_asist = $request->get('id_asist');
            $imagen = $request->file('adjunto1');
            $nombre = $organizacion->NombOrga.'-'.time().'.'.$imagen->getClientOriginalExtension();
            $destino = public_path('/img/asistencias/');
            $request->adjunto1->move($destino, $nombre);
            //$ruta = $destino.$nombre;      En localhost no funciona
            $ruta = $nombre; //En localhost si funciona
            $solucion = Solucion::create(['id_user' => auth()->id(), 'id_asist' =>$id_asist, 'tipo' => 'file', 'ruta' => $ruta]);
        } else {
            request()->validate([
                'DescSolu'  => 'required',
                'id_asist'   => 'required',
            ]);
        }

        if (($request->DescSolu <> '')){
            $request->request->add(['id_user'=>auth()->id()]);
            $request->request->add(['tipo'=>'texto']);
            $solucion = Solucion::create($request->all());
        } else {
            $request->DescSolu = 'Archivo adjunto';
        }
        //$ultimasolucion = Solucion::orderBy('id','desc')->first();
        
        if ($organizacion->NombOrga == "Sala Hnos"){
            $asistsql = Asist::where('id',$request->id_asist)->first();
            if($asistsql->id_organizacion == ''){
                $usersendorga = Solucion::select('users.CodiOrga')
                                        ->join('asists','solucions.id_asist','=','asists.id')
                                        ->join('users','asists.id_user','=','users.id')
                                        ->where('solucions.id',$solucion->id)
                                        ->first();
            // seleccion de usuarios de organizacion que recibiran la notificacion de respuesta del concesionario
            $usersends = User::where('users.CodiOrga', $usersendorga->CodiOrga)
                            ->get();
            } else {
                $usersends = User::where('users.CodiOrga', $asistsql->id_organizacion)
                                ->get();
            }
            $asist->where('id', $request->id_asist)->update(['EstaAsis'=> 'Respondido','ResuAsis' => 'NO', 'DeReAsis' => '']);
            // Seleccion de usuarios (del concesionario) que van a recibir notificacion de la respuesta que dio el concesionario
            $sucursalid = Sucursal::select('sucursals.id','sucursals.NombSucu')
                        ->join('users','sucursals.id','=','users.CodiSucu')
                        ->join('asists','users.id','=','asists.id_user')
                        ->where('asists.id',$request->id_asist)
                        ->first();

            //Se comprueba si trae algun resultado (quiere decir que si es un dia de guardia)
            if (isset($guardia)) {
                $sucursalguardia = $guardia->id_sucursal;
            } else {
                if ($sucursalid->NombSucu == "Adelia Maria") {
                    $sucursalid = Sucursal::select('sucursals.id')
                                ->where('sucursals.NombSucu','Coronel Moldes')
                                ->first();
                $sucursalguardia = $sucursalid->id;
                }else{
                    $sucursalguardia = $sucursalid->id;
                }
            }

            $matchTheseAdministrativo = [['puesto_empleados.NombPuEm', 'Administrativo de servicio'], ['users.CodiSucu', $sucursalguardia], ['users.id','<>',auth()->user()->id]];
            $matchTheseCoordinador = [['puesto_empleados.NombPuEm', 'Coordinador de servicios'], ['users.CodiSucu', $sucursalguardia], ['users.id','<>',auth()->user()->id]];
            $matchTheseGerente = [['puesto_empleados.NombPuEm', 'Gerente de sucursal'], ['users.CodiSucu', $sucursalid->id], ['users.id','<>',auth()->user()->id]];
            $matchTheseCoordinadorCorp = [['puesto_empleados.NombPuEm', 'Coordinador de servicio corporativo'], ['users.id','<>',auth()->user()->id]];
            $matchAdmin = [['roles.name','Admin'], ['users.id','<>',auth()->user()->id]];
            $usersendsconce = User::select('users.id')
                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                    ->join('role_user','users.id','=','role_user.user_id')
                    ->join('roles','role_user.role_id','=','roles.id')
                    ->orWhere($matchTheseAdministrativo)
                    ->orWhere($matchTheseGerente)
                    ->orWhere($matchTheseCoordinador)
                    ->orWhere($matchTheseCoordinadorCorp)
                    ->orWhere($matchAdmin)
                    ->get();

            $title = $organizacion->NombOrga .' - '. auth()->user()->last_name . ' ' . auth()->user()->name;
            foreach($usersendsconce as $usersendconce){
                $notificationData = [
                    'title' => $title,
                    'body' => $request->DescSolu,
                    'path' => '/asist/'.$request->id_asist.'',
                ];
                $this->notificationsService->sendToUser($usersendconce->id, $notificationData);
            }
            
        } else {
            //obtener sucursal donde pertenece el usuario que solicita la asistencia
            $sucursalid = Sucursal::select('sucursals.id')
                        ->join('users','sucursals.id','=','users.CodiSucu')
                        ->join('asists','users.id','=','asists.id_user')
                        ->where('asists.id',$request->id_asist)
                        ->first();

            //Se comprueba si trae algun resultado (quiere decir que si es un dia de guardia)
            if (isset($guardia)) {
                $sucursalguardia = $guardia->id_sucursal;
            } else {
                $sucursalguardia = $sucursalid->id;
            }

            $matchTheseAdministrativo = [['puesto_empleados.NombPuEm', 'Administrativo de servicio'], ['users.CodiSucu', $sucursalguardia]];
            $matchTheseGerente = [['puesto_empleados.NombPuEm', 'Gerente de sucursal'], ['users.CodiSucu', $sucursalid->id]];
            $matchTheseCoordinador = [['puesto_empleados.NombPuEm', 'Coordinador de servicios']];
            $usersends = User::select('users.id')
                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                    ->join('role_user','users.id','=','role_user.user_id')
                    ->join('roles','role_user.role_id','=','roles.id')
                    ->orWhere($matchTheseAdministrativo)
                    ->orWhere($matchTheseGerente)
                    ->orWhere($matchTheseCoordinador)
                    ->orWhere('roles.name','Admin')
                    ->get();
            $asist->where('id', $request->id_asist)->update(['EstaAsis'=> 'Solicitud','ResuAsis' => 'NO', 'DeReAsis' => '']);
        }
        
        //Envio de notificacion
        $title = $organizacion->NombOrga .' - '. auth()->user()->last_name . ' ' . auth()->user()->name;
        foreach($usersends as $usersend){
            $notificationData = [
                'title' => $title,
                'body' => $request->DescSolu,
                'path' => '/asist/'.$request->id_asist.'',
            ];
            $this->notificationsService->sendToUser($usersend->id, $notificationData);
        }
        
        $dataAsist = Asist::where('id',$request->id_asist)->first();
        return redirect()->route('asist.show', $dataAsist);
        //return redirect()->route('asist.index')->with('status_success', 'Respuesta enviada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\solucion  $solucion
     * @return \Illuminate\Http\Response
     */
    public function show(solucion $solucion)
    {
        return view('solucion.view', compact('solucion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\solucion  $solucion
     * @return \Illuminate\Http\Response
     */
    public function edit(solucion $solucion)
    {
        
    }

    function respauto(Request $request)
    {
        $value = $request->get('value');
        $user = $request->get('user');
        $sucursal = $request->get('sucursal');
        if ($value == '1'){
            $respuesta = "Hola, soy " .auth()->user()->name. " de la sucursal de " .$sucursal.". Ahora estoy comunicándome para asistirlo con su problema o consulta.";
        } elseif ($value == '2'){
            $respuesta = "Estimado " .$user.", le adjuntamos el presupuesto según la asistencia solicitada. Esperamos su aprobación para coordinar un turno o visita a campo.";
        } elseif ($value == '3'){
            $respuesta = "El día “01/01/21 a partir de las 9:30 hs” lo visitará un técnico para realizar las tareas de acuerdo al presupuesto. Esperamos darle la mejor solución y agradecemos su contacto.";
        } elseif ($value == '4'){
            $respuesta = "El día “01/01/21 a partir de las 8:30 hs” recibiremos la unidad en la sucursal de " .$sucursal. " para realizar las tareas de acuerdo al presupuesto. Esperamos darle la mejor solución y agradecemos su contacto.";
        } else {
            $respuesta = "Esperamos ayudarle en una próxima oportunidad y agradecemos su contacto.";
        }
        $result = $respuesta;
        echo $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\solucion  $solucion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, solucion $solucion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\solucion  $solucion
     * @return \Illuminate\Http\Response
     */
    public function destroy(solucion $solucion)
    {
        //
    }
}
