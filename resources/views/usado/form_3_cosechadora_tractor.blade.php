@php
    use App\usado;
@endphp
<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 


<div class="form-group row">
    <label for="id_conectividad" class="col-md-4 col-form-label text-md-right">{{ __('Conectividad') }}</label>

    <div class="col-md-6">
        <select class="form-control @error('id_conectividad') is-invalid @enderror" id="id_conectividad" name="id_conectividad" value="{{ isset($usado->id_conectividad)?$usado->id_conectividad:old('id_conectividad') }}" autocomplete="id_conectividad" autofocus>
            <option value="">Seleccionar</option>
            @isset($usado->id_conectividad)
                @foreach($conectividads as $conectividad)
                <option value="{{ $conectividad->id }}"
                @if($usado->id_conectividad == $conectividad->id)
                    selected
                @endif
                >{{ $conectividad->nombre }}</option>
               @endforeach
            @else
                @foreach($conectividads as $conectividad)
                        <option value="{{ $conectividad->id }}">{{ $conectividad->nombre }}</option>
                @endforeach
            @endisset
                
        </select>
        <span class="text-danger" id="id_conectividadError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="agprecision" class="col-md-4 col-form-label text-md-right">{{ __('AutoTrac (Piloto)') }}</label>

    <div class="col-md-6">
        <label class="switch">
            @isset($usado->agprecision)
                @if($usado->agprecision == 'SI')
                    <input type="checkbox" class="warning" id="agprecision" name="agprecision" checked>
                @else
                    <input type="checkbox" class="warning" id="agprecision" name="agprecision">
                @endif
            @else
                <input type="checkbox" class="warning" id="agprecision" name="agprecision">
            @endisset
            <span class="slider round"></span>
        </label>
    </div>
</div>

<div class="form-group row">
    <label for="id_antena" class="col-md-4 col-form-label text-md-right">{{ __('Antena') }}</label>

    <div class="col-md-6">
        <select class="form-control @error('id_antena') is-invalid @enderror" id="id_antena" name="id_antena" value="{{ isset($usado->id_antena)?$usado->id_antena:old('id_antena') }}" autocomplete="id_antena" autofocus>
            <option value="">Seleccionar</option>
            @isset($usado->id_antena)
                @foreach($antenas as $antena)
                <option value="{{ $antena->id }}"
                @if($usado->id_antena == $antena->id)
                    selected
                @endif
                >{{ $antena->NombAnte }}</option>
               @endforeach
            @else
                @foreach($antenas as $antena)
                        <option value="{{ $antena->id }}">{{ $antena->NombAnte }}</option>
                @endforeach
            @endisset
                
        </select>
        <span class="text-danger" id="id_antenaError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="activacion_antena" class="col-md-4 col-form-label text-md-right">{{ __('Activaciones de antena') }} </label>

    <div class="col-md-6">
        <input id="activacion_antena" type="text" class="form-control @error('activacion_antena') is-invalid @enderror" name="activacion_antena" value="{{ isset($usado->activacion_antena)?$usado->activacion_antena:old('activacion_antena') }}" autocomplete="activacion_antena" autofocus>

        <span class="text-danger" id="rodadoError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="id_pantalla" class="col-md-4 col-form-label text-md-right">{{ __('Pantalla') }}</label>

    <div class="col-md-6">
        <select class="form-control @error('id_pantalla') is-invalid @enderror" id="id_pantalla" name="id_pantalla" value="{{ isset($usado->id_pantalla)?$usado->id_pantalla:old('id_pantalla') }}" autocomplete="id_pantalla" autofocus>
            <option value="">Seleccionar</option>
            @isset($usado->id_pantalla)
                @foreach($pantallas as $pantalla)
                <option value="{{ $pantalla->id }}"
                @if($usado->id_pantalla == $pantalla->id)
                    selected
                @endif
                >{{ $pantalla->NombPant }}</option>
               @endforeach
            @else
                @foreach($pantallas as $pantalla)
                        <option value="{{ $pantalla->id }}">{{ $pantalla->NombPant }}</option>
                @endforeach
            @endisset
               
                
        </select>
        <span class="text-danger" id="id_pantallaError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="activacion_pantalla" class="col-md-4 col-form-label text-md-right">{{ __('Activaciones de pantalla') }} </label>

    <div class="col-md-6">
        <input id="activacion_pantalla" type="text" class="form-control @error('activacion_pantalla') is-invalid @enderror" name="activacion_pantalla" value="{{ isset($usado->activacion_pantalla)?$usado->activacion_pantalla:old('activacion_pantalla') }}" autocomplete="activacion_pantalla" autofocus>

        <span class="text-danger" id="rodadoError"></span>
    </div>
