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
                <div class="card-header"><h2>Historial de servicios</h2></div>
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
                        <a href="{{ route('tarea.index') }}" class="btn btn-warning btn-block"><b>Administración</b></a>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-2">
                        <a href="{{ route('tarea.itecnicos') }}" class="btn btn-dark btn-block"><b>Planificación</b></a>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-2">
                        <a href="{{ route('tarea.ihistorial') }}" class="btn btn-success btn-block"><b>T3 Finalizados</b></a>
                    </div>
                </div>
                <br>

                @can('haveaccess','maquina.edit')
                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="organizacions.NombOrga">Organizacion</option>
                                    <option value="nseriemaq">N° de serie</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('tarea.ihistorial') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                @endcan
                <br>
                <br>
                <div class="table-responsive-md">
                    <table class="table table-striped table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Organizacion</th>
                                <th scope="col">Máquina</th>
                                <th scope="col">COR</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tareas as $tarea)
                            @can('haveaccess','tarea.show')
                                <tr href="{{ route('tarea.show',$tarea->id) }}">
                            @else
                                <tr>
                            @endcan
                                <th scope="row">{{  date('d/m/Y',strtotime($tarea->fechaplan)) }}</th>
                                <th scope="row">{{ $tarea->NombSucu }}</th>
                                <th scope="row">{{ $tarea->NombOrga }}</th>
                                <th scope="row">{{ $tarea->ModeMaq }}</th>
                                <th scope="row">{{ $tarea->ncor }}</th>
                                @can('haveaccess','tarea.show')
                                    <th><a href="{{ route('tarea.show',$tarea->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $tareas->links() !!}
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
