@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ingresar alerta') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/alerta') }}">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p>
                        <div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">{{ __('Hora') }} *</label>

                            <div class="col-md-6">
                                <input id="hora" type="text" class="form-control @error('hora') is-invalid @enderror" name="hora" value="{{ old('hora') }}" autocomplete="hora" autofocus>

                                @error('hora')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} *</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control @error('DescAsis') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" rows="12" required autocomplete="descripcion" autofocus></textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="pin" class="col-md-4 col-form-label text-md-right">{{ __('PIN') }} *</label>

                            <div class="col-md-6">
                                <input id="pin" type="text" class="form-control @error('pin') is-invalid @enderror" name="pin" value="{{ old('pin') }}" required autocomplete="pin" autofocus>

                                @error('pin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="accion" class="col-md-4 col-form-label text-md-right">{{ __('Acción tomada por el concesionario') }}</label>

                            <div class="col-md-6">
                                <textarea id="accion" class="form-control @error('accion') is-invalid @enderror" name="accion" value="{{ old('accion') }}" rows="8" autocomplete="accion" autofocus></textarea>

                                @error('accion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="presupuesto" class="col-md-4 col-form-label text-md-right">{{ __('N° Presupuesto') }}</label>

                            <div class="col-md-6">
                                <input id="presupuesto" type="number" class="form-control @error('presupuesto') is-invalid @enderror" name="presupuesto" value="{{ old('presupuesto') }}" autocomplete="presupuesto" autofocus>

                                @error('presupuesto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cor" class="col-md-4 col-form-label text-md-right">{{ __('N° COR') }}</label>

                            <div class="col-md-6">
                                <input id="cor" type="number" class="form-control @error('cor') is-invalid @enderror" name="cor" value="{{ old('cor') }}" autocomplete="cor" autofocus>

                                @error('cor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ __('Ingresar') }}
                                  
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
