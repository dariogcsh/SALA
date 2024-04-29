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
                            <a href="{{ route('guardiasadmin.index') }}"><img src="/imagenes/menu/guardias.png" class="img-fluid"  title="Guardias de administrativos de servicio"></a>
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
                            <a href="{{ route('mant_maq.index') }}"><img src="/imagenes/menu/mant_maq.png" class="img-fluid"  title="Paquete de mantenimiento ABM"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('tarea.itecnicos') }}"><img src="/imagenes/menu/planservicios.png" class="img-fluid"  title="Planificación de servicios"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('reparacion.menu') }}"><img src="/imagenes/menu/planillas.png" class="img-fluid"  title="Planillas digitales"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('viaje.index') }}"><img src="/imagenes/menu/viaje.png" class="img-fluid"  title="Viaje a campo"></a>
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