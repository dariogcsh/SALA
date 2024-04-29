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
                            <a href="{{ route('antena.index') }}"><img src="/imagenes/menu/antenas.png" class="img-fluid"  title="Antenas"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('conectividad.index') }}"><img src="/imagenes/menu/conectividad.png" class="img-fluid"  title="Conectividad"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('mail.index') }}"><img src="/imagenes/menu/email.png" class="img-fluid"  title="Emails"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('externo.index') }}"><img src="/imagenes/menu/externo.png" class="img-fluid"  title="Enlaces externos"></a>
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
                            <a href="{{ route('ideaproyecto.index') }}"><img src="/imagenes/menu/ideas_proyecto.png" class="img-fluid"  title="Ideas de proyectos"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('objetivo.index') }}"><img src="/imagenes/menu/objetivos.png" class="img-fluid"  title="Objetivos"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('organizacion.index') }}"><img src="/imagenes/menu/organizacion.png" class="img-fluid"  title="Organizaciones"></a>
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
                            <a href="{{ route('permission.index') }}"><img src="/imagenes/menu/permisos.png" class="img-fluid"  title="Permisos"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('proyecto.index') }}"><img src="/imagenes/menu/proyectos.png" class="img-fluid"  title="Proyectos"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('puesto_empleado.index') }}"><img src="/imagenes/menu/puestosempleados.png" class="img-fluid"  title="Rol de colaborador"></a>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('repuesto.index') }}"><img src="/imagenes/menu/repuestos.png" class="img-fluid"  title="Repuestos ABM"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('role.index') }}"><img src="/imagenes/menu/roles.png" class="img-fluid"  title="Roles de usuario"></a>
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
                            <a href="{{ route('user.index') }}"><img src="/imagenes/menu/usuarios.png" class="img-fluid"  title="Usuarios"></a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection