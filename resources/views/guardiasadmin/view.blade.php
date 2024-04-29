@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Guardia</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }}</label>
    
                                <div class="col-md-6">
                                    <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($guardiasadmin->fecha)?$guardiasadmin->fecha:old('fecha') }}" autocomplete="fecha" disabled autofocus>
    
                                    @error('fecha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>
                                <div class="col-md-6">
                                    <select name="id_sucursal" id="id_sucursal" class="form-control" disabled>
                                    <option value="">Seleccionar sucursal</option>
                                        @foreach($sucursals as $sucursal)
                                        <option value="{{ $sucursal->id }}"
                                        @isset($guardiasadmin->sucursals->NombSucu)
                                            @if($sucursal->NombSucu == $guardiasadmin->sucursals->NombSucu)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $sucursal->NombSucu }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('guardiasadmin.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','guardiasadmin.edit')
                            <a href="{{ route('guardiasadmin.edit',$guardiasadmin->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','guardiasadmin.destroy')
                            <form action="{{ route('guardiasadmin.destroy',$guardiasadmin->id) }}" method="post">
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