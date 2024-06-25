@php 
    use App\users_proyecto; 
    use App\ticket; 
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de proyectos
                    @can('haveaccess','proyecto.create')
                        <a href="{{ route('proyecto.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
                    </h2>
                    @if(($vista=="SALA App/API") OR ($vista==""))
                        <form name="formulario1">
                            <input type="hidden" name="soluciones" value="Soluciones Integrales">
                        </form>
                        <b>SALA App/API / </b>
                        <a href="javascript:enviar_formulario1()" title="Ver proyectos de Soluciones Integrales">Soluciones Integrales</a>
                    @elseif($vista=="Soluciones Integrales")
                        <a href="{{ route('proyecto.index') }}" title="Ver sproyectos de App de Sala Hnos">SALA App/API</a>
                        <b> / Soluciones Integrales</b>
                    @endif
                </div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('proyecto.gestion') }}" class="btn btn-primary btn-block"><b>Gestión proyectos</b></a>
                    </div>
                </div>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Título</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Inicio estimado</th>
                            <th scope="col">Finalización estimada</th>
                            <th scope="col">Horas estimadas</th>
                            <th scope="col">Inicio</th>
                            <th scope="col">Uúltima fecha</th>
                            <th scope="col">Horas de ejecución</th>
                            <th scope="col">Presupuesto</th>
                            <th scope="col">Responsables</th>
                            <th scope="col">Avance</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($proyectos as $proyecto)
                        @php
                                $responsables = Users_proyecto::select('users.name','users.last_name')
                                                                ->join('users','users_proyectos.id_user','=','users.id')
                                                                ->where('id_proyecto',$proyecto->id)->get();
                                
                                $fecha_inicio = Ticket::select('detalle_tickets.fecha_inicio')
                                                    ->join('detalle_tickets','tickets.id','=','detalle_tickets.id_ticket')
                                                    ->where('tickets.id_proyecto', $proyecto->id)
                                                    ->orderBy('detalle_tickets.fecha_inicio','ASC')
                                                    ->first();
                                $fecha_fin = Ticket::select('detalle_tickets.fecha_fin')
                                                    ->join('detalle_tickets','tickets.id','=','detalle_tickets.id_ticket')
                                                    ->where('tickets.id_proyecto', $proyecto->id)
                                                    ->orderBy('detalle_tickets.fecha_fin','DESC')
                                                    ->first();
                                $tiempo = Ticket::join('detalle_tickets','tickets.id','=','detalle_tickets.id_ticket')
                                                    ->where('tickets.id_proyecto', $proyecto->id)
                                                    ->orderBy('detalle_tickets.fecha_fin','DESC')
                                                    ->sum('detalle_tickets.tiempo');
                                $tiempo_horas = $tiempo / 60;
                                if(isset($proyecto->horas) AND ($tiempo_horas > 0) AND ($proyecto->estado == "")){
                                    $avance = $tiempo_horas / $proyecto->horas * 100;
                                }else{
                                    $avance = $proyecto->estado;
                                }

                            @endphp
                            @can('haveaccess','proyecto.show')
                                <tr href="{{ route('proyecto.show',$proyecto->id) }}">
                            @else
                                <tr>
                            @endcan
                            <th scope="row">{{ $proyecto->id }}</th>
                            <th scope="row">{{ $proyecto->titulo }}</th>
                            <th scope="row">{{ $proyecto->descripcion }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($proyecto->inicio)) }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($proyecto->finalizacion)) }}</th>
                            <th scope="row">{{ $proyecto->horas }} hs</th>
                            <th scope="row">
                                @isset($fecha_inicio)
                                    {{ date('d/m/Y',strtotime($fecha_inicio->fecha_inicio)) }}
                                @endisset
                            </th>
                            <th scope="row">
                                @isset($fecha_fin)
                                    {{ date('d/m/Y',strtotime($fecha_fin->fecha_fin)) }}
                                @endisset
                            </th>
                            <th scope="row">
                                @isset($tiempo_horas)
                                    {{ number_format($tiempo_horas,1) }} hs
                                @endisset
                            </th>
                            <th scope="row">US$ {{ $proyecto->presupuesto }}</th>
                            <th scope="row">
                            @foreach($responsables as $responsable)
                                 {{ $responsable->name }} {{ $responsable->last_name }}, 
                            @endforeach
                            </th>
                            <th scope="row">
                                <div class="progress">
                                    @if($avance >= 100)
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:{{ $avance }}%"></div>
                                    @else
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width:{{ $avance }}%"></div>
                                    @endif
                                </div>
                            </th>
                             @can('haveaccess','proyecto.show')
                            <th><a href="{{ route('proyecto.show',$proyecto->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {!! $proyectos->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
function enviar_formulario1(){
            document.formulario1.submit()
        }
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
