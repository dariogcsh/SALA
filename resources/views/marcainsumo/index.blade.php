@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de marcas 
                @can('haveaccess','marcainsumo.create')
                <a href="{{ route('marcainsumo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Marca</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($marcainsumos as $marcainsumo)
                            @can('haveaccess','marcainsumo.show')
                            <tr href="{{ route('marcainsumo.show',$marcainsumo->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $marcainsumo->id }}</th>
                            <th scope="row">{{ $marcainsumo->nombre }}</th>
                            @can('haveaccess','marcainsumo.show')
                            <th><a href="{{ route('marcainsumo.show',$marcainsumo->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $marcainsumos->links() !!}
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
