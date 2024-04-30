@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Entrega ideal</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('entrega.index') }}"><img src="/imagenes/menu/unidadesnuevas.png" class="img-fluid"  title="Entrega unidades nuevas"></a>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('entrega.indexusado') }}"><img src="/imagenes/menu/unidadesusadas.png" class="img-fluid"  title="Entrega unidades usadas"></a>
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