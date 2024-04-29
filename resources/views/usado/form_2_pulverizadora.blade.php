<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

<div class="form-group row">
    <label for="horasm" class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor') }} *</label>

    <div class="col-md-6">
        <input id="horasm" type="number" class="form-control" name="horasm" value="{{ isset($usado->horasm)?$usado->horasm:old('horasm') }}" autocomplete="horasm" autofocus>
        <span class="text-danger" id="horasmError"></span>
        
    </div>
</div>
<div class="form-group row">
    <label for="botalon" class="col-md-4 col-form-label text-md-right">{{ __('Botalon') }} *</label>

    <div class="col-md-6">
        <input id="botalon" type="text" class="form-control @error('botalon') is-invalid @enderror" name="botalon" value="{{ isset($usado->botalon)?$usado->botalon:old('botalon') }}" autocomplete="botalon" autofocus>

        <span class="text-danger" id="botalonError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="tanque" class="col-md-4 col-form-label text-md-right">{{ __('Tanque (Lts)') }} *</label>

    <div class="col-md-6">
        <input id="tanque" type="number" class="form-control @error('tanque') is-invalid @enderror" name="tanque" value="{{ isset($usado->tanque)?$usado->tanque:old('tanque') }}" autocomplete="tanque" autofocus>

        <span class="text-danger" id="tanqueError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="picos" class="col-md-4 col-form-label text-md-right">{{ __('Picos') }} *</label>

    <div class="col-md-6">
        <input id="picos" type="text" class="form-control @error('picos') is-invalid @enderror" name="picos" value="{{ isset($usado->picos)?$usado->picos:old('picos') }}" autocomplete="picos" autofocus>

        <span class="text-danger" id="picosError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="corte" class="col-md-4 col-form-label text-md-right">{{ __('Corte por secciones') }}</label>

    <div class="col-md-6">
        <label class="switch">
            @isset($usado->corte)
                @if($usado->corte == 'SI')
                    <input type="checkbox" class="warning" id="corte" name="corte" checked>
                @else
                    <input type="checkbox" class="warning" id="corte" name="corte">
                @endif
            @else
                <input type="checkbox" class="warning" id="corte" name="corte">
            @endisset
            <span class="slider round"></span>
        </label>
    </div>
</div>


    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso2-pulverizadora" class="btn btn-warning">Siguiente</button>
        </div>
    </div>


