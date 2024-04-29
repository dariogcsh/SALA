@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>Califica nuestro servicio</h3></div>

                <div class="card-body">
                @include('custom.message')
                    <form method="POST" action="{{ url('/calificacion') }}">
                        @csrf
                        <input id="id_asist" hidden type="text" name="id_asist" value="{{ $asistencia }}">
                        <input id="id_user" hidden type="text" name="id_user" value="{{ auth()->user()->id }}">
                        <div class="form-group row">
                                <p class="clasificacion" id="calif">
                                    <input id="radio1" type="radio" name="puntos" value="5">
                                    <label for="radio1">★</label>
                                    <input id="radio2" type="radio" name="puntos" value="4">
                                    <label for="radio2">★</label>
                                    <input id="radio3" type="radio" name="puntos" value="3">
                                    <label for="radio3">★</label>
                                    <input id="radio4" type="radio" name="puntos" value="2">
                                    <label for="radio4">★</label>
                                    <input id="radio5" type="radio" name="puntos" value="1">
                                    <label for="radio5">★</label>
                                </p>
                                @error('puntos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}"  placeholder="Comentario (opcional)" rows="6" autofocus></textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;"></div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;"></div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <button type="submit" class="btn btn-warning btn-block">
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

@endsection