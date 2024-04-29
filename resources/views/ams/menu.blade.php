@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Depósito virtual</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('activacion.index') }}"><img src="/imagenes/ams.png" class="img-fluid" title="Activaciones y suscripciones"></a>
                            <h3 class="d-flex justify-content-center">Activaciones y suscripciones</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('senal.index') }}"><img src="/imagenes/senal.png" class="img-fluid" title="Alquileres de señal"></a>
                            <h3 class="d-flex justify-content-center">Alquileres de señal</h3>
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
