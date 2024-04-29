@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de mejoras y actualizaciones propuestas
                    @can('haveaccess','ideaproyecto.create')
                        <a href="{{ route('ideaproyecto.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
                    </h2>
                    @if (($vista=="organizaciones") OR ($vista==""))
                        <form name="formulario1">
                            <input type="hidden" name="concesionario" value="concesionario">
                        </form>
                        <b>Organizaciones / </b>
                        <a href="javascript:enviar_formulario1()" title="Ver propuestas del concesionario">Concesionario</a>
                    @elseif($vista=="concesionario")
                        <a href="{{ route('ideaproyecto.index') }}" title="Ver solicitudes de organizaciones">Organizaciones</a>
                        <b> / Concesionario</b>
                    @endif
                </div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Propuesta</th>
                            <th scope="col">Estado</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($ideaproyectos as $ideaproyecto)
                            @can('haveaccess','ideaproyecto.show')
                                <tr href="{{ route('ideaproyecto.show',$ideaproyecto->id) }}">
                            @else
                                <tr>
                            @endcan
                            <th scope="row">{{ date_format($ideaproyecto->created_at, 'd/m/Y')  }}</th>
                            <th scope="row">{{ $ideaproyecto->NombOrga }}</th>
                            <th scope="row">{{ $ideaproyecto->name }} {{ $ideaproyecto->last_name }}</th>
                            <th scope="row">{{ $ideaproyecto->descripcion }}</th>
                            @if($ideaproyecto->estado == "Transferido a proyectos")
                                <th scope="row">{{ $ideaproyecto->estado }} N°{{ $ideaproyecto->id_proyecto }} </th>     
                            @else
                                <th scope="row">{{ $ideaproyecto->estado }}</th> 
                            @endif
                            @can('haveaccess','ideaproyecto.show')
                                <th><a href="{{ route('ideaproyecto.show',$ideaproyecto->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $ideaproyectos->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
function enviar_formulario1(){
            document.formulario1.submit()
        }
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
