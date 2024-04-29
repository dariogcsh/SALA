@extends('errors::minimal')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Sin acceso</h2></div>
                

                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{ asset('imagenes/candado.png') }}" class="img img-responsive" height="100px">
                    </div>
                    <br>
                    <div class="row justify-content-center">
                        <h4>403 | Contacta al concesionario para solicitar el acceso a esta sección</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection