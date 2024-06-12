@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de reclamos 
                @can('haveaccess','reclamo.create')
                <a href="{{ route('reclamo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <a href="{{ url('/export') }}" class="btn btn-secondary"><b>XLSX</b></a>
                <br>
                <br>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha hallazgo</th>
                            <th scope="col"></th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Organización</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Estado</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($reclamos as $reclamo)
                            @can('haveaccess','reclamo.show')
                                <tr href="{{ route('reclamo.show',$reclamo->id) }}">
                            @else
                                <tr>
                            @endcan
                            <th scope="row">{{ $reclamo->id }}</th>
                            <th scope="row">{{ date("d/m/Y",strtotime($reclamo->fecha)) }}</th>
                            @if((($reclamo->fecha_limite_contingencia <> NULL) AND ($reclamo->fecha_limite_contingencia < $hoy) AND ($reclamo->fecha_registro_contingencia == NULL) AND ($reclamo->estado <> "Cerrada") AND ($reclamo->estado <> "Eficaz")) OR (($reclamo->fecha_causa <> NULL) AND ($reclamo->fecha_causa < $hoy) AND ($reclamo->fecha_registro_causa == NULL) AND ($reclamo->estado <> "Cerrada") AND ($reclamo->estado <> "Eficaz")))
                                @if(!isset($fecha_registro_contingencia))
                                    <th><img src="{{ asset('/imagenes/arojo.png') }}"  height="20"></th>
                                @endif                   
                            @else
                                @if ($reclamo->estado == "Abierta")
                                    <th><img src="{{ asset('/imagenes/aamarillo.png') }}"  height="20"></th>
                                @elseif ($reclamo->estado == "En proceso")
                                    <th><img src="{{ asset('/imagenes/aamarillo.png') }}"  height="20"></th>
                                @elseif ($reclamo->estado == "Cerrada")
                                    <th><img src="{{ asset('/imagenes/anegro.png') }}"  height="20"></th>
                                @elseif ($reclamo->estado == "Eficaz")
                                    <th><img src="{{ asset('/imagenes/aazul.png') }}"  height="20"></th>
                                @endif
                            @endif
                            
                            
                            <th scope="row">{{ $reclamo->NombSucu }}</th>
                            <th scope="row">{{ $reclamo->NombOrga }}</th>
                            <th scope="row">{{ $reclamo->nombre_cliente }}</th>
                            <th scope="row">{{ substr($reclamo->descripcion,0,120) }}...</th>
                            <th scope="row">{{ $reclamo->estado }}</th>
                            @can('haveaccess','reclamo.show')
                            <th><a href="{{ route('reclamo.show',$reclamo->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $reclamos->onEachSide(0)->links() !!}
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
