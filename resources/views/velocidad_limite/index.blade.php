@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de velocidades máximas 
                @can('haveaccess','velocidad_limite.create')
                <a href="{{ route('velocidad_limite.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                @if($nomborg->NombOrga == 'Sala Hnos')
                    @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="tipo" class="form-control mr-sm-2">
                                        <option value="">Buscar por</option>
                                        <option value="pin">N° de serie de máquina</option>
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
                            <a class="btn btn-secondary float-right" href="{{ route('velocidad_limite.index') }}">
                                <i class="fa fa-times"> </i>
                                {{ $busqueda }}
                            </a>
                        @endif
                    @endif
                    <br>
                    <br>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Organización</th>
                            <th scope="col">PIN</th>
                            <th scope="col">Velocidad máxima</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($velocidad_limites as $velocidad_limite)
                            @can('haveaccess','velocidad_limite.show')
                            <tr href="{{ route('velocidad_limite.show',$velocidad_limite->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $velocidad_limite->NombOrga }}</th>
                            <th scope="row">{{ $velocidad_limite->pin }}</th>
                            <th scope="row">{{ $velocidad_limite->limite }} km/h</th>
                            @can('haveaccess','velocidad_limite.show')
                            <th><a href="{{ route('velocidad_limite.show',$velocidad_limite->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $velocidad_limites->onEachSide(0)->links() !!}
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
