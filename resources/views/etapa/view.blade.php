@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Etapa</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Etapa') }}</label>
    
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($etapa->nombre)?$etapa->nombre:old('nombre') }}" disabled autocomplete="nombre" autofocus>
    
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tipo_unidad" class="col-md-4 col-form-label text-md-right">{{ __('Tipo unidad') }}</label>
    
                                <div class="col-md-6">
                                    <input id="tipo_unidad" type="text" class="form-control @error('tipo_unidad') is-invalid @enderror" name="tipo_unidad" value="{{ isset($etapa->tipo_unidad)?$etapa->tipo_unidad:old('tipo_unidad') }}" disabled autocomplete="tipo_unidad" autofocus>
    
                                    @error('tipo_unidad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="orden" class="col-md-4 col-form-label text-md-right">{{ __('Orden') }}</label>
    
                                <div class="col-md-6">
                                    <input id="orden" type="number" class="form-control @error('orden') is-invalid @enderror" name="orden" value="{{ isset($etapa->orden)?$etapa->orden:old('orden') }}" disabled autocomplete="orden" autofocus>
    
                                    @error('orden')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('etapa.index') }}">Atras</a>
                                </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','etapa.edit')
                                    <a href="{{ route('etapa.edit',$etapa->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','etapa.destroy')
                                    <form action="{{ route('etapa.destroy',$etapa->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                                    </form>
                                @endcan
                            </div> 
                            </div> 
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection