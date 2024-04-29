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
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }} *</label>
    
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
                                <label for="patente" class="col-md-4 col-form-label text-md-right">{{ __('Patente') }} </label>
    
                                <div class="col-md-6">
                                    <input id="patente" type="text" class="form-control @error('patente') is-invalid @enderror" name="patente" value="{{ isset($vehiculo->patente)?$vehiculo->patente:old('patente') }}" disabled autocomplete="patente" autofocus>
    
                                    @error('patente')
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