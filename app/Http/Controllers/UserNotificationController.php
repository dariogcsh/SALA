<?php

namespace App\Http\Controllers;

use App\user_notification;
use App\organizacion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;
use App\interaccion;

class UserNotificationController extends Controller
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
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Notificaciones']);
        $user_id = auth()->id();
        $notifications = user_notification::where('id_user',$user_id)
                        ->orderBy('id','desc')
                        ->paginate(10);
        $notiupdate = user_notification::where('id_user', $user_id)->update(['estado'=> '0']);
        return view('user_notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','user_notification.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Notificaciones']);
        $organizaciones = Organizacion::orderBy('NombOrga','ASC')->get();
        $usuarios = User::select('users.id','organizacions.NombOrga','users.name','users.last_name')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->whereNotNull('users.TokenNotificacion')
                        ->orderBy('last_name','ASC')
                        ->get();

                        $rutavolver = url()->previous();
        return view('user_notification.create', compact('organizaciones','usuarios','rutavolver'));
    }

    //Funcion cuando selecciona forma de envio interna o externa en Select
    public function cboDestinatario(Request $request){
        $output = '<option value="">Seleccionar</option>';
        $output .='<option value="todos">Todos</option>';
        $output .='<option value="usuario">Un usuario</option>';
        $destino = $request->get('destino');
        if($destino == "externo"){
            $output .='<option value="organizacion">Una organización</option>';
            $output .='<option value="segmento">Una selección parcial</option>';
        }
        echo $output;
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
            'body' => 'required',
            'path' => 'required',
        ]);
        $body = $request->get('body');
        $path = $request->get('path');
        $tipoenvio = $request->get('tipoenvio');
        $destinatario = $request->get('destinatario');
        $usuario = $request->get('id_user');
        $organizacion = $request->get('CodiOrga');
        $segmento = $request->get('segmento');

        if ($destinatario == "externo"){
            if ($tipoenvio == "todos"){
                $usersends = User::select('users.id')
                                ->whereNotNull('tokenNotificacion')
                                ->get();
            } elseif (($tipoenvio == "usuario") AND ($usuario <> "")){
                $usersends = User::select('users.id')
                                ->where([['users.id',$usuario], ['users.TokenNotificacion','<>','']])
                                ->get();
            }
                elseif (($tipoenvio == "organizacion") AND ($organizacion <> "")){
                    $usersends = User::select('users.id')
                                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                    ->where([['organizacions.id',$organizacion], ['users.TokenNotificacion','<>','']])
                                    ->get();
                }
                elseif (($tipoenvio == "segmento") AND ($segmento <> "")){
                    if($segmento == "monitoreo"){
                        $usersends = User::select('users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->where([['organizacions.InscOrga','SI'], ['users.TokenNotificacion','<>','']])
                                        ->get();
                    } elseif($segmento == "cosechadoras"){
                        $usersends = User::select('users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                        ->where([['maquinas.TipoMaq','COSECHADORA'], ['users.TokenNotificacion','<>','']])
                                        ->get();
                    } elseif($segmento == "tractores"){
                        $usersends = User::select('users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['users.TokenNotificacion','<>','']])
                                        ->get();
                    } elseif($segmento == "pulverizadoras"){
                        $usersends = User::select('users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                        ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['users.TokenNotificacion','<>','']])
                                        ->get();
                    } elseif($segmento == "S700"){
                        $usersends = User::select('users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                        ->where([['maquinas.ModeMaq','S760'], ['users.TokenNotificacion','<>','']])
                                        ->orwhere([['maquinas.ModeMaq','S770'], ['users.TokenNotificacion','<>','']])
                                        ->orwhere([['maquinas.ModeMaq','S780'], ['users.TokenNotificacion','<>','']])
                                        ->orwhere([['maquinas.ModeMaq','S790'], ['users.TokenNotificacion','<>','']])
                                        ->get();
                    } elseif($segmento == "S600"){
                        $usersends = User::select('users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                        ->where([['maquinas.ModeMaq','S660'], ['users.TokenNotificacion','<>','']])
                                        ->orwhere([['maquinas.ModeMaq','S670'], ['users.TokenNotificacion','<>','']])
                                        ->orwhere([['maquinas.ModeMaq','S680'], ['users.TokenNotificacion','<>','']])
                                        ->orwhere([['maquinas.ModeMaq','S690'], ['users.TokenNotificacion','<>','']])
                                        ->get();
                    } elseif($segmento == "pla"){
                        $usersends = User::select('users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->join('maquinas','organizacions.id','=','maquinas.CodiOrga')
                                        ->where([['maquinas.MarcMaq','PLA'], ['users.TokenNotificacion','<>','']])
                                        ->get();
                    } elseif ($segmento == "sinmonitoreo"){
                        $usersends = User::select('users.id')
                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                        ->where([['organizacions.InscOrga','NO'], ['users.TokenNotificacion','<>','']])
                                        ->get();
                    } 

                } 
            
        } elseif($destinatario == "interno"){
            if($tipoenvio == "todos"){
                $usersends = User::select('users.id')
                                ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                ->where([['organizacions.NombOrga','Sala Hnos'], ['users.TokenNotificacion','<>','']])
                                ->orderBy('users.id','ASC')
                                ->get();
            } elseif (($tipoenvio == "usuario") AND ($usuario <> "")){
                $usersends = User::select('users.id')
                                ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                ->where([['users.id',$usuario], ['organizacions.NombOrga','Sala Hnos'], ['users.TokenNotificacion','<>','']])
                                ->get();
            } 
        } 
        if ($path == "Personalizado"){
            $path = $request->get('link_vista');
        }
        if(isset($usersends)){
            //Envio de notificacion 
            foreach($usersends as $usersend){
                $notificationData = [
                    'title' => 'SALA',
                    'body' => $body,
                    'path' => $path,
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
            //$this->notificationsService->sendToUser(auth()->id(),$notificationData);
            return redirect()->route('user_notification.index')->with('status_success', 'Notificación enviada con éxito');
        } else {
            return redirect()->route('user_notification.index')->with('status_danger', 'No se pudo enviar la notificación');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user_notification  $user_notification
     * @return \Illuminate\Http\Response
     */
    public function show(user_notification $user_notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user_notification  $user_notification
     * @return \Illuminate\Http\Response
     */
    public function edit(user_notification $user_notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user_notification  $user_notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user_notification $user_notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user_notification  $user_notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(user_notification $user_notification)
    {
        //
    }
}
