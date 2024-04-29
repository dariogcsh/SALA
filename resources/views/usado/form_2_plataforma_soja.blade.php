<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

<div class="form-group row">
    <label for="ancho_plataforma" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de pies') }} *</label>

    <div class="col-md-6">
        <input id="ancho_plataforma" type="number" class="form-control" name="ancho_plataforma" value="{{ isset($usado->ancho_plataforma)?$usado->ancho_plataforma:old('ancho_plataforma') }}" autocomplete="ancho_plataforma" autofocus>
        <span class="text-danger" id="ancho_plataformaError"></span>
    </div>
</div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso2-plataforma_soja" class="btn btn-warning">Siguiente</button>
        </div>
    </div>

