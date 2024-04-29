@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Paquete de mantenimiento</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="id_tipo_paquete_mant" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de paquete de mantenimiento') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="id_tipo_paquete_mant" type="text" class="form-control @error('id_tipo_paquete_mant') is-invalid @enderror" name="id_tipo_paquete_mant" value="{{ isset($paquetemant->id_tipo_paquete_mant)?$paquetemant->id_tipo_paquete_mant:old('id_tipo_paquete_mant') }}" disabled autocomplete="id_tipo_paquete_mant" autofocus>
    
                                    @error('id_tipo_paquete_mant')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción de tarea') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ isset($paquetemant->descripcion)?$paquetemant->descripcion:old('descripcion') }}" disabled autocomplete="descripcion" autofocus>
    
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Horas') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="horas" type="text" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($paquetemant->horas)?$paquetemant->horas:old('horas') }}" disabled autocomplete="horas" autofocus>
    
                                    @error('horas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_repuesto" class="col-md-4 col-form-label text-md-right">{{ __('Repuesto') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="id_repuesto" type="text" class="form-control @error('id_repuesto') is-invalid @enderror" name="id_repuesto" value="{{ isset($paquetemant->id_repuesto)?$paquetemant->id_repuesto:old('id_repuesto') }}" disabled autocomplete="id_repuesto" autofocus>
    
                                    @error('id_repuesto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cantidad" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="cantidad" type="text" class="form-control @error('cantidad') is-invalid @enderror" name="cantidad" value="{{ isset($paquetemant->cantidad)?$paquetemant->cantidad:old('cantidad') }}" disabled autocomplete="cantidad" autofocus>
    
                                    @error('cantidad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('paquetemant.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','paquetemant.edit')
                            <a href="{{ route('paquetemant.edit',$paquetemant->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','paquetemant.destroy')
                            <form action="{{ route('paquetemant.destroy',$paquetemant->id) }}" method="post">
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