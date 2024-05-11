@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">PDF
                    @can('haveaccess','subirpdf.create')
                        <a href="{{ route('subirpdf.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
                   </div>

                <div class="card-body" id="imprimirPDF">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('custom.message')
                    <div class="row">
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('subirpdf.index') }}"><img src="/imagenes/pdfmenu.png" class="img-fluid"  title="Lista de precios"></a>
                            <h3 class="d-flex justify-content-center" style="text-align: center">Lista de precios</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('subirpdf.indexusados') }}"><img src="/imagenes/pdfmenu.png" class="img-fluid" title="Formularios de usados"></a>
                            <h3 class="d-flex justify-content-center" style="text-align: center">Formularios de usados</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('subirpdf.indexvarios') }}"><img src="/imagenes/pdfmenu.png" class="img-fluid" title="Formularios varios"></a>
                            <h3 class="d-flex justify-content-center" style="text-align: center">Formularios varios</h3>
                            <hr>
                            <br>
                        </div>
                        <div class="col-6 col-sm-4">
                            <a href="{{ route('subirpdf.indexams') }}"><img src="/imagenes/pdfmenu.png" class="img-fluid" title="Condiciones comerciales AMS"></a>
                            <h3 class="d-flex justify-content-center" style="text-align: center">Condiciones comerciales AMS</h3>
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
