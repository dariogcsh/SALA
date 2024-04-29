@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Alquiler de señal</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="organizacion_id" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
    
                                    <div class="col-md-6">
                                        <input id="organizacion_id" type="text" class="form-control @error('organizacion_id') is-invalid @enderror" name="organizacion_id" value="{{ isset($activacion->organizacions->NombOrga)?$activacion->organizacions->NombOrga:old('NombOrga') }}" disabled autocomplete="organizacion_id" autofocus>
        
                                    @error('organizacion_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="pantalla_id" class="col-md-4 col-form-label text-md-right">{{ __('Pantalla') }}</label>
    
                                <div class="col-md-6">
                                    <input id="pantalla_id" type="text" class="form-control @error('pantalla_id') is-invalid @enderror" name="pantalla_id" value="{{ isset($activacion->pantallas->NombPant)?$activacion->pantallas->NombPant:old('pantalla_id') }}" autocomplete="pantalla_id" disabled autofocus>
    
                                    @error('pantalla_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_antena" class="col-md-4 col-form-label text-md-right">{{ __('Antena') }}</label>
    
                                <div class="col-md-6">
                                    <input id="id_antena" type="text" class="form-control @error('id_antena') is-invalid @enderror" name="id_antena" value="{{ isset($activacion->antenas->NombAnte)?$activacion->antenas->NombAnte:old('id_antena') }}" autocomplete="id_antena" disabled autofocus>
    
                                    @error('id_antena')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nserie" class="col-md-4 col-form-label text-md-right">{{ __('N° serie') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="nserie" type="text" class="form-control @error('nserie') is-invalid @enderror" name="nserie" value="{{ isset($activacion->nserie)?$activacion->nserie:old('nserie') }}" autocomplete="nserie" disabled autofocus>
    
                                    @error('nserie')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="suscripcion_id" class="col-md-4 col-form-label text-md-right">{{ __('Suscripción') }}</label>
    
                                <div class="col-md-6">
                                    <input id="suscripcion_id" type="text" class="form-control @error('suscripcion_id') is-invalid @enderror" name="suscripcion_id" value="{{ isset($activacion->suscripcions->nombre)?$activacion->suscripcions->nombre:old('suscripcion_id') }}" disabled autocomplete="nfactura" autofocus>
    
                                    @error('suscripcion_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="duracion" class="col-md-4 col-form-label text-md-right">{{ __('Duracion (años)') }}</label>
    
                                <div class="col-md-6">
                                    <input id="duracion" type="text" class="form-control @error('duracion') is-invalid @enderror" name="duracion" value="{{ isset($activacion->duracion)?$activacion->duracion:old('duracion') }}" disabled autocomplete="duracion" autofocus>
    
                                    @error('duracion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>
    
                                <div class="col-md-6">
                                    <input id="precio" type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ isset($activacion->precio)?$activacion->precio:old('precio') }}" disabled autocomplete="precio" placeholder="Ej: 650" autofocus>
    
                                    @error('precio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha activación') }}</label>
                            
                                <div class="col-md-6">
                                    <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($activacion->fecha)?$activacion->fecha:old('fecha') }}" disabled autofocus>
                            
                                    @error('fecha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado interno') }}</label>
    
                                <div class="col-md-6">
                                    <input id="estado" type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ isset($activacion->estado)?$activacion->estado:old('estado') }}" disabled autocomplete="nfactura" autofocus>
    
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nfactura" class="col-md-4 col-form-label text-md-right">{{ __('N° de factura') }} </label>
    
                                <div class="col-md-6">
                                    <input id="nfactura" type="text" class="form-control @error('nfactura') is-invalid @enderror" name="nfactura" value="{{ isset($activacion->nfactura)?$activacion->nfactura:old('nfactura') }}" disabled autocomplete="nfactura" autofocus>
    
                                    @error('nfactura')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_user" class="col-md-4 col-form-label text-md-right">{{ __('Usuario solicitante') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="id_user" type="text" class="form-control @error('id_user') is-invalid @enderror" name="id_user" value="{{ isset($usuario->name)?$usuario->name. ' ' .$usuario->last_name:old('name') }}" disabled autofocus>
    
                                    @error('id_user')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('activacion.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','activacion.edit')
                            <a href="{{ route('activacion.edit',$activacion->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','activacion.destroy')
                            <form action="{{ route('activacion.destroy',$activacion->id) }}" method="post">
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