</div>
@isset($usado)
@else
    @php
    $usado = Usado::where('id',$id_usado)->first();
@endphp
@endisset

@if($usado->tipo == 'COSECHADORA')

    <div class="form-group row">
        <label for="camaras" class="col-md-4 col-form-label text-md-right">{{ __('Camaras') }}</label>

        <div class="col-md-6">
            <label class="switch">
                @isset($usado->camaras)
                    @if($usado->camaras == 'SI')
                        <input type="checkbox" class="warning" id="camaras" name="camaras" checked>
                    @else
                        <input type="checkbox" class="warning" id="camaras" name="camaras">
                    @endif
                @else
                    <input type="checkbox" class="warning" id="camaras" name="camaras">
                @endisset
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="form-group row">
        <label for="prodrive" class="col-md-4 col-form-label text-md-right">{{ __('(Harvest Smart (Pro Drive))') }}</label>

        <div class="col-md-6">
            <label class="switch">
                @isset($usado->prodrive)
                    @if($usado->prodrive == 'SI')
                        <input type="checkbox" class="warning" id="prodrive" name="prodrive" checked>
                    @else
                        <input type="checkbox" class="warning" id="prodrive" name="prodrive">
                    @endif
                @else
                    <input type="checkbox" class="warning" id="prodrive" name="prodrive">
                @endisset
                <span class="slider round"></span>
            </label>
        </div>
    </div>
@else
<div class="form-group row">
<div class="col-md-6">
    <label class="switch">
            <input hidden type="checkbox" class="warning" id="prodrive" name="prodrive">
    </label>
</div>
<div class="col-md-6">
    <label class="switch">
            <input hidden type="checkbox" class="warning" id="camaras" name="camaras">
    </label>
</div>
</div>
@endif

<div class="form-group row">
    <label for="nrodado" class="col-md-4 col-form-label text-md-right">{{ __('N° de rodado delantero') }} *</label>

    <div class="col-md-6">
        <input id="nrodado" type="text" class="form-control @error('nrodado') is-invalid @enderror" name="nrodado" value="{{ isset($usado->nrodado)?$usado->nrodado:old('nrodado') }}" autocomplete="nrodado" autofocus>

        <span class="text-danger" id="rodadoError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="nrodadotras" class="col-md-4 col-form-label text-md-right">{{ __('N° de rodado trasero') }} *</label>

    <div class="col-md-6">
        <input id="nrodadotras" type="text" class="form-control @error('nrodadotras') is-invalid @enderror" name="nrodadotras" value="{{ isset($usado->nrodadotras)?$usado->nrodadotras:old('nrodadotras') }}" autocomplete="nrodadotras" autofocus>

        <span class="text-danger" id="rodadotrasError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="rodadoest" class="col-md-4 col-form-label text-md-right">{{ __('Estado del rodado delantero (%)') }} </label>

    <div class="col-md-6">
        <input id="rodadoest" min="1" max="100" type="number" class="form-control @error('rodadoest') is-invalid @enderror" name="rodadoest" value="{{ isset($usado->rodadoest)?$usado->rodadoest:old('rodadoest') }}" autocomplete="rodadoest" autofocus>

        <span class="text-danger" id="rodadoestError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="rodadoesttras" class="col-md-4 col-form-label text-md-right">{{ __('Estado del rodado trasero (%)') }} </label>

    <div class="col-md-6">
        <input id="rodadoesttras" min="1" max="100" type="number" class="form-control @error('rodadoesttras') is-invalid @enderror" name="rodadoesttras" value="{{ isset($usado->rodadoesttras)?$usado->rodadoesttras:old('rodadoesttras') }}" autocomplete="rodadoesttras" autofocus>

        <span class="text-danger" id="rodadoesttrasError"></span>
    </div>
</div>


    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso3-cosechadora-tractor" class="btn btn-warning">Siguiente</button>
        </div>
    </div>
