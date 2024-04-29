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
                            <a href="{{ route('insumo.index') }}"><img src="/imagenes/producto_insumo.png" class="img-fluid" title="Productos e insumos"></a>
                            <h3 class="d-flex justify-content-center">Productos e insumos</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('mezcla.index') }}"><img src="/imagenes/mezcla.png" class="img-fluid" title="Mezcla de tanque"></a>
                            <h3 class="d-flex justify-content-center">Mezclas de tanque</h3>
                            <hr>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('repuesto.menu') }}"><img src="/imagenes/repuesto.png" class="img-fluid" title="Repuestos"></a>
                            <h3 class="d-flex justify-content-center">Repuestos</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('ams.menu') }}"><img src="/imagenes/ams.png" class="img-fluid" title="AMS"></a>
                            <h3 class="d-flex justify-content-center">AMS</h3>
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
