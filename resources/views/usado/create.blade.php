@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ingresar usado') }}</div>

                <div class="card-body">
                @csrf
                @isset($paso)
                    <input type="text" hidden value="{{ $id_usado }}" id="id_usado">
                    @if($paso == 21)
                        @include('usado.form_2_cosechadora', ['modo'=>'crear'])
                    @elseif($paso == 22)
                        @include('usado.form_2_tractor', ['modo'=>'crear'])
                    @elseif($paso == 23)
                        @include('usado.form_2_pulverizadora', ['modo'=>'crear'])
                    @elseif($paso == 24)
                        @include('usado.form_2_sembradora', ['modo'=>'crear'])
                    @elseif($paso == 35)
                        @include('usado.form_2_plataforma_maiz', ['modo'=>'crear'])
                    @elseif($paso == 36)
                        @include('usado.form_2_plataforma_soja', ['modo'=>'crear'])
                    @elseif($paso == 37)
                        @include('usado.form_2_rotoenfardadora', ['modo'=>'crear'])
                    @elseif($paso == 31)
                        @include('usado.form_3_cosechadora_tractor', ['modo'=>'crear'])
                    @elseif($paso == 32)
                        @include('usado.form_3_sembradora', ['modo'=>'crear'])
                    @elseif($paso == 33)
                        @include('usado.form_3_pulverizadora', ['modo'=>'crear'])
                    @elseif($paso == 4)
                        @include('usado.form_4_imagenes', ['modo'=>'crear'])
                    @elseif($paso == 5)
                        @include('usado.form_5', ['modo'=>'crear'])
                    @endif
                @else
                    @include('usado.form', ['modo'=>'crear'])
                    <input type="text" hidden value="" id="paso">
                @endisset

                @isset($formimage)
                    <input type="text" hidden value="{{ $formimage }}" id="pasosiguiente">
                @else
                    <input type="text" hidden value="" id="pasosiguiente">
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

        $.ajax({
            url:"{{ route('usado.pasoUno') }}",
            method:"POST",
            data:{_token:_token, tipo:tipo, marca:marca, modelo:modelo, ano:ano, nserie:nserie, patente:patente},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
                this.disabled = false;
            },
            success:function(data)
            {
                //window.location = "/usado/createUpdate/" + data;
                window.location = data.url
                
            }
        })
    });

    //ejecutar funciones al hacer click en los botones "Siguiente"
    $( "#btn-paso2-cosechadora" ).click(function() {
        var id_usado = $('#id_usado').val();
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
        if (horast == ''){
            $('#horastError').text('Debe ingresar las horas de trilla');
            document.getElementById("horast").style.borderColor = "red";
            return false;
        } else {
            $('#horastError').text('');
            document.getElementById("horast").style.borderColor = "grey";
        }
        if (plataforma == ''){
            $('#plataformaError').text('Debe ingresar el modelo de plataforma');
            document.getElementById("plataforma").style.borderColor = "red";
            return false;
        } else {
            $('#plataformaError').text('');
            document.getElementById("plataforma").style.borderColor = "grey";
        }
        if (desparramador == ''){
            $('#desparramadorError').text('Debe ingresar el tipo de desparramador');
            document.getElementById("desparramador").style.borderColor = "red";
            return false;
        } else {
            $('#desparramadorError').text('');
            document.getElementById("desparramador").style.borderColor = "grey";
        }

        this.disabled = true;
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, traccion:traccion, rodado:rodado, horasm:horasm, horast:horast, plataforma:plataforma, 
                    desparramador:desparramador, id_usado:id_usado},
            success:function(data)
            {
                window.location = data.url
            },
        })
    });
    
    //ejecutar funciones al hacer click en los botones "Siguiente"
    $( "#btn-paso2-tractor" ).click(function() {
        var id_usado = $('#id_usado').val();
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

        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, traccion:traccion, rodado:rodado, horasm:horasm, cabina:cabina, hp:hp, 
                    transmision:transmision, nseriemotor:nseriemotor, tomafuerza:tomafuerza, bombah:bombah, 
                    id_usado:id_usado},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
                this.disabled = false;
            },
            success:function(data)
            {
                window.location = data.url
            }
        })
   
    });

    $( "#btn-paso2-sembradora" ).click(function() {
        var id_usado = $('#id_usado').val();
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
        
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, categoria:categoria, surcos:surcos, distancia:distancia, monitor:monitor, dosificacion:dosificacion, 
                    fertilizacion:fertilizacion, tolva:tolva, fertilizante:fertilizante, reqhidraulico:reqhidraulico, 
                    id_usado:id_usado},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
                this.disabled = false;
            },
            success:function(data)
            {
                window.location = data.url
            }
        })
    });

    $( "#btn-paso2-pulverizadora" ).click(function() {
        var id_usado = $('#id_usado').val();
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
        
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, horasm:horasm, botalon:botalon, tanque:tanque, picos:picos, corte:corte, id_usado:id_usado},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
                this.disabled = false;
            },
            success:function(data)
            {
                window.location = data.url
            }
        })
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
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, surcos:surcos, espaciamiento:espaciamiento, id_usado:id_usado},
            success:function(data)
            {
                window.location = data.url
            },
        })
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
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, ancho_plataforma:ancho_plataforma, id_usado:id_usado},
            success:function(data)
            {
                window.location = data.url
            },
        })
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
            $('#cantidad_rollosError').text('Debe ingresar el ancho de la plataforma');
            document.getElementById("cantidad_rollos").style.borderColor = "red";
            return false;
        } else {
            $('#cantidad_rollosError').text('');
            document.getElementById("cantidad_rollos").style.borderColor = "grey";
        }

        // Controlar que esten los campos obligatorios completos antes de proceder
        if (configuracion_roto == ''){
            $('#configuracion_rotoError').text('Debe ingresar el ancho de la plataforma');
            document.getElementById("configuracion_roto").style.borderColor = "red";
            return false;
        } else {
            $('#configuracion_rotoError').text('');
            document.getElementById("configuracion_roto").style.borderColor = "grey";
        }

        this.disabled = true;
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, cantidad_rollos:cantidad_rollos, id_usado:id_usado, monitor_roto:monitor_roto
                , configuracion_roto:configuracion_roto, cutter:cutter},
            success:function(data)
            {
                window.location = data.url
            },
        })
    });
    
    $( "#btn-paso3-cosechadora-tractor" ).click(function() {
        var id_usado = $('#id_usado').val();
        var nrodado = $('#nrodado').val();
        var nrodadotras = $('#nrodadotras').val();
        var rodadoest = $('#rodadoest').val();
        var rodadoesttras = $('#rodadoesttras').val();
        var id_antena = $('#id_antena').val();
        var id_conectividad = $('#id_conectividad').val();
        var activacion_antena = $('#activacion_antena').val();
        var id_pantalla = $('#id_pantalla').val();
        var activacion_pantalla = $('#activacion_pantalla').val();
        var agprecision = 'NO';
        var camaras = 'NO';
        var prodrive = 'NO';
        var _token = $('input[name="_token"]').val();
        
        //Verificacion de campos tipo Switch
        if (document.getElementById('agprecision').checked){
            agprecision = 'SI';
        }

        if (document.getElementById('camaras').checked){
            camaras = 'SI';
        }
       
        if (document.getElementById('prodrive').checked){
            prodrive = 'SI';
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

        this.disabled = true;
        
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, nrodado:nrodado, nrodadotras:nrodadotras, rodadoest:rodadoest, rodadoesttras:rodadoesttras, 
                    agprecision:agprecision, id_usado:id_usado, id_antena:id_antena, activacion_antena:activacion_antena,
                    id_pantalla:id_pantalla, activacion_pantalla:activacion_pantalla, camaras:camaras, prodrive:prodrive,
                    id_conectividad:id_conectividad},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
                this.disabled = false;
            },
            success:function(data)
            {
                window.location = data.url
            }
        })
    });

    $( "#btn-paso3-pulverizadora" ).click(function() {
        var id_usado = $('#id_usado').val();
        var nrodado = $('#nrodado').val();
        var rodadoest = $('#rodadoest').val();
        var rodadoesttras = $('#rodadoesttras').val();
        var id_antena = $('#id_antena').val();
        var id_conectividad = $('#id_conectividad').val();
        var activacion_antena = $('#activacion_antena').val();
        var id_pantalla = $('#id_pantalla').val();
        var activacion_pantalla = $('#activacion_pantalla').val();
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

        this.disabled = true;
        
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, nrodado:nrodado, rodadoest:rodadoest, rodadoesttras:rodadoesttras, agprecision:agprecision, 
                id_usado:id_usado, id_antena:id_antena, activacion_antena:activacion_antena,
                    id_pantalla:id_pantalla, activacion_pantalla:activacion_pantalla, id_conectividad:id_conectividad},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
                this.disabled = false;
            },
            success:function(data)
            {
                window.location = data.url
            }
        })
    });

    $( "#btn-paso3-sembradora" ).click(function() {
        var id_usado = $('#id_usado').val();
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

        this.disabled = true;
        
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, nrodado:nrodado, rodadoest:rodadoest, id_usado:id_usado},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
                this.disabled = false;
            },
            success:function(data)
            {
                window.location = data.url
            }
        })
    });

    $( "#btn-paso4" ).click(function() {
        var img1 = $('#img1').val();
        var img2 = $('#img2').val();
        var img3 = $('#img3').val();

        
        // Valido que se hayan seleccionado las 5 imagenes obligatorias
        if (img1 == ''){
            $('#img1Error').text('Debe cargar una imagen');
            document.getElementById("img1").style.borderColor = "red";
            return false;
        } else {
            $('#img1Error').text('');
            document.getElementById("img1").style.borderColor = "grey";
        }
        if (img2 == ''){
            $('#img2Error').text('Debe cargar una imagen');
            document.getElementById("img2").style.borderColor = "red";
            return false;
        } else {
            $('#img2Error').text('');
            document.getElementById("img2").style.borderColor = "grey";
        }
        if (img3 == ''){
            $('#img3Error').text('Debe cargar una imagen');
            document.getElementById("img3").style.borderColor = "red";
            return false;
        } else {
            $('#img3Error').text('');
            document.getElementById("img3").style.borderColor = "grey";
        }
  
        this.disabled = true;
        $("#submit").click();
        this.disabled = false;
    });

    
    //al cambiar el tipo de maquina despliega los divs correspondientes
    $('#tipo').change(function(){
        var tipomaq = $(this).val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"{{ route('usado.seleccionMarca') }}",
            method:"POST",
            data:{tipomaq:tipomaq, _token:_token},
            success:function(result)
            {
                $('#marca').html(result);
            },
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
            }
        })
    });

    $( "#btn-paso5" ).click(function() {
        var id_usado = $('#id_usado').val();
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
        
        $.ajax({
            url:"{{ route('usado.pasoDosTresCuatro') }}",
            method:"POST",
            data:{_token:_token, precio:precio, ingreso:ingreso, id_sucursal:id_sucursal, comentarios:comentarios, excliente:excliente,
                id_vendedor:id_vendedor, id_usado:id_usado},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde.");
                this.disabled = false;
            },
            success:function(response)
            {
                window.location.replace(response);
            }
        })
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