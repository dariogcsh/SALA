@php
    use App\monitoreo_maquina;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de facturas 
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
                    
                <br>
                <br>
                </div>
                @if ($nomborg->NombOrga == 'Sala Hnos')
                        @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="tipo" class="form-control mr-sm-2">
                                        <option value="">Seleccionar</option>
                                        <option value="organizacions.NombOrga">Organizacion</option>
                                        <option value="sucursals.NombSucu">Sucursal</option>
                                        <option value="monitoreo_maquinas.NumSMaq">N° de serie de máquina</option>
                                        <option value="mes_facturacion">Mes</option>
                                        <option value="estado">Estado</option>
                                        <option value="tipo">Tipo de paquete (Oro - Plata)</option>
                                        
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
                            <a class="btn btn-secondary float-right" href="{{ route('monitoreo.index') }}">
                                <i class="fa fa-times"> </i>    
                                {{ $busqueda }}
                            </a>
                        @endif
                    @endif
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sucursal</th>
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
                            <th scope="row">{{ $monitoreo->NombSucu }}</th>
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
                            <th scope="row">
                                @isset($monitoreo->fecha_facturada)
                                    {{ date('d/m/Y',strtotime($monitoreo->fecha_facturada)) }}
                                @endisset
                            </th>
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
