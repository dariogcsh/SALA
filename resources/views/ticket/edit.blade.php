@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar ticket') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/ticket/'.$ticket->id) }}">
                        @csrf
                        @method('patch')
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>

                            <div class="col-md-6">
                                <input id="id_organizacion" type="text" class="form-control @error('id_organizacion') is-invalid @enderror" name="id_organizacion" value="{{ isset($show_t->NombOrga)?$show_t->NombOrga:old('id_organizacion') }}" disabled autocomplete="id_organizacion" autofocus>

                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_servicioscsc" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de servicio') }}</label>

                            <div class="col-md-6">
                                <input id="id_servicioscsc" type="text" class="form-control @error('id_servicioscsc') is-invalid @enderror" name="id_servicioscsc" value="{{ isset($show_t->nombre)?$show_t->nombre:old('id_servicioscsc') }}" disabled>

                                @error('id_servicioscsc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Detalle de servicio') }}</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ isset($ticket->titulo)?$ticket->titulo:old('titulo') }}">

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="servicioscsc" class="col-md-4 col-form-label text-md-right">{{ __('Detalle de servicio') }}</label>

                            <div class="col-md-6">
                                <input id="servicioscsc" type="text" class="form-control @error('servicioscsc') is-invalid @enderror" name="servicioscsc" value="{{ isset($ticket->nombreservicio)?$ticket->nombreservicio:old('servicioscsc') }}">

                                @error('servicioscsc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">{{ __('Modificar') }} </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
