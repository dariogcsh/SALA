@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Solicitudes de reparaciones</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('reparacion.solicitud') }}" class="btn btn-danger btn-block">Solicitar una reparacion</a>
                        </div>
                        <br><br>
                        <div class="col-md-4">
                            <a href="{{ route('reparacion.pendientes_de_presupuestar') }}" class="btn btn-warning btn-block">Pendientes de presupuestar</a>
                        </div>
                        <br><br>
                        <div class="col-md-4">
                            <a href="{{ route('reparacion.pendientes_de_aprobar') }}" class="btn btn-success btn-block">Pendientes de aprobar</a>
                        </div>
                        <br><br>
                        <div class="col-md-4">
                            <a href="{{ route('reparacion.administrar_solicitudes') }}" class="btn btn-secondary btn-block">Administrar solicitudes</a>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection