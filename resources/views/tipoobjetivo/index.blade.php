@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de tipos de objetivos 
                @can('haveaccess','tipoobjetivo.create')
                <a href="{{ route('tipoobjetivo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tipoobjetivos as $objetivo)
                            @can('haveaccess','tipoobjetivo.show')
                            <tr href="{{ route('tipoobjetivo.show',$objetivo->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $objetivo->id }}</th>
                            <th scope="row">{{ $objetivo->nombre }}</th>
                            @can('haveaccess','tipoobjetivo.show')
                            <th><a href="{{ route('tipoobjetivo.show',$objetivo->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $tipoobjetivos->onEachSide(0)->links() !!}
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
