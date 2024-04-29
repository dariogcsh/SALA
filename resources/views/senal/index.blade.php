@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de alquileres de señal 
                @can('haveaccess','senal.create')
                <a href="{{ route('senal.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                @can('haveaccess','senal.gestion')
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('senal.gestion') }}" class="btn btn-primary btn-block"><b>Estadisticas de alquileres de señal</b></a>
                        </div>
                    </div>
                    <br>
                @endcan

                    @can('haveaccess','senal.edit')
                        @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="tipo" class="form-control mr-sm-2">
                                        <option value="">Buscar por</option>
                                        <option value="organizacions.NombOrga">Organizacion </option>
                                        <option value="antenas.NombAnte">Antena </option>
                                        <option value="nserie">N° de serie</option>
                                        <option value="duracion">Duración (meses)</option>
                                        <option value="costo">Costo</option>
                                        <option value="estado">Estado</option>
                                        <option value="users.name">Nombre de usuario solicitante</option>
                                        <option value="users.last_name">Apellido de usuario solicitante</option>
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
                            <a class="btn btn-secondary float-right" href="{{ route('senal.index') }}">
                                <i class="fa fa-times"> </i>
                                {{ $busqueda }}
                            </a>
                        @endif
                        @endcan

                    <br>
                    <br>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Antena</th>
                            <th scope="col">N° serie</th>
                            <th scope="col">Fecha solucitud</th>
                            <th scope="col">Fecha activación</th>
                            <th scope="col">Duración</th>
                            <th scope="col">Costo</th>
                            <!---
                            <th scope="col">Estado</th>
                            -->
                            <th scope="col">Estado interno</th>
                            <th scope="col">N° de factura</th>
                            <th scope="col">Especialista solicitante</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($senals as $senal)
                            @can('haveaccess','senal.show')
                                <tr href="{{ route('senal.show',$senal->id) }}">
                            @else
                            <tr>
                            @endcan
                                <th scope="row">{{ $senal->NombOrga }}</th>
                                <th scope="row">{{ $senal->NombAnte }}</th>
                                <th scope="row">{{ $senal->nserie }}</th>
                                <th scope="row">{{ date("d/m/Y",strtotime($senal->created_at)) }}</th>
                                <th scope="row">{{ date("d/m/Y",strtotime($senal->activacion)) }}</th>
                                <th scope="row">{{ $senal->duracion }} meses</th>
                                <th scope="row">US$ {{ $senal->costo }}</th>
                                <!---
                                @if (($senal->activacion > $hoy) OR ($senal->activacion == '') OR (date("Y-m-d",strtotime($senal->activacion."+ ". $senal->duracion ." month")) < $hoy))
                                    <th scope="row">Inactivo</th>
                                @elseif(($senal->activacion <= $hoy) AND (date("Y-m-d",strtotime($senal->activacion."+ ". $senal->duracion ." month")) >= $hoy))
                                    <th scope="row">Activo</th>
                                @endif
                                -->
                                <th scope="row">{{ $senal->estado }}</th>
                                <th scope="row">{{ $senal->nfactura }}</th>
                                <th scope="row">{{ $senal->name }} {{ $senal->last_name }}</th>
                            @can('haveaccess','senal.show')
                            <th><a href="{{ route('senal.show',$senal->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $senals->onEachSide(0)->links() !!}
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
