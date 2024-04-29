@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Repuesto</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Código') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ isset($repuesto->codigo)?$repuesto->codigo:old('codigo') }}" disabled autocomplete="codigo" autofocus>
    
                                    @error('codigo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($repuesto->nombre)?$repuesto->nombre:old('nombre') }}" disabled autocomplete="nombre" autofocus>
    
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo (US$) *') }} </label>
    
                                <div class="col-md-6">
                                    <input id="costo" type="number" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($repuesto->costo)?$repuesto->costo:old('costo') }}" disabled autofocus>
    
                                    @error('costo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="margen" class="col-md-4 col-form-label text-md-right">{{ __('Margen (%$) *') }} </label>
    
                                <div class="col-md-6">
                                    <input id="margen" type="number" class="form-control @error('margen') is-invalid @enderror" name="margen" value="{{ isset($repuesto->margen)?$repuesto->margen:old('margen') }}" disabled autofocus>
    
                                    @error('margen')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="venta" class="col-md-4 col-form-label text-md-right">{{ __('Venta (US$) *') }} </label>
    
                                <div class="col-md-6">
                                    <input id="venta" type="number" class="form-control @error('venta') is-invalid @enderror" name="venta" value="{{ isset($repuesto->venta)?$repuesto->venta:old('venta') }}" disabled autofocus>
    
                                    @error('venta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jdpart" class="col-md-4 col-form-label text-md-right">{{ __('JDPart (US$) *') }} </label>
    
                                <div class="col-md-6">
                                    <input id="jdpart" type="number" step="0.01" class="form-control @error('jdpart') is-invalid @enderror" name="jdpart" value="{{ isset($repuesto->jdpart)?$repuesto->jdpart:old('jdpart') }}" autofocus>
    
                                    @error('jdpart')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('repuesto.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','repuesto.edit')
                            <a href="{{ route('repuesto.edit',$repuesto->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','repuesto.destroy')
                            <form action="{{ route('repuesto.destroy',$repuesto->id) }}" method="post">
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