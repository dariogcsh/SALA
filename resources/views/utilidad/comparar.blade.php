@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear informe comparativo') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('utilidad.informeComparar') }}" id="informef" name="informef">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <input id="vista" hidden type="text" value="{{ $habilitar }}">
                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                            <div class="col-md-6">
                                @if($organizacion->NombOrga == "Sala Hnos")
                                    <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" required @if ($habilitar == "NO") disabled @endif autofocus> 
                                        @foreach($organizaciones as $organ)
                                            <option value="{{ $organ->id }}" data-subtext="{{ $organ->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                @isset($informe->CodiOrga)
                                                        @if($organ->CodiOrga == $informe->CodiOrga)
                                                            selected
                                                        @endif
                                                @endisset
                                                >{{ $organ->NombOrga }} </option>
                                        @endforeach
                                @else
                                    <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" required @if ($habilitar == "NO") readonly @endif autofocus> 
                                            <option value="{{ $organizacion->id }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
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
                            <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('Maquina') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('NumSMaq') is-invalid @enderror" id="NumSMaq" multiple name="NumSMaq[]" value="{{ isset($jdlink->NumSMaq)?$jdlink->NumSMaq:old('NumSMaq') }}" autofocus>
                                    @isset($informe) 
                                        <option value="{{ $informe->NumSMaq }}" selected>{{ $informe->NumSMaq }} </option>
                                    @endisset
                                </select>
                                @error('NumSMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                        <div id="cultivo" style="display: none;">
                            <div class="form-group row">
                                <label for="inlineRadioOptions" class="col-md-4 col-form-label text-md-right"></label>
                               
                                @isset($informe->CultInfo)
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Soja")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="soja" value="soja" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="soja" value="soja">
                                            @endif
                                            <label class="form-check-label" for="soja">Soja</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Maiz")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maiz" value="maíz" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maiz" value="maíz">
                                            @endif
                                            <label class="form-check-label" for="maiz">Maíz</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Trigo")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="trigo" value="trigo" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="trigo" value="trigo">
                                            @endif
                                            <label class="form-check-label" for="trigo">Trigo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Girasol")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="girasol" value="girasol" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="girasol" value="girasol">
                                            @endif
                                            <label class="form-check-label" for="girasol">Girasol</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Siembra")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="siembra" value="siembra" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="siembra" value="siembra">
                                            @endif
                                            <label class="form-check-label" for="siembra">Siembra</label>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="soja" onchange="handleChange(this);" value="soja" checked>
                                            <label class="form-check-label" for="soja">Soja</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maiz" onchange="handleChange(this);" value="maíz">
                                            <label class="form-check-label" for="maiz">Maíz</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="trigo" onchange="handleChange(this);" value="trigo">
                                            <label class="form-check-label" for="trigo">Trigo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="girasol" onchange="handleChange(this);" value="girasol">
                                            <label class="form-check-label" for="girasol">Girasol</label>
                                        </div>
                                        <div class="form-check form-check-inline" hidden>
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="siembra" onchange="handleChange(this);" value="siembra">
                                            <label class="form-check-label" for="siembra">Siembra</label>
                                        </div>
                                    </div>
                                @endisset
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label for="desde" class="col-md-4 col-form-label text-md-right">{{ __('Desde') }} *</label>

                            <div class="col-md-6">
                                <input id="desde" type="date" class="form-control @error('desde') is-invalid @enderror" name="desde" value="{{ isset($informe->FecIInfo)?$informe->FecIInfo:old('desde') }}" required @if ($habilitar == "NO") readonly @endif autofocus>

                                @error('desde')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hasta" class="col-md-4 col-form-label text-md-right">{{ __('Hasta') }} *</label>

                            <div class="col-md-6">
                                <input id="hasta" type="date" class="form-control @error('hasta') is-invalid @enderror" name="hasta" value="{{ isset($informe->FecFInfo)?$informe->FecFInfo:old('hasta') }}" required @if ((auth()->user()->email <> "dariogarcia@salahnos.com.ar") && ($habilitar == "NO")) readonly @endif autofocus>

                                @error('hasta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="div_plataforma" style="display: none;">
                            <div class="form-group row">
                                <!-- Maquina 0 -->
                                <label for="plataforma0" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma (pies) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maq0" type="text" class="form-control @error('maq0') is-invalid @enderror" name="maq0" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maq0') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="plataforma0" type="number" class="form-control @error('plataforma0') is-invalid @enderror" name="plataforma0" value="{{ old('plataforma0') }}" placeholder="Ej: 40" autofocus>

                                    @error('plataforma0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> 
                            </div> 
                            <div class="form-group row"> 
                                <!-- Maquina 1 -->
                                <label for="plataforma1" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma (pies) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maq1" type="text" class="form-control @error('maq1') is-invalid @enderror" name="maq1" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maq1') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="plataforma1" type="number" class="form-control @error('plataforma1') is-invalid @enderror" name="plataforma1" value="{{ old('plataforma1') }}" placeholder="Ej: 40" autofocus>

                                    @error('plataforma1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> 
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 2 -->
                                <label for="plataforma2" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma (pies) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maq2" type="text" class="form-control @error('maq2') is-invalid @enderror" name="maq2" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maq2') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="plataforma2" type="number" class="form-control @error('plataforma2') is-invalid @enderror" name="plataforma2" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('plataforma2') }}" placeholder="Ej: 40" autofocus>

                                    @error('plataforma2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>        
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 3 -->
                                <label for="plataforma3" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma (pies) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maq3" type="text" class="form-control @error('maq3') is-invalid @enderror" name="maq3" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maq3') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="plataforma3" type="number" class="form-control @error('plataforma3') is-invalid @enderror" name="plataforma3" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('plataforma3') }}" placeholder="Ej: 40" autofocus>

                                    @error('plataforma3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>        
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 4 -->
                                <label for="plataforma4" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma (pies) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maq4" type="text" class="form-control @error('maq4') is-invalid @enderror" name="maq4" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maq4') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="plataforma4" type="number" class="form-control @error('plataforma4') is-invalid @enderror" name="plataforma4" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('plataforma4') }}" placeholder="Ej: 40" autofocus>

                                    @error('plataforma4')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>        
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 5 -->
                                <label for="plataforma5" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma (pies) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maq5" type="text" class="form-control @error('maq5') is-invalid @enderror" name="maq5" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maq5') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="plataforma5" type="number" class="form-control @error('plataforma5') is-invalid @enderror" name="plataforma5" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('plataforma5') }}" placeholder="Ej: 40" autofocus>

                                    @error('plataforma5')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>        
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 6 -->
                                <label for="plataforma6" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma (pies) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maq6" type="text" class="form-control @error('maq6') is-invalid @enderror" name="maq6" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maq6') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="plataforma6" type="number" class="form-control @error('plataforma6') is-invalid @enderror" name="plataforma6" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('plataforma6') }}" placeholder="Ej: 40" autofocus>

                                    @error('plataforma6')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>        
                            </div>
                        </div>

                        <div id="div_apero" style="display: none;">
                            <div class="form-group row">
                                <!-- Maquina 0 -->
                                <label for="apero0" class="col-md-4 col-form-label text-md-right">{{ __('Maicero/Implemento (mts) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maqm0" type="text" class="form-control @error('maqm0') is-invalid @enderror" name="maqm0" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maqm0') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="apero0" type="number" step="0.01" class="form-control @error('apero0') is-invalid @enderror" name="apero0" value="{{ isset($maquinas->MaicMaq)?$maquinas->MaicMaq:old('apero0') }}" placeholder="Ej: 8.40" autofocus>

                                    @error('apero0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 1 -->
                                <label for="apero1" class="col-md-4 col-form-label text-md-right">{{ __('Maicero/Implemento (mts) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maqm1" type="text" class="form-control @error('maqm1') is-invalid @enderror" name="maqm1" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maqm1') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="apero1" type="number" step="0.01" class="form-control @error('apero1') is-invalid @enderror" name="apero1" value="{{ isset($maquinas->MaicMaq)?$maquinas->MaicMaq:old('apero1') }}" placeholder="Ej: 8.40" autofocus>

                                    @error('apero1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 2 -->
                                <label for="apero2" class="col-md-4 col-form-label text-md-right">{{ __('Maicero/Implemento (mts) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maqm2" type="text" class="form-control @error('maqm2') is-invalid @enderror" name="maqm2" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maqm2') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="apero2" type="number" step="0.01" class="form-control @error('apero2') is-invalid @enderror" name="apero2" value="{{ isset($maquinas->MaicMaq)?$maquinas->MaicMaq:old('apero2') }}" placeholder="Ej: 8.40" autofocus>

                                    @error('apero2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 3 -->
                                <label for="apero3" class="col-md-4 col-form-label text-md-right">{{ __('Maicero/Implemento (mts) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maqm3" type="text" class="form-control @error('maqm3') is-invalid @enderror" name="maqm3" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maqm3') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="apero3" type="number" step="0.01" class="form-control @error('apero3') is-invalid @enderror" name="apero3" value="{{ isset($maquinas->MaicMaq)?$maquinas->MaicMaq:old('apero3') }}" placeholder="Ej: 8.40" autofocus>

                                    @error('apero3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 4 -->
                                <label for="apero4" class="col-md-4 col-form-label text-md-right">{{ __('Maicero/Implemento (mts) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maqm4" type="text" class="form-control @error('maqm4') is-invalid @enderror" name="maqm4" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maqm4') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="apero4" type="number" step="0.01" class="form-control @error('apero4') is-invalid @enderror" name="apero4" value="{{ isset($maquinas->MaicMaq)?$maquinas->MaicMaq:old('apero4') }}" placeholder="Ej: 8.40" autofocus>

                                    @error('apero4')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 5 -->
                                <label for="apero5" class="col-md-4 col-form-label text-md-right">{{ __('Maicero/Implemento (mts) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maqm5" type="text" class="form-control @error('maqm5') is-invalid @enderror" name="maqm5" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maqm5') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="apero5" type="number" step="0.01" class="form-control @error('apero5') is-invalid @enderror" name="apero5" value="{{ isset($maquinas->MaicMaq)?$maquinas->MaicMaq:old('apero5') }}" placeholder="Ej: 8.40" autofocus>

                                    @error('apero5')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- Maquina 6 -->
                                <label for="apero6" class="col-md-4 col-form-label text-md-right">{{ __('Maicero/Implemento (mts) *') }} </label>
                                <div class="col-lg-4">
                                    <input id="maqm6" type="text" class="form-control @error('maqm6') is-invalid @enderror" name="maqm6" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('maqm6') }}" disabled autofocus>
                                </div>
                                <br>
                                <div class="col-lg-2">
                                    <input id="apero6" type="number" step="0.01" class="form-control @error('apero6') is-invalid @enderror" name="apero6" value="{{ isset($maquinas->MaicMaq)?$maquinas->MaicMaq:old('apero6') }}" placeholder="Ej: 8.40" autofocus>

                                    @error('apero6')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <div class="text-center" id="carga" name="carga" style="display: none">
                                    <div class="spinner-border text-secondary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                </div>
                                <button id="crear" type="submit" class="btn btn-success">Crear informe</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    window.addEventListener('unload', function(event) {
        divcarga.style.display='none';
      });

function radiosCheck()
{
    div_plataforma = document.getElementById("div_plataforma"); 
    div_apero = document.getElementById("div_apero");

    if ((document.getElementById('maiz').checked) || (document.getElementById('siembra').checked) || (document.getElementById('girasol').checked)){
        div_plataforma.style.display='none';
        div_apero.style.display='block';
    } else {
        div_plataforma.style.display='block';
        div_apero.style.display='none';      
    }
}

window.onload = radiosCheck();

$("#informef").submit(function(e){
        divcarga = document.getElementById("carga");
        divcarga.style.display='block';
});

$('input[type=radio][name=inlineRadioOptions]').change(function() {
    var implemento = '';
    var NumSMaq = $('#NumSMaq').val();
    var cultivo = this.value;
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url:"{{ route('utilidad.cargaImplemento') }}",
        method:"POST",
        data:{NumSMaq:NumSMaq, _token:_token, cultivo:cultivo},
        success:function(result)
        {
            implemento = result;

            if ((cultivo == 'maíz') || (cultivo == 'girasol')) {
                div_plataforma.style.display='none';
                div_apero.style.display='block';
                $('#apero').val(implemento);
            } else {
                div_plataforma.style.display='block';
                div_apero.style.display='none';
                $('#plataforma').val(implemento);
            }
        }
    })

});

        $('#crear').click(function(){
            deshabilitar();
            divcarga = document.getElementById("carga_ralenti_lleno");
            divcarga.style.display='block';
        });

        $('#CodiOrga').change(function(){
            
            if ($(this).val() != ''){ 
                var select = $(this).attr("id");
                var value = $(this).val();             
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('utilidad.fetchss') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#NumSMaq').html(result); 
                        $("#NumSMaq").multipleSelect({
                            filter: true
                        });
                        
                    }
                })
            }
        });

        $('#NumSMaq').change(function(){
            
            if ($(this).val() != ''){ 
                var implemento = '';
                var NumSMaq = $(this).val();
                var cultivo = '';
                if (document.getElementById('maiz').checked){
                    cultivo = document.getElementById('maiz').value;
                } else{
                    if (document.getElementById('girasol').checked){
                    cultivo = document.getElementById('girasol').value;
                    } else{
                        if (document.getElementById('soja').checked){
                            cultivo = document.getElementById('soja').value;
                        } else{
                            cultivo = document.getElementById('trigo').value;
                        }
                    }
                }
                var _token = $('input[name="_token"]').val();
                tipocultivo = document.getElementById("cultivo");

                $.ajax({
                    url:"{{ route('utilidad.verificaTipoMaquina') }}",
                    method:"POST",
                    data:{NumSMaq:NumSMaq, _token:_token},
                    success:function(result)
                    {
                        if (result == "COSECHADORA"){
                            tipocultivo.style.display='block';
                            if ((cultivo == 'maíz') || (cultivo == 'girasol')) {
                                div_plataforma.style.display='none';
                                div_apero.style.display='block';
                            } else {
                                div_plataforma.style.display='block';
                                div_apero.style.display='none';
                            }
                        }else{
                            tipocultivo.style.display='none';
                            div_plataforma.style.display='none';
                            div_apero.style.display='block';
                        }
                    }
                    
                })
                $.ajax({
                    url:"{{ route('utilidad.verificaTipoMaquinaApero') }}",
                    method:"POST",
                    data:{NumSMaq:NumSMaq, _token:_token, cultivo:cultivo},
                    dataType: "JSON",
                    success:function(result)
                    {  
                        //Coloca en cero a todos los valores
                        for (let i = 0; i < 7; i++) {
                            $('#maq'+i).val('');
                            $('#maqm'+i).val('');
                            $('#plataforma'+i).val(''); 
                            $('#apero'+i).val('');   
                        }
                        $.each(result, function (index,value) {
                            $('#maq'+index).val(result[index][0]);
                            $('#maqm'+index).val(result[index][0]);
                            $('#plataforma'+index).val(result[index][1]); 
                            $('#apero'+index).val(result[index][2]);   
                        });
                    }
                })

            } else {
                tipocultivo.style.display='none';
            }
        });
    }); 
</script>
@endsection

@endsection
