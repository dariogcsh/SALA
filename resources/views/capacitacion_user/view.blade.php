@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Capacitación de usuario</h2></div>

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
                                <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ isset($capacitacion_user->estado)?$capacitacion_user->estado:old('estado') }}" disabled autocomplete="estado" autofocus>
                                        @isset($capacitacion_user->estado)
                                            <option value="{{ $capacitacion_user->estado }}" selected>{{ $capacitacion_user->estado }}</option>
                                        @else
                                            <option value="">Seleccionar estado</option>
                                        @endisset
                                        <option value="Inscripto">Inscripto</option>
                                        <option value="Finalizado">Finalizado</option>
                                        <option value="Ausente">Ausente</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="comentario" class="col-md-4 col-form-label text-md-right">{{ __('Comentario') }} </label>
    
                                <div class="col-md-6">
                                    <textarea rows="7" id="comentario" class="form-control-textarea @error('comentario') is-invalid @enderror" name="comentario" value="{{ old('comentario') }}" autocomplete="comentario" autofocus disabled>@isset($capacitacion_user->comentario){{ $capacitacion_user->comentario }}@endisset</textarea>
    
                                    @error('comentario')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ url('capacitacion_user/'.$capacitacion_user->id) }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','capacitacion_user.edit')
                                        <a href="{{ route('capacitacion_user.edit',$capacitacion_user->id) }}" class="btn btn-warning btn-block">Editar</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','capacitacion_user.destroy')
                                        <form action="{{ route('capacitacion_user.destroy',$capacitacion_user->id) }}" method="post">
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