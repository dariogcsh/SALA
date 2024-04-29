@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear informe agronómico') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('reporte_agronomico.informe') }}">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                            <div class="col-md-6">
                                @if($organizacion->NombOrga == "Sala Hnos")
                                    <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" required autofocus> 
                                        @foreach($organizaciones as $organ)
                                            <option value="{{ $organ->CodiOrga }}" data-subtext="{{ $organ->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                @isset($informe->CodiOrga)
                                                        @if($organ->CodiOrga == $informe->CodiOrga)
                                                            selected
                                                        @endif
                                                @endisset
                                                >{{ $organ->NombOrga }} </option>
                                        @endforeach
                                @else
                                    <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" required autofocus> 
                                            <option value="{{ $organizacion->CodiOrga }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                >{{ $organizacion->NombOrga }} </option>
                                @endif 
                                   
                            </select>
                                @error('CodiOrga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="trabajo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de trabajo') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('trabajo') is-invalid @enderror" name="trabajo" id="trabajo" value="{{ old('trabajo') }}" required autofocus> 
                                <option value="">Seleccionar</option>
                                <option value="Cosecha">Cosecha</option>
                            </select>
                                @error('trabajo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="año" class="col-md-4 col-form-label text-md-right">{{ __('Año') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('año') is-invalid @enderror" name="año" id="año" value="{{ old('año') }}" required autofocus> 
                                <option value="">Seleccionar</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                            </select>
                                @error('año')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                        
                            
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="crear" type="submit" class="btn btn-success">Crear informe</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
