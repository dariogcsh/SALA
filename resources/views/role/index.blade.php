@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de roles 
                @can('haveaccess','role.create')
                <a href="{{ route('role.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                @can('haveaccess','role.edit')
                @if ($filtro=="")
                <form class="form-inline float-right">
                    <div class="row">
                        <div class="input-group col-md-12">
                            <select name="tipo" class="form-control mr-sm-2">
                                <option value="">Buscar por</option>
                                <option value="name">Nombre </option>
                                <option value="slug">Slug </option>
                                <option value="description">Descripción</option>
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
                    <a class="btn btn-secondary float-right" href="{{ route('role.index') }}">
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
                            <th scope="col">Slug</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Full-Access</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            @can('haveaccess','role.show')
                            <tr href="{{ route('role.show',$role->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $role->id }}</th>
                            <th scope="row">{{ $role->name }}</th>
                            <th scope="row">{{ $role->slug }}</th>
                            <th scope="row">{{ $role->description }}</th>
                            <th scope="row">{{ $role['full-access'] }}</th>
                            @can('haveaccess','role.show')
                            <th><a href="{{ route('role.show',$role->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {!! $roles->onEachSide(0)->links() !!}
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
