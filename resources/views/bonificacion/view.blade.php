@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Beneficio</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>

                                <div class="col-md-6">
                                    <input id="tipo" type="text" class="form-control" name="tipo" value="{{ old('tipo', $bonificacion->tipo) }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="descuento" class="col-md-4 col-form-label text-md-right">{{ __('Descuento %') }}</label>

                                <div class="col-md-6">
                                    <input id="descuento" type="text" class="form-control" name="descuento" value="{{ old('descuento', $bonificacion->descuento) }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo US$') }}</label>

                                <div class="col-md-6">
                                    <input id="costo" type="text" class="form-control" name="costo" value="{{ old('costo', $bonificacion->costo) }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="imagen" class="col-md-4 col-form-label text-md-right">{{ __('Imagen') }}</label>

                                <div class="col-md-6">
                                   <img src="{{ asset('img/bonificaciones/'.$bonificacion->imagen) }}" class="img img-responsive" width="150px">
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="descuento" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>

                                <div class="col-md-6">
                                    <textarea id="descripcion" type="text" class="form-control-textarea" name="descripcion" disabled>{{ old('descripcion', $bonificacion->descripcion) }}</textarea>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="desde" class="col-md-4 col-form-label text-md-right">{{ __('Vigencia desde') }} *</label>
                            
                                <div class="col-md-6">
                                    <input id="desde" type="date" class="form-control @error('desde') is-invalid @enderror" name="desde" value="{{ old('desde', $bonificacion->desde) }}" disabled autofocus>
                                    
                                    @error('desde')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="hasta" class="col-md-4 col-form-label text-md-right">{{ __('Vigencia hasta') }} *</label>
                            
                                <div class="col-md-6">
                                    <input id="hasta" type="date" class="form-control @error('hasta') is-invalid @enderror" name="hasta" value="{{ old('hasta', $bonificacion->hasta) }}" disabled autofocus>
                                    
                                    @error('hasta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('bonificacion.index') }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','bonificacion.edit')
                                        <a href="{{ route('bonificacion.edit',$bonificacion->id) }}" class="btn btn-warning btn-block">Editar</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','bonificacion.destroy')
                                        <form action="{{ route('bonificacion.destroy',$bonificacion->id) }}" method="post">
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