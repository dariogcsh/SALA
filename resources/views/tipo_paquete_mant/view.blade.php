@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Tipo de paquete de mantenimiento</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo de equipo') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{ isset($tipo_paquete_mant->modelo)?$tipo_paquete_mant->modelo:old('modelo') }}" disabled autocomplete="modelo" autofocus>
    
                                    @error('modelo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Horas *') }} </label>
    
                                <div class="col-md-6">
                                    <input id="horas" type="number" step="0.01" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($tipo_paquete_mant->horas)?$tipo_paquete_mant->horas:old('horas') }}" disabled autofocus>
    
                                    @error('horas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo (US$) *') }} </label>
    
                                <div class="col-md-6">
                                    <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($tipo_paquete_mant->costo)?$tipo_paquete_mant->costo:old('costo') }}" disabled autofocus>
    
                                    @error('costo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('tipo_paquete_mant.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','tipo_paquete_mant.edit')
                            <a href="{{ route('tipo_paquete_mant.edit',$tipo_paquete_mant->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','tipo_paquete_mant.destroy')
                            <form action="{{ route('tipo_paquete_mant.destroy',$tipo_paquete_mant->id) }}" method="post">
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