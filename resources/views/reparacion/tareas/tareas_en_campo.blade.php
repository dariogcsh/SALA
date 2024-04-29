<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tareas en campo') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('reparacion.tareas_de_reparacion_campo_crear') }}">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('N° COR') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cor" id="cor" readonly required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Cliente') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cliente" id="cliente" readonly required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="id_sucursal" id="id_sucursal" readonly required autofocus> 
                                    <option value="">Seleccionar sucursal</option>
                                    @foreach ($sucursals as $sucursal)
                                        <option value="{{$sucursal->id}}">{{ $sucursal->NombSucu }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Tiene garantia?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="garantia" id="garantia" readonly required autofocus> 
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Cuantos tecnicos intervienen en la reparacion?') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="cant_tecnicos" id="cant_tecnicos" required autofocus> 
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico1" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico responsable') }} *</label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico1" id="tecnico1" required autofocus> 
                                    @foreach ($tecnicos as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico2" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 2') }} </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico2" id="tecnico2" required autofocus> 
                                    @foreach ($tecnicos as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>                            
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico3" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 3') }} </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico3" id="tecnico3" required autofocus> 
                                    @foreach ($tecnicos as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>   
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico4" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 4') }} </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico4" id="tecnico4" required autofocus> 
                                    @foreach ($tecnicos as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>   
                            </div>
                        </div>
                        <div class="form-group row" id="tecnico5" hidden>
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 5') }} </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tecnico5" id="tecnico5" required autofocus> 
                                    @foreach ($tecnicos as $tecnico)
                                        <option value="{{$tecnico->id}}">{{ $tecnico->name . " " . $tecnico->last_name }}</option>
                                    @endforeach
                                </select>   
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Numero de Chasis') }} *</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="numero_chasis" id="numero_chasis" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horas de Motor') }} *</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="horas_de_motor" id="horas_de_motor" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha de ingreso') }} *</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horario salida agencia') }} *</label>
                            <div class="col-md-6">
                                <input type="time" class="form-control" name="horario_salida_agencia" id="horario_salida_agencia" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horario llegada campo') }} *</label>
                            <div class="col-md-6">
                                <input type="time" class="form-control" name="horario_llegada_campo" id="horario_llegada_campo" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horario salida campo') }} *</label>
                            <div class="col-md-6">
                                <input type="time" class="form-control" name="horario_salida_campo" id="horario_salida_campo" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horario llegada agencia') }} *</label>
                            <div class="col-md-6">
                                <input type="time" class="form-control" name="horario_llegada_agencia" id="horario_llegada_agencia" required autofocus> 
                            </div>
                        </div>
                        <div class="tareas">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary agregar_tarea">Agregar tarea</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="reclamos">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary agregar_reclamo">Agregar reclamo</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="cant_tareas" id="cant_tareas" value=0>
                        <input type="hidden" name="cant_reclamos" id="cant_reclamos" value=0>
                        <br>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Firma tecnico responsable') }}*</label>
                            <div class="col-md-6">
                                <canvas style="width: 300px; height: 200px;" class="canvas_tecnico paint-canvas" ></canvas>
                                <br>
                                <button class="btn btn-secondary" id="boton_limpiar_firma_tecnico">Limpiar</button>   
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Firma cliente') }}*</label>
                            <div class="col-md-6">
                                <canvas style="width: 300px; height: 200px;" class="canvas_cliente paint-canvas" ></canvas>
                                <br>
                                <button class="btn btn-secondary" id="boton_limpiar_firma_cliente">Limpiar</button>   
                            </div>
                        </div>
                        <input type="hidden" id="firma_tecnico" name="firma_tecnico" value="">
                        <input type="hidden" id="firma_cliente" name="firma_cliente" value="">
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="crear" type="submit" class="btn btn-success">Enviar</button>
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
    var tareas = $(".tareas");
    var agregar_tarea = $(".agregar_tarea");
    var cant_tareas_input = document.getElementById('cant_tareas');

    var cant_tareas = 0;
    $(agregar_tarea).click(function(e) {
        e.preventDefault();
        if(cant_tareas > 0){
            let borrar_tarea = document.getElementById('borrar_tarea');
            borrar_tarea.remove();
        }
        cant_tareas++;
        cant_tareas_input.value = cant_tareas;
        $(tareas).append(`<div class="mt-2" id="tarea_${cant_tareas}"> <b>Tarea ${cant_tareas}</b> <div class="form-group row"><label class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }} *</label> <div class="col-md-6"> <input type="date" class="form-control" name="fecha_tarea${cant_tareas}" id="fecha_tarea${cant_tareas}"> </div> </div> <div class="form-group row"><label class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} *</label> <div class="col-md-6"> <textarea class="form-control-textarea" name="description_tarea${cant_tareas}" id="description_tarea${cant_tareas}" rows="4"></textarea> </div> </div> <div class="form-group row"><label class="col-md-4 col-form-label text-md-right">{{ __('Horas') }} *</label> <div class="col-md-6"> <input type="number" class="form-control" name="horas_tarea${cant_tareas}" id="horas_tarea${cant_tareas}"> </div> </div> <div class="form-group row mb-0"> <div class="col-md-6 offset-md-4" id="borrar_tarea"> <a href="#" class="borrar_tarea btn btn-danger">Borrar</a> </div> </div></div>`);
    });

    $(tareas).on("click", ".borrar_tarea", function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
        cant_tareas--;
        cant_tareas_input.value = cant_tareas;
        if(cant_tareas > 0){
            let tarea = document.getElementById(`tarea_${cant_tareas}`);
            tarea.insertAdjacentHTML('beforeend', `<div class="form-group row mb-0" id="borrar_tarea"> <div class="col-md-6 offset-md-4"> <a href="#" class="borrar_tarea btn btn-danger">Borrar</a> </div> </div>`);
        }
    })

    //Para agregar reclamos
    var reclamos = $(".reclamos");
    var agregar_reclamo = $(".agregar_reclamo");
    var cant_reclamos_input = document.getElementById('cant_reclamos');

    var cant_reclamos = 0;
    $(agregar_reclamo).click(function(e) {
        e.preventDefault();
        if(cant_reclamos > 0){
            let borrar_reclamo = document.getElementById('borrar_reclamo');
            borrar_reclamo.remove();
        }
        cant_reclamos++;
        cant_reclamos_input.value = cant_reclamos;
        $(reclamos).append(`<div class="mt-2" id="reclamo_${cant_reclamos}"> <b>Reclamo ${cant_reclamos}</b> <div class="form-group row"><label class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }} *</label> <div class="col-md-6"> <input type="date" class="form-control" name="fecha_reclamo${cant_reclamos}" id="fecha_reclamo${cant_reclamos}"> </div> </div> <div class="form-group row"><label class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} *</label> <div class="col-md-6"> <textarea class="form-control-textarea" name="description_reclamo${cant_reclamos}" id="description_reclamo${cant_reclamos}" rows="4"></textarea> </div> </div> <div class="form-group row mb-0"> <div class="col-md-6 offset-md-4" id="borrar_reclamo"> <a href="#" class="borrar_reclamo btn btn-danger">Borrar</a> </div> </div></div>`);
    });

    $(reclamos).on("click", ".borrar_reclamo", function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
        cant_reclamos--;
        cant_reclamos_input.value = cant_reclamos;
        if(cant_reclamos > 0){
            let reclamo = document.getElementById(`reclamo_${cant_reclamos}`);
            reclamo.insertAdjacentHTML('beforeend', `<div class="form-group row mb-0" id="borrar_reclamo"> <div class="col-md-6 offset-md-4"> <a href="#" class="borrar_reclamo btn btn-danger">Borrar</a> </div> </div>`);
        }
    })

    //Para manejar la cantidad de tecnicos
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

