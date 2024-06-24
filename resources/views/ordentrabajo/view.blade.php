@php
    use App\mezcla;
    use App\mezcla_insu;
    use App\orden_insumo;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Orden de trabajo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>
    
                                <div class="col-md-6">
                                    <input id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ isset($ordentrabajo->tipo)?$ordentrabajo->tipo:old('tipo') }}" disabled autofocus>
    
                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_lote" class="col-md-4 col-form-label text-md-right">{{ __('Lote') }} </label>
                                
                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('id_usuariotrabajo') is-invalid @enderror" data-live-search="true" id="id_lote" name="id_lote" value="{{ isset($ordentrabajo->id_usuariotrabajo)?$ordentrabajo->id_usuariotrabajo:old('id_usuariotrabajo') }}" autocomplete="id_usuariotrabajo" disabled autofocus>
                                            <option value="{{ $lote->id }}" data-subtext="{{ $lote->client }} - {{ $lote->farm }}"><small>{{ $lote->name }} - {{ $lote->farm }} - {{ $lote->name }} </small></option>
                                    </select>
                                    @error('id_lote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_usuarioorden" class="col-md-4 col-form-label text-md-right">{{ __('Usuario que crea la órden') }}</label>
    
                                <div class="col-md-6">
                                    <input id="id_usuarioorden" type="text" class="form-control @error('id_usuarioorden') is-invalid @enderror" id="id_usuarioorden" name="id_usuarioorden" value="{{ isset($usuarioorden->last_name)?$usuarioorden->last_name.' '.$usuarioorden->name:old('id_usuarioorden') }}" disabled autofocus>
    
                                    @error('id_usuarioorden')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_usuariotrabajo" class="col-md-4 col-form-label text-md-right">{{ __('Usuario que ejecuta trabajo') }}</label>
    
                                <div class="col-md-6">
                                    <input id="id_usuariotrabajo" type="text" class="form-control @error('id_usuariotrabajo') is-invalid @enderror" id="id_usuariotrabajo" name="id_usuariotrabajo" value="{{ isset($usuariotrabajo->last_name)?$usuariotrabajo->last_name.' '.$usuariotrabajo->name:old('id_usuariotrabajo') }}" disabled autofocus>
    
                                    @error('id_usuariotrabajo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fechaindicada" class="col-md-4 col-form-label text-md-right">{{ __('Fecha indicada') }}</label>
    
                                <div class="col-md-6">
                                    <input id="fechaindicada" type="date" class="form-control @error('fechaindicada') is-invalid @enderror" id="fechaindicada" name="fechaindicada" value="{{ isset($ordentrabajo->fechaindicada)?$ordentrabajo->fechaindicada:old('fechaindicada') }}" disabled autofocus>
    
                                    @error('fechaindicada')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="has" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de hectáreas') }}</label>
    
                                <div class="col-md-6">
                                    <input id="has" type="number" step="0.01" class="form-control @error('has') is-invalid @enderror" id="has" name="has" value="{{ isset($ordentrabajo->has)?$ordentrabajo->has:old('has') }}" disabled autofocus>
    
                                    @error('has')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prescripcion" class="col-md-4 col-form-label text-md-right">{{ __('Estado de trabajo') }}</label>
    
                                <div class="col-md-6">
                                    <input id="prescripcion" type="text" step="0.01" class="form-control @error('prescripcion') is-invalid @enderror" id="prescripcion" name="prescripcion" value="{{ isset($ordentrabajo->prescripcion)?$ordentrabajo->prescripcion:old('prescripcion') }}" disabled autofocus>
    
                                    @error('prescripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fechainicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio') }}</label>
    
                                <div class="col-md-6">
                                    <input id="fechainicio" type="date" class="form-control @error('fechainicio') is-invalid @enderror" id="fechainicio" name="fechainicio" value="{{ isset($ordentrabajo->fechainicio)?$ordentrabajo->fechainicio:old('fechainicio') }}" disabled autofocus>
    
                                    @error('fechainicio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fechafin" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de finalización') }}</label>
    
                                <div class="col-md-6">
                                    <input id="fechafin" type="date" class="form-control @error('fechafin') is-invalid @enderror" id="fechafin" name="fechafin" value="{{ isset($ordentrabajo->fechafin)?$ordentrabajo->fechafin:old('fechafin') }}" disabled autofocus>
    
                                    @error('fechafin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado de trabajo') }}</label>
    
                                <div class="col-md-6">
                                    <input id="estado" type="text" step="0.01" class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ isset($ordentrabajo->estado)?$ordentrabajo->estado:old('estado') }}" disabled autofocus>
    
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prescripcion" class="col-md-4 col-form-label text-md-right">{{ __('Prescripción') }}</label>
    
                                <div class="col-md-6">
                                    <input id="prescripcion" type="text" step="0.01" class="form-control @error('prescripcion') is-invalid @enderror" id="prescripcion" name="prescripcion" value="{{ isset($ordentrabajo->prescripcion)?$ordentrabajo->prescripcion:old('prescripcion') }}" disabled autofocus>
    
                                    @error('prescripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <br>
                        <h4>Insumos</h4>
                        <hr>    
                        @php
                            $i = 0;
                        @endphp
                        @foreach($insumos as $insumo)
                            @if(!isset($insumo->id_mezcla))
                                <div class="form-group row">
                                    <label for="id_insumo{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }}</label>

                                    <div class="col-md-6">
                                        <select class="selectpicker form-control @error('id_insumo{{ $i }}') is-invalid @enderror" data-live-search="true" id="id_insumo{{ $i }}" name="id_insumo{{ $i }}" value="{{ isset($insumo->unidades)?$insumo->unidades:$insumo->lts }}" disabled autofocus> 
                                            <option>{{ $insumo->insumo }} </option>        
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

                                    <div class="col-md-4">
                                        @isset($insumo->unidades)
                                            @if($insumo->unidades > 0)
                                                <input id="cantidad{{ $i }}" type="text" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}" value="{{number_format($insumo->unidades)}}" disabled autofocus>
                                            @endif
                                        @endisset
                                        @isset($insumo->lts)
                                            @if($insumo->lts > 0)
                                                <input id="cantidad{{ $i }}" type="text" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}" value="{{number_format($insumo->lts)}}" disabled autofocus>
                                            @endif
                                        @endisset
                                        @isset($insumo->kg)
                                            @if($insumo->kg > 0)
                                                <input id="cantidad{{ $i }}" type="text" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}" value="{{number_format($insumo->kg)}}" disabled autofocus>
                                            @endif
                                        @endisset
                                        
                                        @error('cantidad{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            
                                    <div class="col-md-2">
                                        <input id="unidades_medidas{{ $i }}" type="text" class="form-control @error('unidades_medidas{{ $i }}') is-invalid @enderror" name="unidades_medidas{{ $i }}" value="{{ isset($insumo->unidades)?" semillas/ha":""}}{{isset($insumo->lts)?" lts/ha":""}}{{isset($insumo->kg)?" kg/ha":""}}" disabled autofocus>
                                        @error('unidades_medidas{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="dosis_variable" class="col-md-4 col-form-label text-md-right">{{ __('Dosis variable') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="dosis_variable" type="text" class="form-control @error('dosis_variable') is-invalid @enderror" id="dosis_variable" name="dosis_variable" value="{{ isset($insumo->dosis_variable)?$insumo->dosis_variable:old('dosis_variable') }}" disabled autofocus>
        
                                        @error('dosis_variable')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="has_variable" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad hectáreas') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="has_variable" type="text" class="form-control @error('has_variable') is-invalid @enderror" id="has_variable" name="has_variable" value="{{ isset($insumo->has_variable)?$insumo->has_variable:old('has_variable') }}" disabled autofocus>
        
                                        @error('has_variable')
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
                            @endif
                        @endforeach
                        <br>
                        <h4>Mezclas de tanque</h4>
                                <hr>
                        @php
                            $ordenes = Orden_insumo::where('id_ordentrabajo',$ordentrabajo->id)
                                                    ->groupBy('id_mezcla')->get()
                        @endphp

                        @foreach($ordenes as $orden)
                            @if(isset($orden->id_mezcla))
                            @php
                                $mezclas2 = Orden_insumo::where([['id_mezcla',$orden->id_mezcla], ['id_ordentrabajo',$ordentrabajo->id]])->get();
                                $mezcla = Mezcla::where('id',$orden->id_mezcla)->first();
                            @endphp

                                    <div class="form-group row">
                                        <label for="id_mezcla{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Mezcla de tanque') }}</label>

                                        <div class="col-md-6">
                                            <select class="selectpicker form-control @error('id_mezcla{{ $i }}') is-invalid @enderror" data-live-search="true" id="{{ $i }}" name="id_mezcla{{ $i }}" value="{{ old('id_mezcla'.$i) }}" disabled autofocus> 
                                                    <option value="{{ $mezcla->id }}">{{ $mezcla->nombre }} </option>
                                            </select>

                                            @error('id_mezcla{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    @foreach($mezclas2 as $mezcla2)
                                        <div class="form-group row">
                                            <label for="id_insumo{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }}</label>
        
                                            <div class="col-md-6">
                                                <select class="selectpicker form-control @error('id_insumo{{ $i }}') is-invalid @enderror" data-live-search="true" id="id_insumo{{ $i }}" name="id_insumo{{ $i }}" value="{{ isset($insumo->unidades)?$insumo->unidades:$insumo->lts }}" disabled autofocus> 
                                                    <option>{{ $mezcla2->insumo }} </option>        
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
                                            
                                            <div class="col-md-4">
                                                <input id="cantidad{{ $i }}" type="text" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}" 
                                                @isset($mezcla2->unidades)
                                                @if($mezcla2->unidades <> 0)
                                                    value="{{ $mezcla2->unidades }}"
                                                @endif
                                                @endisset
                                                @isset($mezcla2->lts)
                                                    @if($mezcla2->lts <> 0)
                                                        value="{{ $mezcla2->lts }}"
                                                    @endif
                                                @endisset
                                                @isset($mezcla2->kg)
                                                    @if($mezcla2->kg <> 0)
                                                        value="{{ $mezcla2->kg }}"
                                                    @endif
                                                @endisset
                                                autocomplete="cantidad{{ $i }}" disabled autofocus>
                                                @error('cantidad{{ $i }}')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div><div class="col-md-2">
                                                <input id="unidades_medidas_mez{{ $i }}" type="text" class="form-control @error('unidades_medidas_mez{{ $i }}') is-invalid @enderror" name="unidades_medidas_mez{{ $i }}" 
                                                @isset($mezcla2->unidades)
                                                @if($mezcla2->unidades <> 0)
                                                    value="semillas/ha"
                                                @endif
                                                @endisset
                                                @isset($mezcla2->lts)
                                                    @if($mezcla2->lts <> 0)
                                                        value="lts/ha"
                                                    @endif
                                                @endisset
                                                @isset($mezcla2->kg)
                                                    @if($mezcla2->kg <> 0)
                                                        value="kg/ha"
                                                    @endif
                                                @endisset
                                                 disabled autofocus>
                                                @error('unidades_medidas_mez{{ $i }}')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="dosis_variable" class="col-md-4 col-form-label text-md-right">{{ __('Dosis variable') }}</label>
                
                                            <div class="col-md-6">
                                                <input id="dosis_variable" type="text" class="form-control @error('dosis_variable') is-invalid @enderror" id="dosis_variable" name="dosis_variable" value="{{ isset($mezcla2->dosis_variable)?$mezcla2->dosis_variable:old('dosis_variable') }}" disabled autofocus>
                
                                                @error('dosis_variable')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label for="has_variable" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad hectáreas') }}</label>
                
                                            <div class="col-md-6">
                                                <input id="has_variable" type="text" class="form-control @error('has_variable') is-invalid @enderror" id="has_variable" name="has_variable" value="{{ isset($mezcla2->has_variable)?$mezcla2->has_variable:old('has_variable_mez') }}" disabled autofocus>
                
                                                @error('has_variable')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr>
                                @endforeach
                            @endif
                        @endforeach

                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('ordentrabajo.index') }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','ordentrabajo.edit')
                                        <a href="{{ route('ordentrabajo.edit',$ordentrabajo->id) }}" class="btn btn-warning btn-block">Editar</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','ordentrabajo.destroy')
                                    <form action="{{ route('ordentrabajo.destroy',$ordentrabajo->id) }}" method="post">
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