@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Capacitacion</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de capacitación') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($capacitacion->nombre)?$capacitacion->nombre:old('nombre') }}" disabled autofocus>
    
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ isset($capacitacion->codigo)?$capacitacion->codigo:old('codigo') }}" disabled autofocus>
    
                                    @error('codigo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>
    
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('codigo') is-invalid @enderror" value="{{ isset($capacitacion->tipo)?$capacitacion->tipo:old('tipo') }}" disabled>
                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="modalidad" class="col-md-4 col-form-label text-md-right">{{ __('Modalidad') }}</label>
    
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('codigo') is-invalid @enderror" value="{{ isset($capacitacion->modalidad)?$capacitacion->modalidad:old('modalidad') }}" disabled>
                                    @error('modalidad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="valoracion" class="col-md-4 col-form-label text-md-right">{{ __('Valoración') }} </label>
    
                                <div class="col-md-6">
                                    <textarea rows="7" id="valoracion" class="form-control-textarea @error('valoracion') is-invalid @enderror" name="valoracion" value="{{ old('valoracion') }}" autocomplete="valoracion" autofocus disabled>@isset($capacitacion->valoracion){{ $capacitacion->valoracion }}@endisset</textarea>
    
                                    @error('valoracion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="fechainicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="fechainicio" type="date" class="form-control @error('fechainicio') is-invalid @enderror" name="fechainicio" value="{{ isset($capacitacion->fechainicio)?$capacitacion->fechainicio:old('fechainicio') }}" disabled required>
    
                                    @error('fechainicio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="horainicio" class="col-md-4 col-form-label text-md-right">{{ __('Hora de inicio') }} </label>
    
                                <div class="col-md-6">
                                    <input id="horainicio" type="time" class="form-control @error('horainicio') is-invalid @enderror" name="horainicio" value="{{ isset($horarios->horainicio)?$horarios->horainicio:old('horainicio') }}" disabled autofocus>
    
                                    @error('horainicio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="fechafin" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de finalización') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="fechafin" type="date" class="form-control @error('fechafin') is-invalid @enderror" name="fechafin" value="{{ isset($capacitacion->fechafin)?$capacitacion->fechafin:old('fechafin') }}" disabled required>
    
                                    @error('fechafin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="horafin" class="col-md-4 col-form-label text-md-right">{{ __('Hora de finalización') }} </label>
    
                                <div class="col-md-6">
                                    <input id="horafin" type="time" class="form-control @error('horafin') is-invalid @enderror" name="horafin" value="{{ isset($horarios->horafin)?$horarios->horafin:old('horafin') }}" disabled autofocus>
    
                                    @error('horafin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de horas') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="horas" type="number" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($capacitacion->horas)?$capacitacion->horas:old('horas') }}" disabled autofocus>
    
                                    @error('horas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo US$') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($capacitacion->costo)?$capacitacion->costo:old('costo') }}" disabled autofocus>
    
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
                                    <a class="btn btn-light btn-block" href="{{ url('capacitacion/index_view/'.$capacitacion->id) }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','capacitacion.edit')
                                        <a href="{{ route('capacitacion.edit',$capacitacion->id) }}" class="btn btn-warning btn-block">Editar</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','capacitacion.destroy')
                                        <form action="{{ route('capacitacion.destroy',$capacitacion->id) }}" method="post">
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