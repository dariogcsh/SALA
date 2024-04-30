@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>Lista de pasos 
                @can('haveaccess','paso.create')
                <a href="{{ route('paso.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Etapa</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Paso</th>
                            <th scope="col">Tipo Unidad</th>
                            <th scope="col">Orden</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($pasos as $paso)
                            @can('haveaccess','paso.show')
                            <tr href="{{ route('paso.show',$paso->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $paso->nombreetapa }}</th>
                            <th scope="row">{{ $paso->NombPuEm }}</th>
                            <th scope="row">{{ $paso->nombre }}</th>
                            <th scope="row">{{ $paso->tipo_unidad }}</th>
                            <th scope="row">{{ $paso->orden }}</th>
                            @can('haveaccess','paso.show')
                            <th><a href="{{ route('paso.show',$paso->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $pasos->onEachSide(0)->links() !!}
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
