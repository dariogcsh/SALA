@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ($solicitud->pendiente_de_presupuestar != "0" && $solicitud->pendiente_de_aprobar != "0")
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="align-baseline" style="font-size: 1rem;">{{ __('Administracion de solicitud') }}</span>
                        <a id="download" class="btn btn-secondary" href={{ route('reparacion.solicitudes_pdf',$solicitud->id) }}>Descargar PDF</a>
                    </div>
                @else
                    <div class="card-header">{{ __('Administracion de solicitud') }}</div>
                @endif
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha acordada con el cliente') }} </label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" value="{{ $solicitud->fecha }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('N° de COR') }} </label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" placeholder="{{ $solicitud->cor }}" readonly> 
                        </div>
                    </div>
                    <b>Datos del cliente</b> 
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Razon Social') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->razon_social }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>
                        <div class="col-md-6">
                            <select class="form-control" name="id_sucursal" id="id_sucursal" required autofocus disabled> 
                                <option value="">Seleccionar sucursal</option>
                                @foreach ($sucursals as $sucursal)
                                    <option value="{{ $sucursal->id }}" {{ ($solicitud->id_sucursal == $sucursal->id) ? "selected" : ""  }}>{{ $sucursal->NombSucu }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Contacto') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->contacto_cliente }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->telefono_cliente }}" readonly> 
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor') }}</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" placeholder="{{ $solicitud->horas_de_motor }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->modelo }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('N° de Serie') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->numero_serie }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Responsable del Relevamiento') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->responsable_relevamiento }}" readonly> 
                        </div>
                    </div>
                    <b>Relevamiento del desperfecto</b> 
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿La maquina esta parada?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->maquina_parada == 0) 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Descripcion de la falla') }}</label>
                        <div class="col-md-6">
                            <textarea class="form-control-textarea" readonly rows="6">{{ $solicitud->descripcion_falla }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Codigo de diagnostico') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->codigo_diagnostico }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Bajo que condiciones ocurre?') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->condiciones_de_ocurrencia }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Tipo de cultivo o tarea que estaba realizando') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->tarea_que_estaba_realizando }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Que tipo de falla es?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->tipo_falla == "Intermitente") 
                                    <option>Intermitente</option>
                                @else 
                                    <option>Permanente</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Primera vez que ocurre?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->primera_ocurrencia == "0") 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Se realizo alguna prueba?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->prueba_realizada == "0") 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Es necesaria la visita al campo?') }}</label>
                        <div class="col-md-6">
                            @if($solicitud->visita_a_campo == "0") 
                                <input class="form-control" type="checkbox" disabled/>
                            @else 
                                <input class="form-control" type="checkbox" checked disabled/>
                            @endif
                        </div>
                    </div>
                    @if($solicitud->visita_a_campo != "0") 
                        <div id="relevamiento_del_lugar">
                            <b>Relevamiento del lugar(en caso de visita a campo)</b> 
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Lugar donde se encuentra') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" placeholder="{{ $solicitud->donde_se_encuentra }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('¿En el lugar tiene electricidad o instalaciones?') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control" disabled>
                                        @if($solicitud->tiene_instalaciones == "0") 
                                            <option>No</option>
                                        @else 
                                            <option>Si</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    <b>Postventa proactiva</b> 
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene paquete de monitoreo?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->paquete_monitoreo == "0") 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Se le realizo el ultimo service?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->ultimo_service_hecho == "0") 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo de pantalla') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->modelo_pantalla }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Esta actualizada la pantalla?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->modelo_pantalla_actualizado == "0") 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Modelo de antena') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ $solicitud->modelo_antena }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Esta actualizada la antena?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->modelo_antena_actualizado == "0") 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Tipo de piloto') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->tipo_piloto == "Integrado") 
                                    <option>Integrado</option>
                                @else 
                                    <option>Universal</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene otra maquina JD en el lugar?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($solicitud->otra_maquina_JD == "0") 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Trabajo a presupuestar') }} </label>
                        <div class="col-md-6">
                            <textarea class="form-control-textarea" rows="6" readonly> {{ $solicitud->trabajo_a_presupuestar }} </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Cuantos tecnicos intervienen en la reparacion?') }}</label>
                        <div class="col-md-6">
                            @php
                                $cant_tecnicos = count($tecnicos);
                            @endphp
                            <select class="form-control" disabled> 
                                <option>{{ $cant_tecnicos }}</option>
                            </select>
                        </div>
                    </div>
                    @foreach ($tecnicos as $i => $tecnico)
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico ' . ($i + 1)) }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{ $tecnico->name . " " . $tecnico->last_name }}" readonly>
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Horas a presupuestar') }} </label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" placeholder="{{ $solicitud->horas_a_presupuestar }}" readonly> 
                        </div>
                    </div>
                    <b>Repuestos</b> 
                    <br>
                    @foreach ($repuestos_faltantes as $i => $repuesto)
                        <b>Repuesto {{ $i + 1 }}</b>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{ $repuesto->cantidad }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{ $repuesto->codigo }}" readonly> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Reemplazo') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{ $repuesto->reemplazo }}" readonly>
                            </div>
                        </div>
                        @php
                            $disponibilidad = explode(",", $repuesto->disponibilidad);
                        @endphp
                        @foreach ($disponibilidad as $disp)
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Disponible en </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="{{ $disp }}" readonly>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                    <br>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene PMP pendientes?') }} </label>
                        <div class="col-md-6">
                        <select class="form-control" disabled> 
                            @if($solicitud->pmp_pendientes == "0") 
                                <option>No</option>
                            @else 
                                <option>Si</option>
                            @endif
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene PowerGard?') }} </label>
                        <div class="col-md-6">
                        <select class="form-control" disabled> 
                            @if($solicitud->tiene_powergard == "0") 
                                <option>No</option>
                            @else 
                                <option>Si</option>
                            @endif
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('N° CPRES') }} </label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" placeholder="{{ $solicitud->numero_cpres }}" readonly> 
                            </div>
                        </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Aprobado?') }} </label>
                        <div class="col-md-6">
                        <select class="form-control" disabled> 
                            @if($solicitud->aprobado == "0") 
                                <option>No</option>
                            @else 
                                <option>Si</option>
                            @endif
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Observaciones') }} </label>
                        <div class="col-md-6">
                        <textarea class="form-control-textarea" rows="4" readonly>{{ $solicitud->observaciones }} </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 col-form-label text-md-right">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Firma') }}</label>
                        </div>
                        <div class="col-md-6">
                            <canvas style="width: 300px; height: 200px;" class="js-paint paint-canvas paint-canvas-onlyview" ></canvas>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href={{ route('reparacion.administrar_solicitudes') }}>Atras</a>
                        </div>
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-warning btn-block" href={{ route('reparacion.administrar_solicitud_editar',$solicitud->id) }}>Editar</a>
                        </div>
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                <form method="post" action="{{ route('reparacion.borrar_solicitud',$solicitud->id) }}"> 
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar esta solicitud?');">Eliminar</button>
                                </form>
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    if({!! json_encode($solicitud->firma) !!}){
        const canvas = document.querySelector( '.js-paint' );
        const context = canvas.getContext("2d");

        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
        
        var image = new Image();
        image.onload = function() {
            context.drawImage(image, 0, 0);
        };
        image.src = {!! json_encode($solicitud->firma) !!}
    }

    document.getElementById("download").addEventListener("click", function(){
        const id = {!! json_encode($solicitud->id) !!} 
        const type = "solicitudes";
        const name = `solicitud${id}`
        var messageObj = { action: "downloadPDF", id, type, name };
        var stringifiedMessageObj = JSON.stringify(messageObj);
        if(typeof webkit != "undefined"){
            webkit.messageHandlers.cordova_iab.postMessage(stringifiedMessageObj);
        }
    }, false);
</script>
@endsection
