<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Solicitud Reparacion de Maquinaria - Administrativo de Servicio') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('reparacion.solicitud_reparacion_aprobar') }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('N° CPRES') }} *</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="numero_cpres" id="numero_cpres" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('¿Aprobado?') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control" name="aprobado" id="aprobado" required autofocus> 
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Observaciones') }} *</label>
                            <div class="col-md-6">
                                <textarea class="form-control-textarea" name="observaciones" id="observaciones" rows="4" required autofocus> </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Fecha acordada con el cliente') }} *</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="fecha" id="fecha" required autofocus> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('N° de COR') }}</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="cor" id="cor"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Firma') }}*</label>
                            <div class="col-md-6">
                                <canvas style="width: 300px; height: 200px;" class="js-paint paint-canvas" ></canvas>
                                <br>
                                <button class="btn btn-secondary" id="boton_limpiar_firma">Limpiar</button>   
                            </div>
                        </div>
                        <br>
                        <input type="hidden" id="firma" name="firma" value="">
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

<script>
    window.addEventListener("load", () => {
        const canvas = document.querySelector('.js-paint');
        const boton = document.getElementById('boton_limpiar_firma');
        const firma = document.getElementById("firma");
        const context = canvas.getContext("2d");
        const color = "black";
        const strokeSize = 5;
        var painting = false;

        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;

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
    });

</script>
