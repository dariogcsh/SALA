@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Enlaces externos
                        @can('haveaccess','externo.create')
                            <a href="{{ route('externo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                        @endcan
                    </h2>
                </div>
                <div class="card-body">
                    @isset($externos)
                        @foreach($externos as $externo)
                            <div class="row">
                                <div class="col-md-4">
                                    <h5><u>{{$externo->titulo}}</u></h5>
                                    <img src="{{ asset('img/externo/' .$externo->imagen) }}" width="100%" class="img img-responsive">
                                    <br>
                                    <br>
                                    <p>{{ $externo->descripcion }}</p>
                                    <a class="btn btn-success btn-block" href="{{ $externo->url }}">IR</a>
                                    <a class="btn btn-light btn-block" href="{{ route('home') }}">Atras</a>
                                    @can('haveaccess','externo.edit')
                                        <a href="{{ route('externo.edit',$externo->id) }}" class="btn btn-warning btn-block">Editar</a>
                                    @endcan
                                    @can('haveaccess','externo.destroy')
                                        <form action="{{ route('externo.destroy',$externo->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                                        </form>
                                    @endcan
                                </div>
                                <br>
                            </div>
                            <br>
                        @endforeach
                    @endisset
                    <div class="d-flex justify-content-center">
                        {!! $externos->links() !!}
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
