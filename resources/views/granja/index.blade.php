@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de granjas
                @can('haveaccess','granja.create')
                <a href="{{ route('granja.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Granja</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($granjas as $granja)
                            @can('haveaccess','granja.show')
                                <tr href="{{ route('granja.show',$granja->id) }}">
                            @else
                                <tr>
                            @endcan
                            <th scope="row">{{ $granja->id }}</th>
                            <th scope="row">{{ $granja->NombOrga }}</th>
                            <th scope="row">{{ $granja->nombrecliente }}</th>
                            <th scope="row">{{ $granja->nombre }}</th>
                            @can('haveaccess','granja.show')
                                <th><a href="{{ route('granja.show',$granja->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $granjas->links() !!}
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
