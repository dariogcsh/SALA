@php
    use App\User;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de organizaciones 
                @can('haveaccess','organizacion.create')
                <a href="{{ route('organizacion.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                    @include('custom.message')
                    
                    @can('haveaccess','organizacion.edit')
                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="NombOrga">Organizacion</option>
                                    <option value="InscOrga">Monitoreo</option>
                                    <option value="NombSucu">Sucursal</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('organizacion.index') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                    @endcan
                <br>
                <br>
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Monitoreado</th>
                            <th scope="col">Usuarios logueados en la App</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($organizacions as $organizacion)
                            @can('haveaccess','organizacion.show')
                            <tr href="{{ route('organizacion.show',$organizacion->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $organizacion->NombOrga }}</th>
                            <th scope="row">
                            @isset($organizacion->sucursals->NombSucu)
                                {{ $organizacion->sucursals->NombSucu }}
                            @endisset
                            @isset($organizacion->NombSucu)
                                {{ $organizacion->NombSucu }}
                            @endisset
                            </th>
                            <th scope="row">{{ $organizacion->InscOrga }}</th>                                                         
                                @php
                                    $logueado = User::where([['CodiOrga',$organizacion->id], ['TokenNotificacion','<>','']])->count();
                                @endphp                            
                            <th scope="row">{{ $logueado }}</th>
                            @can('haveaccess','organizacion.show')
                            <th><a href="{{ route('organizacion.show',$organizacion->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $organizacions->onEachSide(0)->links() !!}
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
