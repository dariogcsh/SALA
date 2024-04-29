@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de beneficios 
                @can('haveaccess','bonificacion.create')
                    <a href="{{ route('bonificacion.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')

                @can('haveaccess','bonificacion.edit')
                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="tipo">Tipo </option>
                                    <option value="descuento">Descuento</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('bonificacion.administrar') }}">
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
                            <th scope="col">#</th>
                            <th></th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descuento</th>
                            <th scope="col">Costo</th>
                            <th scope="col">Desde</th>
                            <th scope="col">Hasta</th>
                            <th scope="col">Estado</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($bonificaciones as $bonificacion)
                            @can('haveaccess','bonificacion.show')
                                <tr href="{{ route('bonificacion.show',$bonificacion->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $bonificacion->id }}</th>
                            @if($hoy > $bonificacion->hasta)
                                <th><img src="{{ asset('/imagenes/arojo.png') }}"  height="20" title="Respuesta del concesionario"></th>
                            @else
                                <th><img src="{{ asset('/imagenes/averde.png') }}"  height="20" title="Respuesta del concesionario"></th>
                            @endif
                            <th scope="row">{{ $bonificacion->tipo }}</th>
                            <th scope="row">{{ $bonificacion->descuento }} %</th>
                            <th scope="row">US$ {{ $bonificacion->costo }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($bonificacion->desde)) }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($bonificacion->hasta)) }}</th>
                            @if($hoy > $bonificacion->hasta)
                                <th>Vencida</th>
                            @else
                                <th>Vigente</th>
                            @endif
                            @can('haveaccess','bonificacion.show')
                                <th><a href="{{ route('bonificacion.show',$bonificacion->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $bonificaciones->links() !!}
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
