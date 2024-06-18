@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Monitoreo</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('cosecha.index') }}"><img src="/imagenes/informe_diario.png" class="img-fluid" title="Informes"></a>
                            <h3 class="d-flex justify-content-center" style="text-align: center;">Informe diario agronómico</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('reporte_agronomico.index') }}"><img src="/imagenes/reporte_agronomico.png" class="img-fluid"  title="Reporte Agronomico"></a>
                            <h3 class="d-flex justify-content-center" style="text-align: center;">Informe agronómico</h3>
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
