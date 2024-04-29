@php 
use App\planservicio; 
use App\maquina;
@endphp

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Planificación semanal
                    @can('haveaccess','tarea.create')
                        <a href="{{ route('tarea.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                    <div class="form-group col-md-2">
                        <h5><u>Sucursal</u></h5>
                        <form name="formulario1">
                            <select name="sucursal" id="sucursal" class="form-control" onchange="javascript:enviar_formulario1()">
                                <option value="Todas las sucursales">Todas las sucursales</option>
                                @isset ($sucursal)
                                    <option value="{{ $sucursal }}" selected>{{ $sucursal }}</option>
                                @else
                                    @php
                                        $sucursal="";
                                    @endphp
                                @endisset
                                @foreach($sucursales as $sucu)
                                    @if($sucu->NombSucu <> $sucursal)
                                        <option value="{{ $sucu->NombSucu }}">{{ $sucu->NombSucu }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-2">
                        <a href="{{ route('tarea.itecnicos') }}" class="btn btn-dark btn-block"><b>Detalle semanal</b></a>
                    </div>
                        <br>
                        <br>
                    <div class="col-md-2">
                        <a href="{{ route('tarea.index') }}" class="btn btn-warning btn-block"><b>T1 Aministrativo</b></a>
                    </div>
                        <br>
                        <br>
                    <div class="col-md-2">
                        <a href="{{ route('tarea.progreso') }}" class="btn btn-warning btn-block"><b>T2 Técnicos</b></a>
                    </div>
                        <br>
                        <br>
                    <div class="col-md-2">
                        <a href="{{ route('tarea.ihistorial') }}" class="btn btn-success btn-block"><b>T3 Finalizados</b></a>
                    </div>
                </div>
                <br>
                <br>
                @php
                    $domingo=99;
                @endphp
                <div class="table-responsive-md">
                    <table class="table table-striped table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Tecnicos</th>
                                @for($i = 0; $i < 3; $i++)
                                    @php 
                                    $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
                                    $dia = $dias[(date('N', strtotime($hoy[$i]))) - 1];
                                    @endphp
                                    @if($dia <> "Domingo")
                                        <th scope="col">{{ $dia }} {{ date('d', strtotime($hoy[$i])) }}</th>
                                    @else
                                        @php
                                            $domingo = $i;
                                        @endphp
                                    @endif
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tecnicos as $tecnico)
                            <tr>
                            <th scope="row">{{ $tecnico->name[0] }}. {{ $tecnico->last_name }}</th>
                            @for($i = 0; $i < 3; $i++)
                                @php  
                                    if ($i==$domingo) {
                                        $i++;
                                    }
                                    $tareas = Planservicio::select('organizacions.NombOrga','maquinas.ModeMaq','tareas.ubicacion'
                                                                ,'tareas.turno','tareas.ncor')
                                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                        ->where([['planservicios.id_user',$tecnico->id],['tareas.fechaplan',$hoy[$i]], 
                                                                ['tareas.estado','Programado']])
                                                        ->get();
                                @endphp
                                @isset($tareas)
                                <th scope="row">
                                        @foreach($tareas as $tarea)
                                            {{ $tarea->NombOrga }} | {{ $tarea->ModeMaq }} | {{ $tarea->ubicacion }} |  
                                                @if($tarea->turno == "Mañana")
                                                    M | 
                                                @elseif($tarea->turno == "Tarde")
                                                    T | 
                                                @else
                                                    M-T | 
                                                @endif
                                                COR: {{ $tarea->ncor }} //
                                        @endforeach
                                </th>
                                @else
                                    <th scope="row"></th>
                                @endisset
                            @endfor
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
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
