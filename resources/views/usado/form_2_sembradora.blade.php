<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

<div class="form-group row">
    <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }} *</label>

    <div class="col-md-6">
        <input id="categoria" type="text" class="form-control @error('categoria') is-invalid @enderror" name="categoria" value="{{ isset($usado->categoria)?$usado->categoria:old('categoria') }}" autocomplete="categoria" autofocus>

        <span class="text-danger" id="categoriaError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="surcos" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de surcos') }} *</label>

    <div class="col-md-6">
        <input id="surcos" type="number" class="form-control @error('surcos') is-invalid @enderror" name="surcos" value="{{ isset($usado->surcos)?$usado->surcos:old('surcos') }}" autocomplete="surcos" autofocus>

        <span class="text-danger" id="surcosError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="distancia" class="col-md-4 col-form-label text-md-right">{{ __('Distancia entre surcos') }} *</label>

    <div class="col-md-6">
        <input id="distancia" type="number" class="form-control @error('distancia') is-invalid @enderror" name="distancia" value="{{ isset($usado->distancia)?$usado->distancia:old('distancia') }}" autocomplete="distancia" autofocus>

        <span class="text-danger" id="distanciaError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="monitor" class="col-md-4 col-form-label text-md-right">{{ __('Monitor') }} *</label>

    <div class="col-md-6">
        <input id="monitor" type="text" class="form-control @error('monitor') is-invalid @enderror" name="monitor" value="{{ isset($usado->monitor)?$usado->monitor:old('monitor') }}" autocomplete="monitor" autofocus>

        <span class="text-danger" id="monitorError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="dosificacion" class="col-md-4 col-form-label text-md-right">{{ __('Dosificacion') }} *</label>

    <div class="col-md-6">
        <input id="dosificacion" type="text" class="form-control @error('dosificacion') is-invalid @enderror" name="dosificacion" value="{{ isset($usado->dosificacion)?$usado->dosificacion:old('dosificacion') }}" autocomplete="dosificacion" autofocus>

        <span class="text-danger" id="dosificacionError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="fertilizacion" class="col-md-4 col-form-label text-md-right">{{ __('Fertilización') }} *</label>

    <div class="col-md-6">
        <input id="fertilizacion" type="text" class="form-control @error('fertilizacion') is-invalid @enderror" name="fertilizacion" value="{{ isset($usado->fertilizacion)?$usado->fertilizacion:old('fertilizacion') }}" autocomplete="fertilizacion" autofocus>

        <span class="text-danger" id="fertilizacionError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="tolva" class="col-md-4 col-form-label text-md-right">{{ __('Cap. de tolva (Lts)') }} *</label>

    <div class="col-md-6">
        <input id="tolva" type="number" class="form-control @error('tolva') is-invalid @enderror" name="tolva" value="{{ isset($usado->tolva)?$usado->tolva:old('tolva') }}" autocomplete="tolva" autofocus>

        <span class="text-danger" id="tolvaError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="fertilizante" class="col-md-4 col-form-label text-md-right">{{ __('Cap. de fertilizante') }} *</label>

    <div class="col-md-6">
        <input id="fertilizante" type="text" class="form-control @error('fertilizante') is-invalid @enderror" name="fertilizante" value="{{ isset($usado->fertilizante)?$usado->fertilizante:old('fertilizante') }}" autocomplete="fertilizante" autofocus>

        <span class="text-danger" id="fertilizanteError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="reqhidraulico" class="col-md-4 col-form-label text-md-right">{{ __('Requerimiento hidráulico') }} *</label>

    <div class="col-md-6">
        <input id="reqhidraulico" type="text" class="form-control @error('reqhidraulico') is-invalid @enderror" name="reqhidraulico" value="{{ isset($usado->reqhidraulico)?$usado->reqhidraulico:old('reqhidraulico') }}" autocomplete="reqhidraulico" autofocus>

        <span class="text-danger" id="reqhidraulicoError"></span>
    </div>
</div>


    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso2-sembradora" class="btn btn-warning">Siguiente</button>
        </div>
    </div>

