@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('internosoluciones') }}"><img src="/imagenes/CSC.png" class="img-fluid" title="Activaciones y suscripciones"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Soluciones integrales</h4>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('internoventas') }}"><img src="/imagenes/ventas2.png" class="img-fluid" title="Activaciones y suscripciones"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Ventas</h4>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('internoservicios') }}"><img src="/imagenes/servicios.png" class="img-fluid" title="Activaciones y suscripciones"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Servicio</h4>
                            <hr>
                            <br>
                        </div>
                   
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('calendario.index') }}"><img src="/imagenes/calendario.png" class="img-fluid"  title="Calendario"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Calendario</h4>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('internocx') }}"><img src="/imagenes/CX.png" class="img-fluid"  title="Customer Experience"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">CX</h4>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('internoestadisticas') }}"><img src="/imagenes/estadisticas.png" class="img-fluid" title="Estadisticas"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Estadísticas</h4>
                            <hr>
                            <br>
                        </div>
                 
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('internoentregas') }}"><img src="/imagenes/entrega.png" class="img-fluid"  title="Entrega técnica"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Entrega ideal</h4>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('internoconfiguracion') }}"><img src="/imagenes/configuracion.png" class="img-fluid" title="Activaciones y suscripciones"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Configuracion</h4>
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
