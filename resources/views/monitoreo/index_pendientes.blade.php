@php
    use App\monitoreo_maquina;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de monitoreos listos para facturar
                @can('haveaccess','monitoreo.create')
                <a href="{{ route('monitoreo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ route('monitoreo.index') }}" class="btn btn-success btn-block"><b>Lista de facturación de monitoreo</b></a>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-2">
                        <a href="{{ route('monitoreo.index_pendientes') }}" class="btn btn-dark btn-block"><b>Monitoreos listos para facturar</b></a>
                    </div>
                </div>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Maquinas y costo por maquina</th>
                            <th scope="col">Mes de facturación</th>
                            <th scope="col">Costo total</th>
                            <th scope="col">Estado</th>
                            <th scope="col">N° de factura</th>
                            <th scope="col">Fecha factura</th>
                            <th scope="col">Tipo de paquete</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($monitoreos as $monitoreo)
                            @can('haveaccess','monitoreo.show')
                            <tr href="{{ route('monitoreo.show',$monitoreo->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $monitoreo->id }}</th>
                            <th scope="row">{{ $monitoreo->NombOrga }}</th>
                                @php
                                    $maquinas = Monitoreo_maquina::where('id_monitoreo',$monitoreo->id)->get();
                                @endphp
                            <th>
                                @foreach($maquinas as $maquina)
                                    {{ $maquina->NumSMaq }} (<small>US$ {{ $maquina->costo }}</small>) - 
                                @endforeach
                            </th>
                            <th scope="row">{{ $monitoreo->mes_facturacion }}</th>  
                            <th scope="row">US$ {{ $monitoreo->costo_total }}</th>
                            <th scope="row">{{ $monitoreo->estado }}</th>
                            <th scope="row">{{ $monitoreo->factura }}</th>
                            <th scope="row">{{ $monitoreo->fecha_facturada }}</th>
                            <th scope="row">{{ $monitoreo->tipo }}</th>
                            @can('haveaccess','monitoreo.show')
                                <th><a href="{{ route('monitoreo.show',$monitoreo->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $monitoreos->onEachSide(0)->links() !!}
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
