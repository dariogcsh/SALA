@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Reclamo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                                           
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($reclamo->id_organizacion)?$reclamo->id_organizacion:old('id_organizacion') }}" disabled>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($orga_sucu)
                                                @if($organizacion->id == $orga_sucu->id)
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
                            <label for="id_sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_sucursal') is-invalid @enderror" data-live-search="true" id="id_sucursal" name="id_sucursal" value="{{ isset($reclamo->id_sucursal)?$reclamo->id_sucursal:old('id_sucursal') }}" disabled>
                                    <option value="">Seleccionar sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}" 
                                        @isset($orga_sucu)
                                                @if($sucursal->id == $orga_sucu->ids)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $sucursal->NombSucu }}</option>
                                    @endforeach
                                </select>
                                @error('id_sucursal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }} *</label>

                            <div class="col-md-6">
                                <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($reclamo->fecha)?$reclamo->fecha:old('fecha') }}" disabled autocomplete="fecha" autofocus>

                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="origen" class="col-md-4 col-form-label text-md-right">{{ __('Origen') }} *</label>

                            <div class="col-md-6">
                                <input id="origen" type="text" class="form-control @error('origen') is-invalid @enderror" name="origen" value="{{ isset($reclamo->origen)?$reclamo->origen:old('origen') }}" disabled autocomplete="origen" autofocus>

                                @error('origen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hallazgo" class="col-md-4 col-form-label text-md-right">{{ __('Hallazgo') }} *</label>

                            <div class="col-md-6">
                                <input id="hallazgo" type="text" class="form-control @error('hallazgo') is-invalid @enderror" name="hallazgo" value="{{ isset($reclamo->hallazgo)?$reclamo->hallazgo:old('hallazgo') }}" disabled autocomplete="hallazgo" autofocus>

                                @error('hallazgo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="proceso" class="col-md-4 col-form-label text-md-right">{{ __('Proceso') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('proceso') is-invalid @enderror" id="proceso" name="proceso" value="{{ isset($reclamo->proceso)?$reclamo->proceso:old('proceso') }}" disabled autofocus>
                                    @isset($reclamo->proceso)
                                        <option value="{{ $reclamo->proceso }}">{{ $reclamo->proceso }}</option>
                                    @else
                                        <option value="">Seleccionar proceso</option>
                                    @endisset
                                        <option value="Ventas">Ventas</option>
                                        <option value="Pos venta">Pos venta</option>
                                        <option value="Administracion">Administracion</option>
                                        <option value="Soluciones integrales">Soluciones integrales</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre_cliente" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de cliente') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre_cliente" type="text" class="form-control @error('nombre_cliente') is-invalid @enderror" name="nombre_cliente" value="{{ isset($reclamo->nombre_cliente)?$reclamo->nombre_cliente:old('nombre_cliente') }}" disabled autocomplete="nombre_cliente" autofocus>

                                @error('nombre_cliente')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} *</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" disabled autocomplete="descripcion" autofocus rows="8">@isset($reclamo->descripcion){{ $reclamo->descripcion }}@endisset</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ isset($reclamo->estado)?$reclamo->estado:old('estado') }}" disabled autofocus>
                                    @isset($reclamo->estado)
                                        <option value="{{ $reclamo->estado }}">{{ $reclamo->estado }}</option>
                                    @else
                                        <option value="">Seleccionar estado</option>
                                    @endisset
                                        <option value="Abierta">Abierta</option>
                                        <option value="En proceso">En proceso</option>
                                        <option value="Cerrada">Cerrada</option>
                                        <option value="Eficaz">Eficaz</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
<br>
                        <h3>Acción de contingencia</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="accion_contingencia" class="col-md-4 col-form-label text-md-right">{{ __('Acción de contingencia') }} </label>

                            <div class="col-md-6">
                                <textarea id="accion_contingencia" class="form-control-textarea @error('accion_contingencia') is-invalid @enderror" name="accion_contingencia" value="{{ old('accion_contingencia') }}" autocomplete="accion_contingencia" autofocus rows="8" disabled>@isset($reclamo->accion_contingencia){{ $reclamo->accion_contingencia }}@endisset</textarea>

                                @error('accion_contingencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_contingencia" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user_contingencia') is-invalid @enderror" data-live-search="true" id="id_user_contingencia" name="id_user_contingencia" value="{{ isset($reclamo->id_user_contingencia)?$reclamo->id_user_contingencia:old('id_user_contingencia') }}" disabled>
                                    <option value="">Seleccionar responsable</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuario_contingencia)
                                                @if($usuario->id == $usuario_contingencia->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user_contingencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    @isset($cambios_fecha)
                    @if($cant_contingencia > 0)
                        <br>
                        <p><u>Cambios de fecha límite</u></p>
                        <div class="table-responsive-md">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Fecha anterior
                                        </th>
                                        <th>
                                            Fecha nueva
                                        </th>
                                        <th>
                                            Fecha modificacion
                                        </th>
                                    </tr>
                                </thead>
                                    @foreach($cambios_fecha as $cambio)
                                        @if($cambio->accion == 'Contingencia')
                                            <tr>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_nueva))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y H:i",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            <br>
                        @endif
                        @endisset

                        <div class="form-group row">
                            <label for="fecha_limite_contingencia" class="col-md-4 col-form-label text-md-right">{{ __('Fecha límite') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_limite_contingencia" type="date" class="form-control @error('fecha_limite_contingencia') is-invalid @enderror" name="fecha_limite_contingencia" value="{{ isset($reclamo->fecha_limite_contingencia)?$reclamo->fecha_limite_contingencia:old('fecha_limite_contingencia') }}" disabled autocomplete="fecha_limite_contingencia" autofocus>

                                @error('fecha_limite_contingencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if($reclamo->vencido_contingencia == "SI")
                            <div class="form-group row">
                                <label for="vencido_contingencia" class="col-md-4 col-form-label text-md-right">{{ __('¿Venció en algun momento esta acción?') }} </label>

                                <div class="col-md-6">
                                    <input id="vencido_contingencia" type="text" class="form-control @error('vencido_contingencia') is-invalid @enderror" name="vencido_contingencia" value="{{ isset($reclamo->vencido_contingencia)?$reclamo->vencido_contingencia:old('vencido_contingencia') }}" disabled autocomplete="vencido_contingencia" autofocus>

                                    @error('vencido_contingencia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="fecha_registro_contingencia" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de registro') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_registro_contingencia" type="date" class="form-control @error('fecha_registro_contingencia') is-invalid @enderror" name="fecha_registro_contingencia" value="{{ isset($reclamo->fecha_registro_contingencia)?$reclamo->fecha_registro_contingencia:old('fecha_registro_contingencia') }}" disabled autocomplete="fecha_registro_contingencia" autofocus>

                                @error('fecha_registro_contingencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h3>Análisis de causa realizado</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="causa" class="col-md-4 col-form-label text-md-right">{{ __('Análisis de causa realizado') }} </label>

                            <div class="col-md-6">
                                <textarea id="causa" class="form-control-textarea @error('causa') is-invalid @enderror" name="causa" value="{{ old('causa') }}" autocomplete="causa" autofocus rows="8" disabled>@isset($reclamo->causa){{ $reclamo->causa }}@endisset</textarea>

                                @error('causa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_responsable" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user_responsable') is-invalid @enderror" data-live-search="true" id="id_user_responsable" name="id_user_responsable" disabled value="{{ isset($reclamo->id_user_responsable)?$reclamo->id_user_responsable:old('id_user_responsable') }}">
                                    <option value="">Seleccionar responsable</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuario_responsable)
                                                @if($usuario->id == $usuario_responsable->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user_responsable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @isset($cambios_fecha)
                        @if($cant_causa > 0)
                        <br>
                        <p><u>Cambios de fecha límite</u></p>
                        <div class="table-responsive-md">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Fecha anterior
                                        </th>
                                        <th>
                                            Fecha nueva
                                        </th>
                                        <th>
                                            Fecha modificacion
                                        </th>
                                    </tr>
                                </thead>
                                    @foreach($cambios_fecha as $cambio)
                                        @if($cambio->accion == 'Analisis de causa')
                                            <tr>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_nueva))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y H:i",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            <br>
                            @endif
                        @endisset
                        <div class="form-group row">
                            <label for="fecha_contacto" class="col-md-4 col-form-label text-md-right">{{ __('Fecha limite') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_contacto" type="date" class="form-control @error('fecha_contacto') is-invalid @enderror" name="fecha_contacto" disabled value="{{ isset($reclamo->fecha_contacto)?$reclamo->fecha_contacto:old('fecha_contacto') }}" autocomplete="fecha_contacto" autofocus>

                                @error('fecha_contacto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if($reclamo->vencido_causa == "SI")
                            <div class="form-group row">
                                <label for="vencido_causa" class="col-md-4 col-form-label text-md-right">{{ __('¿Venció en algun momento esta acción?') }} </label>

                                <div class="col-md-6">
                                    <input id="vencido_causa" type="text" class="form-control @error('vencido_causa') is-invalid @enderror" name="vencido_causa" value="{{ isset($reclamo->vencido_causa)?$reclamo->vencido_causa:old('vencido_causa') }}" disabled autocomplete="vencido_causa" autofocus>

                                    @error('vencido_causa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="fecha_registro_causa" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de registro') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_registro_causa" type="date" class="form-control @error('fecha_registro_causa') is-invalid @enderror" name="fecha_registro_causa" disabled value="{{ isset($reclamo->fecha_registro_causa)?$reclamo->fecha_registro_causa:old('fecha_registro_causa') }}" autocomplete="fecha_registro_causa" autofocus>

                                @error('fecha_registro_causa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h3>Acción correctiva</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="accion_correctiva" class="col-md-4 col-form-label text-md-right">{{ __('Acción correctiva') }} </label>

                            <div class="col-md-6">
                                <textarea id="accion_correctiva" class="form-control-textarea @error('accion_correctiva') is-invalid @enderror" name="accion_correctiva" value="{{ old('accion_correctiva') }}" disabled autocomplete="accion_correctiva" autofocus rows="8">@isset($reclamo->accion_correctiva){{ $reclamo->accion_correctiva }}@endisset</textarea>

                                @error('accion_correctiva')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_correctiva" class="col-md-4 col-form-label text-md-right">{{ __('Responsables') }} </label>

                            <div class="col-md-6">
                                <label class="form-control-textarea @error('id_user_correctiva') is-invalid @enderror"  id="id_user_correctiva" name="id_user_correctiva" disabled>
                                    @foreach ($usuarios as $usuario)
                                        @isset($usuarios_correctiva)
                                            @foreach($usuarios_correctiva as $user_correctiva)
                                                @if($usuario->id == $user_correctiva->id_user_correctiva)
                                                    {{ $usuario->name }} {{ $usuario->last_name }} - 
                                                @endif
                                            @endforeach   
                                        @endisset
                                    @endforeach
                                </label>
                                @error('id_user_correctiva')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @isset($cambios_fecha)
                        @if($cant_correccion > 0)
                        <br>
                        <div class="table-responsive-md">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Fecha anterior
                                        </th>
                                        <th>
                                            Fecha nueva
                                        </th>
                                        <th>
                                            Fecha modificacion
                                        </th>
                                    </tr>
                                </thead>
                                    @foreach($cambios_fecha as $cambio)
                                        @if($cambio->accion == 'Accion correctiva')
                                            <tr>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_nueva))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y H:i",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            <br>
                            @endif
                        @endisset

                        <div class="form-group row">
                            <label for="fecha_limite_correctiva" class="col-md-4 col-form-label text-md-right">{{ __('Fecha límite') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_limite_correctiva" type="date" class="form-control @error('fecha_limite_correctiva') is-invalid @enderror" name="fecha_limite_correctiva" disabled value="{{ isset($reclamo->fecha_limite_correctiva)?$reclamo->fecha_limite_correctiva:old('fecha_limite_correctiva') }}" autocomplete="fecha_limite_correctiva" autofocus>

                                @error('fecha_limite_correctiva')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <h3>Verificación implementación</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="verificacion_implementacion" class="col-md-4 col-form-label text-md-right">{{ __('Verificación implementación') }} </label>

                            <div class="col-md-6">
                                <textarea id="verificacion_implementacion" class="form-control-textarea @error('verificacion_implementacion') is-invalid @enderror" name="verificacion_implementacion" disabled value="{{ old('verificacion_implementacion') }}" autocomplete="verificacion_implementacion" autofocus rows="8">@isset($reclamo->verificacion_implementacion){{ $reclamo->verificacion_implementacion }}@endisset</textarea>

                                @error('verificacion_implementacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_implementacion" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user_implementacion') is-invalid @enderror" data-live-search="true" id="id_user_implementacion" disabled name="id_user_implementacion" value="{{ isset($reclamo->id_user_implementacion)?$reclamo->id_user_implementacion:old('id_user_implementacion') }}">
                                    <option value="">Seleccionar responsable</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuario_implementacion)
                                                @if($usuario->id == $usuario_implementacion->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user_implementacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @isset($cambios_fecha)
                        @if($cant_implementacion > 0)
                        <br>
                        <div class="table-responsive-md">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Fecha anterior
                                        </th>
                                        <th>
                                            Fecha nueva
                                        </th>
                                        <th>
                                            Fecha modificacion
                                        </th>
                                    </tr>
                                </thead>
                                    @foreach($cambios_fecha as $cambio)
                                        @if($cambio->accion == 'Implementacion')
                                            <tr>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_nueva))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y H:i",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            <br>
                            @endif
                        @endisset

                        <div class="form-group row">
                            <label for="fecha_implementacion" class="col-md-4 col-form-label text-md-right">{{ __('Fecha implementacion') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_implementacion" type="date" class="form-control @error('fecha_implementacion') is-invalid @enderror" name="fecha_implementacion" disabled value="{{ isset($reclamo->fecha_implementacion)?$reclamo->fecha_implementacion:old('fecha_implementacion') }}" autocomplete="fecha_implementacion" autofocus>

                                @error('fecha_implementacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h3>Medición eficiencia</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="medicion_eficiencia" class="col-md-4 col-form-label text-md-right">{{ __('Medición eficiencia') }} </label>

                            <div class="col-md-6">
                                <textarea id="medicion_eficiencia" class="form-control-textarea @error('medicion_eficiencia') is-invalid @enderror" name="medicion_eficiencia" disabled value="{{ old('medicion_eficiencia') }}" autocomplete="medicion_eficiencia" autofocus rows="8">@isset($reclamo->medicion_eficiencia){{ $reclamo->medicion_eficiencia }}@endisset</textarea>

                                @error('medicion_eficiencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_eficiencia" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user_eficiencia') is-invalid @enderror" data-live-search="true" id="id_user_eficiencia" disabled name="id_user_eficiencia" value="{{ isset($reclamo->id_user_eficiencia)?$reclamo->id_user_eficiencia:old('id_user_eficiencia') }}">
                                    <option value="">Seleccionar responsable</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuario_eficiencia)
                                                @if($usuario->id == $usuario_eficiencia->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user_eficiencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @isset($cambios_fecha)
                        @if($cant_eficiencia > 0)
                        <br>
                        <div class="table-responsive-md">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Fecha anterior
                                        </th>
                                        <th>
                                            Fecha nueva
                                        </th>
                                        <th>
                                            Fecha modificacion
                                        </th>
                                    </tr>
                                </thead>
                                    @foreach($cambios_fecha as $cambio)
                                        @if($cambio->accion == 'Eficiencia')
                                            <tr>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y",strtotime($cambio->fecha_nueva))}}
                                                </td>
                                                <td>
                                                    {{date("d/m/Y H:i",strtotime($cambio->fecha_vieja))}}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            <br>
                            @endif
                        @endisset

                        <div class="form-group row">
                            <label for="fecha_eficiencia" class="col-md-4 col-form-label text-md-right">{{ __('Fecha medición') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_eficiencia" type="date" class="form-control @error('fecha_eficiencia') is-invalid @enderror" name="fecha_eficiencia" disabled value="{{ isset($reclamo->fecha_eficiencia)?$reclamo->fecha_eficiencia:old('fecha_eficiencia') }}" autocomplete="fecha_eficiencia" autofocus>

                                @error('fecha_eficiencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('reclamo.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','reclamo.edit')
                            <a href="{{ route('reclamo.edit',$reclamo->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','reclamo.destroy')
                            <form action="{{ route('reclamo.destroy',$reclamo->id) }}" method="post">
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