                        
                        
<p><small> Los campos marcados con * son de caracter obligatorio</small></p> 



    <div class="form-group row">
        <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de máquina') }} *</label>

        <div class="col-md-6">
        @if ($modo == 'crear')
            <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ old('tipo') }}" autofocus>
        @else
            <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ isset($usado->tipo)?$usado->tipo:old('tipo') }}" disabled autofocus>
        @endif   
            @isset($usado->tipo)
                <option value="{{ $usado->tipo }}">{{ $usado->tipo }}</option>
            @else
                <option value="">Seleccionar</option>
            @endisset
                <option value="COSECHADORA">COSECHADORA</option>
                <option value="TRACTOR">TRACTOR</option>
                <option value="PULVERIZADORA">PULVERIZADORA</option>
                <option value="SEMBRADORA">SEMBRADORA</option>
                <option value="PLATAFORMA DE MAIZ">PLATAFORMA DE MAIZ</option>
                <option value="PLATAFORMA DE GIRASOL">PLATAFORMA DE GIRASOL</option>
                <option value="PLATAFORMA SINFIN">PLATAFORMA SINFIN</option>
                <option value="PLATAFORMA DRAPER">PLATAFORMA DRAPER</option>
                <option value="ROTOENFARDADORA">ROTOENFARDADORA</option>
        </select>

        <span class="text-danger" id="tipoError"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="marca" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }} *</label>

        <div class="col-md-6">
            @if ($modo == 'crear')
                <select class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{ old('marca') }}" autofocus>
            @else
                <select class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{ isset($usado->marca)?$usado->marca:old('marca') }}" autofocus>
                    <option value="{{ $usado->marca }}">{{ $usado->marca }}</option>
                @isset($usado->tipo)
                    @if ($usado->tipo == "COSECHADORA")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="MASSEY FERGUSON">MASSEY FERGUSON</option>
                        <option value="CASE IH">CASE IH</option>
                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                        <option value="CLASS">CLASS</option>
                        <option value="OTRA">OTRA</option>
                    @elseif ($usado->tipo == "TRACTOR")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="MASSEY FERGUSON">MASSEY FERGUSON</option>
                        <option value="CASE IH">CASE IH</option>
                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                        <option value="PAUNY">PAUNY</option>
                        <option value="VALTRA">VALTRA</option>
                        <option value="AGCO ALIS">AGCO ALIS</option>
                        <option value="OTRA">OTRA</option>
                    @elseif($usado->tipo == "PULVERIZADORA")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="PLA">PLA</option>
                        <option value="METALFOR">METALFOR</option>
                        <option value="CAIMAN">CAIMAN</option>
                        <option value="JACTO">JACTO</option>
                        <option value="OTRA">OTRA</option>
                    @elseif($usado->tipo == "SEMBRADORA")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="PLA">PLA</option>
                        <option value="AGROMETAL">AGROMETAL</option>
                        <option value="PIEROBON">PIEROBON</option>
                        <option value="CRUCIANELLI">CRUCIANELLI</option>
                        <option value="CELA">CELA</option>
                        <option value="ASCANELLI">ASCANELLI</option>
                        <option value="FERCAM">FERCAM</option>
                        <option value="SUPER WALTER">SUPER WALTER</option>
                        <option value="TANZZI">TANZZI</option>
                        <option value="ERCA">ERCA</option>
                        <option value="APACHE">APACHE</option>
                        <option value="FABIGAM">FABIGAM</option>
                        <option value="OTRA">OTRA</option>
                    @elseif($usado->tipo == "PLATAFORMA DE MAIZ")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="CASE">CASE</option>
                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                        <option value="MAINERO">MAINERO</option>
                        <option value="ALLOCHIS">ALLOCHIS</option>
                        <option value="MAZCO">MAZCO</option>
                        <option value="OMBU">OMBU</option>
                        <option value="PIERSANTI">PIERSANTI</option>
                        <option value="DEGRANDE">DEGRANDE</option>
                        <option value="STARA">STARA</option>
                        <option value="OTRA">OTRA</option>
                    @elseif($usado->tipo == "PLATAFORMA DE GIRASOL")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="CASE">CASE</option>
                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                        <option value="MAINERO">MAINERO</option>
                        <option value="YHOMEL">YHOMEL</option>
                        <option value="ALLOCHIS">ALLOCHIS</option>
                        <option value="MAZCO">MAZCO</option>
                        <option value="OMBU">OMBU</option>
                        <option value="PIERSANTI">PIERSANTI</option>
                        <option value="DEGRANDE">DEGRANDE</option>
                        <option value="STARA">STARA</option>
                        <option value="OTRA">OTRA</option>
                    @elseif($usado->tipo == "PLATAFORMA SIN FIN")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="CASE">CASE</option>
                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                        <option value="MAINERO">MAINERO</option>
                        <option value="ALLOCHIS">ALLOCHIS</option>
                        <option value="MAZCO">MAZCO</option>
                        <option value="OMBU">OMBU</option>
                        <option value="PIERSANTI">PIERSANTI</option>
                        <option value="DEGRANDE">DEGRANDE</option>
                        <option value="STARA">STARA</option>
                        <option value="OTRA">OTRA</option>
                    @elseif($usado->tipo == "PLATAFORMA DRAPER")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="CASE">CASE</option>
                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                        <option value="MAINERO">MAINERO</option>
                        <option value="ALLOCHIS">ALLOCHIS</option>
                        <option value="MAZCO">MAZCO</option>
                        <option value="OMBU">OMBU</option>
                        <option value="PIERSANTI">PIERSANTI</option>
                        <option value="DEGRANDE">DEGRANDE</option>
                        <option value="STARA">STARA</option>
                        <option value="OTRA">OTRA</option>
                    @elseif($usado->tipo == "ROTOENFARDADORA")
                        <option value="JOHN DEERE">JOHN DEERE</option>
                        <option value="CASE">CASE</option>
                        <option value="VALTRA">VALTRA</option>
                        <option value="MAINERO">MAINERO</option>
                        <option value="YOMEL">YOMEL</option>
                        <option value="MASSEY FERGUSON">MASSEY FERGUSON</option>
                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                        <option value="IMPLECOR">IMPLECOR</option>
                        <option value="KRONE">KRONE</option>
                        <option value="KUHN">KUHN</option>
                        <option value="CHALLENGER">CHALLENGER</option>
                        <option value="AGCO ALLIS">AGCO ALLIS</option>
                        <option value="MAIZCO">MAIZCO</option>
                        <option value="OTRA">OTRA</option>
                    @endif
                @endisset
                @isset($usado->marca)
                    <option value="{{ $usado->marca }}">{{ $usado->marca }}</option>
                @endisset
            @endif
            </select>

            <span class="text-danger" id="marcaError"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }} *</label>

        <div class="col-md-6">
            <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{ isset($usado->modelo)?$usado->modelo:old('modelo') }}" autocomplete="modelo" placeholder="S780" autofocus>

            <span class="text-danger" id="modeloError"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="ano" class="col-md-4 col-form-label text-md-right">{{ __('Año') }} *</label>

        <div class="col-md-6">
            <input id="ano" type="number" class="form-control @error('ano') is-invalid @enderror" name="ano" value="{{ isset($usado->ano)?$usado->ano:old('ano') }}" autocomplete="ano" placeholder="2020" autofocus>

            <span class="text-danger" id="anoError"></span>
        </div>
    </div>

    <div hidden class="form-group row">
        <label for="nserie" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie') }} *</label>

        <div class="col-md-6">
            <input id="nserie" type="text" class="form-control @error('nserie') is-invalid @enderror" name="nserie" value="{{ isset($usado->nserie)?$usado->nserie:old('nserie') }}" autocomplete="nserie" autofocus>

            <span class="text-danger" id="nserieError"></span>
        </div>
    </div>

    <div hidden class="form-group row">
        <label for="patente" class="col-md-4 col-form-label text-md-right">{{ __('Patente') }}</label>

        <div class="col-md-6">
            <input hidden id="patente" type="text" class="form-control @error('patente') is-invalid @enderror" name="patente" value="{{ isset($usado->patente)?$usado->patente:old('patente') }}" autocomplete="patente" autofocus>

            <span class="text-danger" id="patenteError"></span>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso1" class="btn btn-warning">{{ $modo=='crear' ? __('Siguiente'):__('Siguiente') }}</button>
        </div>
    </div>
    




    