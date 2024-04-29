@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @isset($organizacion->NombOrga)
            @if($organizacion->NombOrga == "Sala Hnos")
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Interno</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-1">
                                 
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ route('homeinterno') }}"><img src="/imagenes/interno.png" class="img-fluid"  title="Asistencias"></a>
                                    <h3 class="d-flex justify-content-center">Sala Interno</h3>
                                    <hr>
                                    <br>
                                </div>
                                <div class="col-sm-2">
                                 
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ route('calendario.index') }}"><img src="/imagenes/calendario.png" class="img-fluid"  title="Calendario"></a>
                                    <h3 class="d-flex justify-content-center">Calendario</h3>
                                    <hr>
                                    <br>
                                </div>
                                <div class="col-sm-1">
                                 
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
                            <a href="{{ route('jdlink.menu') }}"><img src="/imagenes/monitoreo.png" class="img-fluid"  title="Soporte y monitoreo"></a>
                            <h3 class="d-flex justify-content-center">Monitoreo de equipos</h3>
                            <hr>
                            <br>
                        </div>

                        <div class="col-sm-3">
                            <a href="{{ route('paqueteagronomico.menu') }}"><img src="/imagenes/agronomico.png" class="img-fluid"  title="Monitoreo agronómico"></a>
                            <h3 class="d-flex justify-content-center">Monitoreo agronómico</h3>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-sm-3">
                            <a href="{{ route('mant_maq.index') }}"><img src="/imagenes/mantenimiento.png" class="img-fluid"  title="Paquete de mantenimiento"></a>
                            <h3 class="d-flex justify-content-center">Mantenimientos</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ route('tutorial.index') }}"><img src="/imagenes/tutoriales.png" class="img-fluid"  title="Tutoriales"></a>
                            <h3 class="d-flex justify-content-center">Tutoriales</h3>
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
