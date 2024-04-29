@php
    use App\detalle_ticket;
    use Illuminate\Support\Facades\DB;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de tickets 
                @can('haveaccess','ticket.create')
                    <a href="{{ route('ticket.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('detalle_ticket.index') }}" class="btn btn-primary btn-block"><b>Gestión de la información CSC</b></a>
                    </div>
                    <br><br>
                    <div class="col-md-3">
                        <a href="{{ route('detalle_ticket.analyst') }}" class="btn btn-primary btn-block"><b>Gestión de la información SALA</b></a><br><br>
                    </div>
                </div>

                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="organizacions.NombOrga">Organización</option>
                                    <option value="users.last_name">Apellido de usuario</option>
                                    <option value="users.name">Nombre de usuario</option>
                                    <option value="servicioscscs.nombre">Tipo de servicio CSC</option>
                                </select>
                                <input class="form-control py-2" type="text" placeholder="Buscar" name="buscarpor">
                                <span class="input-group-append">
                                    <button class="btn btn-warning" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                    @endif
                    @if ($filtro=="SI")
                        <a class="btn btn-secondary float-right" href="{{ route('ticket.index') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                    <br>
                    <br>

                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Organizacion</th>
                                <th scope="col">Servicio</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Participantes</th>
                                <th scope="col">Tiempo (minutos)</th>
                                <th colspan=3></th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        @can('haveaccess','ticket.show')
                                        <tr href="{{ route('ticket.show',$ticket->id) }}">
                                        @else
                                        <tr>
                                        @endcan
                                        <th scope="row">{{ $ticket->id }}</th>
                                        <th scope="row">{{ $ticket->NombOrga }}</th>
                                        @if($ticket->nombre == "Otro")
                                            <th scope="row">Otro - {{ $ticket->nombreservicio }}</th>
                                        @else
                                            <th scope="row">{{ $ticket->nombre }}</th>
                                        @endif
                                        @php
                                            $usuarios = Detalle_ticket::join('users','detalle_tickets.id_user','=','users.id')
                                                                        ->where('detalle_tickets.id_ticket',$ticket->id)
                                                                        ->groupBy('users.id')->get();
                                            $estado_ticket = Detalle_ticket::where([['fecha_fin',NULL], ['id_ticket',$ticket->id]])->first();
                                            $tiempo_total = DB::table('detalle_tickets')
                                                            ->selectRaw('SUM(detalle_tickets.tiempo) as time')
                                                            ->where('id_ticket',$ticket->id)->first();
                                        @endphp
                                        @isset($estado_ticket)
                                            @php
                                                $estado = 'En ejecución';
                                            @endphp
                                        @else
                                            @php
                                                $estado = $ticket->estado;
                                            @endphp
                                        @endisset
                                        @if($estado == "Abierto")
                                            <th scope="row" style="color:red">{{ $estado }}</th>
                                        @elseif($estado == "En ejecución")
                                            <th scope="row" style="color:darkorange">{{ $estado }}</th>
                                        @else
                                            <th scope="row">{{ $estado }}</th>
                                        @endif
                                        <th scope="row">
                                            @foreach($usuarios as $usuario)
                                                {{ $usuario->name }} {{ $usuario->last_name }} - 
                                            @endforeach
                                        </th>
                                        @isset($tiempo_total)
                                            <th scope="row">{{ $tiempo_total->time }}</th>
                                        @else
                                            <th scope="row"></th>
                                        @endisset
                                        @can('haveaccess','ticket.show')
                                            <th><a href="{{ route('ticket.show',$ticket->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                                        @endcan
                                        </tr>
                                    @endforeach

                                    @if($tickets_c <> "")
                                        @foreach ($tickets_c as $ticket)
                                            @can('haveaccess','ticket.show')
                                                <tr href="{{ route('ticket.show',$ticket->id) }}">
                                            @else
                                                <tr>
                                            @endcan
                                            <th scope="row">{{ $ticket->id }}</th>
                                            <th scope="row">{{ $ticket->NombOrga }}</th>
                                            @if($ticket->nombre == "Otro")
                                                <th scope="row">Otro - {{ $ticket->nombreservicio }}</th>
                                            @else
                                                <th scope="row">{{ $ticket->nombre }}</th>
                                            @endif
                                            @php
                                                $usuarios = Detalle_ticket::join('users','detalle_tickets.id_user','=','users.id')
                                                                            ->where('detalle_tickets.id_ticket',$ticket->id)
                                                                            ->groupBy('users.id')->get();
                                            
                                                $tiempo_total = DB::table('detalle_tickets')
                                                                ->selectRaw('SUM(detalle_tickets.tiempo) as time')
                                                                ->where('id_ticket',$ticket->id)->first();
                                            @endphp
                                            <th scope="row">{{ $ticket->estado }}</th>
                                            <th scope="row">
                                                @foreach($usuarios as $usuario)
                                                    {{ $usuario->name }} {{ $usuario->last_name }} - 
                                                @endforeach
                                            </th>
                                            @isset($tiempo_total)
                                                <th scope="row">{{ $tiempo_total->time }}</th>
                                            @else
                                                <th scope="row"></th>
                                            @endisset
                                            @can('haveaccess','ticket.show')
                                                <th><a href="{{ route('ticket.show',$ticket->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                                            @endcan
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            @if($tickets_c <> "")
                                {!! $tickets_c->links() !!}
                            @else
                                {!! $tickets->links() !!}
                            @endif
                            
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
$(document).ready(function(){
       $('table tr').click(function(){
        if ($(this).attr('href')) {
           window.location = $(this).attr('href');
        }
           return false;
       });
});
</script>
@endsection
