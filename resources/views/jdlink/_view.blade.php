@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Maquina conectada</h2></div>

                <div class="card-body">
                    <div class="container">

                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" autofocus disabled>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($organizacionjd)
                                                @if($organizacion->id == $organizacionjd->CodiOrga)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $organizacion->NombOrga }}</option>
                                    @endforeach
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie de la máquina') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('NumSMaq') is-invalid @enderror" data-live-search="true" id="NumSMaq" name="NumSMaq" value="{{ isset($jdlink->NumSMaq)?$jdlink->NumSMaq:old('NumSMaq') }}" autofocus disabled>
                                    @isset($jdlink) 
                                        <option value="{{ $jdlink->NumSMaq }}" selected>{{ $jdlink->NumSMaq }} </option>
                                    @endisset
                                </select>
                                @error('NumSMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>       
                        </div>

                        <div class="form-group row">
                            <label for="conectado" class="col-md-4 col-form-label text-md-right">{{ __('Conectado') }}</label>

                            <div class="col-md-6">
                                <input id="conectado" type="text" class="form-control" name="conectado" value="{{ old('conectado', $jdlink->conectado) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="monitoreo" class="col-md-4 col-form-label text-md-right">{{ __('Monitoreado') }}</label>

                            <div class="col-md-6">
                                <input id="monitoreo" type="text" class="form-control" name="monitoreo" value="{{ old('monitoreo', $jdlink->monitoreo) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="soporte_siembra" class="col-md-4 col-form-label text-md-right">{{ __('Soporte en siembra') }}</label>

                            <div class="col-md-6">
                                <input id="soporte_siembra" type="text" class="form-control" name="soporte_siembra" value="{{ old('soporte_siembra', $jdlink->soporte_siembra) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="informes" class="col-md-4 col-form-label text-md-right">{{ __('Informes') }}</label>

                            <div class="col-md-6">
                                <input id="informes" type="text" class="form-control" name="informes" value="{{ old('informes', $jdlink->informes) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="alertas" class="col-md-4 col-form-label text-md-right">{{ __('Alertas') }}</label>

                            <div class="col-md-6">
                                <input id="alertas" type="text" class="form-control" name="alertas" value="{{ old('alertas', $jdlink->alertas) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="mantenimiento" class="col-md-4 col-form-label text-md-right">{{ __('Mantenimiento') }}</label>

                            <div class="col-md-6">
                                <input id="mantenimiento" type="text" class="form-control" name="mantenimiento" value="{{ old('mantenimiento', $jdlink->mantenimiento) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="actualizacion_comp" class="col-md-4 col-form-label text-md-right">{{ __('Actualización de componentes') }}</label>

                            <div class="col-md-6">
                                <input id="actualizacion_comp" type="text" class="form-control" name="actualizacion_comp" value="{{ old('actualizacion_comp', $jdlink->actualizacion_comp) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="capacitacion_op" class="col-md-4 col-form-label text-md-right">{{ __('Capacitación a operarios') }}</label>

                            <div class="col-md-6">
                                <input id="capacitacion_op" type="text" class="form-control" name="capacitacion_op" value="{{ old('capacitacion_op', $jdlink->capacitacion_op) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="capacitacion_asesor" class="col-md-4 col-form-label text-md-right">{{ __('Capacitación a asesor agronómico') }}</label>

                            <div class="col-md-6">
                                <input id="capacitacion_asesor" type="text" class="form-control" name="capacitacion_asesor" value="{{ old('capacitacion_asesor', $jdlink->capacitacion_asesor) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="ordenamiento_agro" class="col-md-4 col-form-label text-md-right">{{ __('Ordenamiento de datos agronómicos') }}</label>

                            <div class="col-md-6">
                                <input id="ordenamiento_agro" type="text" class="form-control" name="ordenamiento_agro" value="{{ old('ordenamiento_agro', $jdlink->ordenamiento_agro) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="fecha_comienzo" class="col-md-4 col-form-label text-md-right">{{ __('Fecha aprox. de comienzo') }}</label>

                            <div class="col-md-6">
                                <input id="fecha_comienzo" type="text" class="form-control" name="fecha_comienzo" value="{{ old('fecha_comienzo', date("d/m/Y",strtotime($jdlink->fecha_comienzo))) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="visita_inicial" class="col-md-4 col-form-label text-md-right">{{ __('Visita inicial') }}</label>

                            <div class="col-md-6">
                                <input id="visita_inicial" type="text" class="form-control" name="conectado" value="{{ old('visita_inicial', $jdlink->visita_inicial) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="fecha_visita" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de visita inicial') }}</label>

                            <div class="col-md-6">
                                <input id="fecha_visita" type="text" class="form-control" name="fecha_visita" value="{{ old('fecha_visita', date("d/m/Y",strtotime($jdlink->fecha_visita))) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ensayo" class="col-md-4 col-form-label text-md-right">{{ __('Ensayo Combine Advisor') }}</label>

                            <div class="col-md-6">
                                <input id="ensayo" type="text" class="form-control" name="ensayo" value="{{ old('ensayo', $jdlink->ensayo) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="check_list" class="col-md-4 col-form-label text-md-right">{{ __('Check List') }}</label>

                            <div class="col-md-6">
                                <input id="check_list" type="text" class="form-control" name="check_list" value="{{ old('check_list', $jdlink->check_list) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="limpieza_inyectores" class="col-md-4 col-form-label text-md-right">{{ __('Limpieza de inyectores') }}</label>

                            <div class="col-md-6">
                                <input id="limpieza_inyectores" type="text" class="form-control" name="limpieza_inyectores" value="{{ old('limpieza_inyectores', $jdlink->limpieza_inyectores) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="apivinculada" class="col-md-4 col-form-label text-md-right">{{ __('API vinculada') }}</label>

                            <div class="col-md-6">
                                <input id="apivinculada" type="text" class="form-control" name="apivinculada" value="{{ old('apivinculada', $jdlink->apivinculada) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="analisis_final" class="col-md-4 col-form-label text-md-right">{{ __('Análisis final de campaña') }}</label>

                            <div class="col-md-6">
                                <input id="analisis_final" type="text" class="form-control" name="conectado" value="{{ old('analisis_final', $jdlink->analisis_final) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="hectareas" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de hectáreas') }}</label>

                            <div class="col-md-6">
                                <input id="hectareas" type="text" class="form-control" name="hectareas" value="{{ old('hectareas', $jdlink->hectareas) }}" disabled>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="calidad_siembra" class="col-md-4 col-form-label text-md-right">{{ __('Relevamiento de calidad de siembra') }}</label>

                            <div class="col-md-6">
                                <input id="calidad_siembra" type="text" class="form-control" name="calidad_siembra" value="{{ old('calidad_siembra', $jdlink->calidad_siembra) }}" disabled>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="muestreo" class="col-md-4 col-form-label text-md-right">{{ __('Muestreo de suelo') }}</label>

                            <div class="col-md-6">
                                <input id="muestreo" type="text" class="form-control" name="muestreo" value="{{ old('muestreo', $jdlink->muestreo) }}" disabled>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="ambientes" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de ambientes a muestrear') }}</label>

                            <div class="col-md-6">
                                <input id="ambientes" type="text" class="form-control" name="ambientes" value="{{ old('ambientes', $jdlink->ambientes) }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo') }}</label>

                            <div class="col-md-6">
                                <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($jdlink->costo)?$jdlink->costo:old('costo') }}" disabled autocomplete="costo" autofocus>

                                @error('costo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @php $aux = 0; @endphp
                        <div class="form-group row">
                            <label for="id_mibonificacion" class="col-md-4 col-form-label text-md-right">{{ __('Beneficios disponibles') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_mibonificacion') is-invalid @enderror" data-live-search="true" id="id_mibonificacion" name="id_mibonificacion" value="{{ isset($jdlink->id_mibonificacion)?$jdlink->id_mibonificacion:old('id_mibonificacion') }}" disabled autofocus>
                                    <option value="">Seleccionar bonificacion</option>
                                    @isset($misbonificaciones)
                                        @foreach ($misbonificaciones as $mibonificacion)
                                            @isset($jdlink->mibonificacions->id)
                                                @if($mibonificacion->id == $jdlink->mibonificacions->id)
                                                    <option value="{{ $mibonificacion->id }}" selected>{{ $mibonificacion->tipo }} - {{ $mibonificacion->descuento }}% </option>
                                                    @php $aux = $mibonificacion->id ; @endphp
                                                @endif
                                            @endisset
                                            @if($aux <> $mibonificacion->id)
                                                <option value="{{ $mibonificacion->id }}">{{ $mibonificacion->tipo }} - {{ $mibonificacion->descuento }}% </option>
                                            @endif
                                        @endforeach
                                    @endisset
                                </select>
                                @error('id_mibonificacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contrato_firmado" class="col-md-4 col-form-label text-md-right">{{ __('Contrato firmado') }}</label>

                            <div class="col-md-6">
                                <input id="contrato_firmado" type="text" class="form-control" name="contrato_firmado" value="{{ old('contrato_firmado', $jdlink->contrato_firmado) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vencimiento_contrato" class="col-md-4 col-form-label text-md-right">{{ __('Vencimiento de contrato') }}</label>

                            <div class="col-md-6">
                                <input id="vencimiento_contrato" type="text" class="form-control" name="vencimiento_contrato" value="{{ old('vencimiento_contrato', date("d/m/Y",strtotime($jdlink->vencimiento_contrato))) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="factura" class="col-md-4 col-form-label text-md-right">{{ __('Factura') }}</label>

                            <div class="col-md-6">
                                <input id="factura" type="text" class="form-control" name="factura" value="{{ old('factura', $jdlink->factura) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="anofiscal" class="col-md-4 col-form-label text-md-right">{{ __('Año fiscal') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('anofiscal') is-invalid @enderror" data-live-search="true" id="anofiscal" name="anofiscal" value="{{ isset($jdlink->anofiscal)?$jdlink->anofiscal:old('anofiscal') }}" disabled>
                                    <option value="">Año fiscal</option>
                                    @php $year = date("Y"); @endphp
                                        @for ($i= 2021; $i <= $year + 1 ; $i++)
                                        @isset($jdlink->anofiscal)
                                            @if($jdlink->anofiscal == $i)
                                                <option value="{{$i}}" selected>'{{$i}}</option>
                                            @endif
                                        @else
                                            <option value="{{$i}}">'{{$i}}</option>
                                        @endisset
                                        @endfor
                                </select>
                                @error('anofiscal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="asesor" class="col-md-4 col-form-label text-md-right">{{ __('¿Quién asesoró al cliente sobre el Paquete de soporte y monitoreo?') }}</label>

                            <div class="col-md-6">
                                <input id="asesor" type="text" class="form-control" name="asesor" value="{{ old('asesor', $jdlink->asesor) }}" disabled>
                            </div>
                        </div> 

                        <hr>
                        <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                <a class="btn btn-light btn-block" href="{{ route('jdlink.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','jdlink.edit')
                                    <a href="{{ route('jdlink.edit',$jdlink->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @elsecan('haveaccess','jdlink.editservicio')
                                    <a href="{{ route('jdlink.editservicio',$jdlink->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','jdlink.destroy')
                                    <form action="{{ route('jdlink.destroy',$jdlink->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                                    </form>
                                @endcan
                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection