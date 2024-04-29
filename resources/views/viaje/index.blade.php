@php
    use App\User;
    use App\viaje_user;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de viajes a campo compartidos
                @can('haveaccess','viaje.create')
                <a href="{{ route('viaje.create') }}" class="btn btn-success float-right"><b>+</b></a>
                <!--
                <a href="{{ route('viaje.lista_vehiculos') }}" class="btn btn-success float-right"><b>Vehiculos</b></a>
                -->
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('viaje.gestion') }}" class="btn btn-primary btn-block"><b>Gestión viajes a campo compartidos</b></a>
                    </div>
                </div>
                    <br><br>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Vehículo</th>
                            <th scope="col">Patente</th>
                            <th scope="col">Duración</th>
                            <th scope="col">Organización</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Usuarios que recibieron notificación</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($viajes as $viaje)
                            @can('haveaccess','viaje.show')
                            <tr href="{{ route('viaje.show',$viaje->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $viaje->id }}</th>
                            <th scope="row">{{ date_format($viaje->created_at, 'd/m/Y H:i:s') }}</th>
                            <th scope="row">{{ $viaje->nombre }}</th>
                            <th scope="row">{{ $viaje->patente }}</th>
                            <th scope="row">{{ $viaje->minutos }} <small>minutos</small></th>
                            <th scope="row">{{ $viaje->NombOrga }}</th>
                            <th scope="row">{{ $viaje->NombSucu }}</th>
                            @php
                                $viaje_users = Viaje_user::where('id_viaje',$viaje->id)->get();
                            @endphp
                            <th scope="row">
                                @foreach($viaje_users as $viaje_user)
                                    @php
                                        $usuario = User::where('id',$viaje_user->id_user)->first();
                                    @endphp
                                    {{ $usuario->name }} {{ $usuario->last_name }} - 
                                @endforeach
                            </th>
                            @can('haveaccess','viaje.show')
                                <th><a href="{{ route('viaje.show',$viaje->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $viajes->onEachSide(0)->links() !!}
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
