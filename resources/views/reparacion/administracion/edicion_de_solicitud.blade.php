@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edicion de solicitud') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('reparacion.editar_solicitud') }}">
                        @method('PUT')
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <b>Datos del cliente</b> 
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Razon Social') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="razon_social" id="razon_social" value="{{ $solicitud->razon_social }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Contacto') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="contacto_cliente" id="contacto_cliente" value="{{ $solicitud->contacto_cliente }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="telefono_cliente" id="telefono_cliente" value="{{ $solicitud->telefono_cliente }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="id_sucursal" id="id_sucursal" required autofocus> 
                                    <option value="">Seleccionar sucursal</option>
                                    @foreach ($sucursals as $sucursal)
                                        <option value="{{ $sucursal->id }}" {{ ($solicitud->id_sucursal == $sucursal->id) ? "selected" : ""  }}>{{ $sucursal->NombSucu }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor') }} *</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="horas_de_motor" id="horas_de_motor" value="{{ $solicitud->horas_de_motor }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="modelo" id="modelo" value="{{ $solicitud->modelo }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Responsable del Relevamiento') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="responsable_relevamiento" id="responsable_relevamiento" value="{{ $solicitud->responsable_relevamiento }}" readonly required autofocus> 
                            </div>
                        </div>
                        <b>Relevamiento del desperfecto</b> 
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿La maquina esta parada?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="maquina_parada" id="maquina_parada" required autofocus> 
                                    @if($solicitud->maquina_parada == "0") 
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    @else 
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Descripcion de la falla') }} *</label>
                            <div class="col-md-6">
                            <textarea class="form-control-textarea" name="descripcion_falla" id="descripcion_falla" rows="6" required autofocus> {{ $solicitud->descripcion_falla }} </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Codigo de diagnostico') }}</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="codigo_diagnostico" id="codigo_diagnostico" value="{{ $solicitud->codigo_diagnostico }}" autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Bajo que condiciones ocurre?') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="condiciones_de_ocurrencia" id="condiciones_de_ocurrencia" value="{{ $solicitud->condiciones_de_ocurrencia }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tipo de cultivo o tarea que estaba realizando') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="tarea_que_estaba_realizando" id="tarea_que_estaba_realizando" value="{{ $solicitud->tarea_que_estaba_realizando }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Que tipo de falla es?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="tipo_falla" id="tipo_falla" required autofocus> 
                                    @if($solicitud->tipo_falla == "Intermitente") 
                                        <option value="Intermitente">Intermitente</option>
                                        <option value="Permanente">Permanente</option>
                                    @else 
                                        <option value="Permanente">Permanente</option>
                                        <option value="Intermitente">Intermitente</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Primera vez que ocurre?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="primera_ocurrencia" id="primera_ocurrencia" required autofocus> 
                                    @if($solicitud->primera_ocurrencia == "0") 
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    @else 
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Se realizo alguna prueba? ') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="prueba_realizada" id="prueba_realizada" required autofocus> 
                                    @if($solicitud->prueba_realizada == "0") 
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    @else 
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Es necesaria la visita al campo?') }} *</label>
                            <div class="col-md-6">
                                @if($solicitud->visita_a_campo == "0") 
                                    <input class="form-control" type="checkbox" id="visita_a_campo" name="visita_a_campo" value="0"/>
                                @else 
                                    <input class="form-control" type="checkbox" id="visita_a_campo" name="visita_a_campo" checked value="1"/>
                                @endif
                            </div>
                        </div>
                        @if($solicitud->visita_a_campo != "0") 
                            <div id="relevamiento_del_lugar">
                                <b>Relevamiento del lugar(en caso de visita a campo)</b> 
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('Lugar donde se encuentra') }} *</label>
                                    <div class="col-md-6 donde_se_encuentra_input">
                                        <input class="form-control" type="text" id="donde_se_encuentra" name="donde_se_encuentra" value="{{ $solicitud->donde_se_encuentra }}" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('¿En el lugar tiene electricidad o instalaciones?') }} *</label>
                                    <div class="col-md-6 tiene_instalaciones_select">
                                        <select class="form-control" id="tiene_instalaciones" name="tiene_instalaciones" required autofocus>
                                            @if($solicitud->tiene_instalaciones == "0") 
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            @else 
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div id="relevamiento_del_lugar" hidden>
                                <b>Relevamiento del lugar(en caso de visita a campo)</b> 
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('Lugar donde se encuentra') }} *</label>
                                    <div class="col-md-6 donde_se_encuentra_input"></div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('¿En el lugar tiene electricidad o instalaciones?') }} *</label>
                                    <div class="col-md-6 tiene_instalaciones_select"></div>
                                </div>
                            </div>
                        @endif
                        <b>Postventa proactiva</b> 
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene paquete de monitoreo?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="paquete_monitoreo" id="paquete_monitoreo" required autofocus> 
                                    @if($solicitud->paquete_monitoreo == "0") 
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    @else 
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Se le realizo el ultimo service?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="ultimo_service_hecho" id="ultimo_service_hecho" required autofocus> 
                                    @if($solicitud->ultimo_service_hecho == "0") 
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    @else 
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo de pantalla') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="modelo_pantalla" id="modelo_pantalla" required autofocus>
                                    <option value="">Seleccionar pantalla</option> 
                                    @foreach ($pantallas as $pantalla)
                                        @if($solicitud->modelo_pantalla == $pantalla->NombPant)
                                            <option value="{{$pantalla->NombPant}}" selected>{{ $pantalla->NombPant }}</option>
                                        @else
                                            <option value="{{$pantalla->NombPant}}">{{ $pantalla->NombPant }}</option>
                                        @endif
                                    @endforeach
                                    <option value="Otra">Otra</option>
                                    <option value="No tiene">No tiene</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Esta actualizada la pantalla?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="modelo_pantalla_actualizado" id="modelo_pantalla_actualizado" required autofocus> 
                                    @if($solicitud->modelo_pantalla_actualizado == "0") 
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    @else 
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo de antena') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="modelo_antena" id="modelo_antena" required autofocus> 
                                    <option value="">Seleccionar antena</option>
                                    @foreach ($antenas as $antena)
                                        @if($solicitud->modelo_antena == $antena->NombAnte)
                                            <option value="{{$antena->NombAnte}}" selected>{{ $antena->NombAnte }}</option>
                                        @else
                                            <option value="{{$antena->NombAnte}}">{{ $antena->NombAnte }}</option>
                                        @endif
                                    @endforeach
                                    <option value="Otra">Otra</option>
                                    <option value="No tiene">No tiene</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Esta actualizada la antena?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="modelo_antena_actualizado" id="modelo_antena_actualizado" required autofocus> 
                                    @if($solicitud->modelo_antena_actualizado == "0") 
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    @else 
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tipo de piloto') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="tipo_piloto" id="tipo_piloto" required autofocus> 
                                    @if($solicitud->tipo_piloto == "Integrado") 
                                        <option value="Integrado">Integrado</option>
                                        <option value="Universal">Universal</option>
                                        <option value="No tiene">No tiene</option>
                                    @elseif($solicitud->tipo_piloto == "Universal")
                                        <option value="Universal">Universal</option>
                                        <option value="Integrado">Integrado</option>
                                        <option value="No tiene">No tiene</option>
                                    @else
                                        <option value="No tiene">No tiene</option>
                                        <option value="Integrado">Integrado</option>
                                        <option value="Universal">Universal</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Esta en garantía?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="garantia" id="garantia" required autofocus> 
                                    @if($solicitud->garantia == "No") 
                                        <option value="No">No</option>
                                        <option value="Si">Si</option>
                                    @else 
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene PMP pendientes?') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="pmp_pendientes" id="pmp_pendientes" required autofocus> 
                                @if($solicitud->pmp_pendientes == "0") 
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                @else 
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                @endif
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene PowerGard?') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="tiene_powergard" id="tiene_powergard" required autofocus> 
                                @if($solicitud->tiene_powergard == "0") 
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                @else 
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                @endif
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene otra maquina JD en el lugar?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="otra_maquina_JD" id="otra_maquina_JD" required autofocus> 
                                    @if($solicitud->otra_maquina_JD == "0") 
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    @else 
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <b>Presupuesto</b>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Trabajo a presupuestar') }} *</label>
                            <div class="col-md-6">
                                <textarea class="form-control-textarea" name="trabajo_a_presupuestar" id="trabajo_a_presupuestar" rows="6" required autofocus> {{ $solicitud->trabajo_a_presupuestar }} </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Cuantos tecnicos intervienen en la reparacion?') }}</label>
                            <div class="col-md-6">
                                @php
                                    $cant_tecnicos = count($tecnicos_selected);
                                    for ($i = $cant_tecnicos; $i <= 4; $i++) {
                                        $tecnicos_selected[$i] = "";
                                    }
                                @endphp
                                <select class="form-control" name="cant_tecnicos" id="cant_tecnicos" required autofocus> 
                                    <option value="1" {{ ($cant_tecnicos == "1") ? "selected" : "" }}>1</option>
                                    <option value="2" {{ ($cant_tecnicos == "2") ? "selected" : "" }}>2</option>
                                    <option value="3" {{ ($cant_tecnicos == "3") ? "selected" : "" }}>3</option>
                                    <option value="4" {{ ($cant_tecnicos == "4") ? "selected" : "" }}>4</option>
                                    <option value="5" {{ ($cant_tecnicos == "5") ? "selected" : "" }}>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico1" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 1') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico1" id="tecnico1" required autofocus> 
                                    @php
                                        $tecnicos_0 = $all_tecnicos;
                                        foreach($tecnicos_0 as $i => $tecnico){
                                            if($tecnicos_selected[0] != "" && $tecnico->name == $tecnicos_selected[0]->name && $tecnico->last_name == $tecnicos_selected[0]->last_name){
                                                unset($tecnicos_0[$i]);
                                            }
                                        }
                                    @endphp
                                    @if ($tecnicos_selected[0] != "")
                                        <option value="{{$tecnicos_selected[0]->id}}">{{ $tecnicos_selected[0]->name . " " . $tecnicos_selected[0]->last_name }}</option>
                                    @endif
                                    @foreach ($tecnicos_0 as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico2" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 2') }} </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico2" id="tecnico2" required autofocus> 
                                    @php
                                        $tecnicos_1 = $all_tecnicos;
                                        foreach($tecnicos_1 as $i => $tecnico){
                                            if($tecnicos_selected[1] != "" && $tecnico->name == $tecnicos_selected[1]->name && $tecnico->last_name == $tecnicos_selected[1]->last_name){
                                                unset($tecnicos_1[$i]);
                                            }
                                        }
                                    @endphp
                                    @if ($tecnicos_selected[1] != "")
                                        <option value="{{$tecnicos_selected[1]->id}}">{{ $tecnicos_selected[1]->name . " " . $tecnicos_selected[1]->last_name }}</option>
                                    @endif
                                    @foreach ($tecnicos_1 as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico3" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 3') }} </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico3" id="tecnico3" required autofocus> 
                                    @php
                                        $tecnicos_2 = $all_tecnicos;
                                        foreach($tecnicos_2 as $i => $tecnico){
                                            if($tecnicos_selected[2] != "" && $tecnico->name == $tecnicos_selected[2]->name && $tecnico->last_name == $tecnicos_selected[2]->last_name){
                                                unset($tecnicos_2[$i]);
                                            }
                                        }
                                    @endphp
                                    @if ($tecnicos_selected[2] != "")
                                        <option value="{{$tecnicos_selected[2]->id}}">{{ $tecnicos_selected[2]->name . " " . $tecnicos_selected[2]->last_name }}</option>
                                    @endif
                                    @foreach ($tecnicos_2 as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico4">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 4') }} </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico4" id="tecnico4" required autofocus> 
                                    @php
                                        $tecnicos_3 = $all_tecnicos;
                                        foreach($tecnicos_3 as $i => $tecnico){
                                            if($tecnicos_selected[3] != "" && $tecnico->name == $tecnicos_selected[3]->name && $tecnico->last_name == $tecnicos_selected[3]->last_name){
                                                unset($tecnicos_3[$i]);
                                            }
                                        }
                                    @endphp
                                    @if ($tecnicos_selected[3] != "")
                                        <option value="{{$tecnicos_selected[3]}}">{{ $tecnicos_selected[3]->name . " " . $tecnicos_selected[3]->last_name }}</option>
                                    @endif
                                    @foreach ($tecnicos_3 as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico5" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 5') }} </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico5" id="tecnico5" required autofocus> 
                                    @php
                                        $tecnicos_4 = $all_tecnicos;
                                        foreach($tecnicos_4 as $i => $tecnico){
                                            if($tecnicos_selected[4] != "" && $tecnico->name == $tecnicos_selected[4]->name && $tecnico->last_name == $tecnicos_selected[4]->last_name){
                                                unset($tecnicos_4[$i]);
                                            }
                                        }
                                    @endphp
                                    @if ($tecnicos_selected[4] != "")
                                        <option value="{{$tecnicos_selected[4]}}">{{ $tecnicos_selected[4]->name . " " . $tecnicos_selected[4]->last_name }}</option>
                                    @endif
                                    @foreach ($tecnicos_4 as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horas a presupuestar') }}</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="horas_a_presupuestar" id="horas_a_presupuestar" value="{{ $solicitud->horas_a_presupuestar }}" autofocus> 
                            </div>
                        </div>
                        <b>Repuestos</b> 
                        <br>
                        <div class="repuestos_guardados">
                            @foreach ($repuestos_faltantes as $i => $repuesto)
                                    <div>
                                        <b>Repuesto {{ $i + 1 }}</b>
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="{{ 'cantidad_respuesto'. ($repuesto->id) }}" id="{{ 'cantidad_respuesto'. ($repuesto->id) }}"value="{{ $repuesto->cantidad }}" required autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }}</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="{{ 'codigo_respuesto'. ($repuesto->id) }}" id="{{ 'codigo_respuesto'. ($repuesto->id) }}" value="{{ $repuesto->codigo }}" required autofocus> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label text-md-right">{{ __('Reemplazo') }}</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="{{ 'reemplazo_respuesto'. ($repuesto->id) }}" id="{{ 'reemplazo_respuesto'. ($repuesto->id) }}" value="{{ $repuesto->reemplazo }}" required autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label text-md-right">{{ __('Disponibilidad') }}</label>
                                            <div class="col-md-6">
                                                <select multiple="multiple" class="form-control multiple-select" name="{{ 'disponibilidad_respuesto'. ($repuesto->id) }}[]" id="{{ 'disponibilidad_respuesto'. ($repuesto->id) }}" required autofocus>
                                                    @php
                                                        $disponibilidad = explode(",", $repuesto->disponibilidad);
                                                        $cant_selected = count($disponibilidad);
                                                        $disponibilidad_options = [];
                                                        if(!in_array("En sucursal", $disponibilidad)){ 
                                                            $disponibilidad[count($disponibilidad)] = "En sucursal"; 
                                                        }
                                                        if(!in_array("Coronel Moldes", $disponibilidad)){ 
                                                            $disponibilidad[count($disponibilidad)] = "Coronel Moldes"; 
                                                        }
                                                        if(!in_array("Adelia Maria", $disponibilidad)){ 
                                                            $disponibilidad[count($disponibilidad)] = "Adelia Maria"; 
                                                        }
                                                        if(!in_array("Villa Mercedes", $disponibilidad)){ 
                                                            $disponibilidad[count($disponibilidad)] = "Villa Mercedes"; 
                                                        }
                                                        if(!in_array("Vicuña Mackenna", $disponibilidad)){ 
                                                            $disponibilidad[count($disponibilidad)] = "Vicuña Mackenna"; 
                                                        }
                                                        if(!in_array("Rio Cuarto", $disponibilidad)){ 
                                                            $disponibilidad[count($disponibilidad)] = "Rio Cuarto"; 
                                                        }
                                                        if(!in_array("Fabrica", $disponibilidad)){ 
                                                            $disponibilidad[count($disponibilidad)] = "Fabrica"; 
                                                        }
                                                        for ($i = 0; $i < count($disponibilidad) ; $i++) { 
                                                            if( $i < $cant_selected ){
                                                                $disponibilidad_options[$i] = "<option value='" . $disponibilidad[$i] . "' selected='selected'>" . $disponibilidad[$i] . "</option>";
                                                            }
                                                            else{
                                                                $disponibilidad_options[$i] = "<option value='" . $disponibilidad[$i] . "'>" . $disponibilidad[$i] . "</option>";
                                                            }
                                                        }
                                                    @endphp
                                                    @foreach ($disponibilidad_options as $option)
                                                        {!! $option  !!}
                                                    @endforeach
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4"> 
                                                <a href="#" class="borrar_repuesto_guardado btn btn-danger" value="{{ $repuesto->id }}">
                                                    Borrar
                                                </a> 
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="repuestos">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary agregar_repuesto">Agregar repuesto</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="hidden" name="cant_repuestos_a_crear" id="cant_repuestos_a_crear" value="0">
                        <input type="hidden" name="cant_repuestos_a_editar" id="cant_repuestos_a_editar" value="{{ count($repuestos_faltantes) }}">
                        <input type="hidden" name="cant_repuestos_a_eliminar" id="cant_repuestos_a_eliminar" value="0">
                        <input type="hidden" name="ids_repuestos_a_eliminar" id="ids_repuestos_a_eliminar" value="">
                        @php
                            $ids_repuestos_a_editar = [];
                            foreach ($repuestos_faltantes as $i => $repuesto) {
                                $ids_repuestos_a_editar[$i - 1] = $repuesto->id; 
                            } 
                            $ids_repuestos_a_editar = implode($ids_repuestos_a_editar, ",") . ",";
                        @endphp
                        <input type="hidden" name="ids_repuestos_a_editar" id="ids_repuestos_a_editar" value="{{ $ids_repuestos_a_editar }}">
                        <input type="hidden" name="cant_repuestos" id="cant_repuestos" value="{{ count($repuestos_faltantes) }}">
                        
                        <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('N° CPRES') }} *</label>
                                <div class="col-md-6">
                                <input type="number" class="form-control" name="numero_cpres" id="numero_cpres" value="{{ $solicitud->numero_cpres }}" required autofocus> 
                                </div>
                            </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Aprobado?') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="aprobado" id="aprobado" required autofocus> 
                                @if($solicitud->aprobado == "0") 
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                @else 
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                @endif
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Observaciones') }} *</label>
                            <div class="col-md-6">
                            <textarea class="form-control-textarea" name="observaciones" id="observaciones" rows="4" required autofocus> {{ $solicitud->observaciones }} </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha acordada con el cliente') }} *</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="fecha" id="fecha" value="{{ $solicitud->fecha }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('N° de COR') }}</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="cor" id="cor" value="{{ $solicitud->cor }}"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Firma') }}*</label>
                            <div class="col-md-6">
                                <canvas style="width: 300px; height: 200px;" class="js-paint paint-canvas"></canvas>
                                <br>
                                <button class="btn btn-secondary" id="boton_limpiar_firma">Limpiar</button>   
                            </div>
                        </div>
                        <input type="hidden" id="firma" name="firma" value="{{ $solicitud->firma }}">
                        <input type="hidden" name="id" value="{{ $solicitud->id }}">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="crear" type="submit" class="btn btn-success">Editar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('/reparacion/tareas/tareas_en_campo');
