@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de guardias 
                @can('haveaccess','guardiasadmin.create')
                <a href="{{ route('guardiasadmin.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Fecha</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($guardiasadmins as $guardiasadmin)
                            @can('haveaccess','guardiasadmin.show')
                            <tr href="{{ route('guardiasadmin.show',$guardiasadmin->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $guardiasadmin->id }}</th>
                            <th scope="row">{{ $guardiasadmin->sucursals->NombSucu }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($guardiasadmin->fecha)) }}</th>
                            @can('haveaccess','guardiasadmin.show')
                            <th><a href="{{ route('guardiasadmin.show',$guardiasadmin->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $guardiasadmins->links() !!}
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
