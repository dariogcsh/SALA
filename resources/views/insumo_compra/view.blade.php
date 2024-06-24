@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Compra</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="proveedor" class="col-md-4 col-form-label text-md-right">{{ __('Proveedor') }} </label>
    
                                <div class="col-md-6">
                                    <input id="proveedor" type="date" class="form-control @error('proveedor') is-invalid @enderror" name="proveedor" value="{{ isset($insumo_compra->proveedor)?$insumo_compra->proveedor:old('proveedor') }}" disabled autofocus>
    
                                    @error('proveedor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fecha_compra" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de compra') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="fecha_compra" type="date" class="form-control @error('fecha_compra') is-invalid @enderror" name="fecha_compra" value="{{ isset($insumo_compra->fecha_compra)?$insumo_compra->fecha_compra:old('fecha_compra') }}" disabled autofocus>
    
                                    @error('fecha_compra')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nfactura" class="col-md-4 col-form-label text-md-right">{{ __('N° de factura') }} </label>
    
                                <div class="col-md-6">
                                    <input id="nfactura" type="text" class="form-control @error('nfactura') is-invalid @enderror" name="nfactura" value="{{ isset($insumo_compra->nfactura)?$insumo_compra->nfactura:old('nfactura') }}" disabled autofocus>
    
                                    @error('nfactura')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }} </label>
    
                                <div class="col-md-6">
                                    <input id="categoria" type="text" class="form-control @error('categoria') is-invalid @enderror" name="categoria" value="{{ isset($insumo->categoria)?$insumo->categoria:old('categoria') }}" disabled  autocomplete="id_insumo" autofocus>
    
                                    @error('categoria')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_insumo" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }} </label>
    
                                <div class="col-md-6">
                                    <input id="id_insumo" type="text" class="form-control @error('id_insumo') is-invalid @enderror" name="id_insumo" value="{{ isset($insumo->nombreinsumo)?$insumo->nombreinsumo:old('id_nombre') }}" disabled  autocomplete="id_insumo" autofocus>
    
                                    @error('id_insumo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nombremarca" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }} </label>
    
                                <div class="col-md-6">
                                    <input id="nombremarca" type="text" class="form-control @error('nombremarca') is-invalid @enderror" name="nombremarca" value="{{ isset($insumo->nombremarca)?$insumo->nombremarca:old('nombremarca') }}" disabled  autocomplete="nombremarca" autofocus>
    
                                    @error('nombremarca')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="litros" class="col-md-4 col-form-label text-md-right">{{ __('Litros') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="litros" type="decimal" step="0.01" class="form-control @error('litros') is-invalid @enderror" name="litros" value="{{ isset($insumo_compra->litros)?$insumo_compra->litros:old('litros') }}" disabled autofocus>
    
                                    @error('litros')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="peso" class="col-md-4 col-form-label text-md-right">{{ __('Kg') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="peso" type="decimal" step="0.01" class="form-control @error('peso') is-invalid @enderror" name="peso" value="{{ isset($insumo_compra->peso)?$insumo_compra->peso:old('peso') }}" disabled autofocus>
    
                                    @error('peso')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="bultos" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de bolsas') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="bultos" type="decimal" step="0.01" class="form-control @error('bultos') is-invalid @enderror" name="bultos" value="{{ isset($insumo_compra->bultos)?$insumo_compra->bultos:old('bultos') }}" disabled autofocus>
    
                                    @error('bultos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                           
                            <div class="form-group row">
                                <label for="semillas" class="col-md-4 col-form-label text-md-right">{{ __('Semillas por bolsa') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="semillas" type="text" class="form-control @error('semillas') is-invalid @enderror" name="semillas" value="{{ isset($insumo_compra->semillas)?$insumo_compra->semillas:old('semillas') }}" disabled autocomplete="semillas" autofocus>
    
                                    @error('semillas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio (US$) por unidad de medida') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="precio" type="decimal" step="0.01" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ isset($insumo_compra->precio)?$insumo_compra->precio:old('precio') }}"  disabled autofocus>
    
                                    @error('precio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('insumo_compra.index') }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','insumo_compra.edit')
                                    <a href="{{ route('insumo_compra.edit',$insumo_compra->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','insumo_compra.destroy')
                                    <form action="{{ route('insumo_compra.destroy',$insumo_compra->id) }}" method="post">
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