<script>
    $(document).ready(function() {
        $('.multiple-select').select2();

        //Para controlar el checkbox si es necesaria la visita a campo
        var input_div = $(".donde_se_encuentra_input");
        var select_div = $(".tiene_instalaciones_select");
        var checkbox = document.getElementById('visita_a_campo');
        checkbox.addEventListener("click", function () {
            if (document.getElementById("donde_se_encuentra") || document.getElementById("tiene_instalaciones")) {
                document.getElementById("relevamiento_del_lugar").setAttribute("hidden", true);
                checkbox.value = "0";
                document.getElementById("donde_se_encuentra").remove();
                document.getElementById("tiene_instalaciones").remove();
            } else {
                document.getElementById("relevamiento_del_lugar").removeAttribute("hidden");
                checkbox.value = "1";
                var input = document.createElement("input");
                input.className = "form-control";
                input.id = "donde_se_encuentra";
                input.name = "donde_se_encuentra"
                input.type = "text";
                input.value = {!! json_encode($solicitud->donde_se_encuentra) !!}

                var select = document.createElement("select");
                select.className = "form-control";
                select.id = "tiene_instalaciones";
                select.name = "tiene_instalaciones"

                var opcionSi = document.createElement("option");
                opcionSi.value = "1";
                opcionSi.text = "Si";

                var opcionNo = document.createElement("option");
                opcionNo.value = "0";
                opcionNo.text = "No";

                var tiene_instalaciones = {!! json_encode($solicitud->tiene_instalaciones) !!}
                if(tiene_instalaciones == "0"){
                    select.appendChild(opcionNo);
                    select.appendChild(opcionSi);
                }
                else{
                    select.appendChild(opcionSi);
                    select.appendChild(opcionNo);
                }
                
                $(input_div).append(input);
                $(select_div).append(select);
            }
        });

        //Para agregar repuestos
        var wrapper = $(".repuestos");
        var agregar_repuesto = $(".agregar_repuesto");
        var repuestos_guardados = $('.repuestos_guardados');
        var cant_repuestos_input = document.getElementById('cant_repuestos');
        var borrar_repuesto_guardado = document.getElementById('borrar_repuesto_guardado');
        var cant_repuestos_a_crear = document.getElementById('cant_repuestos_a_crear');        
        var cant_repuestos_a_editar = document.getElementById('cant_repuestos_a_editar');        
        var cant_repuestos_a_eliminar = document.getElementById('cant_repuestos_a_eliminar');        
        var ids_repuestos_a_eliminar = document.getElementById('ids_repuestos_a_eliminar');
        var ids_repuestos_a_editar = document.getElementById('ids_repuestos_a_editar');                
        
        var cant_repuestos = cant_repuestos_input.value;
        $(agregar_repuesto).click(function(e) {
            e.preventDefault();
            if(cant_repuestos_a_crear.value > 0){
                let borrar_repuesto = document.getElementById('borrar_repuesto');
                borrar_repuesto.remove();
            }
            cant_repuestos++;
            cant_repuestos_input.value = cant_repuestos;
            cant_repuestos_a_crear.value++;
            $(wrapper).append(`<div class="mt-2" id="repuesto_${cant_repuestos}"> <b>Repuesto ${cant_repuestos}</b> <div class="form-group row"> <label class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }} *</label> <div class="col-md-6"> <input type="number" class="form-control" name="cant_respuesto${cant_repuestos_a_crear.value}" id="cant_respuesto${cant_repuestos_a_crear.value}" required autofocus> </div> </div> <div class="form-group row"> <label class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }} *</label> <div class="col-md-6"> <input type="text" class="form-control" name="cod_respuesto${cant_repuestos_a_crear.value}" id="cod_respuesto${cant_repuestos_a_crear.value}" required autofocus> </div> </div> <div class="form-group row"> <label class="col-md-4 col-form-label text-md-right">{{ __('Reemplazo') }} *</label> <div class="col-md-6"> <input type="text" class="form-control" name="ree_respuesto${cant_repuestos_a_crear.value}" id="ree_respuesto${cant_repuestos_a_crear.value}" required autofocus> </div> </div> <div class="form-group row"> <label class="col-md-4 col-form-label text-md-right">{{ __('Disponibilidad') }} *</label> <div class="col-md-6"> <select multiple="multiple" class="form-control multiple-select" name="dispo_respuesto${cant_repuestos_a_crear.value}[]" id="dispo_respuesto${cant_repuestos_a_crear.value}" required autofocus> <option value="En sucursal">En sucursal</option> <option value="Coronel Moldes">Coronel Moldes</option> <option value="Adelia Maria">Adelia Maria</option> <option value="Villa Mercedes">Villa Mercedes</option> <option value="Vicuña Mackenna">Vicuña Mackenna</option> <option value="Rio Cuarto">Rio Cuarto</option> <option value="Fabrica">Fabrica</option> </select> </div> </div> <div class="form-group row mb-0"> <div class="col-md-6 offset-md-4" id="borrar_repuesto"> <a href="#" class="borrar_repuesto btn btn-danger">Borrar</a> </div> </div></div>`);
            $('.multiple-select').select2();
        });
            
        $(wrapper).on("click", ".borrar_repuesto", function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').parent('div').remove();
            cant_repuestos--;
            cant_repuestos_input.value = cant_repuestos;
            cant_repuestos_a_crear.value--;
            if(cant_repuestos_a_crear.value > 0){
                let repuesto = document.getElementById(`repuesto_${cant_repuestos}`);
                repuesto.insertAdjacentHTML('beforeend', `<div class="form-group row mb-0" id="borrar_repuesto"> <div class="col-md-6 offset-md-4"> <a href="#" class="borrar_repuesto btn btn-danger">Borrar</a> </div> </div>`);
            }
        })

        $(repuestos_guardados).on("click", ".borrar_repuesto_guardado", function(e) {
            e.preventDefault();
            cant_repuestos_a_editar.value = cant_repuestos_a_editar.value - 1;
            cant_repuestos--;
            cant_repuestos_input.value = cant_repuestos;
            cant_repuestos_a_eliminar.value++;
            var id = e.target.getAttribute('value');
            ids_repuestos_a_eliminar.value = ids_repuestos_a_eliminar.value + id + ",";
            ids_repuestos_a_editar.value = ids_repuestos_a_editar.value.replace(id + ",", "");
            if(ids_repuestos_a_editar.value[0] && ids_repuestos_a_editar.value.charAt(0) == ","){
                ids_repuestos_a_editar.value = ids_repuestos_a_editar.value.substring(1);
            }
            $(this).parent('div').parent('div').parent('div').remove();
        })

        //  Para manejar la cantidad de tecnicos
        var select = document.getElementById("cant_tecnicos");
        function onChange() {
            var selectedValue = select.value;
            var cant_tecnicos = parseInt(selectedValue);
            if(cant_tecnicos == "1"){
                document.getElementById("tecnico1").removeAttribute("hidden");
                document.getElementById("tecnico2").setAttribute("hidden", true);
                document.getElementById("tecnico3").setAttribute("hidden", true);
                document.getElementById("tecnico4").setAttribute("hidden", true);
                document.getElementById("tecnico5").setAttribute("hidden", true);
            }
            if(cant_tecnicos == "2"){
                document.getElementById("tecnico1").removeAttribute("hidden");
                document.getElementById("tecnico2").removeAttribute("hidden");
                document.getElementById("tecnico3").setAttribute("hidden", true);
                document.getElementById("tecnico4").setAttribute("hidden", true);
                document.getElementById("tecnico5").setAttribute("hidden", true);
            }
            if(cant_tecnicos == "3"){
                document.getElementById("tecnico1").removeAttribute("hidden");
                document.getElementById("tecnico2").removeAttribute("hidden");
                document.getElementById("tecnico3").removeAttribute("hidden");
                document.getElementById("tecnico4").setAttribute("hidden", true);
                document.getElementById("tecnico5").setAttribute("hidden", true);
            }
            if(cant_tecnicos == "4"){
                document.getElementById("tecnico1").removeAttribute("hidden");
                document.getElementById("tecnico2").removeAttribute("hidden");
                document.getElementById("tecnico3").removeAttribute("hidden");
                document.getElementById("tecnico4").removeAttribute("hidden");
                document.getElementById("tecnico5").setAttribute("hidden", true);
            }
            if(cant_tecnicos == "5"){
                document.getElementById("tecnico1").removeAttribute("hidden");
                document.getElementById("tecnico2").removeAttribute("hidden");
                document.getElementById("tecnico3").removeAttribute("hidden");
                document.getElementById("tecnico4").removeAttribute("hidden");
                document.getElementById("tecnico5").removeAttribute("hidden");
            }
            
        }
        select.onchange = onChange;
        onChange();

        //Para manejar el firmado
        const canvas = document.querySelector( '.js-paint' );
        const boton = document.getElementById( 'boton_limpiar_firma' );
        const firma = document.getElementById("firma");
        const context = canvas.getContext( '2d' );
        const color = "black";
        const strokeSize = 5;
        var painting = false;

        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
        
        var image = new Image();
        image.onload = function() {
            context.drawImage(image, 0, 0);
        };
        image.src = {!! json_encode($solicitud->firma) !!};

        function startPosition(event) {
            painting = true;
            draw(event);
        }

        function endPosition() {
            painting = false;
            context.beginPath();
            firma.value = canvas.toDataURL();
        }

        function draw(event) {
            if (!painting) return;

            event.preventDefault();
            context.lineWidth = strokeSize;
            context.lineCap = "round";  
            rect = canvas.getBoundingClientRect()

            if (event.type == 'touchmove') {
                context.lineTo(event.touches[0].clientX - rect.x, event.touches[0].clientY - rect.y);
            } else if (event.type == 'mousemove') {
                context.lineTo(event.clientX - rect.x, event.clientY - rect.y);
            }

            context.stroke();
            context.strokeStyle = color;
            context.beginPath();

            if (event.type == 'touchmove') {
                context.moveTo(event.touches[0].clientX - rect.x, event.touches[0].clientY - rect.y);
            } else if (event.type == 'mousemove') {
                context.moveTo(event.clientX - rect.x, event.clientY - rect.y);
            }
        }

        boton.addEventListener("click", event => {
            event.preventDefault();
            context.clearRect(0, 0, canvas.width, canvas.height);
            firma.value = "";
        });

        canvas.addEventListener("mousedown", startPosition);
        canvas.addEventListener("touchstart", startPosition);
        canvas.addEventListener("mouseup", endPosition);
        canvas.addEventListener("touchend", endPosition);
        canvas.addEventListener("mousemove", draw);
        canvas.addEventListener("touchmove", draw);
    })
</script>
@endsection
