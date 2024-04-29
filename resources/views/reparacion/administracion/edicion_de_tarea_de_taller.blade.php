@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edicion de tarea de taller') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('reparacion.editar_tarea_taller') }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('N° COR') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cor" id="cor" value="{{ $reparacion->cor }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Cliente') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cliente" id="cliente" value="{{ $reparacion->cliente }}" > 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene garantia?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="garantia" id="garantia" required autofocus> 
                                        @if($reparacion->garantia == "0") 
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
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Vendido por sala?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="vendido_sala" id="vendido_sala" required autofocus> 
                                    @if($reparacion->vendido_sala == "0") 
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
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico responsable') }} *</label>
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
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Numero de Chasis') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="numero_chasis" id="numero_chasis" value="{{ $reparacion->numero_chasis }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horas de Motor') }} *</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="horas_de_motor" id="horas_de_motor" value="{{ $reparacion->horas_de_motor }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horas de trilla') }}</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="horas_de_trilla" id="horas_de_trilla" value="{{ $reparacion->horas_de_trilla }}"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha de ingreso') }} *</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" value="{{ $reparacion->fecha_ingreso }}" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha salida') }} *</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="fecha_salida" id="fecha_salida" value="{{ $reparacion->fecha_salida }}" required autofocus> 
                            </div>
                        </div>
                        <b>Tareas</b>
                        <br>
                        <div class="tareas_guardadas">
                            @foreach ($tareas_reparacion as $i => $tarea)
                                <div>
                                    <b>Tarea {{ $i + 1}}</b>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }} *</label>
                                        <div class="col-md-6"> 
                                            <input type="date" class="form-control" name="{{ 'fecha_tarea'. ($tarea->id) }}" id="{{ 'fecha_tarea'. ($tarea->id) }}" value="{{ $tarea->fecha }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} *</label>
                                        <div class="col-md-6"> 
                                            <textarea class="form-control-textarea" rows="4" name="{{ 'descripcion_tarea'. ($tarea->id) }}" id="{{ 'descripcion_tarea'. ($tarea->id) }}" required autofocus>{{ $tarea->descripcion }}</textarea> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Horas') }} *</label>
                                        <div class="col-md-6"> 
                                            <input type="number" class="form-control" name="{{ 'horas_tarea'. ($tarea->id) }}" id="{{ 'horas_tarea'. ($tarea->id) }}" value="{{ $tarea->horas }}" required autofocus> 
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4"> 
                                            <a href="#" class="borrar_tarea_guardada btn btn-danger" value="{{ $tarea->id }}">
                                                Borrar
                                            </a> 
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="tareas">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary agregar_tarea">Agregar tarea</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="cant_tareas" id="cant_tareas" value="{{ count($tareas_reparacion) }}">
                        <input type="hidden" name="cant_tareas_a_crear" id="cant_tareas_a_crear" value="0">
                        <input type="hidden" name="cant_tareas_a_editar" id="cant_tareas_a_editar" value="{{ count($tareas_reparacion) }}">
                        <input type="hidden" name="cant_tareas_a_eliminar" id="cant_tareas_a_eliminar" value="0">
                        <input type="hidden" name="ids_tareas_a_eliminar" id="ids_tareas_a_eliminar" value="">
                        @php
                            $ids_tareas_a_editar = [];
                            foreach ($tareas_reparacion as $i => $tarea) {
                                $ids_tareas_a_editar[$i - 1] = $tarea->id; 
                            } 
                            $ids_tareas_a_editar = implode($ids_tareas_a_editar, ",") . ",";
                        @endphp
                        <input type="hidden" name="ids_tareas_a_editar" id="ids_tareas_a_editar" value="{{ $ids_tareas_a_editar }}">
                        <input type="hidden" name="id" value="{{ $reparacion->id }}">
                        <br>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Firma tecnico responsable') }} *</label>
                            <div class="col-md-6">
                                <canvas style="width: 300px; height: 200px;" class="canvas_tecnico paint-canvas" ></canvas>
                                <br>
                                <button class="btn btn-secondary" id="boton_limpiar_firma_tecnico">Limpiar</button>   
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Firma jefe de taller') }} *</label>
                            <div class="col-md-6">
                                <canvas style="width: 300px; height: 200px;" class="canvas_cliente paint-canvas" ></canvas>
                                <br>
                                <button class="btn btn-secondary" id="boton_limpiar_firma_cliente">Limpiar</button>   
                            </div>
                        </div>
                        <input type="hidden" id="firma_tecnico" name="firma_tecnico" value="{{ $reparacion->firma_tecnico }}">
                        <input type="hidden" id="firma_cliente" name="firma_cliente" value="{{ $reparacion->firma_cliente }}">
                        <hr>
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
<script type="application/javascript">
    $(document).ready(function() {
        //Para agregar tareas
        var wrapper = $(".tareas");
        var agregar_tarea = $(".agregar_tarea");
        var tareas_guardadas = $('.tareas_guardadas');
        var cant_tareas_input = document.getElementById('cant_tareas');
        var borrar_tarea_guardada = document.getElementById('borrar_tarea_guardada');
        var cant_tareas_a_crear = document.getElementById('cant_tareas_a_crear');        
        var cant_tareas_a_editar = document.getElementById('cant_tareas_a_editar');        
        var cant_tareas_a_eliminar = document.getElementById('cant_tareas_a_eliminar');        
        var ids_tareas_a_eliminar = document.getElementById('ids_tareas_a_eliminar');
        var ids_tareas_a_editar = document.getElementById('ids_tareas_a_editar'); 
    
        var cant_tareas = cant_tareas_input.value;
        $(agregar_tarea).click(function(e) {
            e.preventDefault();
            if(cant_tareas_a_crear.value > 0){
                let borrar_tarea = document.getElementById('borrar_tarea');
                borrar_tarea.remove();
            }
            cant_tareas++;
            cant_tareas_input.value = cant_tareas;
            cant_tareas_a_crear.value++;
            $(wrapper).append(`<div class="mt-2" id="tarea_${cant_tareas}"> <b>Tarea ${cant_tareas}</b> <div class="form-group row"><label class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }} *</label> <div class="col-md-6"> <input type="date" class="form-control" name="fech_tarea${cant_tareas_a_crear.value}" id="fech_tarea${cant_tareas_a_crear.value}"> </div> </div> <div class="form-group row"><label class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} *</label> <div class="col-md-6"> <textarea class="form-control-textarea" name="descr_tarea${cant_tareas_a_crear.value}" id="descr_tarea${cant_tareas_a_crear.value}"></textarea> </div> </div> <div class="form-group row"><label class="col-md-4 col-form-label text-md-right">{{ __('Horas') }} *</label> <div class="col-md-6"> <input type="number" class="form-control" name="hrs_tarea${cant_tareas_a_crear.value}" id="hrs_tarea${cant_tareas_a_crear.value}"> </div> </div> <div class="form-group row mb-0"> <div class="col-md-6 offset-md-4" id="borrar_tarea"> <a href="#" class="borrar_tarea btn btn-danger">Borrar</a> </div> </div></div>`);
        });
    
        $(wrapper).on("click", ".borrar_tarea", function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').parent('div').remove();
            cant_tareas--;
            cant_tareas_input.value = cant_tareas;
            cant_tareas_a_crear.value--;
            if(cant_tareas_a_crear.value > 0){
                let tarea = document.getElementById(`tarea_${cant_tareas}`);
                tarea.insertAdjacentHTML('beforeend', `<div class="form-group row mb-0" id="borrar_tarea"> <div class="col-md-6 offset-md-4"> <a href="#" class="borrar_tarea btn btn-danger">Borrar</a> </div> </div>`);
            }
        })

        $(tareas_guardadas).on("click", ".borrar_tarea_guardada", function(e) {
            e.preventDefault();
            cant_tareas_a_editar.value = cant_tareas_a_editar.value - 1;
            cant_tareas--;
            cant_tareas_input.value = cant_tareas;
            cant_tareas_a_eliminar.value++;
            var id = e.target.getAttribute('value');
            ids_tareas_a_eliminar.value = ids_tareas_a_eliminar.value + id + ",";
            ids_tareas_a_editar.value = ids_tareas_a_editar.value.replace(id + ",", "");
            if(ids_tareas_a_editar.value[0] && ids_tareas_a_editar.value.charAt(0) == ","){
                ids_tareas_a_editar.value = ids_tareas_a_editar.value.substring(1);
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
        const color = "black";
        const strokeSize = 5;

        //Firma tecnico
        const canvas_tecnico = document.querySelector('.canvas_tecnico');
        const boton_limpiar_firma_tecnico = document.getElementById('boton_limpiar_firma_tecnico');
        const firma_tecnico = document.getElementById("firma_tecnico");
        const context_tecnico = canvas_tecnico.getContext("2d");
        var pintando_tecnico = false;

        canvas_tecnico.width = canvas_tecnico.offsetWidth;
        canvas_tecnico.height = canvas_tecnico.offsetHeight;

        var imagen_firma_tecnico = new Image();
        imagen_firma_tecnico.onload = function() {
            context_tecnico.drawImage(imagen_firma_tecnico, 0, 0);
        };
        imagen_firma_tecnico.src = {!! json_encode($reparacion->firma_tecnico) !!};

        function empezarFirmaTecnico(event) {
            pintando_tecnico = true;
            firmarTecnico(event);
        }

        function posicionFinalFirmaTecnico() {
            pintando_tecnico = false;
            context_tecnico.beginPath();
            firma_tecnico.value = canvas_tecnico.toDataURL();
        }

        function firmarTecnico(event) {
            if (!pintando_tecnico) return;

            event.preventDefault();
            context_tecnico.lineWidth = strokeSize;
            context_tecnico.lineCap = "round";  
            rect = canvas_tecnico.getBoundingClientRect()

            if (event.type == 'touchmove') {
                context_tecnico.lineTo(event.touches[0].clientX - rect.x, event.touches[0].clientY - rect.y);
            } else if (event.type == 'mousemove') {
                context_tecnico.lineTo(event.clientX - rect.x, event.clientY - rect.y);
            }

            context_tecnico.stroke();
            context_tecnico.strokeStyle = color;
            context_tecnico.beginPath();

            if (event.type == 'touchmove') {
                context_tecnico.moveTo(event.touches[0].clientX - rect.x, event.touches[0].clientY - rect.y);
            } else if (event.type == 'mousemove') {
                context_tecnico.moveTo(event.clientX - rect.x, event.clientY - rect.y);
            }
        }

        boton_limpiar_firma_tecnico.addEventListener("click", event => {
            event.preventDefault();
            context_tecnico.clearRect(0, 0, canvas_tecnico.width, canvas_tecnico.height);
            firma_tecnico.value = "";
        });

        canvas_tecnico.addEventListener("mousedown", empezarFirmaTecnico);
        canvas_tecnico.addEventListener("touchstart", empezarFirmaTecnico);
        canvas_tecnico.addEventListener("mouseup", posicionFinalFirmaTecnico);
        canvas_tecnico.addEventListener("touchend", posicionFinalFirmaTecnico);
        canvas_tecnico.addEventListener("mousemove", firmarTecnico);
        canvas_tecnico.addEventListener("touchmove", firmarTecnico);

        //Firma cliente
        const canvas_cliente = document.querySelector('.canvas_cliente');
        const boton_limpiar_firma_cliente = document.getElementById('boton_limpiar_firma_cliente');
        const firma_cliente = document.getElementById("firma_cliente");
        const context_cliente = canvas_cliente.getContext("2d");
        var pintando_cliente = false;

        canvas_cliente.width = canvas_cliente.offsetWidth;
        canvas_cliente.height = canvas_cliente.offsetHeight;

        var imagen_firma_cliente = new Image();
        imagen_firma_cliente.onload = function() {
            context_cliente.drawImage(imagen_firma_cliente, 0, 0);
        };
        imagen_firma_cliente.src = {!! json_encode($reparacion->firma_cliente) !!};

        function empezarFirmaCliente(event) {
            pintando_cliente = true;
            firmarCliente(event);
        }

        function posicionFinalFirmaCliente() {
            pintando_cliente = false;
            context_cliente.beginPath();
            firma_cliente.value = canvas_cliente.toDataURL();
        }

        function firmarCliente(event) {
            if (!pintando_cliente) return;

            event.preventDefault();
            context_cliente.lineWidth = strokeSize;
            context_cliente.lineCap = "round";  
            rect = canvas_cliente.getBoundingClientRect()

            if (event.type == 'touchmove') {
                context_cliente.lineTo(event.touches[0].clientX - rect.x, event.touches[0].clientY - rect.y);
            } else if (event.type == 'mousemove') {
                context_cliente.lineTo(event.clientX - rect.x, event.clientY - rect.y);
            }

            context_cliente.stroke();
            context_cliente.strokeStyle = color;
            context_cliente.beginPath();

            if (event.type == 'touchmove') {
                context_cliente.moveTo(event.touches[0].clientX - rect.x, event.touches[0].clientY - rect.y);
            } else if (event.type == 'mousemove') {
                context_cliente.moveTo(event.clientX - rect.x, event.clientY - rect.y);
            }
        }

        boton_limpiar_firma_cliente.addEventListener("click", event => {
            event.preventDefault();
            context_cliente.clearRect(0, 0, canvas_cliente.width, canvas_cliente.height);
            firma_cliente.value = "";
        });

        canvas_cliente.addEventListener("mousedown", empezarFirmaCliente);
        canvas_cliente.addEventListener("touchstart", empezarFirmaCliente);
        canvas_cliente.addEventListener("mouseup", posicionFinalFirmaCliente);
        canvas_cliente.addEventListener("touchend", posicionFinalFirmaCliente);
        canvas_cliente.addEventListener("mousemove", firmarCliente);
        canvas_cliente.addEventListener("touchmove", firmarCliente);
    });
</script>
@endsection
