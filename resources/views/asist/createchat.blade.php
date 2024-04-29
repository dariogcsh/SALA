@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Solicitar asistencia</h2></div>

                <div class="card-body">
                    <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                    <form action="{{ url('/asist') }}" method="post" id="formulario">
                    @csrf
                    @method('post')

                        <div class="container">

                        <div class="form-group row">
                            <label for="DescAsis" class="col-md-4 col-form-label text-md-right">{{ __('DescAsis') }} *</label>

                            <div class="col-md-6">
                                <textarea id="DescAsis" class="form-control-textarea @error('DescAsis') is-invalid @enderror" name="DescAsis" value="{{ old('DescAsis') }}" required autocomplete="DescAsis" autofocus></textarea>

                                @error('DescAsis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" onclick="return pregunta();" class="btn btn-success" id="btn-enviar" name="btn-enviar">
                                    {{ __('Enviar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function pregunta(){
            const boton = document.getElementById("btn-enviar");
            boton.setAttribute('disabled', "true");
            var opcion = confirm('¿Confirma la solicitud de asistencia?');
            if (opcion == true) {
                $("#formulario").submit();
            } else {
                alert("Se ha cancelado el envío de solicitud de asistencia");
            }
    }
</script>
@endsection