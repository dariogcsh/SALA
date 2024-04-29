@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="align-baseline" style="font-size: 1rem;">{{ __('Administracion de tareas de taller') }}</span>
                    <a id="download" class="btn btn-secondary" href={{ route('reparacion.tarea_taller_pdf',$reparacion->id) }}>Descargar PDF</a>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('N° COR') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $reparacion->cor }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Cliente') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $reparacion->cliente }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene garantia?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                @if($reparacion->garantia == 0) 
                                    <option>No</option>
                                @else 
                                    <option>Si</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('¿Vendido por sala?') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" disabled> 
                                    @if($reparacion->vendido_sala == 0) 
                                        <option>No</option>
                                    @else 
                                        <option>Si</option>
                                    @endif
                            </select>
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
                            @if(($i + 1) == 1)
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico responsable') }}</label>
                            @else
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico ' . ($i + 1)) }}</label>
                            @endif
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="{{ $tecnico->name . " " . $tecnico->last_name }}" readonly>
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Numero de Chasis') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $reparacion->numero_chasis }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Horas de Motor') }}</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" value="{{ $reparacion->horas_de_motor }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Horas de Trilla') }}</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" value="{{ $reparacion->horas_de_trilla }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha de ingreso') }}</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" value="{{ $reparacion->fecha_ingreso }}" readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha de salida') }}</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" value="{{ $reparacion->fecha_salida }}" readonly> 
                        </div>
                    </div>
                    @if(!$tareas_reparacion->isEmpty())
                        <b>Tareas</b>
                        <br>
                        @foreach ($tareas_reparacion as $i => $tarea)
                            <b>Tarea {{ $i + 1}}</b>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }}</label>
                                <div class="col-md-6"> 
                                    <input type="date" class="form-control" value="{{ $tarea->fecha }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }}</label>
                                <div class="col-md-6"> 
                                    <textarea class="form-control-textarea" rows="4" readonly>{{ $tarea->descripcion }}</textarea> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Horas') }}</label>
                                <div class="col-md-6"> 
                                    <input type="number" class="form-control" value="{{ $tarea->horas }}" readonly> 
                                </div>
                            </div>
                        @endforeach
                        <br>
                    @else
                        <b>No hay tareas relacionadas</b>
                        <br>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Firma tecnico responsable') }}</label>
                        <div class="col-md-6">
                            <canvas style="width: 300px; height: 200px;" class="canvas_tecnico paint-canvas paint-canvas-onlyview" ></canvas>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('Firma jefe de taller') }}</label>
                        <div class="col-md-6">
                            <canvas style="width: 300px; height: 200px;" class="canvas_cliente paint-canvas paint-canvas-onlyview" ></canvas>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href={{ route('reparacion.administrar_solicitudes') }}>Atras</a>
                        </div>
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-warning btn-block" href={{ route('reparacion.administrar_tarea_de_taller_editar',$reparacion->id) }}>Editar</a>
                        </div>
                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                <form method="post" action="{{ route('reparacion.borrar_tarea_taller',$reparacion->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar esta tarea?');">Eliminar</button>
                                </form>
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    if({!! json_encode($reparacion->firma_tecnico) !!}){
        const canvas_tecnico = document.querySelector( '.canvas_tecnico' );
        const context_tecnico = canvas_tecnico.getContext("2d");

        canvas_tecnico.width = canvas_tecnico.offsetWidth;
        canvas_tecnico.height = canvas_tecnico.offsetHeight;

        var imagen_firma_tecnico = new Image();
        imagen_firma_tecnico.onload = function() {
            context_tecnico.drawImage(imagen_firma_tecnico, 0, 0);
        };
        imagen_firma_tecnico.src = {!! json_encode($reparacion->firma_tecnico) !!};
    }

    if({!! json_encode($reparacion->firma_cliente) !!}){
        const canvas_cliente = document.querySelector( '.canvas_cliente' );
        const context_cliente = canvas_cliente.getContext("2d");

        canvas_cliente.width = canvas_cliente.offsetWidth;
        canvas_cliente.height = canvas_cliente.offsetHeight;

        var image_firma_cliente = new Image();
        image_firma_cliente.onload = function() {
            context_cliente.drawImage(image_firma_cliente, 0, 0);
        };
        image_firma_cliente.src = {!! json_encode($reparacion->firma_cliente) !!};
    }

    document.getElementById("download").addEventListener("click", function(){
        const id = {!! json_encode($reparacion->id) !!} 
        const type = "tareas/taller";
        const name = `tarea_taller${id}`
        var messageObj = { action: "downloadPDF", id, type, name };
        var stringifiedMessageObj = JSON.stringify(messageObj);
        if(typeof webkit != "undefined"){
            webkit.messageHandlers.cordova_iab.postMessage(stringifiedMessageObj);
        }
    }, false);
</script>
@endsection
