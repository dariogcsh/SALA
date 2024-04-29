                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="organizacion_id" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('organizacion_id') is-invalid @enderror" data-live-search="true" id="organizacion_id" name="organizacion_id" value="{{ isset($activacion->organizacion_id)?$activacion->organizacion_id:old('organizacion_id') }}" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($activacion->organizacions->NombOrga)
                                                @if($organizacion->NombOrga == $activacion->organizacions->NombOrga)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $organizacion->NombOrga }}</option>
                                    @endforeach
                                </select>
                                @error('organizacion_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pantalla_id" class="col-md-4 col-form-label text-md-right">{{ __('Pantalla') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('pantalla_id') is-invalid @enderror" name="pantalla_id" value="{{ isset($activacion->pantalla_id)?$activacion->pantalla_id:old('pantalla_id') }}" autofocus>
                                    <option value="">Seleccionar pantalla</option>
                                    @foreach ($pantallas as $pantalla)
                                        <option value="{{ $pantalla->id }}" 
                                        @isset($activacion->pantallas->NombPant)
                                                @if($pantalla->NombPant == $activacion->pantallas->NombPant)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $pantalla->NombPant }}</option>
                                    @endforeach
                                </select>
                                @error('pantalla_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_antena" class="col-md-4 col-form-label text-md-right">{{ __('Antena') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_antena') is-invalid @enderror" name="id_antena" value="{{ isset($activacion->id_antena)?$activacion->id_antena:old('id_antena') }}" autofocus>
                                    <option value="">Seleccionar antena</option>
                                    @foreach ($antenas as $antena)
                                        <option value="{{ $antena->id }}" 
                                        @isset($activacion->antenas->NombAnte)
                                                @if($antena->NombAnte == $activacion->antenas->NombAnte)
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
                                <input id="nserie" type="text" class="form-control @error('nserie') is-invalid @enderror" name="nserie" value="{{ isset($activacion->nserie)?$activacion->nserie:old('nserie') }}" autocomplete="nserie" autofocus>

                                @error('nserie')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="suscripcion_id" class="col-md-4 col-form-label text-md-right">{{ __('Suscripción') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('suscripcion_id') is-invalid @enderror" name="suscripcion_id" value="{{ isset($activacion->suscripcion_id)?$activacion->suscripcion_id:old('suscripcion_id') }}" autofocus>
                                    <option value="">Seleccionar suscripcion</option>
                                    @foreach ($suscripciones as $suscripcion)
                                        <option value="{{ $suscripcion->id }}" 
                                        @isset($activacion->suscripcions->nombre)
                                                @if($suscripcion->nombre == $activacion->suscripcions->nombre)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $suscripcion->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('suscripcion_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="duracion" class="col-md-4 col-form-label text-md-right">{{ __('Duracion') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('duracion') is-invalid @enderror" name="duracion" value="{{ isset($activacion->duracion)?$activacion->duracion:old('duracion') }}" autofocus>
                                    @isset($activacion->duracion)
                                        <option value="{{ $activacion->duracion }}">{{ $activacion->duracion }}</option>
                                    @endisset
                                    <option value="1">1 año</option>
                                    <option value="3">3 años</option>
                                    <option value="5">5 años</option>
                                    <option value="99">Definitiva</option>
                                </select>
                                @error('duracion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>

                            <div class="col-md-6">
                                <input id="precio" type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ isset($activacion->precio)?$activacion->precio:old('precio') }}" autocomplete="precio" placeholder="Ej: 650" autofocus>

                                @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha activación') }}</label>
                        
                            <div class="col-md-6">
                                <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($activacion->fecha)?$activacion->fecha:old('fecha') }}" autofocus>
                        
                                @error('fecha')
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
                                    @isset($activacion->estado)
                                        <option value="{{ $activacion->estado }}">{{ $activacion->estado }}</option>
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
                                <input id="nfactura" type="text" class="form-control @error('nfactura') is-invalid @enderror" name="nfactura" value="{{ isset($activacion->nfactura)?$activacion->nfactura:old('nfactura') }}" autocomplete="nfactura" autofocus>

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