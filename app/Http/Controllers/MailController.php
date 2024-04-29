<?php

namespace App\Http\Controllers;

use App\mail;
use App\organizacion;
use App\User;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('haveaccess','mail.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Notificaciones de monitoreo']);
        $rutavolver = route('internoconfiguracion');
        $filtro="";
        $busqueda="";

        if($request->buscarpor AND $request->tipo){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $mails = Mail::Buscar($tipo, $busqueda)
                                        ->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else {
            $mails = Mail::select('mails.id','organizacions.NombOrga', 'users.last_name', 'users.name','users.email',
                                'mails.TipoMail','mails.TiInMail')
                                ->join('organizacions', 'mails.OrgaMail','=','organizacions.id')
                                ->join('users','mails.UserMail','=','users.id')
                                ->paginate(20);
        }

        return view('mail.index', compact('mails','filtro','busqueda','rutavolver'));         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','mail.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Notificaciones de monitoreo']);
        $organizaciones = Organizacion::orderBy('NombOrga','ASC')->get();
        $usuarios = User::orderBy('last_name','ASC')->get();

        $rutavolver = route('mail.index');
        return view('mail.create', compact('organizaciones','usuarios','rutavolver'));
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
            'OrgaMail' => 'required',
            'UserMail' => 'required',
            'TipoMail' => 'required',
            'TiInMail' => 'required'
        ]);
        $mail = Mail::create($request->all());
        return redirect()->route('mail.index')->with('status_success', 'Relación de envio de email y notificación creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function show(mail $mail)
    {
        Gate::authorize('haveaccess','mail.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Notificaciones de monitoreo']);
        $organizaciones = Organizacion::orderBy('NombOrga','ASC')->get();
        $usuarios = User::orderBy('last_name','ASC')->get();
        $rutavolver = route('mail.index');
        return view('mail.view', compact('organizaciones','usuarios','mail','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(mail $mail)
    {
        Gate::authorize('haveaccess','organizacion.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Notificaciones de monitoreo']);
        $organizaciones = Organizacion::orderBy('NombOrga','ASC')->get();
        $usuarios = User::orderBy('last_name','ASC')->get();
        $rutavolver = route('mail.index');
        return view('mail.edit', compact('organizacion','organizaciones','usuarios','mail','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mail $mail)
    {
        Gate::authorize('haveaccess','mail.edit');
        $request->validate([
            'OrgaMail'   => 'required',
            'UserMail'   => 'required',
            'TipoMail'   => 'required',
            'TiInMail'   => 'required',
        ]);

        $mail->update($request->all());
        return redirect()->route('mail.index')->with('status_success', 'Relación de envio de email y notificación modificada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy(mail $mail)
    {
        Gate::authorize('haveaccess','mail.destroy');
        $mail->delete();
        return redirect()->route('mail.index')->with('status_success', 'Relación de envio de email y notificación eliminada con éxito');
    }
}
