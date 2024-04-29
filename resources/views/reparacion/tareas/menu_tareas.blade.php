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
                            <a href="{{ route('reparacion.tareas_de_reparacion_taller') }}" class="btn btn-primary btn-block">Tareas en taller</a>
                        </div>
                        <br><br>
                        <div class="col-md-4">
                            <a href="{{ route('reparacion.tareas_de_reparacion_campo') }}" class="btn btn-primary btn-block">Tareas en campo</a>
                        </div>
                        <br><br>
                        <div class="col-md-4">
                            <a href="{{ route('reparacion.administrar_tareas_campo') }}" class="btn btn-secondary btn-block">Administrar tareas de campo</a>
                        </div>
                        <br><br>
                        <div class="col-md-4">
                            <a href="{{ route('reparacion.administrar_tareas_taller') }}" class="btn btn-secondary btn-block">Administrar tareas de taller</a>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection