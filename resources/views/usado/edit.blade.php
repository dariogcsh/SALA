@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar usado') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/usado/'.$usado->id) }}" id="formUpdate"> 
                        @csrf
                        @method('patch')
                        @isset($paso)
                            @if($paso == 21)
                                @include('usado.form_2_cosechadora', ['modo'=>'modificar'])
                            @elseif($paso == 22)
                                @include('usado.form_2_tractor', ['modo'=>'modificar'])
                            @elseif($paso == 23)
                                @include('usado.form_2_pulverizadora', ['modo'=>'modificar'])
                            @elseif($paso == 24)
                                @include('usado.form_2_sembradora', ['modo'=>'modificar'])
                            @elseif($paso == 35)
                                @include('usado.form_2_plataforma_maiz', ['modo'=>'modificar'])
                            @elseif($paso == 36)
                                @include('usado.form_2_plataforma_soja', ['modo'=>'modificar'])
                            @elseif($paso == 37)
                                @include('usado.form_2_rotoenfardadora', ['modo'=>'modificar'])
                            @elseif($paso == 31)
                                @include('usado.form_3_cosechadora_tractor', ['modo'=>'modificar'])
                            @elseif($paso == 32)
                                @include('usado.form_3_sembradora', ['modo'=>'modificar'])
                            @elseif($paso == 33)
                                @include('usado.form_3_pulverizadora', ['modo'=>'modificar'])
                            @elseif($paso == 5)
                                @include('usado.form_5', ['modo'=>'modificar'])
                            @endif
                        <input type="text" hidden value="{{ $paso }}" id="paso" name="paso">
                        @else
                            @include('usado.form', ['modo'=>'modificar'])
                            <input type="text" hidden value="1" id="paso" name="paso">
                        @endisset
                    </form>
                    @isset($paso)
                         @if($paso == 4)
                            @php $id_usado = $usado->id; @endphp
                            @include('usado.form_4_imagenes', ['modo'=>'modificar'])
                        @endif
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
 $( document ).ready(function() {
     //ejecutar funciones al hacer click en los botones "Siguiente"
     $( "#btn-paso1" ).click(function() {
        var tipo = $('#tipo').val();
        var marca = $('#marca').val();
        var modelo = $('#modelo').val();
        var ano = $('#ano').val();
        var nserie = $('#nserie').val();
        var patente = $('#patente').val();
        var _token = $('input[name="_token"]').val();

        // Controlar que esten los campos obligatorios completos antes de proceder
        if (tipo == ''){
            $('#tipoError').text('Debe seleccionar un tipo de máquina');
            document.getElementById("tipo").style.borderColor = "red";
            
            return false;
        } else {
            $('#tipoError').text('');
            document.getElementById("tipo").style.borderColor = "grey";
        }
        if (marca == ''){
            $('#marcaError').text('Debe seleccionar una marca');
            document.getElementById("marca").style.borderColor = "red";
           
            return false;
        } else {
            $('#marcaError').text('');
            document.getElementById("marca").style.borderColor = "grey";
        }
        if (modelo == ''){
            $('#modeloError').text('Debe ingresar el modelo');
            document.getElementById("modelo").style.borderColor = "red";
            
            return false;
        } else {
            $('#modeloError').text('');
            document.getElementById("modelo").style.borderColor = "grey";
        }
        if (ano == ''){
            $('#anoError').text('Debe ingresar el año');
            document.getElementById("ano").style.borderColor = "red";
            
            return false;
        } else {
            $('#anoError').text('');
            document.getElementById("ano").style.borderColor = "grey";
        }

        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
     });

      //ejecutar funciones al hacer click en los botones "Siguiente"
    $( "#btn-paso2-cosechadora" ).click(function() {
        const boton = document.getElementById("#btn-paso1");
        boton.setAttribute('disabled', "true");
        var traccion = $('#traccion').val();
        var rodado = $('#rodado').val();
        var horasm = $('#horasm').val();
        var horast = $('#horast').val();
        var plataforma = $('#plataforma').val();
        var desparramador = $('#desparramador').val();
        var _token = $('input[name="_token"]').val();

        // Controlar que esten los campos obligatorios completos antes de proceder
        if (traccion == ''){
            $('#traccionError').text('Debe seleccionar la tracción');
            document.getElementById("traccion").style.borderColor = "red";
            boton.setAttribute('disabled', "false");
            return false;
        } else {
            $('#traccionError').text('');
            document.getElementById("traccion").style.borderColor = "grey";
        }
        if (rodado == ''){
            $('#rodadoError').text('Debe seleccionar el rodado');
            document.getElementById("rodado").style.borderColor = "red";
            boton.setAttribute('disabled', "false");
            return false;
        } else {
            $('#rodadoError').text('');
            document.getElementById("rodado").style.borderColor = "grey";
        }
        if (horasm == ''){
            $('#horasmError').text('Debe ingresar las horas de motor');
            document.getElementById("horasm").style.borderColor = "red";
            boton.setAttribute('disabled', "false");
            return false;
        } else {
            $('#horasmError').text('');
            document.getElementById("horasm").style.borderColor = "grey";
        }
        if (horast == ''){
            $('#horastError').text('Debe ingresar las horas de trilla');
            document.getElementById("horast").style.borderColor = "red";
            boton.setAttribute('disabled', "false");
            return false;
        } else {
            $('#horastError').text('');
            document.getElementById("horast").style.borderColor = "grey";
        }
        if (plataforma == ''){
            $('#plataformaError').text('Debe ingresar el modelo de plataforma');
            document.getElementById("plataforma").style.borderColor = "red";
            boton.setAttribute('disabled', "false");
            return false;
        } else {
            $('#plataformaError').text('');
            document.getElementById("plataforma").style.borderColor = "grey";
        }
        if (desparramador == ''){
            $('#desparramadorError').text('Debe ingresar el tipo de desparramador');
            document.getElementById("desparramador").style.borderColor = "red";
            boton.setAttribute('disabled', "false");
            return false;
        } else {
            $('#desparramadorError').text('');
            document.getElementById("desparramador").style.borderColor = "grey";
        }
        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

         //ejecutar funciones al hacer click en los botones "Siguiente"
    $( "#btn-paso2-plataforma_maiz" ).click(function() {
        var id_usado = $('#id_usado').val();
        var surcos = $('#surcos').val();
        var espaciamiento = $('#espaciamiento').val();
        var _token = $('input[name="_token"]').val();

        // Controlar que esten los campos obligatorios completos antes de proceder
        if (surcos == ''){
            $('#surcosError').text('Debe ingresar la cantidad de hileras');
            document.getElementById("surcos").style.borderColor = "red";
            return false;
        } else {
            $('#surcosError').text('');
            document.getElementById("surcos").style.borderColor = "grey";
        }
        if (espaciamiento == ''){
            $('#espaciamientoError').text('Debe ingresar el espaciamiento entre hileras');
            document.getElementById("espaciamiento").style.borderColor = "red";
            return false;
        } else {
            $('#espaciamientoError').text('');
            document.getElementById("espaciamiento").style.borderColor = "grey";
        }

        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

     //ejecutar funciones al hacer click en los botones "Siguiente"
     $( "#btn-paso2-plataforma_soja" ).click(function() {
        var id_usado = $('#id_usado').val();
        var ancho_plataforma = $('#ancho_plataforma').val();
        var _token = $('input[name="_token"]').val();

        // Controlar que esten los campos obligatorios completos antes de proceder
        if (ancho_plataforma == ''){
            $('#ancho_plataformaError').text('Debe ingresar el ancho de la plataforma');
            document.getElementById("ancho_plataforma").style.borderColor = "red";
            return false;
        } else {
            $('#ancho_plataformaError').text('');
            document.getElementById("ancho_plataforma").style.borderColor = "grey";
        }

        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    //ejecutar funciones al hacer click en los botones "Siguiente"
    $( "#btn-paso2-rotoenfardadora" ).click(function() {
        var id_usado = $('#id_usado').val();
        var cantidad_rollos = $('#cantidad_rollos').val();
        var monitor_roto = 'NO';
        var cutter = 'NO';
        var configuracion_roto = $('#configuracion_roto').val();
        var _token = $('input[name="_token"]').val();

         //Verificacion de campos tipo Switch
         if (document.getElementById('monitor_roto').checked){
            monitor_roto = 'SI';
        }
        if (document.getElementById('cutter').checked){
            cutter = 'SI';
        }

        // Controlar que esten los campos obligatorios completos antes de proceder
        if (cantidad_rollos == ''){
            $('#ancho_plataformaError').text('Debe ingresar el ancho de la plataforma');
            document.getElementById("cantidad_rollos").style.borderColor = "red";
            return false;
        } else {
            $('#ancho_plataformaError').text('');
            document.getElementById("cantidad_rollos").style.borderColor = "grey";
        }


        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    //ejecutar funciones al hacer click en los botones "Siguiente"
    $( "#btn-paso2-tractor" ).click(function() {
        var traccion = $('#traccion').val();
        var rodado = $('#rodado').val();
        var horasm = $('#horasm').val();
        var cabina = 'NO';
        var hp = $('#hp').val();
        var transmision = $('#transmision').val();
        var nseriemotor = $('#nseriemotor').val();
        var tomafuerza = 'NO';
        var bombah = $('#bombah').val();
        var _token = $('input[name="_token"]').val();

        //Verificacion de campos tipo Switch
        if (document.getElementById('cabina').checked){
            cabina = 'SI';
        }
        if (document.getElementById('tomafuerza').checked){
            tomafuerza = 'SI';
        }

        // Controlar que esten los campos obligatorios completos antes de proceder
        if (traccion == ''){
            $('#traccionError').text('Debe seleccionar la tracción');
            document.getElementById("traccion").style.borderColor = "red";
            return false;
        } else {
            $('#traccionError').text('');
            document.getElementById("traccion").style.borderColor = "grey";
        }
        if (rodado == ''){
            $('#rodadoError').text('Debe seleccionar el rodado');
            document.getElementById("rodado").style.borderColor = "red";
            return false;
        } else {
            $('#rodadoError').text('');
            document.getElementById("rodado").style.borderColor = "grey";
        }
        if (horasm == ''){
            $('#horasmError').text('Debe ingresar las horas de motor');
            document.getElementById("horasm").style.borderColor = "red";
            return false;
        } else {
            $('#horasmError').text('');
            document.getElementById("horasm").style.borderColor = "grey";
        }
        if (hp == ''){
            $('#hpError').text('Debe ingresar las horas de motor');
            document.getElementById("hp").style.borderColor = "red";
            return false;
        } else {
            $('#hpError').text('');
            document.getElementById("hp").style.borderColor = "grey";
        }
        if (transmision == ''){
            $('#transmisionError').text('Debe ingresar las horas de motor');
            document.getElementById("transmision").style.borderColor = "red";
            return false;
        } else {
            $('#transmisionError').text('');
            document.getElementById("transmision").style.borderColor = "grey";
        }
        
        if (bombah == ''){
            $('#bombahError').text('Debe ingresar las horas de motor');
            document.getElementById("bombah").style.borderColor = "red";
            return false;
        } else {
            $('#bombahError').text('');
            document.getElementById("bombah").style.borderColor = "grey";
        }
        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    $( "#btn-paso2-sembradora" ).click(function() {
        var categoria = $('#categoria').val();
        var surcos = $('#surcos').val();
        var distancia = $('#distancia').val();
        var monitor = $('#monitor').val();
        var dosificacion = $('#dosificacion').val();
        var fertilizacion = $('#fertilizacion').val();
        var tolva = $('#tolva').val();
        var fertilizante = $('#fertilizante').val();
        var reqhidraulico = $('#reqhidraulico').val();
        var _token = $('input[name="_token"]').val();

        // Controlar que esten los campos obligatorios completos antes de proceder
        if (categoria == ''){
            $('#categoriaError').text('Debe ingresar la categoria');
            document.getElementById("categoria").style.borderColor = "red";
            return false;
        } else {
            $('#categoriaError').text('');
            document.getElementById("categoria").style.borderColor = "grey";
        }
        if (surcos == ''){
            $('#surcosError').text('Debe ingresar la cantidad de surcos');
            document.getElementById("surcos").style.borderColor = "red";
            return false;
        } else {
            $('#surcosError').text('');
            document.getElementById("surcos").style.borderColor = "grey";
        }
        if (distancia == ''){
            $('#distanciaError').text('Debe ingresar la distancia entre surcos');
            document.getElementById("distancia").style.borderColor = "red";
            return false;
        } else {
            $('#distanciaError').text('');
            document.getElementById("distancia").style.borderColor = "grey";
        }
        if (monitor == ''){
            $('#monitorError').text('Debe ingresar datos del monitor');
            document.getElementById("monitor").style.borderColor = "red";
            return false;
        } else {
            $('#monitorError').text('');
            document.getElementById("monitor").style.borderColor = "grey";
        }
        if (dosificacion == ''){
            $('#dosificacionError').text('Debe ingresar datos de dosificacion');
            document.getElementById("dosificacion").style.borderColor = "red";
            return false;
        } else {
            $('#dosificacionError').text('');
            document.getElementById("dosificacion").style.borderColor = "grey";
        }
        if (fertilizacion == ''){
            $('#fertilizacionError').text('Debe ingresar datos de fertilizacion');
            document.getElementById("fertilizacion").style.borderColor = "red";
            return false;
        } else {
            $('#fertilizacionError').text('');
            document.getElementById("fertilizacion").style.borderColor = "grey";
        }
        if (tolva == ''){
            $('#tolvaError').text('Debe ingresar datos de capacidad de tolva');
            document.getElementById("tolva").style.borderColor = "red";
            return false;
        } else {
            $('#tolvaError').text('');
            document.getElementById("tolva").style.borderColor = "grey";
        }
        if (fertilizante == ''){
            $('#fertilizanteError').text('Debe ingresar datos de capacidad de fertilizante');
            document.getElementById("fertilizante").style.borderColor = "red";
            return false;
        } else {
            $('#fertilizanteError').text('');
            document.getElementById("fertilizante").style.borderColor = "grey";
        }
        if (reqhidraulico == ''){
            $('#reqhidraulicoError').text('Debe ingresar datos del requerimiento hidráulico');
            document.getElementById("reqhidraulico").style.borderColor = "red";
            return false;
        } else {
            $('#reqhidraulicoError').text('');
            document.getElementById("reqhidraulico").style.borderColor = "grey";
        }
        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    $( "#btn-paso2-pulverizadora" ).click(function() {
        var horasm = $('#horasm').val();
        var botalon = $('#botalon').val();
        var tanque = $('#tanque').val();
        var picos = $('#picos').val();
        var corte = 'NO';
        var _token = $('input[name="_token"]').val();

        //Verificacion de campos tipo Switch
        if (document.getElementById('corte').checked){
            corte = 'SI';
        }

        if (horasm == ''){
            $('#horasmError').text('Debe ingresar las horas de motor');
            document.getElementById("horasm").style.borderColor = "red";
            return false;
        } else {
            $('#horasmError').text('');
            document.getElementById("horasm").style.borderColor = "grey";
        }
        if (botalon == ''){
            $('#botalonError').text('Debe ingresar datos de botalon');
            document.getElementById("botalon").style.borderColor = "red";
            return false;
        } else {
            $('#botalonError').text('');
            document.getElementById("botalon").style.borderColor = "grey";
        }
        if (tanque == ''){
            $('#tanqueError').text('Debe ingresar la capacidad del tanque');
            document.getElementById("tanque").style.borderColor = "red";
            return false;
        } else {
            $('#tanqueError').text('');
            document.getElementById("tanque").style.borderColor = "grey";
        }
        if (picos == ''){
            $('#picosError').text('Debe ingresar datos de los picos');
            document.getElementById("picos").style.borderColor = "red";
            return false;
        } else {
            $('#picosError').text('');
            document.getElementById("picos").style.borderColor = "grey";
        }
        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    $( "#btn-paso3-cosechadora-tractor" ).click(function() {
        var nrodado = $('#nrodado').val();
        var nrodadotras = $('#nrodadotras').val();
        var rodadoest = $('#rodadoest').val();
        var rodadoesttras = $('#rodadoesttras').val();
        var agprecision = 'NO';
        var _token = $('input[name="_token"]').val();

        //Verificacion de campos tipo Switch
        if (document.getElementById('agprecision').checked){
            agprecision = 'SI';
        }

        if (nrodado == ''){
            $('#nrodadoError').text('Debe ingresar el numero de rodado');
            document.getElementById("nrodado").style.borderColor = "red";
            return false;
        } else {
            $('#nrodadoError').text('');
            document.getElementById("nrodado").style.borderColor = "grey";
        }
        if (nrodadotras == ''){
            $('#nrodadotrasError').text('Debe ingresar el numero de rodado');
            document.getElementById("nrodadotras").style.borderColor = "red";
            return false;
        } else {
            $('#nrodadotrasError').text('');
            document.getElementById("nrodadotras").style.borderColor = "grey";
        }
        if ((rodadoest == '') || (rodadoest >= 101) || (rodadoest <= 0)){
            $('#rodadoestError').text('Debe ingresar el estado del rodado entre 1 y 100');
            document.getElementById("rodadoest").style.borderColor = "red";
            return false;
        } else {
            $('#rodadoestError').text('');
            document.getElementById("rodadoest").style.borderColor = "grey";
        }
        if ((rodadoesttras == '') || (rodadoesttras >= 101) || (rodadoesttras <= 0)){
            $('#rodadoesttrasError').text('Debe ingresar el estado del rodado entre 1 y 100');
            document.getElementById("rodadoesttras").style.borderColor = "red";
            return false;
        } else {
            $('#rodadoesttrasError').text('');
            document.getElementById("rodadoesttras").style.borderColor = "grey";
        }
        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    $( "#btn-paso3-pulverizadora" ).click(function() {
        var nrodado = $('#nrodado').val();
        var rodadoest = $('#rodadoest').val();
        var rodadoesttras = $('#rodadoesttras').val();
        var agprecision = 'NO';
        var _token = $('input[name="_token"]').val();

        //Verificacion de campos tipo Switch
        if (document.getElementById('agprecision').checked){
            agprecision = 'SI';
        }
        if (nrodado == ''){
            $('#nrodadoError').text('Debe ingresar el numero de rodado');
            document.getElementById("nrodado").style.borderColor = "red";
            return false;
        } else {
            $('#nrodadoError').text('');
            document.getElementById("nrodado").style.borderColor = "grey";
        }
        if ((rodadoest == '') || (rodadoest >= 101) || (rodadoest <= 0)){
            $('#rodadoestError').text('Debe ingresar el estado del rodado entre 1 y 100');
            document.getElementById("rodadoest").style.borderColor = "red";
            return false;
        } else {
            $('#rodadoestError').text('');
            document.getElementById("rodadoest").style.borderColor = "grey";
        }
        if ((rodadoesttras == '') || (rodadoesttras >= 101) || (rodadoesttras <= 0)){
            $('#rodadoesttrasError').text('Debe ingresar el estado del rodado entre 1 y 100');
            document.getElementById("rodadoesttras").style.borderColor = "red";
            return false;
        } else {
            $('#rodadoestError').text('');
            document.getElementById("rodadoesttras").style.borderColor = "grey";
        }
        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    $( "#btn-paso3-sembradora" ).click(function() {
        var nrodado = $('#nrodado').val();
        var rodadoest = $('#rodadoest').val();
        var _token = $('input[name="_token"]').val();
        if (nrodado == ''){
            $('#nrodadoError').text('Debe ingresar el numero de rodado');
            document.getElementById("nrodado").style.borderColor = "red";
            return false;
        } else {
            $('#nrodadoError').text('');
            document.getElementById("nrodado").style.borderColor = "grey";
        }
        if ((rodadoest == '') || (rodadoest >= 101) || (rodadoest <= 0)){
            $('#rodadoestError').text('Debe ingresar el estado del rodado entre 1 y 100');
            document.getElementById("rodadoest").style.borderColor = "red";
            return false;
        } else {
            $('#rodadoestError').text('');
            document.getElementById("rodadoest").style.borderColor = "grey";
        }
        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    $( "#btn-paso4" ).click(function() {
        this.disabled = true;
        $("#submit").click();
        this.disabled = false;
    });

    $( "#btn-paso5" ).click(function() {
        var precio = $('#precio').val();
        var ingreso = $('#ingreso').val();
        var id_sucursal = $('#id_sucursal').val();
        var comentarios = $('#comentarios').val();
        var excliente = $('#excliente').val();
        var id_vendedor = $('#id_vendedor').val();
        var _token = $('input[name="_token"]').val();

        if (ingreso == ''){
            $('#ingresoError').text('Debe seleccionar una fecha de posible ingreso');
            document.getElementById("ingreso").style.borderColor = "red";
            return false;
        } else {
            $('#ingresoError').text('');
            document.getElementById("ingreso").style.borderColor = "grey";
        }
        if (id_sucursal == ''){
            $('#id_sucursalError').text('Debe seleccionar la sucursal donde se encuentra la maquinaria');
            document.getElementById("id_sucursal").style.borderColor = "red";
            return false;
        } else {
            $('#id_sucursalError').text('');
            document.getElementById("id_sucursal").style.borderColor = "grey";
        }
        if (excliente == ''){
            $('#exclienteError').text('Debe ingresar el nombre y apellido del último dueño de la maquina');
            document.getElementById("excliente").style.borderColor = "red";
            return false;
        } else {
            $('#exclienteError').text('');
            document.getElementById("excliente").style.borderColor = "grey";
        }
        if (id_vendedor == ''){
            $('#id_vendedorError').text('Debe seleccionar el vendedor que recibe la maquinaria');
            document.getElementById("id_vendedor").style.borderColor = "red";
            return false;
        } else {
            $('#id_vendedorError').text('');
            document.getElementById("id_vendedor").style.borderColor = "grey";
        }
        this.disabled = true;
        $('formUpdate').submit();
        this.disabled = false;
    });

    // Previsualizar imagen a subir
    document.getElementById("img1").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir1").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    // Previsualizar imagen a subir
    document.getElementById("img2").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir2").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    // Previsualizar imagen a subir
    document.getElementById("img3").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir3").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    // Previsualizar imagen a subir
    document.getElementById("img4").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir4").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    // Previsualizar imagen a subir
    document.getElementById("img5").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir5").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    // Previsualizar imagen a subir
    document.getElementById("img6").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir6").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    // Previsualizar imagen a subir
    document.getElementById("img7").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir7").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    // Previsualizar imagen a subir
    document.getElementById("img8").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir8").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };
});
</script>
@endsection