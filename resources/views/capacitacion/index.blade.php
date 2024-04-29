@php
    use App\capacitacion_user;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de capacitaciones 
                    @can('haveaccess','capacitacion.create')
                    <a href="{{ route('capacitacion.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
                    </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Capacitación</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Modalidad</th>
                            <th scope="col">Fecha inicio</th>
                            <th scope="col">Fecha fin</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Costo</th>
                            <th scope="col">Inscriptos</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($capacitaciones as $capacitacion)
                            @can('haveaccess','capacitacion.index')
                                <tr href="{{ route('capacitacion.index_view',$capacitacion->id) }}">
                            @else
                                <tr>
                            @endcan
                            <th scope="row">{{ $capacitacion->codigo }}</th>
                            <th scope="row">{{ $capacitacion->nombre }}</th>
                            <th scope="row">{{ $capacitacion->tipo }}</th>
                            <th scope="row">{{ $capacitacion->modalidad }}</th>
                            <th scope="row">{{  date('d/m/Y',strtotime($capacitacion->fechainicio)) }}</th>
                            <th scope="row">{{  date('d/m/Y',strtotime($capacitacion->fechafin)) }}</th>
                            <th scope="row">{{ $capacitacion->horas }}</th>
                            <th scope="row">US$ {{ $capacitacion->costo }}</th>
                            @php
                                $usuarios = Capacitacion_user::select('users.name','users.last_name')
                                                                ->join('users','capacitacion_users.id_user','=','users.id')
                                                                ->where('capacitacion_users.id_capacitacion',$capacitacion->id)->get();
                            @endphp
                            <th scope="row">
                                @foreach($usuarios as $usuario)
                                    {{ $usuario->name }} {{ $usuario->last_name }} - 
                                @endforeach
                            </th>
                            @can('haveaccess','capacitacion.index')
                                <th><a href="{{ route('capacitacion.index_view',$capacitacion->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $capacitaciones->links() !!}
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
