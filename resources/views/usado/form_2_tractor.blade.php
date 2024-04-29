<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

<div class="form-group row">
    <label for="traccion" class="col-md-4 col-form-label text-md-right">{{ __('Tracción') }} *</label>

    <div class="col-md-6">
        <select class="form-control @error('traccion') is-invalid @enderror" id="traccion" name="traccion" value="{{ isset($usado->traccion)?$usado->traccion:old('traccion') }}" required autocomplete="traccion" autofocus>
            @isset($usado->traccion)
                <option value="{{ $usado->traccion }}">{{ $usado->traccion }}</option>
            @else
                <option value="">Seleccionar</option>
            @endisset
                <option value="Simple">Simple</option>
                <option value="Doble">Doble</option>
                
        </select>
        <span class="text-danger" id="traccionError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="rodado" class="col-md-4 col-form-label text-md-right">{{ __('Rodado') }} *</label>

    <div class="col-md-6">
        <select class="form-control @error('rodado') is-invalid @enderror" id="rodado" name="rodado" value="{{ isset($usado->rodado)?$usado->rodado:old('rodado') }}" required autocomplete="rodado" autofocus>
            @isset($usado->rodado)
                <option value="{{ $usado->rodado }}">{{ $usado->traccion }}</option>
            @else
                <option value="">Seleccionar</option>
            @endisset
                <option value="Simple">Simple</option>
                <option value="Dual">Dual</option>
                
        </select>
        <span class="text-danger" id="rodadoError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="horasm" class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor') }} *</label>

    <div class="col-md-6">
        <input id="horasm" type="number" class="form-control" name="horasm" value="{{ isset($usado->horasm)?$usado->horasm:old('horasm') }}" autocomplete="horasm" autofocus>
        <span class="text-danger" id="horasmError"></span>
        
    </div>
</div>

<div class="form-group row">
    <label for="cabina" class="col-md-4 col-form-label text-md-right">{{ __('Cabina') }}</label>

    <div class="col-md-6">
        <label class="switch">
            @isset($usado->cabina)
                @if($usado->cabina == 'SI')
                    <input type="checkbox" class="warning" id="cabina" name="cabina" checked>
                @else
                    <input type="checkbox" class="warning" id="cabina" name="cabina">
                @endif
            @else
                <input type="checkbox" class="warning" id="cabina" name="cabina">
            @endisset
            
            <span class="slider round"></span>
        </label>
    </div>
</div>

<div class="form-group row">
    <label for="hp" class="col-md-4 col-form-label text-md-right">{{ __('HP') }} *</label>

    <div class="col-md-6">
        <input id="hp" type="number" class="form-control @error('hp') is-invalid @enderror" name="hp" value="{{ isset($usado->hp)?$usado->hp:old('hp') }}" autocomplete="hp" autofocus>

        <span class="text-danger" id="hpError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="transmision" class="col-md-4 col-form-label text-md-right">{{ __('Transmisión') }} *</label>

    <div class="col-md-6">
        <input id="transmision" type="text" class="form-control @error('transmision') is-invalid @enderror" name="transmision" value="{{ isset($usado->transmision)?$usado->transmision:old('transmision') }}" autocomplete="transmision" autofocus>

        <span class="text-danger" id="transmisionError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="nseriemotor" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie de motor') }}</label>

    <div class="col-md-6">
        <input id="nseriemotor" type="text" class="form-control @error('nseriemotor') is-invalid @enderror" name="nseriemotor" value="{{ isset($usado->nseriemotor)?$usado->nseriemotor:old('nseriemotor') }}" autocomplete="nseriemotor" autofocus>

        <span class="text-danger" id="nseriemotorError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="tomafuerza" class="col-md-4 col-form-label text-md-right">{{ __('Toma de fuerza') }} *</label>

    <div class="col-md-6">
        <label class="switch">
            @isset($usado->tomafuerza)
                @if($usado->tomafuerza == 'SI')
                    <input type="checkbox" class="warning" id="tomafuerza" name="tomafuerza" checked>
                @else
                    <input type="checkbox" class="warning" id="tomafuerza" name="tomafuerza">
                @endif
            @else
                <input type="checkbox" class="warning" id="tomafuerza" name="tomafuerza">
            @endisset
            <span class="slider round"></span>
        </label>
    </div>
</div>

<div class="form-group row">
    <label for="bombah" class="col-md-4 col-form-label text-md-right">{{ __('Bomba hidráulica') }} *</label>

    <div class="col-md-6">
        <input id="bombah" type="text" class="form-control @error('bombah') is-invalid @enderror" name="bombah" value="{{ isset($usado->bombah)?$usado->bombah:old('bombah') }}" autocomplete="bombah" autofocus>

        <span class="text-danger" id="bombahError"></span>
    </div>
</div>


    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso2-tractor" class="btn btn-warning">Siguiente</button>
        </div>
    </div>

