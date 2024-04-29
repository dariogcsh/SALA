@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear URL externo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/externo') }}" enctype="multipart/form-data">
                        @csrf
                        @include('externo.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">

$( document ).ready(function() {
// Previsualizar imagen a subir
    document.getElementById("imagen").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("imgSubir").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };
}); 
    </script>
@endsection