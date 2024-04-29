@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Estadísticas</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{ route('maquina.gestion') }}"><img src="/imagenes/Equipos y conectividad.png" class="img-fluid" title="Equipos y Conectividads"></a>
                            <h3 class="d-flex justify-content-center">Equipos y conectividad</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('interaccion.index') }}"><img src="/imagenes/click.png" class="img-fluid" title="Visitas en la App"></a>
                            <h3 class="d-flex justify-content-center">Visitas en la App</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('alerta.gestion') }}"><img src="/imagenes/estadistica_alertas.png" class="img-fluid" title="Alertas"></a>
                            <h3 class="d-flex justify-content-center">Alertas</h3>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{ route('asist.gestion') }}"><img src="/imagenes/estadistica_asistencia.png" class="img-fluid" title="Asistencias"></a>
                            <h3 class="d-flex justify-content-center">Asistencias</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('calificacion.gestion') }}"><img src="/imagenes/estadistica_calificaciones.png" class="img-fluid" title="Calificaciones de asistencias"></a>
                            <h3 class="d-flex justify-content-center">Calificaciones de asistencias</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('detalle_ticket.index') }}"><img src="/imagenes/estadistica_tickets.png" class="img-fluid" title="Ticket CSC"></a>
                            <h3 class="d-flex justify-content-center">Ticket CSC</h3>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{ route('detalle_ticket.analyst') }}"><img src="/imagenes/estadistica_tickets.png" class="img-fluid" title="Ticket SALA"></a>
                            <h3 class="d-flex justify-content-center">Ticket SALA</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('viaje.gestion') }}"><img src="/imagenes/estadistica_viaje.png" class="img-fluid" title="Viajes a campo compartidos"></a>
                            <h3 class="d-flex justify-content-center">Viajes a campo compartidos</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('senal.gestion') }}"><img src="/imagenes/alquiler_señal.png" class="img-fluid" title="Alquileres de señal"></a>
                            <h3 class="d-flex justify-content-center">Alquileres de señal</h3>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{ route('activacion.gestion') }}"><img src="/imagenes/estadistica_activaciones.png" class="img-fluid" title="Activación/Suscripción"></a>
                            <h3 class="d-flex justify-content-center">Activación/Suscripción</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('proyecto.gestion') }}"><img src="/imagenes/estadistica_proyectos.png" class="img-fluid" title="Proyectos"></a>
                            <h3 class="d-flex justify-content-center">Proyectos CSC</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('mant_maq.gestion') }}"><img src="/imagenes/estadistica_mantenimientos.png" class="img-fluid" title="Mantenimientos"></a>
                            <h3 class="d-flex justify-content-center">Mantenimientos</h3>
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
