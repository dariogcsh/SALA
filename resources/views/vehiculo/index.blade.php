@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de vehículos
                @can('haveaccess','vehiculo.create')
                <a href="{{ route('vehiculo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Id VSat</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Patente</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($vehiculos as $vehiculo)
                            @can('haveaccess','vehiculo.show')
                            <tr href="{{ route('vehiculo.show',$vehiculo->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $vehiculo->id }}</th>
                            <th scope="row">{{ $vehiculo->id_vsat }}</th>
                            <th scope="row">{{ $vehiculo->nombre }}</th>
                            <th scope="row">{{ $vehiculo->patente }}</th>
                            @can('haveaccess','vehiculo.show')
                            <th><a href="{{ route('antena.show',$vehiculo->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $vehiculos->onEachSide(0)->links() !!}
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
