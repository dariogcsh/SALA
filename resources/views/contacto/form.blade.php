                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" name="id_organizacion" value="{{ isset($organizacion->id_organizacion)?$organizacion->id_organizacion:old('id_organizacion') }}" required autocomplete="id_organizacion" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizacions as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($contacto->organizacions->NombOrga)
                                                @if($organizacion->NombOrga == $contacto->organizacions->NombOrga)
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
                            <label for="persona" class="col-md-4 col-form-label text-md-right">{{ __('¿Aquién contactó?') }} *</label>

                            <div class="col-md-6">
                                <input id="persona" type="text" class="form-control @error('persona') is-invalid @enderror" name="persona" value="{{ isset($contacto->persona)?$contacto->persona:old('persona') }}" required autocomplete="persona" placeholder="" autofocus>

                                @error('persona')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de contacto') }} *</label>

                            <div class="col-md-6">
                            <select class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ isset($contacto->tipo)?$contacto->tipo:old('tipo') }}" required autocomplete="tipo" autofocus>
                                @isset($contacto->tipo)
                                    <option value="{{ $contacto->tipo }}">{{ $contacto->tipo }}</option>
                                @else
                                    <option value="">Seleccionar tipo de contacto</option>
                                @endisset
                                    <option value="Llamado">Llamado</option>
                                    <option value="WhatsApp">WhatsApp</option>
                                    <option value="Videollamada">Videollamada</option>
                                    <option value="En concesionario">En concesionario</option>
                                    <option value="En campo">En campo</option>
                                    <option value="E-mail">E-mail</option>
                            </select>
             
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="departamento" class="col-md-4 col-form-label text-md-right">{{ __('Departamento') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('departamento') is-invalid @enderror" name="departamento" value="{{ isset($contacto->departamento)?$contacto->departamento:old('departamento') }}" required autocomplete="departamento" autofocus>
                                @isset($contacto->departamento)
                                    <option value="{{ $contacto->departamento }}">{{ $contacto->departamento }}</option>
                                @else
                                    <option value="">Departamento</option>
                                @endisset
                                    <option value="Ventas">Ventas</option>
                                    <option value="Posventa">Posventa</option>
                                    <option value="Centro de Soluciones Conectadas">Centro de Soluciones Conectadas</option>
                            </select>

                                @error('departamento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comentarios" class="col-md-4 col-form-label text-md-right">{{ __('Comentarios') }}</label>

                            <div class="col-md-6">
                                <textarea id="comentarios" rows="6" class="form-control-textarea @error('comentarios') is-invalid @enderror" name="comentarios" placeholder="Opcional" autocomplete="comentarios" autofocus>{{ isset($contacto->comentarios)?$contacto->comentarios:old('comentarios') }}</textarea>

                                @error('comentarios')
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