@php
    use Carbon\Carbon;
    use App\viaje;
    use Illuminate\Http\Request;
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @isset($viajes)
            @foreach($viajes as $viaje)
            @php
                $ahora = Carbon::now();
                $horaviaje = Viaje::where('id',$viaje->id)->first();
                $horainicial = $horaviaje->created_at;
                //dd($viajes);
                $horainicio = $horainicial->addMinute($viaje->minutos);
            @endphp
                @if($horainicio > $ahora)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Viaje a campo en transcurso</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <iframe id="myIframe" class="iframe" src={{ $viaje->url }} height="400" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endisset
        @isset($organizacion->NombOrga)
            @if($organizacion->NombOrga == "Sala Hnos")
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Interno</div>
                        <div class="card-body">
                            <input id="notification-token-input" hidden type="text" name="notification-token">
                            <div class="row">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ route('menuinterno') }}"><img src="/imagenes/interno.png" class="img-fluid"  title="Interno"></a>
                                    <h3 class="d-flex justify-content-center">SALA Interno</h3>
                                    <hr>
                                    <br>
                                </div>
                                <!--
                                
                                <div class="col-sm-4">
                                    <a href="{{ route('entrega.index') }}"><img src="/imagenes/entrega.png" class="img-fluid"  title="Entrega técnica"></a>
                                    <h3 class="d-flex justify-content-center">Entrega ideal</h3>
                                    <hr>
                                    <br>
                                </div>
                            -->
                                <div class="col-sm-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endif
        @endisset
       

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Inicio</div>

                <div class="card-body">
                    @include('custom.message')
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="{{ route('asist.index') }}"><img src="/imagenes/asistencia.png" class="img-fluid"  title="Asistencias"></a>
                            <h3 class="d-flex justify-content-center">Asistencias</h3>
                            <hr>
                            <br>
                        </div>

                        <div class="col-sm-3">
                            <a href="{{ route('bonificacion.index') }}"><img src="/imagenes/bonificaciones.png" class="img-fluid"  title="Beneficios"></a>
                            <h3 class="d-flex justify-content-center">Beneficios</h3>
                            <hr>
                            <br>
                        </div>

                        <div class="col-sm-3">
                            <a href="{{ route('solucion.index') }}"><img src="/imagenes/soluciones integrales.png" class="img-fluid"  title="Beneficios"></a>
                            <h3 class="d-flex justify-content-center">Soluciones</h3>
                            <hr>
                            <br>
                        </div>

                        <div class="col-sm-3">
                            <a href="{{ route('jdlink.menu') }}"><img src="/imagenes/monitoreo.png" class="img-fluid"  title="Soporte y monitoreo"></a>
                            <h3 class="d-flex justify-content-center">Monitoreo de equipos</h3>
                            <hr>
                            <br>
                        </div>

                        
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="{{ route('paqueteagronomico.menu') }}"><img src="/imagenes/agronomico.png" class="img-fluid"  title="Monitoreo agronómico"></a>
                            <h3 class="d-flex justify-content-center">Monitoreo agronómico</h3>
                            <hr>
                            <br>
                        </div>
                    <!--
                        <div class="col-sm-3">
                            <a href="{{ route('ordentrabajo.index') }}"><img src="/imagenes/ordentrabajo.png" class="img-fluid"  title="órden de trabajo"></a>
                            <h3 class="d-flex justify-content-center">Órden de trabajo</h3>
                            <hr>
                            <br>
                        </div>
                        
                        <div class="col-sm-3">
                            <a href="{{ route('insumo.menu') }}"><img src="/imagenes/deposito.png" class="img-fluid"  title="Deposito virtual"></a>
                            <h3 class="d-flex justify-content-center">Depósito virtual</h3>
                            <hr>
                            <br>
                        </div> 
                    -->
                        <div class="col-sm-3">
                            <a href="{{ route('mant_maq.index') }}"><img src="/imagenes/mantenimiento.png" class="img-fluid"  title="Paquete de mantenimiento"></a>
                            <h3 class="d-flex justify-content-center">Mantenimientos</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ url('https://sala.portalconcesionario.com/') }}"><img src="/imagenes/sala_portal.png" class="img-fluid"  title="Sala Portal"></a>
                            <h3 class="d-flex justify-content-center">Sala Portal</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ route('tutorial.index') }}"><img src="/imagenes/tutoriales.png" class="img-fluid"  title="Contenido"></a>
                            <h3 class="d-flex justify-content-center">Contenido</h3>
                            <hr>
                            <br>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript"> // your code
    function onReady(e){
        function receiveMessage(event) {
            console.log("Received event", event);
            if (!event.data) return;
            const { action } = JSON.parse(event.data);
            if (action === "get-token-successfully") {
                console.log('TOKEN SUCCESS: ', window.mobileAppNotificationToken);
                const notificationTokenElemen = document.getElementById("notification-token-input");
                notificationTokenElemen.value = window.mobileAppNotificationToken;
            }
            var _token = $('input[name="_token"]').val();
            var tokennuevo = $('#notification-token-input').val();
            //alert(tokennuevo);
            $.ajax({
            url:"{{ route('home.token') }}",
            method:"POST",
            data:{_token:_token, tokennuevo:tokennuevo},
            success:function(data)
            {
                //window.location = "/usado/createUpdate/" + data;
                //alert(data);
            }
        })
        }
        window.addEventListener('message', receiveMessage);
     }
     document.addEventListener('DOMContentLoaded', onReady);

</script>

@endsection
