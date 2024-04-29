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
    <label for="horast" class="col-md-4 col-form-label text-md-right">{{ __('Horas de trilla') }} *</label>

    <div class="col-md-6">
        <input id="horast" type="number" class="form-control @error('horast') is-invalid @enderror" name="horast" value="{{ isset($usado->horast)?$usado->horast:old('horast') }}" autocomplete="horast" autofocus>

        <span class="text-danger" id="horastError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="plataforma" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma') }} *</label>

    <div class="col-md-6">
        <input id="plataforma" type="text" class="form-control @error('plataforma') is-invalid @enderror" name="plataforma" value="{{ isset($usado->plataforma)?$usado->plataforma:old('plataforma') }}" autocomplete="plataforma" autofocus>

        <span class="text-danger" id="plataformaError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="desparramador" class="col-md-4 col-form-label text-md-right">{{ __('Desparramador') }} *</label>

    <div class="col-md-6">
        <input id="desparramador" type="text" class="form-control @error('desparramador') is-invalid @enderror" name="desparramador" value="{{ isset($usado->desparramador)?$usado->desparramador:old('desparramador') }}" autocomplete="desparramador" autofocus>

        <span class="text-danger" id="desparramadorError"></span>
    </div>
</div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso2-cosechadora" class="btn btn-warning">Siguiente</button>
        </div>
    </div>

