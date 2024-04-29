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
                                <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" disabled autofocus>
                                        <option value="">Seleccionar Organización</option>
                                        @foreach ($organizaciones as $organizacion)
                                            <option value="{{ $organizacion->id }}" 
                                            @isset($senal->organizacions->NombOrga)
                                                    @if($organizacion->NombOrga == $senal->organizacions->NombOrga)
                                                        selected
                                                    @endif
                                            @endisset
                                                >{{ $organizacion->NombOrga }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_organizacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_antena" class="col-md-4 col-form-label text-md-right">{{ __('Antena') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('id_antena') is-invalid @enderror" data-live-search="true" name="id_antena" value="{{ isset($senal->id_antena)?$senal->id_antena:old('id_antena') }}" disabled autofocus>
                                        <option value="">Seleccionar antena</option>
                                        @foreach ($antenas as $antena)
                                            <option value="{{ $organizacion->id }}" 
                                            @isset($senal->antenas->NombAnte)
                                                    @if($antena->NombAnte == $senal->antenas->NombAnte)
                                                        selected
                                                    @endif
                                            @endisset
                                                >{{ $antena->NombAnte }}</option>
                                        @endforeach
                                    </select>
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
                                    <input id="nserie" type="text" class="form-control @error('nserie') is-invalid @enderror" name="nserie" value="{{ isset($senal->nserie)?$senal->nserie:old('nserie') }}" disabled autofocus>
    
                                    @error('nserie')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="activacion" class="col-md-4 col-form-label text-md-right">{{ __('Fecha activación') }}</label>
                            
                                <div class="col-md-6">
                                    <input id="activacion" type="text" class="form-control @error('activacion') is-invalid @enderror" name="activacion" value="{{ old('activacion', date("d/m/Y",strtotime($senal->activacion))) }}" disabled autofocus>
                            
                                    @error('activacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="duracion" class="col-md-4 col-form-label text-md-right">{{ __('Duracion') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('duracion') is-invalid @enderror" name="duracion" value="{{ isset($senal->duracion)?$senal->duracion:old('duracion') }}" disabled autofocus>
                                        @isset($senal->duracion)
                                            <option value="{{ $senal->duracion }}">{{ $senal->duracion }}</option>
                                        @endisset
                                        <option value="3meses">3 meses</option>
                                        <option value="6meses">6 meses</option>
                                        <option value="12meses">12 meses</option>
                                        <option value="24meses">24 meses</option>
                                        <option value="36meses">36 meses</option>
                                    </select>
                                    @error('duracion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo') }}</label>
    
                                <div class="col-md-6">
                                    <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($senal->costo)?$senal->costo:old('costo') }}" disabled autofocus>
    
                                    @error('costo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_bonificacion" class="col-md-4 col-form-label text-md-right">{{ __('Bonificación') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('id_bonificacion') is-invalid @enderror" data-live-search="true" name="id_bonificacion" value="{{ isset($senal->id_bonificacion)?$senal->id_bonificacion:old('id_bonificacion') }}" disabled autofocus>
                                        <option value="">Seleccionar bonificacion</option>
                                        @isset($misbonificaciones)
                                            @foreach ($misbonificaciones as $mibonificacion)
                                                @isset($senal->mibonificacions->id)
                                                    @if($mibonificacion->id == $senal->mibonificacions->id)
                                                        <option value="{{ $mibonificacion->id }}" selected>{{ $mibonificacion->tipo }} - {{ $mibonificacion->descuento }}% </option>
                                                    @endif
                                                @endisset
                                            @endforeach
                                        @endisset
                                    </select>
                                    @error('id_bonificacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado interno') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ old('estado') }}" disabled autofocus>           
                                        @isset($senal->estado)
                                            <option value="{{ $senal->estado }}">{{ $senal->estado }}</option>
                                        @endisset
                                        <option value="Solicitado">Solicitado</option>
                                        <option value="En facturacion">En facturacion</option>
                                        <option value="Facturado">Facturado</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
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
                                    <input id="nfactura" type="text" class="form-control @error('nfactura') is-invalid @enderror" name="nfactura" value="{{ isset($senal->nfactura)?$senal->nfactura:old('nfactura') }}" disabled autocomplete="nfactura" autofocus>
    
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
                            <a class="btn btn-light btn-block" href="{{ route('senal.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','senal.edit')
                            <a href="{{ route('senal.edit',$senal->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','senal.destroy')
                            <form action="{{ route('senal.destroy',$senal->id) }}" method="post">
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