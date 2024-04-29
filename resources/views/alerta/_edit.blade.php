@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar alerta') }}</div>

                <div class="card-body">   
                    <form method="POST" action="{{ url('/alerta/'.$alerta->id) }}">
                        @csrf
                        @method('patch')
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p>
                        <div class="form-group row">
                            <label for="NombOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>
    
                            <div class="col-md-6">
                                <input id="NombOrga" type="text" class="form-control @error('NombOrga') is-invalid @enderror" name="NombOrga" value="{{ isset($alerta->NombOrga)?$alerta->NombOrga:old('NombOrga') }}" disabled autocomplete="NombOrga" autofocus>
    
                                @error('NombOrga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>
    
                            <div class="col-md-6">
                                <input id="sucursal" type="text" class="form-control @error('sucursal') is-invalid @enderror" name="sucursal" value="{{ isset($alerta->NombSucu)?$alerta->NombSucu:old('NombSucu') }}" disabled autocomplete="NombSucu" autofocus>
    
                                @error('sucursal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        
                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }} *</label>

                            <div class="col-md-6">
                                <input id="fecha" type="text" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($alerta->fecha)?date('d/m/Y',strtotime($alerta->fecha)):old('fecha') }}" disabled autocomplete="fecha" autofocus>

                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">{{ __('Hora') }} *</label>

                            <div class="col-md-6">
                                <input id="hora" type="text" class="form-control @error('hora') is-invalid @enderror" name="hora" value="{{ isset($alerta->hora)?$alerta->hora:old('hora') }}" disabled autocomplete="hora" autofocus>

                                @error('hora')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-6">
                                <img class="img img-responsive" src="/imagenes/{{ $alerta->TipoMaq }}.png" height="30px"> <b>{{ $alerta->ModeMaq }}</b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="anio" class="col-md-4 col-form-label text-md-right">{{ __('Año') }}</label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('anio') is-invalid @enderror" value="{{  isset($alerta->anio)?$alerta->anio:old('anio') }}" disabled autofocus>
    
                                @error('anio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="horasm" class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor') }}</label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('horasm') is-invalid @enderror" value="{{  isset($alerta->horas)?$alerta->horas:old('horas') }}" disabled autofocus>
    
                                @error('horasm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} *</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control @error('DescAsis') is-invalid @enderror" name="descripcion" value="{{ isset($alerta->descripcion)?$alerta->descripcion:old('descripcion') }}" disabled required autocomplete="descripcion" autofocus rows="12">{{ isset($alerta->descripcion)?$alerta->descripcion:old('descripcion') }}</textarea>

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
                                <input id="pin" type="text" class="form-control @error('pin') is-invalid @enderror" name="pin" value="{{ isset($alerta->pin)?$alerta->pin:old('pin') }}" disabled autocomplete="pin" autofocus>

                                @error('pin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        @isset($alerta->lat)
                            @isset($alerta->lon)
                                <div class="form-group row">
                                    <label for="ubicacion" class="col-md-4 col-form-label text-md-right">{{ __('Ubicación') }}</label>
                                    <div class="col-md-6">
                                        <iframe class="iframe" src="https://maps.google.com/?q={{ $alerta->lat }},{{ $alerta->lon }}&z=14&t=k&output=embed" height="400" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endisset
                        @endisset

                        <div class="form-group row">
                            <label for="accion" class="col-md-4 col-form-label text-md-right">{{ __('Acción tomada por el concesionario') }}</label>

                            <div class="col-md-6">
                                <textarea id="accion" class="form-control @error('accion') is-invalid @enderror" name="accion" value="{{ old('accion') }}" autocomplete="accion" autofocus rows="8">{{ isset($alerta->accion)?$alerta->accion:old('accion') }}</textarea>

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
                                <input id="presupuesto" type="number" class="form-control @error('presupuesto') is-invalid @enderror" name="presupuesto" value="{{ isset($alerta->presupuesto)?$alerta->presupuesto:old('presupuesto') }}" autocomplete="presupuesto" autofocus>

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
                                <input id="cor" type="number" class="form-control @error('cor') is-invalid @enderror" name="cor" value="{{ isset($alerta->cor)?$alerta->cor:old('cor') }}" autocomplete="cor" autofocus>

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
                                {{__('Enviar') }}
                                  
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