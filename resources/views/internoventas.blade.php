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
                            <a href="{{ route('usado.index') }}"><img src="/imagenes/menu/usados.png" class="img-fluid"  title="Usados"></a>
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