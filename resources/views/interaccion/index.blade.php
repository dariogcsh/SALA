@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de interacciones
                </h2>
                @if ($vista=="organizacion")
                    <a href="{{ route('interaccion.index') }}" title="Ver solicitudes del concesionario">NO Concesionario</a>
                    <b> / Concesionario</b>
                @elseif($vista=="concesionario")
                    <form name="formulario1">
                        <input type="hidden" name="orga" value="organizacion">
                    </form>
                    <b>NO Concesionario / </b>
                    <a href="javascript:enviar_formulario1()" title="Ver interacciones de las organizaciones">Concesionario</a>
                @endif
            </div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('interaccion.gestion') }}" class="btn btn-primary btn-block"><b>Estadisticas de interacciones con la App</b></a>
                    </div>
                </div>
                <br>
                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="organizacions.NombOrga">Organizacion</option>
                                    <option value="users.name">Nombre usuario</option>
                                    <option value="users.last_name">Apellido usuario</option>
                                    <option value="sucursals.NombSucu">Sucursal</option>
                                    <option value="interaccions.modulo">Módulos visitados</option>
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
                    <br>
                    <br>
                    @if ($filtro=="SI")
                        <a class="btn btn-secondary float-right" href="{{ route('interaccion.index') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Módulo</th>
                            <th scope="col">Fecha y Hora</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($interacciones as $interaccion)
                            @can('haveaccess','interaccion.show')
                            <tr href="{{ url($interaccion->enlace) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $interaccion->id }}</th>
                            <th scope="row">{{ $interaccion->name }} {{ $interaccion->last_name }}</th>
                            <th scope="row">{{ $interaccion->NombOrga }}</th>
                            <th scope="row">{{ $interaccion->modulo }}</th>
                            <th scope="row">{{ $interaccion->created_at }}</th>
                            @can('haveaccess','interaccion.show')
                                <th><a href="{{ url($interaccion->enlace) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $interacciones->onEachSide(0)->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
function enviar_formulario1(){
            document.formulario1.submit();
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
