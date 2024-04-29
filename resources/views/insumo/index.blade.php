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
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Variedad/Producto químico</th>
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
