@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
         

                <div class="card-body" id="imprimirPDF">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-6 col-sm-6">
                            <a href="{{ route('informe.index') }}"><img src="/imagenes/lupa.png" class="img-fluid"  title="Asistencias"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Ver informes</h4>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-6">
                            <a href="{{ route('utilidad.index') }}"><img src="/imagenes/crear_informe_eficiencia.png" class="img-fluid" title="Informes"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Generar Informes de trabajo</h4>
                            <hr>
                            <br>
                        </div>
                  
                        <div class="col-6 col-sm-6">
                            <a href="{{ route('utilidad.acarreo') }}"><img src="/imagenes/acarreo.png" class="img-fluid"  title="Informes de acarreo"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Generar informes de acarreo</h4>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-6">
                            <a href="{{ route('utilidad.comparar') }}"><img src="/imagenes/comparar.png" class="img-fluid"  title="Informes comparativos"></a>
                            <h4 class="d-flex justify-content-center" style="text-align:center;">Generar informes comparativos</h4>
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
