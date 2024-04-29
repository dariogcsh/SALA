@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de clientes contactados
                </h2></div>
                <div class="card-body">
                    <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                    <div class="form-group row">
                        <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                        <div class="col-md-6">
                            <select class=" form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" name="id_organizacion" value="{{ isset($organizacion->id_organizacion)?$organizacion->id_organizacion:old('id_organizacion') }}" disabled autocomplete="id_organizacion" autofocus>
                                    <option>{{ $organizacion->NombOrga }}</option>
                            </select>
                            @error('id_organizacion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="persona" class="col-md-4 col-form-label text-md-right">{{ __('¿Aquién contactó?') }} *</label>

                        <div class="col-md-6">
                            <input id="persona" type="text" class="form-control @error('persona') is-invalid @enderror" name="persona" value="{{ isset($contacto->persona)?$contacto->persona:old('persona') }}" disabled autocomplete="persona" placeholder="" autofocus>

                            @error('persona')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('TipoMaq') }} *</label>

                        <div class="col-md-6">
                        <select class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ isset($contacto->tipo)?$contacto->tipo:old('tipo') }}" disabled autocomplete="tipo" autofocus>
                            @isset($contacto->tipo)
                                <option value="{{ $contacto->tipo }}">{{ $contacto->tipo }}</option>
                            @else
                                <option value="">Seleccionar tipo de contacto</option>
                            @endisset
                                <option value="Llamado">Llamado</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Videollamada">Videollamada</option>
                                <option value="En concesionario">En concesionario</option>
                                <option value="En campo">En campo</option>
                        </select>
         
                            @error('tipo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="departamento" class="col-md-4 col-form-label text-md-right">{{ __('Departamento') }} *</label>

                        <div class="col-md-6">
                            <select class="form-control @error('departamento') is-invalid @enderror" name="departamento" value="{{ isset($contacto->departamento)?$contacto->departamento:old('departamento') }}" disabled autocomplete="departamento" autofocus>
                            @isset($contacto->departamento)
                                <option value="{{ $contacto->departamento }}">{{ $contacto->departamento }}</option>
                            @else
                                <option value="">Departamento</option>
                            @endisset
                                <option value="Ventas">Ventas</option>
                                <option value="Posventa">Posventa</option>
                                <option value="Centro de Soluciones Conectadas">Centro de Soluciones Conectadas</option>
                        </select>

                            @error('departamento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="comentarios" class="col-md-4 col-form-label text-md-right">{{ __('Comentarios') }}</label>

                        <div class="col-md-6">
                            <textarea id="comentarios" class="form-control-textarea @error('comentarios') is-invalid @enderror" name="comentarios" disabled autocomplete="comentarios" autofocus>{{ isset($contacto->comentarios)?$contacto->comentarios:old('comentarios') }}</textarea>

                            @error('comentarios')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('contacto.index') }}">Atras</a>
                        </div>
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','contacto.edit')
                                <a href="{{ route('contacto.edit',$contacto->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                        </div>
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','contacto.destroy')
                                <form action="{{ route('contacto.destroy',$contacto->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                                </form>
                            @endcan
                        </div> 
                    </div> 
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection