@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Stock de productos e insumos 
                @can('haveaccess','insumo.create')
                <a href="{{ route('insumo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <a href="{{ route('insumo_compra.index') }}" class="btn btn-secondary"><b>Órdenes de compra</b></a>
                @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="insumos.nombre">Nombre producto</option>
                                    <option value="insumos.categoria">Categoria</option>
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
                    <a class="btn btn-secondary float-right" href="{{ route('insumo.index') }}">
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
                            <th scope="col">Marca</th>
                            <th scope="col">Variedad/Producto químico</th>
                            <th scope="col">Bultos</th>
                            <th scope="col">Semillas</th>
                            <th scope="col">Peso</th>
                            <th scope="col">Litros</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($insumos as $insumo)
                            @can('haveaccess','insumo.show')
                            <tr href="{{ route('insumo.show',$insumo->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $insumo->id }}</th>
                            <th scope="row">{{ $insumo->nombremarca }}</th>
                            <th scope="row">{{ $insumo->nombre }}</th>
                            <th scope="row">{{ $insumo->bultos }}</th>
                            @isset($insumo->semillas)
                                <th scope="row">{{ $insumo->semillas }} U</th>
                            @else
                                <th scope="row">-</th>
                            @endisset
                            @isset($insumo->peso)
                                <th scope="row">{{ $insumo->peso }} Kg</th>
                            @else
                                <th scope="row">-</th>
                            @endisset
                            @isset($insumo->litros)
                                <th scope="row">{{ $insumo->litros }} Lts</th>
                            @else
                                <th scope="row">-</th>
                            @endisset
                            @can('haveaccess','insumo.show')
                            <th><a href="{{ route('insumo.show',$insumo->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $insumos->links() !!}
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
