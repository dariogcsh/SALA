@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de clientes contactados
                @can('haveaccess','contacto.create')
                <a href="{{ route('contacto.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                    @include('custom.message')
                    <a href="{{ route('contacto.sincontacto') }}" class="btn btn-light"><b>Monitoreados sin contacto en los últimos 15 dias</b></a>
                    <br>
                    @can('haveaccess','contacto.edit')
                    @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <select name="tipo" class="form-control mr-sm-2">
                                    <option value="">Buscar por</option>
                                    <option value="tipo">Tipo contacto</option>
                                    <option value="id_user">Usuario (SALA)</option>
                                    <option value="departamento">Departamento</option>
                                    <option value="organizacions.NombOrga">Organizacion</option>
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
                        <a class="btn btn-secondary float-right" href="{{ route('contacto.index') }}">
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
                            <th scope="col">Organización</th>
                            <th scope="col">Tipo de contacto</th>
                            <th scope="col">¿Con quién?</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Comentarios</th>
                            <th scope="col">Fecha</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($contactos as $contacto)
                            <tr>
                            <th scope="row">{{ $contacto->NombOrga }}</th>
                            <th scope="row">{{ $contacto->tipo }}</th>
                            <th scope="row">{{ $contacto->persona }}</th>
                            <th scope="row">{{ $contacto->departamento }}</th>
                            @if($contacto->tipo == "Ticket CSC")
                            <th scope="row">Ticket CSC N° {{ $contacto->comentarios }}</th>
                            @else
                            <th scope="row">{{ $contacto->comentarios }}</th>
                            @endif
                            
                            <th scope="row">{{ date_format($contacto->created_at, 'd/m/Y H:i:s')  }}</th>
                            @can('haveaccess','contacto.show')
                                <th><a href="{{ route('contacto.show',$contacto->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            @can('haveaccess','contacto.show')
                                <th><a href="{{ route('contacto.historial',$contacto->id) }}" title="Ver historial de contactos">HISTORIAL</a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $contactos->links() !!}
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
