                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($senal->organizacions->NombOrga)
                                                @if($organizacion->NombOrga == $senal->organizacions->NombOrga)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $organizacion->NombOrga }}</option>
                                    @endforeach
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_antena" class="col-md-4 col-form-label text-md-right">{{ __('Antena') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_antena') is-invalid @enderror" data-live-search="true" name="id_antena" value="{{ isset($senal->id_antena)?$senal->id_antena:old('id_antena') }}" autofocus>
                                    <option value="">Seleccionar antena</option>
                                    @foreach ($antenas as $antena)
                                        <option value="{{ $antena->id }}" 
                                        @isset($senal->antenas->NombAnte)
                                                @if($antena->NombAnte == $senal->antenas->NombAnte)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $antena->NombAnte }}</option>
                                    @endforeach
                                </select>
                                @error('id_antena')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nserie" class="col-md-4 col-form-label text-md-right">{{ __('N° serie') }} *</label>

                            <div class="col-md-6">
                                <input id="nserie" type="text" class="form-control @error('nserie') is-invalid @enderror" name="nserie" value="{{ isset($senal->nserie)?$senal->nserie:old('nserie') }}" autocomplete="nserie" autofocus>

                                @error('nserie')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="activacion" class="col-md-4 col-form-label text-md-right">{{ __('Fecha activación') }}</label>
                        
                            <div class="col-md-6">
                                <input id="activacion" type="date" class="form-control @error('activacion') is-invalid @enderror" name="activacion" value="{{ isset($senal->activacion)?$senal->activacion:old('activacion') }}" autofocus>
                        
                                @error('activacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="duracion" class="col-md-4 col-form-label text-md-right">{{ __('Duracion') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('duracion') is-invalid @enderror" name="duracion" value="{{ isset($senal->duracion)?$senal->duracion:old('duracion') }}" autofocus>
                                    @isset($senal->duracion)
                                        <option value="{{ $senal->duracion }}">{{ $senal->duracion }}</option>
                                    @endisset
                                    <option value="3meses">3 meses</option>
                                    <option value="6meses">6 meses</option>
                                    <option value="12meses">12 meses</option>
                                    <option value="24meses">24 meses</option>
                                    <option value="36meses">36 meses</option>
                                </select>
                                @error('duracion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo') }}</label>

                            <div class="col-md-6">
                                <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($senal->costo)?$senal->costo:old('costo') }}" autocomplete="costo" placeholder="Ej: 650" autofocus>

                                @error('costo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @php $aux = 0; @endphp
                        <div class="form-group row">
                            <label for="id_mibonificacion" class="col-md-4 col-form-label text-md-right">{{ __('Bonificación') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_mibonificacion') is-invalid @enderror" data-live-search="true" id="id_mibonificacion" name="id_mibonificacion" value="{{ isset($senal->id_mibonificacion)?$senal->id_mibonificacion:old('id_mibonificacion') }}" autofocus>
                                    <option value="">Seleccionar bonificacion</option>
                                    @isset($misbonificaciones)
                                        @foreach ($misbonificaciones as $mibonificacion)
                                            @isset($senal->mibonificacions->id)
                                                @if($mibonificacion->id == $senal->mibonificacions->id)
                                                    <option value="{{ $mibonificacion->id }}" selected>{{ $mibonificacion->tipo }} - {{ $mibonificacion->descuento }}% </option>
                                                    @php $aux = $mibonificacion->id ; @endphp
                                                @endif
                                            @endisset
                                            @if($aux <> $mibonificacion->id)
                                                <option value="{{ $mibonificacion->id }}">{{ $mibonificacion->tipo }} - {{ $mibonificacion->descuento }}% </option>
                                            @endif
                                        @endforeach
                                    @endisset
                                </select>
                                @error('id_mibonificacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado interno') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ old('estado') }}" autofocus>           
                                    @isset($senal->estado)
                                        <option value="{{ $senal->estado }}">{{ $senal->estado }}</option>
                                    @endisset
                                    <option value="Solicitado">Solicitado</option>
                                    <option value="Facturado">Facturado</option>
                                    <option value="Pagado">Pagado</option>
                                    <option value="Activado">Activado</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nfactura" class="col-md-4 col-form-label text-md-right">{{ __('N° de factura') }} </label>

                            <div class="col-md-6">
                                <input id="nfactura" type="text" class="form-control @error('nfactura') is-invalid @enderror" name="nfactura" value="{{ isset($senal->nfactura)?$senal->nfactura:old('nfactura') }}" autocomplete="nfactura" autofocus>

                                @error('nfactura')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>