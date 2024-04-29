@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de puestos de empleado 
                @can('haveaccess','puesto_empleado.create')
                <a href="{{ route('puesto_empleado.create') }}" class="btn btn-success float-right"><b>+</b></a>
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
                        @foreach ($puestoemps as $puestoemp)
                            @can('haveaccess','puesto_empleado.show')
                            <tr href="{{ route('puesto_empleado.show',$puestoemp->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $puestoemp->id }}</th>
                            <th scope="row">{{ $puestoemp->NombPuEm }}</th>
                            @can('haveaccess','puesto_empleado.show')
                            <th><a href="{{ route('puesto_empleado.show',$puestoemp->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $puestoemps->onEachSide(0)->links() !!}
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
