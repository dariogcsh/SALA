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
        <br>
        @isset($organizacion->NombOrga)
            @if($organizacion->NombOrga == "Sala Hnos")
                <div class="col-md-12" style="padding-bottom: 20px">
                    <div class="card">
                     
                        <div class="card-body">
                            <input id="notification-token-input" hidden type="text" name="notification-token">
                            <div class="row">
                                <div class="col-3 col-sm-4">
                                </div>
                                <div class="col-6 col-sm-4">
                                    <a href="{{ route('menuinterno') }}"><img src="/imagenes/interno.png" class="img-fluid"  title="Interno"></a>
                                    <h4 class="d-flex justify-content-center">SALA Interno</h3>
                                </div>
                                <div class="col-3 col-sm-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endif
        @endisset
        @php
        /*
             $token = "BEARER eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3Mjc1MzQ2NjAsInR5cGUiOiJleHRlcm5hbCIsInVzZXIiOiJkYXJpb2dhcmNpYUBzYWxhaG5vcy5jb20uYXIifQ.7aEUSPCVNtA_7nhHL-IepPWtMfWL7y7GGwIiq3ouLgYEhmnziuJo_N8oYF5x3MSNfijhEfF2y0X7AsXncnb10Q";
        
        $apiEndpoint = "https://api.estadisticasbcra.com/usd_of";
        
        $ch = curl_init($apiEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization:". $token,
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $decodedResponse = json_decode($response, true);
        $enlace = $decodedResponse['v'];
echo($enlace);
*/
        @endphp

        <div class="col-md-12">
            <div class="card">
            

                <div class="card-body">
                    @include('custom.message')
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <a href="{{ route('noticia.index') }}"><img src="/imagenes/noticia.png" class="img-fluid"  title="Noticias"></a>
                            <h4 class="d-flex justify-content-center" style="text-align: center;">Noticias</h3>
                            <hr>
                            <br>
                        </div>

                        <div class="col-6 col-md-3">
                            <a href="{{ route('solucion.index') }}"><img src="/imagenes/soluciones integrales.png" class="img-fluid"  title="Beneficios"></a>
                            <h4 class="d-flex justify-content-center" style="text-align: center;">Soluciones</h3>
                            <hr>
                            <br>
                        </div>

                        <div class="col-6 col-md-3">
                            <a href="{{ route('usado.index') }}"><img src="/imagenes/usados.png" class="img-fluid"  title="Beneficios"></a>
                            <h4 class="d-flex justify-content-center" style="text-align: center;">Usados</h3>
                            <hr>
                            <br>
                        </div>

                        <div class="col-6 col-md-3">
                            <a href="{{ route('bonificacion.index') }}"><img src="/imagenes/bonificaciones.png" class="img-fluid"  title="Beneficios"></a>
                            <h4 class="d-flex justify-content-center" style="text-align: center;">Beneficios</h3>
                            <hr>
                            <br>
                        </div>

                    <!--
                        <div class="col-6 col-md-3">
                            <a href="{{ route('ordentrabajo.index') }}"><img src="/imagenes/ordentrabajo.png" class="img-fluid"  title="órden de trabajo"></a>
                            <h4 class="d-flex justify-content-center">Órden de trabajo</h3>
                            <hr>
                            <br>
                        </div>
                        
                        <div class="col-6 col-md-3">
                            <a href="{{ route('insumo.menu') }}"><img src="/imagenes/deposito.png" class="img-fluid"  title="Deposito virtual"></a>
                            <h4 class="d-flex justify-content-center">Depósito virtual</h3>
                            <hr>
                            <br>
                        </div> 
                    -->
                        <div class="col-6 col-md-3">
                            <a href="{{ url('https://sala.portalconcesionario.com/') }}"><img src="/imagenes/sala_portal.png" class="img-fluid"  title="Sala Portal"></a>
                            <h4 class="d-flex justify-content-center" style="text-align: center;">Sala Portal</h3>
                            <hr>
                            <br>
                        </div>
                        
                        <div class="col-6 col-md-3">
                            <a href="{{ route('mant_maq.index') }}"><img src="/imagenes/mantenimiento.png" class="img-fluid"  title="Paquete de mantenimiento"></a>
                            <h4 class="d-flex justify-content-center" style="text-align: center;">Mantenimientos</h3>
                            <hr>
                            <br>
                        </div>
                       
                        <div class="col-6 col-md-3">
                            <a href="{{ route('tutorial.index') }}"><img src="/imagenes/tutoriales.png" class="img-fluid"  title="Contenido"></a>
                            <h4 class="d-flex justify-content-center" style="text-align: center;">Contenido</h3>
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
