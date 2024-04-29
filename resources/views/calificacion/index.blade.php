@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Calificaciones</h2></div>
                <div class="card-body">  
                    @can('haveaccess','calificacion.gestion')
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('calificacion.gestion') }}" class="btn btn-primary btn-block"><b>Estadisticas de calificaciones de asistencias</b></a>
                            </div>
                        </div>
                        <br>
                    @endcan
                    @can('haveaccess','calificacion.index')
                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="puntos">Puntos</option>
                                    <option value="organizacions.NombOrga">Organizacion</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('calificacion.index') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                    @endcan
                        <br>
                        <br>
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Puntos</th>
                            <th scope="col">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($calificaciones as $calificacion)
                            <tr>
                            <th scope="row">{{ $calificacion->id }}</th>
                            <th scope="row">{{ $calificacion->name}} {{ $calificacion->last_name}}</th>
                            <th scope="row">{{ $calificacion->NombOrga }}</th>
                            <th scope="row">{{  date('d/m/Y H:m:i',strtotime($calificacion->created_at)) }}</th>
                            <th scope="row">{{ $calificacion->puntos }}</th>
                            <th scope="row">{{ $calificacion->descripcion }}</th>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $calificaciones->links() !!}
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
