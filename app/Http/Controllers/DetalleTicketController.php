<?php

namespace App\Http\Controllers;

use App\detalle_ticket;
use App\ticket;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DetalleTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       //
       Gate::authorize('haveaccess','ticket.index');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
       $rutavolver = route('ticket.index');
       $filtro="";
        $busqueda="";
        if (($request->fecha_inicio) AND ($request->fecha_fin)) {
            $hasta = $request->fecha_fin;
            $desde = $request->fecha_inicio;
            $busqueda = $desde.' - '.$hasta;
        } else{
            $fecha_h = Carbon::today();
            $hasta = $fecha_h->format('Y-m-d');
            $fecha_d = $fecha_h->subDays(5);
            $desde = $fecha_d->format('Y-m-d');
        }

       $ranking_servicios = DB::table('detalle_tickets')
                            ->selectRaw('SUM(detalle_tickets.tiempo) as time, servicioscscs.nombre')
                            ->join('tickets','detalle_tickets.id_ticket','=','tickets.id')
                            ->join('servicioscscs','tickets.id_servicioscsc','=','servicioscscs.id')
                            ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                            ->groupBy('servicioscscs.nombre')
                            ->orderBy('time','DESC')
                            ->where([['detalle_tickets.fecha_inicio','>=',$desde.' 00:00:01'], ['detalle_tickets.fecha_fin','<=',$hasta.' 23:59:59'],
                            ['organizacions.NombOrga','<>','Sala Hnos']])
                            ->get();
        
        $ranking_organizaciones = DB::table('detalle_tickets')
                            ->selectRaw('SUM(detalle_tickets.tiempo) as time, organizacions.NombOrga')
                            ->join('tickets','detalle_tickets.id_ticket','=','tickets.id')
                            ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                            ->groupBy('organizacions.NombOrga')
                            ->orderBy('time','DESC')
                            ->where([['detalle_tickets.fecha_inicio','>=',$desde.' 00:00:01'], ['detalle_tickets.fecha_fin','<=',$hasta.' 23:59:59'],
                            ['organizacions.NombOrga','<>','Sala Hnos']])
                            ->get();
                            
        $ranking_sucursales = DB::table('detalle_tickets')
                            ->selectRaw('SUM(detalle_tickets.tiempo) as time, sucursals.NombSucu')
                            ->join('tickets','detalle_tickets.id_ticket','=','tickets.id')
                            ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->orderBy('time','DESC')
                            ->where([['detalle_tickets.fecha_inicio','>=',$desde.' 00:00:01'], ['detalle_tickets.fecha_fin','<=',$hasta.' 23:59:59'],
                                    ['organizacions.NombOrga','<>','Sala Hnos']])
                            ->get();
                            
       $detalle_tickets = Detalle_ticket::orderBy('id','desc')->paginate(20);
       return view('detalle_ticket.index', compact('detalle_tickets','rutavolver','desde','hasta','ranking_servicios',
                                                    'ranking_organizaciones','ranking_sucursales','filtro'));
    }

    public function analyst(Request $request)
    {
       //
       Gate::authorize('haveaccess','ticket.index');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
       $rutavolver = route('ticket.index');
       $filtro="";
        $busqueda="";
        if (($request->fecha_inicio) AND ($request->fecha_fin)) {
            $hasta = $request->fecha_fin;
            $desde = $request->fecha_inicio;
            $busqueda = $desde.' - '.$hasta;
        } else{
            $fecha_h = Carbon::today();
            $hasta = $fecha_h->format('Y-m-d');
            $fecha_d = $fecha_h->subDays(5);
            $desde = $fecha_d->format('Y-m-d');
        }

       $ranking_servicios = DB::table('detalle_tickets')
                            ->selectRaw('SUM(detalle_tickets.tiempo) as time, servicioscscs.nombre')
                            ->join('tickets','detalle_tickets.id_ticket','=','tickets.id')
                            ->join('servicioscscs','tickets.id_servicioscsc','=','servicioscscs.id')
                            ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                            ->groupBy('servicioscscs.nombre')
                            ->orderBy('time','DESC')
                            ->where([['detalle_tickets.fecha_inicio','>=',$desde.' 00:00:01'], ['detalle_tickets.fecha_fin','<=',$hasta.' 23:59:59'],
                            ['organizacions.NombOrga','Sala Hnos']])
                            ->get();

        $ranking_organizaciones = DB::table('detalle_tickets')
                            ->selectRaw('SUM(detalle_tickets.tiempo) as time, organizacions.NombOrga')
                            ->join('tickets','detalle_tickets.id_ticket','=','tickets.id')
                            ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                            ->groupBy('organizacions.NombOrga')
                            ->orderBy('time','DESC')
                            ->where([['detalle_tickets.fecha_inicio','>=',$desde.' 00:00:01'], ['detalle_tickets.fecha_fin','<=',$hasta.' 23:59:59'],
                            ['organizacions.NombOrga','Sala Hnos']])
                            ->get();

        $ranking_sucursales = DB::table('detalle_tickets')
                            ->selectRaw('SUM(detalle_tickets.tiempo) as time, sucursals.NombSucu')
                            ->join('tickets','detalle_tickets.id_ticket','=','tickets.id')
                            ->join('organizacions','tickets.id_organizacion','=','organizacions.id')
                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                            ->groupBy('sucursals.NombSucu')
                            ->orderBy('time','DESC')
                            ->where([['detalle_tickets.fecha_inicio','>=',$desde.' 00:00:01'], ['detalle_tickets.fecha_fin','<=',$hasta.' 23:59:59'],
                                    ['organizacions.NombOrga','Sala Hnos']])
                            ->get();

       $detalle_tickets = Detalle_ticket::orderBy('id','desc')->paginate(20);
       return view('detalle_ticket.analyst', compact('detalle_tickets','rutavolver','desde','hasta','ranking_servicios',
                                                    'ranking_organizaciones','ranking_sucursales','filtro'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function nueva_tarea($id)
    {
        $id_ticket = $id;
        $id_user = auth()->id();
        $fecha_inicio = Carbon::now();

        $tarea = Detalle_ticket::create(['id_ticket' => $id_ticket, 'id_user' => $id_user, 'fecha_inicio' => $fecha_inicio]);

        $ticket = Ticket::where('id',$id_ticket)->first();
        $ticket->update(['estado' => 'En ejecución']);

        return redirect()->route('ticket.show',$id_ticket)->with('status_success', 'La nueva tarea se inició correctamente');
    }

    public function finalizar_tarea($id)
    {
        $id_ticket = $id;
        $fecha_fin = Carbon::now();
        $ticket_d = Detalle_ticket::where('id',$id_ticket)->first();
        $fecha_inicio = Carbon::createFromFormat('Y-m-d H:i:s',$ticket_d->fecha_inicio);

        $ticket = Ticket::where('id',$ticket_d->id_ticket)->first();
        $ticket->update(['estado' => 'Abierto']);

        $minutos_transcurridos = $fecha_inicio->diffInMinutes($fecha_fin);
        $ticket_d->update(['tiempo' => $minutos_transcurridos, 'fecha_fin' => $fecha_fin]);

        return redirect()->route('ticket.show',$ticket_d->id_ticket)->with('status_success', 'La tarea se finalizó correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\detalle_ticket  $detalle_ticket
     * @return \Illuminate\Http\Response
     */
    public function show(detalle_ticket $detalle_ticket)
    {
        Gate::authorize('haveaccess','ticket.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
        $rutavolver = route('ticket.show', $detalle_ticket->id_ticket);
        return view('detalle_ticket.view', compact('detalle_ticket','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\detalle_ticket  $detalle_ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(detalle_ticket $detalle_ticket)
    {
         //
         Gate::authorize('haveaccess','ticket.edit');
         Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Ticket']);
         $rutavolver = route('ticket.show',$detalle_ticket->id_ticket);
         return view('detalle_ticket.edit', compact('detalle_ticket','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\detalle_ticket  $detalle_ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, detalle_ticket $detalle_ticket)
    {
        //
        Gate::authorize('haveaccess','ticket.edit');
        $request->validate([
            'fecha_inicio'          => 'required',
            'fecha_fin'          => 'required',
        ]);

        $detalle_ticket->update($request->all());

        $detalle = Detalle_ticket::where('id',$detalle_ticket->id)->first();
        $fecha_inicio = Carbon::createFromFormat('Y-m-d H:i:s',$detalle->fecha_inicio);
        $fecha_fin = Carbon::createFromFormat('Y-m-d H:i:s',$detalle->fecha_fin);
        
        $minutos_transcurridos = $fecha_inicio->diffInMinutes($fecha_fin);

        $detalle_ticket->update(['tiempo' => $minutos_transcurridos]);

        return redirect()->route('ticket.show', $detalle_ticket->id_ticket)->with('status_success', 'Tarea modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\detalle_ticket  $detalle_ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(detalle_ticket $detalle_ticket)
    {
        Gate::authorize('haveaccess','ticket.destroy');
        $detalle_ticket->delete();
        return redirect()->route('ticket.show',$detalle_ticket->id_ticket)->with('status_success', 'Tarea eliminada con exito');
    }
}
