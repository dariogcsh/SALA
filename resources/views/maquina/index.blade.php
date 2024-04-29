@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de equipos
                @can('haveaccess','maquina.create')
                <a href="{{ route('maquina.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                    @include('custom.message')
                    @can('haveaccess','maquina.gestion')
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('maquina.gestion') }}" class="btn btn-primary btn-block"><b>Estadisticas de equipos</b></a>
                            </div>
                        </div>
                        <br>
                    @endcan
                    @if ($nomborg->NombOrga == 'Sala Hnos')
                        @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="tipo" class="form-control mr-sm-2">
                                        <option value="">Buscar por</option>
                                        <option value="MarcMaq">Marca</option>
                                        <option value="ModeMaq">Modelo</option>
                                        <option value="NumSMaq">N° de serie de máquina</option>
                                        <option value="TipoMaq">Tipo maquina</option>
                                        <option value="combine_advisor">Combine Advisor</option>
                                        <option value="harvest_smart">Harvest Smart</option>
                                        <option value="InscMaq">Monitoreo</option>
                                        <option value="ethernet">Estado de ethernet</option>
                                        <option value="nseriemotor">N° de serie de motor</option>
                                        <option value="organizacions.NombOrga">Organizacion</option>
                                        <option value="sucursals.NombSucu">Sucursal</option>
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
                            <a class="btn btn-secondary float-right" href="{{ route('maquina.index') }}">
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
                            <th scope="col"></th>
                            <th scope="col">Modelo</th>
                            <th scope="col">N° de serie</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Hs de motor</th>
                            <th scope="col">Harvest Smart</th>
                            <th scope="col">Combine Advisor</th>
                            <th scope="col">Estado de ethernet</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($maquinas as $maquina)
                            @can('haveaccess','maquina.show'||'haveaccess','maquinaown.show')
                            <tr href="{{ route('maquina.show',$maquina->id) }}">
                            @else
                            <tr>
                            @endcan
                            
                            <th scope="row"><img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"></th>
                            <th scope="row">{{ $maquina->ModeMaq }}</th>
                            <th scope="row">{{ $maquina->NumSMaq }}</th>
                            <th scope="row">{{ $maquina->NombSucu }}</th>
                            <th scope="row">
                            @isset($maquina->organizacions->NombOrga)
                                {{ $maquina->organizacions->NombOrga }}
                            @endisset
                            @isset($maquina->NombOrga)
                                {{ $maquina->NombOrga }}
                            @endisset
                            </th>
                            <th scope="row">{{ $maquina->horas }} hs</th>
                            <th scope="row">{{ $maquina->harvest_smart }}</th>
                            <th scope="row">{{ $maquina->combine_advisor }}</th>
                            <th scope="row">{{ $maquina->ethernet }}</th>
                            @can('haveaccess','maquina.show'||'haveaccess','maquinaown.show')
                            <th><a href="{{ route('maquina.show',$maquina->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $maquinas->onEachSide(0)->links() !!}
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
