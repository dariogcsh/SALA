@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Compras registradas
                @can('haveaccess','insumo_compra.create')
                <a href="{{ route('insumo_compra.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="insumos.nombre">Nombre producto</option>
                                    <option value="insumos.categoria">Categoria</option>
                                    <option value="insumo_compras.proveedor">Proveedor</option>
                                    <option value="insumo_compras.nfactura">N° Factura</option>
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
                    <a class="btn btn-secondary float-right" href="{{ route('insumo_compra.index') }}">
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
                            <th scope="col">Proveedor</th>
                            <th scope="col">Fecha de compra</th>
                            <th scope="col">N° de factura</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Insumo</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Litros (Lts)</th>
                            <th scope="col">Peso (Kg)</th>
                            <th scope="col">Bolsas</th>
                            <th scope="col">Cantidad por bolsa</th>
                            <th scope="col">Precio por unidad</th>
                            <th scope="col">Precio total</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($insumo_compras as $insumo_compra)
                            @can('haveaccess','insumo_compra.show')
                                <tr href="{{ route('insumo_compra.show',$insumo_compra->id) }}">
                            @else
                                <tr>
                            @endcan
                            <th scope="row">{{ $insumo_compra->id }}</th>
                            <th scope="row">{{ $insumo_compra->proveedor }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($insumo_compra->fecha_compra)) }}</th>
                            <th scope="row">{{ $insumo_compra->nfactura }}</th>
                            <th scope="row">{{ $insumo_compra->categoria }}</th>
                            <th scope="row">{{ $insumo_compra->nombreinsumo }}</th>
                            <th scope="row">{{ $insumo_compra->nombremarca }}</th>
                            <th scope="row">{{ number_format($insumo_compra->litros) }}</th>
                            <th scope="row">{{ number_format($insumo_compra->peso) }}</th>
                            <th scope="row">{{ number_format($insumo_compra->bultos) }}</th>
                            <th scope="row">{{ number_format($insumo_compra->semillas) }}</th>
                            <th scope="row">US$ {{ number_format($insumo_compra->precio) }}</th>
                            @php
                                $total = 0;
                                if(isset($insumo_compra->litros)){
                                    $total = $insumo_compra->precio * $insumo_compra->litros;
                                }elseif(isset($insumo_compra->peso)){
                                    $total = $insumo_compra->precio * $insumo_compra->peso;
                                }else {
                                    $total = $insumo_compra->precio * $insumo_compra->bultos;
                                }
                            @endphp
                            <th scope="row">US$ {{number_format($total) }}</th>
                            @can('haveaccess','insumo_compra.show')
                            <th><a href="{{ route('insumo_compra.show',$insumo_compra->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $insumo_compras->links() !!}
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
