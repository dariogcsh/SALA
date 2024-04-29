@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Antena</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Titulo') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ isset($tutorial->titulo)?$tutorial->titulo:old('titulo') }}" required autocomplete="titulo" disabled>
    
                                    @error('titulo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }}</label>
                            
                                <div class="col-md-6">
                                    <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" autocomplete="descripcion" disabled>{{ isset($tutorial->descripcion)?$tutorial->descripcion:old('descripcion') }}</textarea>
                            
                                    <span class="text-danger" id="comentariosError"></span>
                                </div>
                            </div> 
    
                            <div class="form-group row">
                                <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('URL') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ isset($tutorial->url)?$tutorial->url:old('url') }}" required autocomplete="url" disabled>
    
                                    @error('url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('antena.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','antena.edit')
                            <a href="{{ route('antena.edit',$antena->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','antena.destroy')
                            <form action="{{ route('antena.destroy',$antena->id) }}" method="post">
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