@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de alertas
                    @can('haveaccess','alerta.create')
                        <a href="{{ route('alerta.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
                    </h2>
                    @if ($vista=="sucursal")
                        <a href="{{ route('alerta.index') }}" title="Ver solicitudes del concesionario">Concesionario</a>
                        <b> / Sucursal</b>
                    @elseif($vista=="concesionario")
                    <form name="formulario1">
                        <input type="hidden" name="sucu" value="sucursal">
                    </form>
                    <b>Concesionario / </b>
                    <a href="javascript:enviar_formulario1()" title="Ver solicitudes de mi sucursal">Sucursal</a>
                    @endif
                </div>
                <div class="card-body">
                @include('custom.message')
                @can('haveaccess','alerta.gestion')
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('alerta.gestion') }}" class="btn btn-primary btn-block"><b>Estadisticas de alertas</b></a>
                        </div>
                    </div>
                    <br>
                @endcan
                @if($nomborg->NombOrga == 'Sala Hnos')
                    @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="tipo" class="form-control mr-sm-2">
                                        <option value="">Buscar por</option>
                                        <option value="organizacions.NombOrga">Organizacion</option>
                                        <option value="alertas.pin">N° de serie</option>
                                        <option value="alertas.descripcion">Descripción</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('alerta.index') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                @endif
                <br>
                        <br>

                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th></th>
                            <th></th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Fecha y hora</th>
                            <th scope="col">PIN</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Acción</th>
                            <th scope="col">Acción tomada por</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($alertas as $alerta)
                            @can('haveaccess','alerta.show')
                            <tr href="{{ route('alerta.show',$alerta->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th>@if ((stripos($alerta->descripcion,'AMARILLO ') !== false)  OR (stripos($alerta->descripcion,'yellow ') !== false))
                                    <img src="{{ asset('/imagenes/caamarillo.png') }}"  height="25" title="Alerta amarilla">
                                @elseif((stripos($alerta->descripcion,'rojo ') !== false) OR (stripos($alerta->descripcion,'red ') !== false))
                                    <img src="{{ asset('/imagenes/carojo.png') }}"  height="25" title="Alerta roja">
                                @else
                                    <img src="{{ asset('/imagenes/cagris.png') }}"  height="25" title="Alerta gris">
                                @endif</th>
                            <th scope="row">
                                <img class="img img-responsive" src="/imagenes/{{ $alerta->TipoMaq }}.png" height="25px">
                            </th>
                            <th scope="row">{{ $alerta->NombSucu }}</th>
                            <th scope="row">{{ $alerta->NombOrga }}</th>
                            <th scope="row">{{ $alerta->ModeMaq }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($alerta->fecha)) }} - {{ $alerta->hora }}</th>
                            <th scope="row">{{ $alerta->pin }}</th>
                            <th scope="row">{{ $alerta->descripcion }}</th>
                            <th scope="row">{{ $alerta->accion }}</th>
                            <th scope="row">{{ $alerta->name }} {{ $alerta->last_name }}</th>
                            @can('haveaccess','alerta.show')
                                <th><a href="{{ route('alerta.show',$alerta->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $alertas->onEachSide(0)->links() !!}
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
