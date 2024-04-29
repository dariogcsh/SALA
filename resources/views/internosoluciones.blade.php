@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Interno</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('activacion.index') }}"><img src="/imagenes/menu/activaciones.png" class="img-fluid"  title="Activaciones"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('senal.index') }}"><img src="/imagenes/menu/alquilerdeseñal.png" class="img-fluid"  title="Alquiler de señal"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('alerta.index') }}"><img src="/imagenes/menu/alertas.png" class="img-fluid"  title="Alerta"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('calificacion.index') }}"><img src="/imagenes/menu/calificaciones.png" class="img-fluid"  title="Calificaciones"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('contacto.index') }}"><img src="/imagenes/menu/contactos.png" class="img-fluid"  title="Contactos con el cliente"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('informe.enviarInforme') }}"><img src="/imagenes/menu/informesTractores.png" class="img-fluid"  title="Envío de informes tractores"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('utilidad.enviarInforme') }}"><img src="/imagenes/menu/informesCosechadoras.png" class="img-fluid"  title="Envío de informes cosechadoras"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('maq_breadcrumb.index') }}"><img src="/imagenes/menu/estadoactual.png" class="img-fluid"  title="Estado actual de máquina"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('maq_breadcrumb.itractor') }}"><img src="/imagenes/menu/estadoactualtractor.png" class="img-fluid"  title="Estado actual de tractores"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('monitoreo.index') }}"><img src="/imagenes/menu/facturacion_monitoreo.png" class="img-fluid"  title="Factura de monitoreoss"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('maquina.index') }}"><img src="/imagenes/menu/maquinas.png" class="img-fluid"  title="Máquinas"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('jdlink.index') }}"><img src="/imagenes/menu/maquinasconectadas.png" class="img-fluid"  title="Máquinas conectadas"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('servicioscsc.index') }}"><img src="/imagenes/menu/servicioscsc.png" class="img-fluid"  title="Servicios CSC"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('paqueteagronomico.index') }}"><img src="/imagenes/menu/siembra.png" class="img-fluid"  title="Soporte agronómico"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('ticket.index') }}"><img src="/imagenes/menu/ticketcsc.png" class="img-fluid"  title="Tickets CSC"></a>
                            <hr>
                            <br>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection