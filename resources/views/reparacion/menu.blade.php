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
                            <a href="{{ route('reparacion.solicitudes') }}" class="btn btn-primary btn-block">Solicitudes de reparacion</a>
                        </div>
                        <br><br>
                        <div class="col-md-4">
                            <a href="{{ route('reparacion.tareas_de_reparacion') }}" class="btn btn-primary btn-block">Tareas de reparacion</a>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection