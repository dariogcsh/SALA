@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de etapas 
                @can('haveaccess','etapa.create')
                <a href="{{ route('etapa.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Etapa</th>
                            <th scope="col">Orden</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($etapas as $etapa)
                            @can('haveaccess','etapa.show')
                            <tr href="{{ route('etapa.show',$etapa->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $etapa->nombre }}</th>
                            <th scope="row">{{ $etapa->orden }}</th>
                            @can('haveaccess','etapa.show')
                            <th><a href="{{ route('etapa.show',$etapa->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $etapas->links() !!}
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
