<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Solicitud Reparacion de Maquinaria - Servicio Tecnico') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('reparacion.solicitud_reparacion_presupuestar') }}">
                        @method('PUT')
                        @csrf
                       
                        <p class="m-1"><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Trabajo a presupuestar') }} *</label>
                            <div class="col-md-6">
                                <textarea class="form-control-textarea" name="trabajo_a_presupuestar" id="trabajo_a_presupuestar" rows="6" required autofocus> </textarea>
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
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Tecnico 1') }} *</label>
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
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Horas a presupuestar') }}</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="horas_a_presupuestar" id="horas_a_presupuestar" autofocus> 
                            </div>
                        </div>
                        <b>Repuestos a presupuestar</b> 
                        <div class="repuestos">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary agregar_repuesto">Agregar repuesto</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        
                        <input type="hidden" name="cant_repuestos" id="cant_repuestos" value=0>
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
    //Para agregar repuestos
    $(document).ready(function() {
        var wrapper = $(".repuestos");
        var agregar_repuesto = $(".agregar_repuesto");
        var cant_repuestos_input = document.getElementById('cant_repuestos');
    
        var cant_repuestos = 0;
        $(agregar_repuesto).click(function(e) {
            e.preventDefault();
            if(cant_repuestos > 0){
                let borrar_repuesto = document.getElementById('borrar_repuesto');
                borrar_repuesto.remove();
            }
            cant_repuestos++;
            cant_repuestos_input.value = cant_repuestos;
            $(wrapper).append(`<div class="mt-2" id="repuesto_${cant_repuestos}"> <b>Repuesto ${cant_repuestos}</b> <div class="form-group row"> <label class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }} *</label> <div class="col-md-6"> <input type="number" class="form-control" name="cantidad_respuesto${cant_repuestos}" id="cantidad_respuesto${cant_repuestos}" required autofocus> </div> </div> <div class="form-group row"> <label class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }} *</label> <div class="col-md-6"> <input type="text" class="form-control" name="codigo_respuesto${cant_repuestos}" id="codigo_respuesto${cant_repuestos}" required autofocus> </div> </div> <div class="form-group row"> <label class="col-md-4 col-form-label text-md-right">{{ __('Reemplazo') }} *</label> <div class="col-md-6"> <input type="text" class="form-control" name="reemplazo_respuesto${cant_repuestos}" id="reemplazo_respuesto${cant_repuestos}" required autofocus> </div> </div> <div class="form-group row"> <label class="col-md-4 col-form-label text-md-right">{{ __('Disponibilidad') }} *</label> <div class="col-md-6"> <select multiple="multiple" class="form-control multiple-select" name="disponibilidad_respuesto${cant_repuestos}[]" id="disponibilidad_respuesto${cant_repuestos}" required autofocus> <option value="En sucursal">En sucursal</option> <option value="Coronel Moldes">Coronel Moldes</option> <option value="Adelia Maria">Adelia Maria</option> <option value="Villa Mercedes">Villa Mercedes</option> <option value="Vicuña Mackenna">Vicuña Mackenna</option> <option value="Rio Cuarto">Rio Cuarto</option> <option value="Fabrica">Fabrica</option> </select> </div> </div> <div class="form-group row mb-0"> <div class="col-md-6 offset-md-4" id="borrar_repuesto"> <a href="#" class="borrar_repuesto btn btn-danger">Borrar</a> </div> </div></div>`);
            $('.multiple-select').select2();
        });
    
        $(wrapper).on("click", ".borrar_repuesto", function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').parent('div').remove();
            cant_repuestos--;
            cant_repuestos_input.value = cant_repuestos;
            if(cant_repuestos > 0){
                let repuesto = document.getElementById(`repuesto_${cant_repuestos}`);
                repuesto.insertAdjacentHTML('beforeend', `<div class="form-group row mb-0" id="borrar_repuesto"> <div class="col-md-6 offset-md-4"> <a href="#" class="borrar_repuesto btn btn-danger">Borrar</a> </div> </div>`);
            }
        })  
    });

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
</script>

