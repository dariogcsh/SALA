@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de objetivos 
                @can('haveaccess','objetivo.create')
                <a href="{{ route('objetivo.create') }}" class="btn btn-success float-right"><b>+</b></a>
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
                                        <option value="organizacions.NombOrga">Organizacion</option>
                                        <option value="NumSMaq">N° de serie</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('objetivo.index') }}">
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
                            <th scope="col">Organizacion</th>
                            <th scope="col">Modelo de máquina</th>
                            <th scope="col">Nombre en Op. Center</th>
                            <th scope="col">N° de serie</th>
                            <th scope="col">Tipo de objetivo</th>
                            <th scope="col">Objetivo</th>
                            <th scope="col">Cultivo</th>
                            <th scope="col">Establecido por</th>
                            <th scope="col">Año</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($objetivos as $objetivo)
                            @can('haveaccess','objetivo.show')
                            <tr href="{{ route('objetivo.show',$objetivo->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $objetivo->NombOrga }}</th>
                            <th scope="row">{{ $objetivo->ModeMaq }}</th>
                            <th scope="row">{{ $objetivo->nomb_maq }}</th>
                            <th scope="row">{{ $objetivo->NumSMaq }}</th>
                            <th scope="row">{{ $objetivo->nombre }}</th>
                            <th scope="row">{{ $objetivo->objetivo }}</th>
                            <th scope="row">{{ $objetivo->cultivo }}</th>
                            <th scope="row">{{ $objetivo->establecido }}</th>
                            <th scope="row">{{ $objetivo->ano }}</th>
                            @can('haveaccess','objetivo.show')
                            <th><a href="{{ route('objetivo.show',$objetivo->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $objetivos->onEachSide(0)->links() !!}
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
