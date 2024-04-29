@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Factura monitoreo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="id_organizacion" type="text" class="form-control @error('id_organizacion') is-invalid @enderror" name="id_organizacion" value="{{ isset($organizacion->NombOrga)?$organizacion->NombOrga:old('NombOrga') }}" autocomplete="id_organizacion" disabled>

                                    @error('id_organizacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            @for($i = 0; $i <= 20; $i++)
                                @isset($monitoreo_maquinas[$i])
                                    <div id='equipo{{ $i }}' style='display: block'>
                                @else
                                    <div id='equipo{{ $i }}' style='display: none'>
                                @endisset
    
                                    <div class="form-group row">
                                        <label for="NumSMaq{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie*') }}</label>
    
                                        <div class="col-md-6">
                                            <input id="NumSMaq{{ $i }}" type="text" class="form-control @error('NumSMaq{{ $i }}') is-invalid @enderror" name="NumSMaq{{ $i }}" value="{{ isset($monitoreo_maquinas[$i]['NumSMaq'])?$monitoreo_maquinas[$i]['NumSMaq']:old('NumSMaq'.$i) }}" autocomplete="NumSMaq{{ $i }}" disabled>
    
                                            @error('NumSMaq{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="costo{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Costo (US$)*') }}</label>
    
                                        <div class="col-md-6">
                                            <input id="costo{{ $i }}" type="number" class="form-control @error('costo{{ $i }}') is-invalid @enderror" name="costo{{ $i }}" value="{{ isset($monitoreo_maquinas[$i]['costo'])?$monitoreo_maquinas[$i]['costo']:old('costo'.$i) }}" autocomplete="costo{{ $i }}" onKeyUp="calcular(this);" disabled>
    
                                            @error('costo{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @endfor
                            <br>
                            <div class="form-group row">
                                <label for="costo_total" class="col-md-4 col-form-label text-md-right">{{ __('Costo total (US$)') }}</label>
    
                                <div class="col-md-6">
                                    <input id="costo_total" type="number" class="form-control @error('costo_total') is-invalid @enderror" name="costo_total" value="{{ isset($monitoreo->costo_total)?$monitoreo->costo_total:old('costo_total') }}" autocomplete="costo_total" disabled>
    
                                    @error('costo_total')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="anofiscal" class="col-md-4 col-form-label text-md-right">{{ __('Año Fiscal') }}</label>
    
                                <div class="col-md-6">
                                    <input id="anofiscal" type="number" class="form-control @error('anofiscal') is-invalid @enderror" name="anofiscal" value="{{ isset($monitoreo->anofiscal)?$monitoreo->anofiscal:old('anofiscal') }}" autocomplete="anofiscal" disabled>
    
                                    @error('anofiscal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="mes_facturacion" class="col-md-4 col-form-label text-md-right">{{ __('¿Mes de facturación?') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('mes_facturacion') is-invalid @enderror" id="mes_facturacion" name="mes_facturacion" value="{{ isset($monitoreo->mes_facturacion)?$monitoreo->mes_facturacion:old('mes_facturacion') }}" disabled>
                                        <option value="">{{ $monitoreo->mes_facturacion }}</option>
                                       
                                    </select>
                                    @error('mes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de paquete') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ isset($monitoreo->tipo)?$monitoreo->tipo:old('tipo') }}" required disabled>
                                        <option value="">{{ $monitoreo->tipo }}</option>
                                    </select>
                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ isset($monitoreo->estado)?$monitoreo->estado:old('estado') }}" required disabled>
                                        <option value="">{{ $monitoreo->estado }}</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="factura" class="col-md-4 col-form-label text-md-right">{{ __('N° de factura') }}</label>
    
                                <div class="col-md-6">
                                    <input id="factura" type="text" class="form-control @error('factura') is-invalid @enderror" name="factura" value="{{ isset($monitoreo->factura)?$monitoreo->factura:old('factura') }}" autocomplete="factura" disabled>
    
                                    @error('factura')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="fecha_facturada" class="col-md-4 col-form-label text-md-right">{{ __('Fecha en que se facturó') }}</label>
    
                                <div class="col-md-6">
                                    <input id="fecha_facturada" type="date" class="form-control @error('fecha_facturada') is-invalid @enderror" name="fecha_facturada" value="{{ isset($monitoreo->fecha_facturada)?$monitoreo->fecha_facturada:old('fecha_facturada') }}" autocomplete="fecha_facturada" disabled>
    
                                    @error('fecha_facturada')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('monitoreo.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','monitoreo.edit')
                            <a href="{{ route('monitoreo.edit',$monitoreo->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','monitoreo.destroy')
                            <form action="{{ route('monitoreo.destroy',$monitoreo->id) }}" method="post">
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