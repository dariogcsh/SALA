@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Solicitar Reparacion de Maquinaria') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('reparacion.solicitud_reparacion_crear') }}">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <b>Datos del cliente</b> 
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Razon Social') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="razon_social" id="razon_social" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Contacto') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="contacto_cliente" id="contacto_cliente" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="telefono_cliente" id="telefono_cliente" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="id_sucursal" id="id_sucursal" required autofocus> 
                                    @foreach ($sucursals as $sucursal)
                                        <option value="{{$sucursal->id}}">{{ $sucursal->NombSucu }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor') }} *</label>
                            <div class="col-md-6">
                            <input type="number" class="form-control" name="horas_de_motor" id="horas_de_motor" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="modelo" id="modelo" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Responsable del Relevamiento') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="responsable_relevamiento" id="responsable_relevamiento" value="{{ $usuario_adm->name. ' ' .$usuario_adm->last_name }}" readonly required autofocus> 
                            </div>
                        </div>
                        <b>Relevamiento del desperfecto</b> 
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿La maquina esta parada?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="maquina_parada" id="maquina_parada" required autofocus> 
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Descripcion de la falla') }} *</label>
                            <div class="col-md-6">
                            <textarea class="form-control-textarea" name="descripcion_falla" id="descripcion_falla" rows="6" required autofocus> </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Codigo de diagnostico') }}</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="codigo_diagnostico" id="codigo_diagnostico" autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Bajo que condiciones ocurre?') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="condiciones_de_ocurrencia" id="condiciones_de_ocurrencia" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tipo de cultivo o tarea que estaba realizando') }} *</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="tarea_que_estaba_realizando" id="tarea_que_estaba_realizando" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Que tipo de falla es?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="tipo_falla" id="tipo_falla" required autofocus> 
                                    <option value="Intermitente">Intermitente</option>
                                    <option value="Permanente">Permanente</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Primera vez que ocurre?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="primera_ocurrencia" id="primera_ocurrencia" required autofocus> 
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Se realizo alguna prueba?') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="prueba_realizada" id="prueba_realizada" autofocus> 
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Es necesaria la visita al campo?') }} *</label>
                            <div class="col-md-6">
                                <input class="form-control" type="checkbox" id="visita_a_campo" name="visita_a_campo" value="0"/>
                            </div>
                        </div>
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
                        <b>Postventa proactiva</b> 
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene paquete de monitoreo?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="paquete_monitoreo" id="paquete_monitoreo" required autofocus> 
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Se le realizo el ultimo service?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="ultimo_service_hecho" id="ultimo_service_hecho" required autofocus> 
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo de pantalla') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="modelo_pantalla" id="modelo_pantalla" required autofocus>
                                <option value="">Seleccionar pantalla</option> 
                                @foreach ($pantallas as $pantalla)
                                    <option value="{{$pantalla->NombPant}}">{{ $pantalla->NombPant }}</option>
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
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo de antena') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="modelo_antena" id="modelo_antena" required autofocus> 
                                <option value="">Seleccionar antena</option>
                                @foreach ($antenas as $antena)
                                    <option value="{{$antena->NombAnte}}">{{ $antena->NombAnte }}</option>
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
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tipo de piloto') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="tipo_piloto" id="tipo_piloto" required autofocus> 
                                    <option value="No tiene">No tiene</option>
                                    <option value="Integrado">Integrado</option>
                                    <option value="Universal">Universal</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Está en garantía?') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="pmp_pendientes" id="pmp_pendientes" required autofocus> 
                                <option value="No">No</option>
                                <option value="Si">Si</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene PMP pendientes?') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="pmp_pendientes" id="pmp_pendientes" required autofocus> 
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene PowerGard?') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="tiene_powergard" id="tiene_powergard" required autofocus> 
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene otra maquina JD en el lugar?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="otra_maquina_JD" id="otra_maquina_JD" required autofocus> 
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="crear" type="submit" class="btn btn-success">Solicitar Reparacion</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('/reparacion/pendiente_de_presupuestar');
@include('/reparacion/pendiente_de_aprobar');
<script>
    $(document).ready(function() {
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

                var select = document.createElement("select");
                select.className = "form-control";
                select.id = "tiene_instalaciones";
                select.name = "tiene_instalaciones"

                var opcionSi = document.createElement("option");
                opcionSi.value = "1";
                opcionSi.text = "Si";
                select.appendChild(opcionSi);

                var opcionNo = document.createElement("option");
                opcionNo.value = "0";
                opcionNo.text = "No";
                select.appendChild(opcionNo);

                $(input_div).append(input);
                $(select_div).append(select);
            }
        });
    })
</script>
@endsection
