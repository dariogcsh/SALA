<?php

namespace App\Http\Controllers;

use App\ticket;
use App\organizacion;
use App\contacto;
use App\servicioscsc;
use App\detalle_ticket;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\interaccion;

class TicketController extends Controller
{
      /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','ticket.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('internosoluciones');
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $tickets = Ticket::Buscar($tipo, $busqueda)->groupBy('tickets.id')->paginate(20)->appends($variablesurl);
            $filtro = "SI";
            $tickets_c ="";
        } else{
            
            $tickets = Ticket::select('servicioscscs.nombre','tickets.id','organizacions.NombOrga','tickets.nombreservicio',
                                        'tickets.estado')
                            ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                            ->join('servicioscscs','tickets.id_servicioscsc','=','servicioscscs.id')
                            ->orderBy('tickets.id','desc')
                            ->where('tickets.estado','<>','Cerrado')
                            ->paginate(9999);
                            
            $tickets_c = Ticket::select('servicioscscs.nombre','tickets.id','organizacions.NombOrga','tickets.nombreservicio',
                                        'tickets.estado')
                            ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                            ->join('servicioscscs','tickets.id_servicioscsc','=','servicioscscs.id')
                            ->orderBy('tickets.id','desc')
                            ->where('tickets.estado','Cerrado')
                            ->orWhere('tickets.estado',NULL)
                            ->paginate(20);
        }
        return view('ticket.index', compact('tickets','rutavolver','tickets_c','filtro','busqueda'));
    }

    public function cerrar_ticket($id)
    {
        $id_ticket = $id;
        $ticket_d = Ticket::where('id',$id_ticket)->first();

        $ticket_d->update(['estado' => 'Cerrado']);

        return redirect()->route('ticket.index')->with('status_success', 'Ticket cerrado con exito');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','ticket.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('ticket.index');
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $servicioscscs = Servicioscsc::orderBy('nombre','asc')->get();
        return view('ticket.create',compact('rutavolver','organizaciones','servicioscscs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->id_servicioscsc == "Otro"){
            if ($request->nombreservicio == '') {
                request()->validate([
                    'nombreservicio' => 'required',
                ]);
            }else{
                $id_otro = Servicioscsc::where('nombre',$request->id_servicioscsc)->first();
                $request->request->add(['id_servicioscsc' => $id_otro->id]);
            }
        }
        $request->request->add(['estado' => 'Abierto']);

        $tickets = Ticket::create($request->all());

        //Inserto en contacto con el cliente en caso afirmativo
        if ($request->contactos){
            $id_user = auth()->id();
            $organizacion = $request->get('id_organizacion');
            $contacto = Contacto::create(['id_user'=>$id_user, 'id_organizacion'=>$organizacion, 'persona'=>'Sin detallar',
                                        'tipo'=>'Ticket CSC', 'departamento'=>'Centro de Soluciones Conectadas',
                                        'comentarios'=>$tickets->id]);
        }

        return redirect()->route('ticket.index')->with('status_success', 'Ticket creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(ticket $ticket)
    {
        //
        Gate::authorize('haveaccess','ticket.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('ticket.index');
        $show_t = Ticket::select('servicioscscs.nombre','tickets.id','organizacions.NombOrga','tickets.nombreservicio')
                        ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                        ->join('servicioscscs','tickets.id_servicioscsc','=','servicioscscs.id')
                        ->where('tickets.id',$ticket->id)
                        ->orderBy('tickets.id','desc')->first();
        $servicioscscs = Detalle_ticket::select('detalle_tickets.id','detalle_tickets.fecha_inicio',
                                                'detalle_tickets.fecha_fin','detalle_tickets.detalle',
                                                'detalle_tickets.tiempo','users.name','users.last_name', 'detalle_tickets.id_ticket')
                                        ->join('users','detalle_tickets.id_user','=','users.id')
                                        ->where('id_ticket',$ticket->id)->orderBy('detalle_tickets.id','desc')->paginate(15);
        $tarea_inconclusa = Detalle_ticket::select('detalle_tickets.id')
                                        ->join('users','detalle_tickets.id_user','=','users.id')
                                        ->where([['users.id', auth()->id()], ['detalle_tickets.id_ticket',$ticket->id], 
                                                ['detalle_tickets.tiempo',NULL]])->first();

        $tarea_inconclusa_2 = Detalle_ticket::select('detalle_tickets.id')
                                                ->join('users','detalle_tickets.id_user','=','users.id')
                                                ->where([['detalle_tickets.id_ticket',$ticket->id], 
                                                        ['detalle_tickets.tiempo',NULL]])->first();

        return view('ticket.view', compact('ticket','rutavolver','show_t','servicioscscs','tarea_inconclusa','tarea_inconclusa_2'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(ticket $ticket)
    {
        //
        Gate::authorize('haveaccess','ticket.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('ticket.index');
        $show_t = Ticket::select('organizacions.NombOrga', 'servicioscscs.nombre')
                        ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                        ->join('servicioscscs','tickets.id_servicioscsc','=','servicioscscs.id')
                        ->where('tickets.id', $ticket->id)->first();
        return view('ticket.edit', compact('ticket','rutavolver','show_t'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ticket $ticket)
    {
        //
        Gate::authorize('haveaccess','ticket.edit');
        $detalle = $request->get('servicioscsc');

        $ticket->update(['nombreservicio' => $detalle]);
        return redirect()->route('ticket.index')->with('status_success', 'Ticket modificado con exito');
    }

    public function finalizar_ticket($id)
    {
        $id_ticket = $id;
        $ticket_d = Ticket::where('id',$id_ticket)->first();
        $ticket_d->update(['estado' => 'Cerrado']);

        return redirect()->route('ticket.show',$ticket_d->id_ticket)->with('status_success', 'La tarea se finalizó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(ticket $ticket)
    {
        //
        Gate::authorize('haveaccess','ticket.destroy');
        $detalle_tickets = Detalle_ticket::where('id_ticket',$ticket->id)->get();
        foreach ($detalle_tickets as $detalle_ticket) {
            $detalle_ticket->delete();
        }
        $ticket->delete();
        return redirect()->route('ticket.index')->with('status_success', 'Ticket eliminado con exito');
    }
}