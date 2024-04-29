@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Soluciones</h2>
                </div>
                <div class="card-body">
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <!-- Accordion card -->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingOne">
                                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne" aria-expanded="false"
                                    aria-controls="collapseOne">
                                    <h4 class="mb-0">
                                        <i class="fas fa-angle-down rotate-icon"></i> Solución en siembra
                                    </h4>
                                    </a>
                                </div>
                                <!-- Card body -->
                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne"
                                    data-parent="#accordionEx1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active">
                                                            <img src="{{ asset('img/soluciones/calidad_siembra.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Digitalizacion.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Informes_2.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Capacitacion_OC.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/ensayando.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Muestreo.PNG') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/ensayo23.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Anterior</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Siguiente</span>
                                                    </a>
                                                </div>                                            
                                            </div>
                                            <br>
                                            <div class="col-md-6"><p>Arma tu SOLUCIÓN EN SIEMBRA a tu medida. Soporte y capacitación 
                                                                    digital, ordenamiento de datos agronómicos, informes de 
                                                                    eficiencia de uso de los equipos, monitoreo y soporte de alertas, 
                                                                    relevamiento de calidad de siembra, muestreos de suelo y mucho más.
                                                                    Elegi los servicios que se adapten a tu necesidad y envianos 
                                                                    tu propuesta.</p></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="{{ route('jdlink.createtractorsolo') }}" class="btn btn-success btn-block">Ver formulario</a>
                                            </div>
                                            <br><br>
                                            <div class="col-md-4">
                                                <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/pdf/monitoreo/Monitoreo siembra.pdf')}}" class="btn btn-light btn-block">Ver detalle del monitoreo</a>
                                            </div>
                                            <div class="col-md-4" style="text-align: center;">
                                                <a href="tel:3584901139"><img src="{{ asset('/imagenes/llamar.png') }}" height="15px"> Quiero saber más</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->
                        </div>
                        <!-- Accordion wrapper -->
                        <br>
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <!-- Accordion card -->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingTwo">
                                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    <h4 class="mb-0">
                                        <i class="fas fa-angle-down rotate-icon"></i> Solución en cosecha
                                    </h4>
                                    </a>
                                </div>
                                <!-- Card body -->
                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo"
                                    data-parent="#accordionEx1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active">
                                                            <img src="{{ asset('img/soluciones/Ensayo_cosecha.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Informes.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Digitalizacion2.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Capacitacion_OC_2.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Digitalizacion.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/Informes_2.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="{{ asset('img/soluciones/ensayo cosecha.png') }}" width="100%" class="img img-responsive">
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Anterior</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Siguiente</span>
                                                    </a>
                                                </div>                                            
                                            </div>
                                            <br>
                                            <div class="col-md-6"><p>Arma tu SOLUCIÓN EN COSECHA a tu medida. Soporte y capacitación 
                                                                    digital, ordenamiento de datos agronómicos, informes de 
                                                                    eficiencia de uso de los equipos, utilización de tecnología, 
                                                                    monitoreo y soporte de alertas, ensayos de Combine Advisor,
                                                                    actualizaciones de equipo de agricultura de presición, check
                                                                    list final de campaña y mucho más.
                                                                    Elegi los servicios que se adapten a tu necesidad y envianos 
                                                                    tu propuesta.</p></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="{{ route('jdlink.create') }}" class="btn btn-success btn-block">Ver formulario</a>
                                            </div>
                                            <br><br>
                                            <div class="col-md-4">
                                                <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/pdf/monitoreo/Monitoreo de cosecha personalizado.pdf')}}" class="btn btn-light btn-block">Ver detalle del monitoreo</a>
                                            </div>
                                            <div class="col-md-4" style="text-align: center;">
                                                <a href="tel:3584901139"><img src="{{ asset('/imagenes/llamar.png') }}" height="15px"> Quiero saber más</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->
                        </div>
                        <!-- Accordion wrapper -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    $('.solicitud').click(function(){
        var opcion = confirm('¿Desea confirmar la solicitud de bonificación?');
            if (opcion == true) { 
                var id = $(this).val();
                var id_boton = $(this).attr('id');
                boton_envio = document.getElementById(id_boton);
                var _token = $('input[name="_token"]').val();
                var path = "{{ route('mibonificacion.store') }}";
                $.ajax({
                    url: path,
                    method:"POST",
                    data:{ _token:_token, id:id_boton},
                    error: function(){
                          alert("No se puede solicitar la bonificación en este momento, intentelo más tarde");
                    },
                    success:function(response)
                    {
                        window.location.replace(response);
                    }
                  });
            } else {
                alert("Se ha cancelado la solicitud de bonificación");
            }
        
    });
});
</script>
@endsection
