@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de vehículos
                @can('haveaccess','vehiculo.create')
                    <a href="{{ route('vehiculo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="col-sm-2">
                    <a href="{{ route('poliza.index') }}" class="btn btn-secondary btn-block"><b>PDF Polizas</b></a>
                </div>
                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="marca">Marca</option>
                                    <option value="modelo">Modelo</option>
                                    <option value="patente">Patente</option>
                                    <option value="nvehiculo">N° de vehículo SALA</option>
                                    <option value="ano">Año</option>
                                    <option value="sucursals.NombSucu">Sucursal</option>
                                    <option value="departamento">Departamento</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('vehiculo.index') }}">
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
                            <th scope="col">N°</th>
                            <th scope="col">Id VSat</th>
                            <th scope="col">Nombre VSat</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Año</th>
                            <th scope="col">Patente</th>
                            <th scope="col">Seguro</th>
                            <th scope="col">Vto. poliza</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($vehiculos as $vehiculo)
                            @can('haveaccess','vehiculo.show')
                            <tr href="{{ route('vehiculo.show',$vehiculo->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $vehiculo->nvehiculo }}</th>
                            <th scope="row">{{ $vehiculo->id_vsat }}</th>
                            <th scope="row">{{ $vehiculo->nombre }}</th>
                            <th scope="row">{{ $vehiculo->NombSucu }}</th>
                            <th scope="row">{{ $vehiculo->marca }}</th>
                            <th scope="row">{{ $vehiculo->modelo }}</th>
                            <th scope="row">{{ $vehiculo->ano }}</th>
                            <th scope="row">{{ $vehiculo->patente }}</th>
                            <th scope="row">{{ $vehiculo->seguro }}</th>
                            <th scope="row">{{ $vehiculo->vto_poliza }}</th>
                            @can('haveaccess','vehiculo.show')
                            <th><a href="{{ route('antena.show',$vehiculo->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $vehiculos->onEachSide(0)->links() !!}
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
