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
                <div class="card-header">{{ __('Modificar órden de trabajo') }}</div>

                <div class="card-body">
                
                    <form method="POST" id="formulario1" action="{{ url('/ordentrabajo/'.$ordentrabajo->id) }}">
                        @csrf
                        @method('patch')
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p>
                        <input type="text" hidden value="{{ $organizacion }}" id="id_organizacion" name="id_organizacion"> 
                        <input type="text" hidden value="{{ $ordentrabajo->id }}" id="orden_de_trabajo" name="orden_de_trabajo">
                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de trabajo') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ old('tipo') }}" required autofocus> 
                                    @isset($ordentrabajo->tipo)
                                        @if($ordentrabajo->tipo == "Siembra")
                                            <option value="Siembra" selected>Siembra</option>
                                            <option value="Fertilizacion">Fertilizacion</option>
                                            <option value="Aplicacion">Aplicacion</option>
                                            <option value="Cosecha">Cosecha</option>
                                        @elseif($ordentrabajo->tipo == "Fertilizacion")
                                            <option value="Siembra">Siembra</option>
                                            <option value="Fertilizacion" selected>Fertilizacion</option>
                                            <option value="Aplicacion">Aplicacion</option>
                                            <option value="Cosecha">Cosecha</option>
                                        @elseif($ordentrabajo->tipo == "Aplicacion")
                                            <option value="Siembra">Siembra</option>
                                            <option value="Fertilizacion">Fertilizacion</option>
                                            <option value="Aplicacion" selected>Aplicacion</option>
                                            <option value="Cosecha">Cosecha</option>
                                        @else
                                            <option value="Siembra">Siembra</option>
                                            <option value="Fertilizacion">Fertilizacion</option>
                                            <option value="Aplicacion">Aplicacion</option>
                                            <option value="Cosecha" selected>Cosecha</option>
                                        @endif
                                    @else
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Siembra">Siembra</option>
                                        <option value="Fertilizacion">Fertilizacion</option>
                                        <option value="Aplicacion">Aplicacion</option>
                                        <option value="Cosecha">Cosecha</option>
                                    @endisset
                                </select>

                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="id_lote" class="col-md-4 col-form-label text-md-right">{{ __('Lote') }} *</label>
                            
                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_usuariotrabajo') is-invalid @enderror" data-live-search="true" id="id_lote" name="id_lote" value="{{ isset($ordentrabajo->id_usuariotrabajo)?$ordentrabajo->id_usuariotrabajo:old('id_usuariotrabajo') }}" required autocomplete="id_usuariotrabajo" autofocus>
                                    <option value="">Seleccionar lote</option>
                                    @foreach ($lotes as $lote)
                                        <option value="{{ $lote->id }}" data-subtext="{{ $lote->client }} - {{ $lote->farm }}"
                                        @isset($lotetrabajo->id)
                                                @if($lote->id == $lotetrabajo->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $lote->name }}</option>
                                    @endforeach
                                </select>
                                @error('id_lote')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @can('haveaccess','ordentrabajo.create')
                            <div class="col-md-2">
                                <a href="{{ route('lote.create') }}" title="Crear máquina nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea ccrear una máquina nueva y salir de la orden de trabajo?');"><b>+</b></a>
                            </div>
                            @endcan
                            
                        </div>
                        
                        <div class="form-group row">
                            <label for="id_usuarioorden" class="col-md-4 col-form-label text-md-right">{{ __('Usuario emisor de órden de trabajo') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_usuarioorden') is-invalid @enderror" id="id_usuarioorden" name="id_usuarioorden" value="{{ old('id_usuarioorden') }}" readonly autofocus> 
                                    <option value="{{ $usuarioorden->id }}" selected>{{ $usuarioorden->last_name }} {{ $usuarioorden->name }}</option>
                                </select>

                                @error('id_usuarioorden')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_usuariotrabajo" class="col-md-4 col-form-label text-md-right">{{ __('Usuario receptor de órden de trabajo') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_usuariotrabajo') is-invalid @enderror" data-live-search="true" id="id_usuariotrabajo" name="id_usuariotrabajo" value="{{ isset($ordentrabajo->id_usuariotrabajo)?$ordentrabajo->id_usuariotrabajo:old('id_usuariotrabajo') }}" required autocomplete="id_usuariotrabajo" autofocus>
                                    <option value="">Seleccionar usuario</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuariotrabajo->id)
                                                @if($usuario->id == $usuariotrabajo->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->last_name }} {{ $usuario->name }}</option>
                                    @endforeach
                                </select>
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
                                <input id="fechaindicada" type="date" class="form-control @error('fechaindicada') is-invalid @enderror" id="fechaindicada" name="fechaindicada" value="{{ isset($ordentrabajo->fechaindicada)?$ordentrabajo->fechaindicada:old('fechaindicada') }}" autofocus>

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
                                <input id="has" type="number" step="0.01" class="form-control @error('has') is-invalid @enderror" id="has" name="has" value="{{ isset($ordentrabajo->has)?$ordentrabajo->has:old('has') }}" autofocus>

                                @error('has')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prescripcion" class="col-md-4 col-form-label text-md-right">{{ __('Prescripción') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @if($ordentrabajo->prescripcion == "SI")
                                        <input type="checkbox" class="warning" name="prescripcion" checked>
                                    @else
                                        <input type="checkbox" class="warning" name="prescripcion">
                                    @endif
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dosis_variable" class="col-md-4 col-form-label text-md-right">{{ __('Dosis variable') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @foreach($orden_insumos as $insumo)
                                        @php
                                            $dosis_v = $insumo->dosis_variable;
                                        @endphp
                                    @endforeach
                                    @if($dosis_v == "SI")
                                        <input type="checkbox" class="warning" name="dosis_variable" id="dosis_variable" onchange="javascript:mostrarVar()" checked>
                                    @else
                                        <input type="checkbox" class="warning" name="dosis_variable" id="dosis_variable" onchange="javascript:mostrarVar()">
                                    @endif
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fechainicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio') }}</label>

                            <div class="col-md-6">
                                <input id="fechainicio" type="date" class="form-control @error('fechainicio') is-invalid @enderror" id="fechainicio" name="fechainicio" value="{{ isset($ordentrabajo->fechainicio)?$ordentrabajo->fechainicio:old('fechainicio') }}" autofocus>

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
                                <input id="fechafin" type="date" class="form-control @error('fechafin') is-invalid @enderror" id="fechafin" name="fechafin" value="{{ isset($ordentrabajo->fechafin)?$ordentrabajo->fechafin:old('fechafin') }}" autofocus>

                                @error('fechafin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                            
                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('estado') is-invalid @enderror" data-live-search="true" id="estado" name="estado" value="{{ isset($ordentrabajo->estado)?$ordentrabajo->estado:old('estado') }}" required autocomplete="estado" autofocus>
                                    <option value="">Seleccionar estado del trabajo</option>
                                        <option value="Enviado" @isset($ordentrabajo->estado) @if($ordentrabajo->estado == "Enviado") selected @endif @endisset>Enviado</option>
                                        <option value="En ejecucion" @isset($ordentrabajo->estado) @if($ordentrabajo->estado == "En ejecucion") selected @endif @endisset>En ejecucion</option>
                                        <option value="Finalizado" @isset($ordentrabajo->estado) @if($ordentrabajo->estado == "Finalizado") selected @endif @endisset>Finalizado</option>
                                        <option value="Cancelado" @isset($ordentrabajo->estado) @if($ordentrabajo->estado == "Cancelado") selected @endif @endisset>Cancelado</option>
                                </select>
                                @error('estado')
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
                            $z=0;
                        @endphp
                        @foreach($orden_insumos as $orden_insumo)
                                @php
                                    $z++;
                                    $orden_insu_id[$z] = $orden_insumo->id;
                                    $orden_insu[$z] = $orden_insumo->insumo;
                                    $orden_insu_mezcla[$z] = $orden_insumo->id_mezcla;
                                    $orden_insu_unidades[$z] = $orden_insumo->unidades;
                                    $orden_insu_kg[$z] = $orden_insumo->kg;
                                    $orden_insu_lts[$z] = $orden_insumo->lts;
                                    $orden_insu_hasv[$z] = $orden_insumo->has_variable;
                                @endphp
                        @endforeach

                        @for($i = 1; $i <= 20; $i++)
                            @if (($i <= $z) OR ($i == 1))
                                <div id='insu{{ $i }}' style='display: block'>
                            @else
                                <div id='insu{{ $i }}' style='display: none'>
                            @endif
                                    
                            @if(!isset($orden_insu_mezcla[$i]))
                            @isset($orden_insu_id[$i])
                                <input type="text" hidden value="{{ $orden_insu_id[$i] }}" id="id_orden_insumo{{ $i }}" name="id_orden_insumo{{ $i }}" readonly>
                            @endisset
                            
                                <div class="form-group row">
                                    <label for="id_insumo{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }}</label>

                                    <div class="col-md-6">
                                        <select class="selectpicker form-control @error('id_insumo{{ $i }}') is-invalid @enderror" data-live-search="true" id="id_insumo{{ $i }}" name="id_insumo{{ $i }}" value="{{ old('id_insumo'.$i) }}" readonly autofocus> 
                                            <option value="">Seleccionar insumo</option>
                                            @isset($orden_insu[$i])
                                                <option value="{{ $orden_insu[$i] }}" selected>{{ $orden_insu[$i] }}</option>
                                            @else
                                                @foreach($insumos as $insumo)
                                                    <option value="{{ $insumo->nombre }}">{{ $insumo->nombre }} </option>
                                                @endforeach
                                            @endisset   
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
                                        <input id="cantidad{{ $i }}" type="number" step="0.01" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}"
                                        @isset($orden_insu_unidades[$i])
                                            @if($orden_insu_unidades[$i] <> 0)
                                                value={{ $orden_insu_unidades[$i] }}
                                            @endif
                                        @endisset
                                        @isset($orden_insu_lts[$i])
                                            @if($orden_insu_lts[$i] <> 0)
                                                value={{ $orden_insu_lts[$i] }}
                                            @endif
                                        @endisset
                                        @isset($orden_insu_kg[$i])
                                            @if($orden_insu_kg[$i] <> 0)
                                                value={{ $orden_insu_kg[$i] }}
                                            @endif
                                        @endisset
                                        autocomplete="cantidad{{ $i }}" autofocus>

                                        @error('cantidad{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control @error('unidades_medidas{{ $i }}') is-invalid @enderror" id="unidades_medidas{{ $i }}" name="unidades_medidas{{ $i }}" value="{{ old('unidades_medidas'.$i) }}" required autofocus> 
                                            @isset($orden_insu_unidades[$i])
                                                @if($orden_insu_unidades[$i] <> 0)
                                                    <option value="semillas/ha">semillas/ha</option>
                                                @endif
                                            @endisset
                                            @isset($orden_insu_lts[$i])
                                                @if($orden_insu_lts[$i] <> 0)
                                                    <option value="lts/ha">lts/ha</option>
                                                @endif
                                            @endisset
                                            @isset($orden_insu_kg[$i])
                                                @if($orden_insu_kg[$i] <> 0)
                                                    <option value="kg/ha">kg/ha</option>
                                                @endif
                                            @endisset
                                            <option value="semillas/ha">semillas/ha</option>
                                            <option value="lts/ha">lts/ha</option>
                                            <option value="kg/ha">kg/ha</option>
                                        </select>
                                        @error('unidades_medidas{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div id='insu_variable{{ $i }}' style='display: none'>
                                    <div class="form-group row">
                                        <label for="has_variable{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad hectáreas') }}</label>

                                        <div class="col-md-4">
                                            <input id="has_variable{{ $i }}" type="number" class="form-control @error('has_variable{{ $i }}') is-invalid @enderror" name="has_variable{{ $i }}" value="{{ isset($orden_insu_hasv[$i])?$orden_insu_hasv[$i]:old('has_variable'.$i) }}" autocomplete="has_variable{{ $i }}" autofocus>

                                            @error('has_variable{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @can('haveaccess','ordeninsumo.destroy')
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button class="btn btn-danger beliminar_insumo" id="deleteinsumo{{ $i }}" name="{{ $i }}">Eliminar insumo</button>
                                        </div>
                                    </div>
                                @endcan
                                <hr>
                                <br>
                                @endif
                                
                                @if(($i <> 20) AND ($i >= $z))
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <a class="btn btn-warning" id="otro{{ $i }}">Agregar otro insumo</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endfor
                        <br>


                        <br>
                        <h4>Mezcla de tanque</h4>
                        <hr>
                        @php
                            $z=0;
                        @endphp
                        @foreach($orden_mezclas as $orden_insumo)
                            @php
                                $z++;
                                $orden_insumez_id[$z] = $orden_insumo->id;
                                $orden_insumez[$z] = $orden_insumo->insumo;
                                $orden_insumez_mezcla[$z] = $orden_insumo->id_mezcla;
                                $orden_insumez_lts[$z] = $orden_insumo->lts;
                                $orden_insumez_kg[$z] = $orden_insumo->kg;
                                $orden_insumez_unidades[$z] = $orden_insumo->unidades;
                                $has_variable_mez[$z] = $orden_insumo->has_variable;
                            @endphp
                        @endforeach
                            @php
                                $control_id = "";
                                $control_id2= "";
                            @endphp
                        @for($i = 1; $i <= 200; $i++)
                            @if (($i <= $z) OR ($i == 1))
                                <div id='mez{{ $i }}' style='display: block'>
                            @else
                                <div id='mez{{ $i }}' style='display: none'>
                            @endif
                                   
                                @isset($orden_insumez_id[$i])
                                    <input type="text" hidden value="{{ $orden_insumez_id[$i] }}" id="id_orden_insumo_mez{{ $i }}" name="id_orden_insumo_mez{{ $i }}" readonly>
                                @else
                                    @php
                                      $orden_insumez_id[$i] = 0; 
                                    @endphp
                                @endisset
                                @isset($orden_insumez_mezcla[$i])
                                    @if($control_id <> $orden_insumez_mezcla[$i])
                                    <div id="div_ocultar_mezcla{{ $i }}">
                                        <div class="form-group row">
                                            <label for="id_mezcla{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Mezcla de tanque') }}</label>

                                            <div class="col-md-6">
                                                <select class="selectpicker form-control @error('id_mezcla{{ $i }}') is-invalid @enderror" data-live-search="true" id="{{ $i }}" name="id_mezcla{{ $i }}" value="{{ old('id_mezcla'.$i) }}" readonly autofocus> 
                                                    <option value="">Seleccionar mezcla de tanque</option>
                                                    @isset($orden_insumez_mezcla[$i])
                                                        @php
                                                            $mezcla_nombre = Mezcla::where('id',$orden_insumez_mezcla[$i])->first();
                                                            $control_id = $orden_insumez_mezcla[$i];
                                                        @endphp
                                                        <option value="{{ $orden_insumez_mezcla[$i] }}" selected>{{ $mezcla_nombre->nombre }} </option>
                                                    @endisset
                                                   
                                                </select>

                                                @error('id_mezcla{{ $i }}')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @else
                                <div id="div_ocultar_mezcla{{ $i }}">
                                    <div class="form-group row">
                                        <label for="id_mezcla{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Mezcla de tanque') }}</label>

                                        <div class="col-md-6">
                                            <select class="selectpicker form-control @error('id_mezcla{{ $i }}') is-invalid @enderror" data-live-search="true" id="{{ $i }}" name="id_mezcla{{ $i }}" value="{{ old('id_mezcla'.$i) }}" readonly autofocus> 
                                                <option value="">Seleccionar mezcla de tanque</option>
                                                @foreach($mezclas as $mezcla)
                                                    <option value="{{ $mezcla->id }}">{{ $mezcla->nombre }} </option>
                                                @endforeach
                                            </select>

                                            @error('id_mezcla{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endisset

                                <input type="text" hidden value="{{ $control_id }}" id="delete_mezcla_id{{ $i }}" name="delete_mezcla_id{{ $i }}" readonly>


                                <div id='insumos{{ $i }}' name='insumos{{ $i }}' style='display:block;'>
                                    <div class="form-group row">
                                        <label for="id_insumo_mez{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }}</label>

                                        <div class="col-md-6">
                                            <input id="id_insumo_mez{{ $i }}" type="text" class="form-control @error('id_insumo_mez{{ $i }}') is-invalid @enderror" name="id_insumo_mez{{ $i }}" value="{{isset($orden_insumez[$i])?$orden_insumez[$i]:""}}" autocomplete="id_insumo_mez{{ $i }}" readonly autofocus>

                                            @error('id_insumo_mez{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    

                                    <div class="form-group row">
                                        <label for="cantidad_mez{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                                        <div class="col-md-4">
                                            <input id="cantidad_mez{{ $i }}" type="number" step="0.01" class="form-control @error('cantidad_mez{{ $i }}') is-invalid @enderror" name="cantidad_mez{{ $i }}"
                                            @isset($orden_insumez_unidades[$i])
                                                @if($orden_insumez_unidades[$i] <> 0)
                                                    value="{{ $orden_insumez_unidades[$i] }}"
                                                @endif
                                            @endisset
                                            @isset($orden_insumez_lts[$i])
                                                @if($orden_insumez_lts[$i] <> 0)
                                                    value="{{ $orden_insumez_lts[$i] }}"
                                                @endif
                                            @endisset
                                            @isset($orden_insumez_kg[$i])
                                                @if($orden_insumez_kg[$i] <> 0)
                                                    value="{{ $orden_insumez_kg[$i] }}"
                                                @endif
                                            @endisset
                                            autocomplete="cantidad_mez{{ $i }}" autofocus>

                                            @error('cantidad_mez{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control @error('unidades_medidas_mez{{ $i }}') is-invalid @enderror" id="unidades_medidas_mez{{ $i }}" name="unidades_medidas_mez{{ $i }}" value="{{ old('unidades_medidas_mez'.$i) }}" required autofocus> 
                                                @isset($orden_insu_unidades[$i])
                                                    @if($orden_insu_unidades[$i] <> 0)
                                                        <option value="semillas/ha">semillas/ha</option>
                                                    @endif
                                                @endisset
                                                @isset($orden_insu_lts[$i])
                                                    @if($orden_insu_lts[$i] <> 0)
                                                        <option value="lts/ha">lts/ha</option>
                                                    @endif
                                                @endisset
                                                @isset($orden_insu_kg[$i])
                                                    @if($orden_insu_kg[$i] <> 0)
                                                        <option value="kg/ha">kg/ha</option>
                                                    @endif
                                                @endisset
                                                <option value="semillas/ha">semillas/ha</option>
                                                <option value="lts/ha">lts/ha</option>
                                                <option value="kg/ha">kg/ha</option>
                                            </select>
                                            @error('unidades_medidas_mez{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div id='mez_variable{{ $i }}' style='display: none'>
                                        <div class="form-group row">
                                            <label for="has_variable_mez{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad hectáreas') }}</label>
    
                                            <div class="col-md-4">
                                                <input id="has_variable_mez{{ $i }}" type="number" class="form-control @error('has_variable_mez{{ $i }}') is-invalid @enderror" name="has_variable_mez{{ $i }}" value="{{ isset($has_variable_mez[$i])?$has_variable_mez[$i]:old('has_variable_mez'.$i) }}" autocomplete="has_variable_mez{{ $i }}" autofocus>
    
                                                @error('has_variable_mez{{ $i }}')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @isset($orden_insumez_mezcla[$i+1])
                                    @if($control_id <> $orden_insumez_mezcla[$i+1])
                                        @can('haveaccess','ordeninsumo.destroy')
                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button class="btn btn-danger beliminar_mezcla" id="deletemezcla{{ $i }}" name="{{ $i }}">Eliminar mezcla de tanque</button>
                                                </div>
                                            </div>
                                            <br>
                                        @endcan
                                    @endif
                                @endisset
                                
                                @if(($i <> 400) AND ($i >= $z))
                                    @can('haveaccess','ordeninsumo.destroy')
                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button class="btn btn-danger beliminar_mezcla" id="deletemezcla{{ $i }}" name="{{ $i }}">Eliminar mezcla de tanque</button>
                                            </div>
                                        </div>
                                    @endcan
                                    <br>
                          
                                
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <a class="btn btn-warning" id="otrom{{ $i }}">Agregar otra mezcla de tanque</a>
                                    </div>
                                </div>
                             
                                   
                                @endif
                            </div>
                        @endfor

                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="guardar" class="btn btn-success">
                                {{ __('Guardar cambios') }}
                                  
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(e) {

var elBotones = document.querySelectorAll("button");
console.log(elBotones);

/*Asignamos  función para escuchar*/
for (var i = 0; i < elBotones.length; i++) {
  elBotones[i].addEventListener("click", manejarBotones, false)
}


});

/*Podremos usar  this.id  para identificar cada botón*/
function manejarBotones(e) {
    e.preventDefault();
        var id_tipo = $(this).attr('id');
        var id_bucle = $(this).attr('name');
        var clase = $(this).attr('class');
        var id_delete_insumo = $('#id_orden_insumo'+id_bucle).val();
        var id_delete_mezcla = $('#delete_mezcla_id'+id_bucle).val();
        var id_insumo_mez = $('#id_insumo_mez'+id_bucle).val();
        var id_ordendetrabajo = $('#orden_de_trabajo').val();
        var _token = $('input[name="_token"]').val();

        if(id_tipo == 'guardar'){
            formulario1.submit();
        } else {
            if (clase == 'btn btn-danger beliminar_insumo') {
                var opcion = confirm('¿Esta seguro que desea eliminar este insumo de la orden de trabajo?');
                if (opcion == true) {
                    $.ajax({
                        url:"{{ route('ordeninsumo.destroyinsumo') }}",
                        method:"POST",
                        data:{_token:_token, id_delete_insumo:id_delete_insumo,id_ordendetrabajo:id_ordendetrabajo},
                        error:function()
                        {
                            alert("Ha ocurrido un error, intentelo más tarde");
                        },
                        success:function(data)
                        {   
                            window.location = data.url
                        },
                    })
                }
            } else {
                if (clase == 'btn btn-danger beliminar_mezcla') {
                    var opcion = confirm('¿Esta seguro que desea eliminar la mezcla de tanque de la orden de trabajo?');
                    if (opcion == true) {
                        $.ajax({
                            url:"{{ route('ordeninsumo.destroymezcla') }}",
                            method:"POST",
                            data:{_token:_token, id_delete_mezcla:id_delete_mezcla,id_ordendetrabajo:id_ordendetrabajo,
                                id_insumo_mez:id_insumo_mez},
                            error:function()
                            {
                                alert("Ha ocurrido un error, intentelo más tarde");
                            },
                            success:function(data)
                            {   
                               window.location = data.url
                            },
                        })
                    }
                }
            }
        
        }
}

function mostrarVar() {
    check = document.getElementById("dosis_variable");
    var i = 1;
    for (let i = 1; i < 21; i++) {
        insumo_variable = document.getElementById("insu_variable"+i);
        mezcla_variable = document.getElementById("mez_variable"+i);
        
        if (check.checked) {
            if(insumo_variable != null){
                insumo_variable.style.display='block';
            }
            mezcla_variable.style.display='block';
        }else {
            if(insumo_variable != null){
                insumo_variable.style.display='none';
            }
            mezcla_variable.style.display='none';
        }
        
    }
}

$( document ).ready(function() {

    
    var i = 1;
    for (let i = 1; i < 21; i++) {
        $( "#otro"+i ).click(function() {
            i=i+1;
            insu = document.getElementById("insu"+i);

            insu.style.display = 'block';
            this.style.display = 'none';
        });   
    }
    var i = 1;
    for (let i = 1; i < 21; i++) {
        $( "#otrom"+i ).click(function() {
            i=i+1;
            mez = document.getElementById("mez"+i);

            mez.style.display = 'block';
            this.style.display = 'none';
        });   
    }

    //Si se selecciona una mezcla buscara los insumos que la componen y devolvera con la marca y cantidades tmbn
    $('select').on('change', function() {
            if ($(this).val() != ''){ 
                var iddiv = $(this).attr('id');
                var separador = iddiv.split('medidas');
                var separador2 = iddiv.split('ipo');
                var separador3 = iddiv.split('ado');
                var comparativa = separador[0];
                var comparativa2 = separador2[0];
                var comparativa3 = separador3[0];
                if((comparativa != 'unidades_') && (comparativa2 != 't') && (comparativa3 != 'est')){
                    var nombrecampo = $(this).attr('name');
                    var value = $(this).val();         
                    var _token = $('input[name="_token"]').val(); 
                    $.ajax({
                        url:"{{ route('ordentrabajo.insumomezcla') }}",
                        method:"POST",
                        dataType: "json",
                        data:{nombrecampo:nombrecampo,value:value, _token:_token,iddiv:iddiv},
                        success:function(data)
                        {
                            if(data.datos == "Mezcla"){
                                
                                    for (let index = 1; index < data.i; index++) {
                                        
                                        insumos_mez = document.getElementById('insumos'+iddiv);
                                        insumos_mez.style.display = 'block';
                                        mez = document.getElementById('mez'+iddiv);
                                        mez.style.display = 'block';
                                        //oculta botones innecesarios
                                        if((iddiv != index) || ((iddiv == 2) && (index == 2))){
                                            if(index != 1){
                                                id_ocultar = document.getElementById('div_ocultar_mezcla'+iddiv);
                                                id_ocultar.style.display = 'none';
                                            }
                                            
                                            nboton = iddiv - 1;
                                            otrom = document.getElementById('otrom'+nboton);
                                            otrom.style.display = 'none';
                                            deletemezcla = document.getElementById('deletemezcla'+nboton);
                                            deletemezcla.style.display = 'none';
                                            
                                        }
                                        var nombre = data.nombreinsu[index];
                                        var cant = data.cantidad[index];
                                        var id_mez = data.id_mezcla[index];
                                        var cbox = data.unidades_medidas[index];
                                
                                        $('#'+iddiv).val(value);
                                        $('#id_insumo_mez'+iddiv).val(nombre);
                                        $('#cantidad_mez'+iddiv).val(cant);
                                        $('#delete_mezcla_id'+iddiv).val(id_mez);
                                        $('#unidades_medidas_mez'+iddiv).html(cbox); 
                                
                                        iddiv++;
                                    }
                                    
                            }
                        },
                        error:function(){
                            $('#insumos'+iddiv).html('');
                            alert("No se ha encontrado ningun insumo para la mezcla de tanque seleccionada");
                        }
                    })
                }
            } else {
                var iddiv = $(this).attr('id');
                $('#insumos'+iddiv).html('');
            }
    
        });
        mostrarVar();
});


</script>
@endsection