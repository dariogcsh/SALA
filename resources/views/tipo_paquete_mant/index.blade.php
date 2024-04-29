@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de tipos de paquete de mantenimimento 
                @can('haveaccess','tipo_paquete_mant.create')
                <a href="{{ route('tipo_paquete_mant.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Costo </th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tipo_paquete_mants as $tipo_paquete_mant)
                            @can('haveaccess','tipo_paquete_mant.show')
                            <tr href="{{ route('tipo_paquete_mant.show',$tipo_paquete_mant->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $tipo_paquete_mant->id }}</th>
                            <th scope="row">{{ $tipo_paquete_mant->modelo }}</th>
                            <th scope="row">{{ $tipo_paquete_mant->horas }} hs</th>
                            <th scope="row">US$ {{ $tipo_paquete_mant->costo }}</th>
                            @can('haveaccess','tipo_paquete_mant.show')
                            <th><a href="{{ route('tipo_paquete_mant.show',$tipo_paquete_mant->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $tipo_paquete_mants->onEachSide(0)->links() !!}
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
