@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de tareas de mantenimiento 
                @can('haveaccess','paquetemant.create')
                <a href="{{ route('paquetemant.create') }}" class="btn btn-success float-right"><b>+</b></a>
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
                                    <option value="tipo_paquete_mants.modelo">Modelo</option>
                                    <option value="paquetemants.descripcion">Tarea</option>
                                    <option value="paquetemants.horas">Horas</option>
                                    <option value="repuestos.codigo">Repuesto</option>
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
                    <br>
                    <br>
                    @if ($filtro=="SI")
                        <a class="btn btn-secondary float-right" href="{{ route('paquetemant.index') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tipo de paquete de mantenimiento</th>
                            <th scope="col">Descripción de tarea</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Repuesto</th>
                            <th scope="col">Cantidad</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($paquetemants as $paquetemant)
                            @can('haveaccess','paquetemant.show')
                            <tr href="{{ route('paquetemant.show',$paquetemant->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $paquetemant->id }}</th>
                            <th scope="row">{{ $paquetemant->modelo }} - <small> {{ $paquetemant->horasmant }} hs</small> </th>
                            <th scope="row">{{ $paquetemant->descripcion }}</th>
                            <th scope="row">{{ $paquetemant->horas }} hs</th>
                            <th scope="row">{{ $paquetemant->nombre }} - <small> {{ $paquetemant->codigo }}</small> </th>
                            <th scope="row">{{ $paquetemant->cantidad }}</th>
                            @can('haveaccess','paquetemant.show')
                            <th><a href="{{ route('paquetemant.show',$paquetemant->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $paquetemants->onEachSide(0)->links() !!}
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
