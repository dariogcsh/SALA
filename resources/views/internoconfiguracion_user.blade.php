@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Configuración</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        
                        <div class="col-sm-6">
                            <a href="{{ route('organizacion.index') }}"><img src="/imagenes/menu/organizacion.png" class="img-fluid"  title="Organizaciones"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('user.index') }}"><img src="/imagenes/menu/usuarios.png" class="img-fluid"  title="Usuarios"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('maquina.index') }}"><img src="/imagenes/menu/maquinas.png" class="img-fluid"  title="Máquinas"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('ideaproyecto.index') }}"><img src="/imagenes/menu/ideas_proyecto.png" class="img-fluid"  title="Ideas de proyectos"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('terminos') }}"><img src="/imagenes/menu/terminos.png" class="img-fluid"  title="Términos y condiciones"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a id="logout" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                     <img src="/imagenes/menu/log_out.png" class="img-fluid"  title="Cerrar sesión">
                                    </a>
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