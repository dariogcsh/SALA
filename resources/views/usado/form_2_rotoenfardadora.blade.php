<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

<div class="form-group row">
    <label for="configuracion_roto" class="col-md-4 col-form-label text-md-right">{{ __('Configuración') }} *</label>

    <div class="col-md-6">
        <select class="form-control @error('configuracion_roto') is-invalid @enderror" id="configuracion_roto" name="configuracion_roto" value="{{ isset($usado->configuracion_roto)?$usado->configuracion_roto:old('configuracion_roto') }}" required autocomplete="configuracion_roto" autofocus>
            @isset($usado->configuracion_roto)
                <option value="{{ $usado->configuracion_roto }}">{{ $usado->configuracion_roto }}</option>
            @else
                <option value="">Seleccionar</option>
            @endisset
                <option value="Rollo grande">Rollo grande (1,50m)</option>
                <option value="Rollo chico">Rollo chico (1,20m)</option>
                
        </select>
        <span class="text-danger" id="configuracion_rotoError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="cantidad_rollos" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad rollos') }} *</label>

    <div class="col-md-6">
        <input id="cantidad_rollos" type="number" class="form-control" name="cantidad_rollos" value="{{ isset($usado->cantidad_rollos)?$usado->cantidad_rollos:old('cantidad_rollos') }}" autocomplete="cantidad_rollos" autofocus>
        <span class="text-danger" id="cantidad_rollosError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="monitor_roto" class="col-md-4 col-form-label text-md-right">{{ __('Monitor') }}</label>

    <div class="col-md-6">
        <label class="switch">
            @isset($usado->monitor_roto)
                @if($usado->monitor_roto == 'SI')
                    <input type="checkbox" class="warning" id="monitor_roto" name="monitor_roto" checked>
                @else
                    <input type="checkbox" class="warning" id="monitor_roto" name="monitor_roto">
                @endif
            @else
                <input type="checkbox" class="warning" id="monitor_roto" name="monitor_roto">
            @endisset
            <span class="slider round"></span>
        </label>
    </div>
</div>

<div class="form-group row">
    <label for="cutter" class="col-md-4 col-form-label text-md-right">{{ __('Cutter') }}</label>

    <div class="col-md-6">
        <label class="switch">
            @isset($usado->cutter)
                @if($usado->cutter == 'SI')
                    <input type="checkbox" class="warning" id="cutter" name="cutter" checked>
                @else
                    <input type="checkbox" class="warning" id="cutter" name="cutter">
                @endif
            @else
                <input type="checkbox" class="warning" id="cutter" name="cutter">
            @endisset
            <span class="slider round"></span>
        </label>
    </div>
</div>


    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso2-rotoenfardadora" class="btn btn-warning">Siguiente</button>
        </div>
    </div>

