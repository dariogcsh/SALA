@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de repuestos 
                @can('haveaccess','repuesto.create')
                <a href="{{ route('repuesto.create') }}" class="btn btn-success float-right"><b>+</b></a>
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
                                    <option value="codigo">Código</option>
                                    <option value="nombre">Nombre</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('repuesto.index') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif

                <br>
                <br>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Costo</th>
                            <th scope="col">Margen </th>
                            <th scope="col">Venta</th>
                            <th scope="col">JDPart</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($repuestos as $repuesto)
                            @can('haveaccess','repuesto.show')
                            <tr href="{{ route('repuesto.show',$repuesto->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $repuesto->id }}</th>
                            <th scope="row">{{ $repuesto->codigo }}</th>
                            <th scope="row">{{ $repuesto->nombre }}</th>
                            <th scope="row">US$ {{ $repuesto->costo }}</th>
                            <th scope="row">{{ $repuesto->margen }} %</th>
                            <th scope="row">US$ {{ $repuesto->venta }}</th>
                            <th scope="row">US$ {{ $repuesto->jdpart }}</th>
                            @can('haveaccess','repuesto.show')
                            <th><a href="{{ route('repuesto.show',$repuesto->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $repuestos->onEachSide(0)->links() !!}
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
