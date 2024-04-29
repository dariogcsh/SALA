@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Insumo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                                                    
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }} *</label>

                            <div class="col-md-6">
                                <input id="categoria" type="text" class="form-control @error('categoria') is-invalid @enderror" name="categoria" value="{{ isset($insumo->categoria)?$insumo->categoria:old('categoria') }}" disabled autocomplete="categoria" autofocus>

                                @error('categoria')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_marcainsumo" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }} *</label>

                            <div class="col-md-6">
                                <input id="id_marcainsumo" type="text" class="form-control @error('id_marcainsumo') is-invalid @enderror" name="id_marcainsumo" value="{{ isset($marca->nombre)?$marca->nombre:old('insumo') }}" disabled autocomplete="id_marcainsumo" autofocus>

                                @error('id_marcainsumo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($insumo->nombre)?$insumo->nombre:old('nombre') }}" disabled autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        @if($insumo->categoria == "Variedad/Hibrido")
                            <div id="producto_quimico" name="producto_quimico" style="display: none;">
                        @else
                            <div id="producto_quimico" name="producto_quimico">
                        @endif
                            <div class="form-group row">
                                <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>

                                <div class="col-md-6">
                                    <input id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ isset($insumo->tipo)?$insumo->tipo:old('tipo') }}" autocomplete="tipo" disabled autofocus>

                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    

                            <div class="form-group row">
                                <label for="principio_activo" class="col-md-4 col-form-label text-md-right">{{ __('Principio activo') }}</label>

                                <div class="col-md-6">
                                    <input id="principio_activo" type="text" class="form-control @error('principio_activo') is-invalid @enderror" name="principio_activo" value="{{ isset($insumo->principio_activo)?$insumo->principio_activo:old('principio_activo') }}" autocomplete="principio_activo" disabled autofocus>

                                    @error('principio_activo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="concentracion" class="col-md-4 col-form-label text-md-right">{{ __('Concentración') }}</label>

                                <div class="col-md-6">
                                    <input id="concentracion" type="text" class="form-control @error('concentracion') is-invalid @enderror" name="concentracion" value="{{ isset($insumo->concentracion)?$insumo->concentracion:old('concentracion') }}" autocomplete="concentracion" disabled autofocus>

                                    @error('concentracion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bultos" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de bolsas/tanques') }}</label>

                            <div class="col-md-6">
                                <input id="bultos" type="text" class="form-control @error('bultos') is-invalid @enderror" name="bultos" value="{{ isset($insumo->bultos)?$insumo->bultos:old('bultos') }}" autocomplete="bultos" disabled autofocus>

                                @error('bultos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cantxbulto" class="col-md-4 col-form-label text-md-right">{{ __('Capacidad de bolsa/tanque (Kg/Lts)') }}</label>

                            <div class="col-md-6">
                                <input id="cantxbulto" type="text" class="form-control @error('cantxbulto') is-invalid @enderror" name="cantxbulto" value="{{ isset($insumo->cantxbulto)?$insumo->cantxbulto:old('cantxbulto') }}" disabled autocomplete="cantxbulto" autofocus>

                                @error('cantxbulto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="litros" class="col-md-4 col-form-label text-md-right">{{ __('Litros') }}</label>

                            <div class="col-md-6">
                                <input id="litros" type="text" class="form-control @error('litros') is-invalid @enderror" name="litros" value="{{ isset($insumo->litros)?$insumo->litros:old('litros') }}" autocomplete="litros" disabled autofocus>

                                @error('litros')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="peso" class="col-md-4 col-form-label text-md-right">{{ __('Peso (Kg)') }}</label>

                            <div class="col-md-6">
                                <input id="peso" type="text" class="form-control @error('peso') is-invalid @enderror" name="peso" value="{{ isset($insumo->peso)?$insumo->peso:old('peso') }}" autocomplete="peso" disabled autofocus>

                                @error('peso')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semillas" class="col-md-4 col-form-label text-md-right">{{ __('Semillas') }}</label>

                            <div class="col-md-6">
                                <input id="semillas" type="text" class="form-control @error('semillas') is-invalid @enderror" name="semillas" value="{{ isset($insumo->semillas)?$insumo->semillas:old('semillas') }}" disabled autocomplete="semillas" autofocus>

                                @error('semillas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('insumo.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','insumo.edit')
                            <a href="{{ route('insumo.edit',$insumo->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','insumo.destroy')
                            <form action="{{ route('insumo.destroy',$insumo->id) }}" method="post">
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