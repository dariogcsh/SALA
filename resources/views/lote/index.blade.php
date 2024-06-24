@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de lotes 
                @can('haveaccess','lote.create')
                <a href="{{ route('lote.create') }}" class="btn btn-success float-right"><b>+</b></a>
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
                            <th scope="col">Lote</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($lotes as $lote)
                            @can('haveaccess','lote.show')
                            <tr href="{{ route('lote.show',$lote->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $lote->id }}</th>
                            <th scope="row">{{ $lote->NombOrga }}</th>
                            <th scope="row">{{ $lote->client }}</th>
                            <th scope="row">{{ $lote->farm }}</th>
                            <th scope="row">{{ $lote->name}}</th>
                            @can('haveaccess','lote.show')
                            <th><a href="{{ route('lote.show',$lote->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $lotes->links() !!}
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
