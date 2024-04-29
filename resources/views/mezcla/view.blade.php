@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Mezcla</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Dá un nombre a la mezcla') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($mezcla->nombre)?$mezcla->nombre:old('nombre') }}" required autocomplete="nombre" disabled>
    
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($mezclainsus as $mezclainsu)  
                                    <div class="form-group row">
                                        <label for="id_insumo{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }}</label>
    
                                        <div class="col-md-6">
                                            <select class="form-control @error('id_insumo{{ $i }}') is-invalid @enderror" id="id_insumo{{ $i }}" name="id_insumo{{ $i }}" value="{{  isset($mezclainsu->id_insumo)?$mezclainsu->id_insumo:old('id_insumo'.$i) }}" disabled> 
                                                <option value="">Seleccionar insumo</option>
                                                @foreach($insumos as $insumo)
                                                    @if($insumo->id == $mezclainsu->id_insumo)
                                                        <option value="{{ $insumo->id }}" selected>{{ $insumo->nombre }} </option>
                                                    @else
                                                        <option value="{{ $insumo->id }}">{{ $insumo->nombre }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
    
                                            @error('id_insumo{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="cantidad{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>
    
                                        <div class="col-md-6">
                                            <input id="cantidad{{ $i }}" type="number" step="0.01" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}" value="{{ isset($mezclainsu->cantidad)?$mezclainsu->cantidad:old('cantidad'.$i) }}" autocomplete="cantidad{{ $i }}" disabled>
    
                                            @error('cantidad{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                    @php
                                        $i++;
                                    @endphp
                            @endforeach


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('mezcla.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                            @can('haveaccess','mezcla.edit')
                                <a href="{{ route('mezcla.edit',$mezcla->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                                @can('haveaccess','mezcla.agregar')
                                    <a href="{{ route('mezcla.agregar',$mezcla->id) }}" class="btn btn-success btn-block">Agregar</a>
                                @endcan
                            </div>
                            <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                            @can('haveaccess','mezcla.destroy')
                            <form action="{{ route('mezcla.destroyinsumo',$mezcla->id) }}" method="post">
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