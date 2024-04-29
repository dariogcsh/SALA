@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de sucursales 
                @can('haveaccess','sucursal.create')
                <a href="{{ route('sucursal.create') }}" class="btn btn-success float-right"><b>+</b></a>
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
                        @foreach ($sucursals as $sucursal)
                            @can('haveaccess','sucursal.show')
                            <tr href="{{ route('sucursal.show',$sucursal->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $sucursal->id }}</th>
                            <th scope="row">{{ $sucursal->NombSucu }}</th>
                            @can('haveaccess','sucursal.show')
                            <th><a href="{{ route('sucursal.show',$sucursal->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $sucursals->onEachSide(0)->links() !!}
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
