@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Vehículo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="id_vsat" class="col-md-4 col-form-label text-md-right">{{ __('Id VSat') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="id_vsat" type="text" class="form-control @error('id_vsat') is-invalid @enderror" name="id_vsat" value="{{ isset($vehiculo->id_vsat)?$vehiculo->id_vsat:old('id_vsat') }}" disabled autocomplete="id_vsat" autofocus>
    
                                    @error('id_vsat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre en VSat') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($vehiculo->nombre)?$vehiculo->nombre:old('nombre') }}" disabled autocomplete="nombre" autofocus>
    
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="marca" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="marca" type="text" class="form-control @error('marca') is-invalid @enderror" name="marca" value="{{ isset($vehiculo->marca)?$vehiculo->marca:old('marca') }}" disabled autocomplete="marca" autofocus>
    
                                    @error('marca')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }} * </label>
    
                                <div class="col-md-6">
                                    <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{ isset($vehiculo->modelo)?$vehiculo->modelo:old('modelo') }}" disabled autocomplete="modelo" autofocus>
    
                                    @error('modelo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="ano" class="col-md-4 col-form-label text-md-right">{{ __('Año') }} </label>
    
                                <div class="col-md-6">
                                    <input id="ano" type="number" class="form-control @error('ano') is-invalid @enderror" name="ano" value="{{ isset($vehiculo->ano)?$vehiculo->ano:old('ano') }}" disabled autocomplete="ano" autofocus>
    
                                    @error('ano')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="patente" class="col-md-4 col-form-label text-md-right">{{ __('Patente') }} * </label>
    
                                <div class="col-md-6">
                                    <input id="patente" type="text" class="form-control @error('patente') is-invalid @enderror" name="patente" value="{{ isset($vehiculo->patente)?$vehiculo->patente:old('patente') }}" disabled placeholder="AA111BB" autocomplete="patente" autofocus>
    
                                    @error('patente')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nvehiculo" class="col-md-4 col-form-label text-md-right">{{ __('N° Vehiculo SALA') }} </label>
    
                                <div class="col-md-6">
                                    <input id="nvehiculo" type="number" class="form-control @error('nvehiculo') is-invalid @enderror" name="nvehiculo" value="{{ isset($vehiculo->nvehiculo)?$vehiculo->nvehiculo:old('nvehiculo') }}" disabled autocomplete="nvehiculo" autofocus>
    
                                    @error('nvehiculo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} </label>
    
                                <div class="col-md-6">
                                    <input id="id_sucursal" type="text" class="form-control @error('id_sucursal') is-invalid @enderror" name="id_sucursal" value="{{ isset($sucursal->NombSucu)?$sucursal->NombSucu:old('id_sucursal') }}" disabled autocomplete="id_sucursal" autofocus>
    
                                    @error('id_sucursal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="tipo_registro" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Registro (Leasing/SALA)') }} </label>
    
                                <div class="col-md-6">
                                    <input id="tipo_registro" type="text" class="form-control @error('tipo_registro') is-invalid @enderror" name="tipo_registro" value="{{ isset($vehiculo->tipo_registro)?$vehiculo->tipo_registro:old('tipo_registro') }}" disabled autocomplete="tipo_registro" autofocus>
    
                                    @error('tipo_registro')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="seguro" class="col-md-4 col-form-label text-md-right">{{ __('Seguro') }} </label>
    
                                <div class="col-md-6">
                                    <input id="seguro" type="text" class="form-control @error('seguro') is-invalid @enderror" name="seguro" value="{{ isset($vehiculo->seguro)?$vehiculo->seguro:old('seguro') }}" disabled placeholder="Opcional" autocomplete="seguro" autofocus>
    
                                    @error('seguro')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="vto_poliza" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de vencimiento poliza') }} </label>
    
                                <div class="col-md-6">
                                    <input id="vto_poliza" type="date" class="form-control @error('vto_poliza') is-invalid @enderror" name="vto_poliza" value="{{ isset($vehiculo->vto_poliza)?$vehiculo->vto_poliza:old('vto_poliza') }}" disabled autocomplete="vto_poliza" autofocus>
    
                                    @error('vto_poliza')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nchasis" class="col-md-4 col-form-label text-md-right">{{ __('N° Chasis') }} </label>
    
                                <div class="col-md-6">
                                    <input id="nchasis" type="text" class="form-control @error('nchasis') is-invalid @enderror" name="nchasis" value="{{ isset($vehiculo->nchasis)?$vehiculo->nchasis:old('nchasis') }}" placeholder="Opcional" disabled autocomplete="nchasis" autofocus>
    
                                    @error('nchasis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nmotor" class="col-md-4 col-form-label text-md-right">{{ __('N° de motor') }} </label>
    
                                <div class="col-md-6">
                                    <input id="nmotor" type="text" class="form-control @error('nmotor') is-invalid @enderror" name="nmotor" value="{{ isset($vehiculo->nmotor)?$vehiculo->nmotor:old('nmotor') }}" disabled placeholder="Opcional" autocomplete="nmotor" autofocus>
    
                                    @error('nmotor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="departamento" class="col-md-4 col-form-label text-md-right">{{ __('Departamento') }} </label>
    
                                <div class="col-md-6">
                                    <input id="departamento" type="text" class="form-control @error('departamento') is-invalid @enderror" name="departamento" value="{{ isset($vehiculo->departamento)?$vehiculo->departamento:old('departamento') }}" disabled placeholder="Opcional" autocomplete="departamento" autofocus>
    
                                    @error('departamento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_user" class="col-md-4 col-form-label text-md-right">{{ __('Responsables') }} </label>
    
                                <div class="col-md-6">
                                    <label class="form-control-textarea @error('id_user') is-invalid @enderror"  id="id_user" name="id_user" disabled>
                                        @foreach ($usuarios as $usuario)
                                            @isset($usuarios_responsables)
                                                @foreach($usuarios_responsables as $user_responsable)
                                                    @if($usuario->id == $user_responsable->id_user)
                                                        {{ $usuario->name }} {{ $usuario->last_name }} - 
                                                    @endif
                                                @endforeach   
                                            @endisset
                                        @endforeach
                                    </label>
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
                                    <a class="btn btn-light btn-block" href="{{ route('vehiculo.index') }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','vehiculo.edit')
                                        <a href="{{ route('vehiculo.edit',$vehiculo->id) }}" class="btn btn-warning btn-block">Editar</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','vehiculo.destroy')
                                    <form action="{{ route('vehiculo.destroy',$vehiculo->id) }}" method="post">
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