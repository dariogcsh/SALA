@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>Lista de usuarios</h2></div>
                <div class="card-body">
                    @include('custom.message')

                    @can('haveaccess','user.edit')
                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="name">Nombre</option>
                                    <option value="last_name">Apellido</option>
                                    <option value="email">Correo</option>
                                    <option value="organizacions.NombOrga">Organizacion</option>
                                    <option value="sucursals.NombSucu">Sucursal</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('user.index') }}">
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
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Logueado en la App</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            @can('view',[$user, ['user.show','userown.show']])
                            <tr href="{{ route('user.show',$user->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $user->id }}</th>
                            <th scope="row">{{ $user->name }}</th>
                            <th scope="row">{{ $user->last_name }}</th>
                            <th scope="row">
                                @isset($user->organizacions->NombOrga)
                                    {{ $user->organizacions->NombOrga }}
                                @endisset
                                @isset($user->NombOrga)
                                    {{ $user->NombOrga }}
                                @endisset
                            </th>
                            <th scope="row">
                                @isset($user->sucursals->NombSucu)
                                    {{ $user->sucursals->NombSucu }}
                                @endisset
                                @isset($user->NombSucu)
                                    {{ $user->NombSucu }}
                                @endisset
                            </th>
                            
                            @if($user->TokenNotificacion <> "")
                                <th scope="row">SI</th>
                            @else
                                <th scope="row">NO</th>
                            @endif
                            
                            @can('view',[$user, ['user.show','userown.show']])
                            <th><a href="{{ route('user.show',$user->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>

                 </div> 
                 <div class="d-flex justify-content-center">
                    {!! $users->onEachSide(0)->links() !!}
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
