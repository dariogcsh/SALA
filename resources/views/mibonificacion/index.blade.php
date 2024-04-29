@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Beneficios solicitados  </h2>
                </div>
                <div class="card-body">
                @include('custom.message')
                    @can('haveaccess','mibonificacion.edit')
                        @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="tipo" class="form-control mr-sm-2">
                                        <option value="">Buscar por</option>
                                        <option value="organizacions.NombOrga">Organizacion </option>
                                        <option value="tipo">Tipo </option>
                                        <option value="descuento">Descuento</option>
                                        <option value="estado">Estado</option>
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
                            <a class="btn btn-secondary float-right" href="{{ route('mibonificacion.index') }}">
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
                            <th scope="col">Organizacion</th>
                            <th scope="col">Tipo bonificacion</th>
                            <th scope="col">Descuento</th>
                            <th scope="col">Estado</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($misbonificaciones as $mibonificacion) 
                            @can('haveaccess','bonificacion.create')
                                <tr href="{{ route('mibonificacion.show',$mibonificacion->id) }}">
                            @else                  
                                <tr>
                            @endcan 
                            <th scope="row">{{ $mibonificacion->id }}</th>
                            <th scope="row">{{ $mibonificacion->NombOrga }}</th>
                            <th scope="row">{{ $mibonificacion->tipo }}</th>
                            <th scope="row">{{ $mibonificacion->descuento }}</th>
                            <th scope="row">{{ $mibonificacion->estado }}</th>
                            @can('haveaccess','bonificacion.create')
                                <th><a href="{{ route('mibonificacion.show',$mibonificacion->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $misbonificaciones->links() !!}
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
