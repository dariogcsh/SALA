@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Paso</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="id_etapa" class="col-md-4 col-form-label text-md-right">{{ __('Etapa') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('id_etapa') is-invalid @enderror" data-live-search="true" name="id_etapa" value="{{ isset($paso->id_etapa)?$paso->id_etapa:old('id_etapa') }}" disabled autocomplete="id_etapa" autofocus>
                                        <option value="">Seleccionar etapa</option>
                                        @foreach ($etapas as $etapa)
                                            <option value="{{ $etapa->id }}" 
                                            @isset($paso->id_etapa)
                                                    @if($etapa->id == $paso->id_etapa)
                                                        selected
                                                    @endif
                                            @endisset
                                                >{{ $etapa->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_etapa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_puesto" class="col-md-4 col-form-label text-md-right">{{ __('Puesto responsable') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('id_puesto') is-invalid @enderror" data-live-search="true" name="id_puesto" value="{{ isset($paso->id_puesto)?$paso->id_puesto:old('id_puesto') }}" disabled autocomplete="id_puesto" autofocus>
                                        <option value="">Seleccionar etapa</option>
                                        @foreach ($puestos as $puesto)
                                            <option value="{{ $puesto->id }}" 
                                            @isset($paso->id_puesto)
                                                    @if($puesto->id == $paso->id_puesto)
                                                        selected
                                                    @endif
                                            @endisset
                                                >{{ $puesto->NombPuEm }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_puesto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Paso') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($paso->nombre)?$paso->nombre:old('nombre') }}" disabled autocomplete="nombre" autofocus>
    
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="orden" class="col-md-4 col-form-label text-md-right">{{ __('Orden') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="orden" type="number" class="form-control @error('orden') is-invalid @enderror" name="orden" value="{{ isset($paso->orden)?$paso->orden:old('orden') }}" disabled autocomplete="orden" autofocus>
    
                                    @error('orden')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('paso.index') }}">Atras</a>
                                </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','paso.edit')
                                    <a href="{{ route('paso.edit',$paso->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','paso.destroy')
                                    <form action="{{ route('paso.destroy',$paso->id) }}" method="post">
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