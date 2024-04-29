@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Beneficio</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                        <div class="form-group row">
                            <label for="id_bonificacion" class="col-md-4 col-form-label text-md-right">{{ __('Bonificacion') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_bonificacion') is-invalid @enderror" name="id_bonificacion" value="{{ $bonificacion->id }}" disabled autofocus>           
                                    <option value="{{ $bonificacion->id }}">{{ $bonificacion->tipo }}</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organización') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_organizacion') is-invalid @enderror" name="id_organizacion" value="{{ $organizacion->id }}" disabled autofocus>           
                                    <option value="{{ $organizacion->id }}">{{ $organizacion->NombOrga }}</option>
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ $mibonificacion->estado }}" disabled autofocus>           
                                    <option value="{{ $mibonificacion->estado }}">{{ $mibonificacion->estado }}</option>
                                    <option value="Solicitado">Solicitado</option>
                                    <option value="Aceptado">Aceptar</option>
                                    <option value="Rechazado">Rechazar</option>
                                    <option value="Aplicado">Aplicar</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('mibonificacion.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','mibonificacion.edit')
                            <a href="{{ route('mibonificacion.edit',$mibonificacion->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','mibonificacion.destroy')
                            <form action="{{ route('mibonificacion.destroy',$mibonificacion->id) }}" method="post">
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