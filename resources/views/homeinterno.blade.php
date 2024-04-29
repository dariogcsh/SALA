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
                            <a href="{{ route('antena.index') }}"><img src="/imagenes/menu/antenas.png" class="img-fluid"  title="Antenas"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('subirpdf.menu') }}"><img src="/imagenes/menu/ventas.png" class="img-fluid"  title="Antenas"></a>
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
                            <a href="{{ route('mail.index') }}"><img src="/imagenes/menu/email.png" class="img-fluid"  title="Emails"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('user_notification.create') }}"><img src="/imagenes/menu/envionotificaciones.png" class="img-fluid"  title="Envío de notificaciones"></a>
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
                            <a href="{{ route('etapa.index') }}"><img src="/imagenes/menu/etapas.png" class="img-fluid"  title="Etapas de entrega técnica"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('evento.index') }}"><img src="/imagenes/menu/eventos.png" class="img-fluid"  title="Eventos"></a>
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
                            <a href="{{ route('ideaproyecto.index') }}"><img src="/imagenes/menu/ideas_proyecto.png" class="img-fluid"  title="Ideas de proyectos"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('maquina.index') }}"><img src="/imagenes/menu/maquinas.png" class="img-fluid"  title="Máquinas"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('jdlink.index') }}"><img src="/imagenes/menu/maquinasconectadas.png" class="img-fluid"  title="Máquinas conectadas"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('mant_maq.index') }}"><img src="/imagenes/menu/mant_maq.png" class="img-fluid"  title="Máquinas con paquete de mantenimiento"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('pantalla.index') }}"><img src="/imagenes/menu/pantallas.png" class="img-fluid"  title="Pantallas"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('paso.index') }}"><img src="/imagenes/menu/pasos.png" class="img-fluid"  title="Pasos de entrega técnica"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('paquetemant.index') }}"><img src="/imagenes/menu/paquete_mantenimiento.png" class="img-fluid"  title="Paquete de mantenimiento ABM"></a>
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
                            <a href="{{ route('permission.index') }}"><img src="/imagenes/menu/permisos.png" class="img-fluid"  title="Permisos"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('proyecto.index') }}"><img src="/imagenes/menu/proyectos.png" class="img-fluid"  title="Proyectos"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('puesto_empleado.index') }}"><img src="/imagenes/menu/puestosempleados.png" class="img-fluid"  title="Rol de colaborador"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('repuesto.index') }}"><img src="/imagenes/menu/repuestos.png" class="img-fluid"  title="Repuestos ABM"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('role.index') }}"><img src="/imagenes/menu/roles.png" class="img-fluid"  title="Roles de usuario"></a>
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
                            <a href="{{ route('sucursal.index') }}"><img src="/imagenes/menu/sucursales.png" class="img-fluid"  title="Sucursales"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('suscripcion.index') }}"><img src="/imagenes/menu/suscripcion.png" class="img-fluid"  title="Suscripciones"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('asistenciatipo.index') }}"><img src="/imagenes/menu/tipoasistencias.png" class="img-fluid"  title="Tipos de asistencias"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('tipoobjetivo.index') }}"><img src="/imagenes/menu/tiposobjetivos.png" class="img-fluid"  title="Tipos de objetivos"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('tipo_paquete_mant.index') }}"><img src="/imagenes/menu/tipo_paquete_mantenimiento.png" class="img-fluid"  title="Tipo de paquete de mantenimiento"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('usado.index') }}"><img src="/imagenes/menu/usados.png" class="img-fluid"  title="Usados"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('user.index') }}"><img src="/imagenes/menu/usuarios.png" class="img-fluid"  title="Usuarios"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('viaje.index') }}"><img src="/imagenes/menu/viaje.png" class="img-fluid"  title="Viaje a campo"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('vehiculo.index') }}"><img src="/imagenes/menu/vehiculo.png" class="img-fluid"  title="Vehículos"></a>
                            <hr>
                            <br>
                        </div>
                        <!--
                        <div class="col-sm-6">
                            <a href="{{ route('reparacion.menu') }}"><img src="/imagenes/menu/antenas.png" class="img-fluid"  title="Reparacion"></a>
                            <hr>
                            <br>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection