<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

<div class="form-group row">
    <label for="surcos" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de hileras') }} *</label>

    <div class="col-md-6">
        <input id="surcos" type="number" class="form-control" name="surcos" value="{{ isset($usado->surcos)?$usado->surcos:old('surcos') }}" autocomplete="surcos" autofocus>
        <span class="text-danger" id="surcosError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="espaciamiento" class="col-md-4 col-form-label text-md-right">{{ __('Espaciamiento (mts)') }} *</label>

    <div class="col-md-6">
        <input id="espaciamiento" type="number" step="0.01" class="form-control" name="espaciamiento" value="{{ isset($usado->espaciamiento)?$usado->espaciamiento:old('espaciamiento') }}" autocomplete="espaciamiento" autofocus>
        <span class="text-danger" id="espaciamientoError"></span>
    </div>
</div>


    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso2-plataforma_maiz" class="btn btn-warning">Siguiente</button>
        </div>
    </div>

