<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

<div class="form-group row">
    <label for="nrodado" class="col-md-4 col-form-label text-md-right">{{ __('N° de rodado') }} *</label>

    <div class="col-md-6">
        <input id="nrodado" type="text" class="form-control @error('nrodado') is-invalid @enderror" name="nrodado" value="{{ isset($usado->nrodado)?$usado->nrodado:old('nrodado') }}" autocomplete="nrodado" autofocus>

        <span class="text-danger" id="rodadoError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="rodadoest" class="col-md-4 col-form-label text-md-right">{{ __('Estado del rodado (%)') }} </label>

    <div class="col-md-6">
        <input id="rodadoest" min="1" max="100" type="number" class="form-control @error('rodadoest') is-invalid @enderror" name="rodadoest" value="{{ isset($usado->rodadoest)?$usado->rodadoest:old('rodadoest') }}" autocomplete="rodadoest" autofocus>

        <span class="text-danger" id="rodadoestError"></span>
    </div>
</div>


    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso3-sembradora" class="btn btn-warning">Siguiente</button>
        </div>
    </div>
