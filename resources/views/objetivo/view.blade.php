@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Objetivo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">
                            <div class="form-group row">
                                <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('CodiOrga') }}</label>
    
                                <div class="col-md-6">
                                <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" value="{{ isset($organizacion->CodiOrga)?$organizacion->CodiOrga:old('CodiOrga') }}" disabled>
                                    <option value="{{ $data->organi }}">{{ $data->NombOrga }}</option>
                                    
                                </select>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_maquina" class="col-md-4 col-form-label text-md-right">{{ __('Maquina') }} *</label>
                                <div class="col-md-6">
                                <select class="form-control @error('id_maquina') is-invalid @enderror" name="id_maquina" id="id_maquina" value="{{ old('NumSMaq') }}" autofocus disabled> 
                                    <option value="{{ $data->id }}">{{ $data->NumSMaq }}</option>
                                </select>
                                    @error('id_maquina')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_tipoobjetivo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de objetivo') }} *</label>
                                <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_tipoobjetivo') is-invalid @enderror" data-live-search="true" name="id_tipoobjetivo" id="id_tipoobjetivo" value="{{ old('id_tipoobjetivo') }}" title="Seleccionar Organizacion" autofocus disabled> 
                                    <option value="{{ $data->tipoobj }}">{{ $data->nombre }}</option>
                                     
                                       
                                </select>
                                    @error('id_tipoobjetivo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="objetivo" class="col-md-4 col-form-label text-md-right">{{ __('objetivo') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="objetivo" type="text" class="form-control @error('objetivo') is-invalid @enderror" name="objetivo" value="{{ isset($objetivo->objetivo)?$objetivo->objetivo:old('objetivo') }}" disabled autocomplete="objetivo" autofocus>
    
                                    @error('objetivo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('objetivo.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','objetivo.edit')
                            <a href="{{ route('objetivo.edit',$objetivo->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','objetivo.destroy')
                            <form action="{{ route('objetivo.destroy',$objetivo->id) }}" method="post">
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