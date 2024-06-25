                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($ticket->id_organizacion)?$ticket->id_organizacion:old('id_organizacion') }}" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}"
                                        @isset($organizacionjd)
                                                @if($organizacion->id == $organizacionjd->id_organizacion)
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
                            <label for="id_servicioscsc" class="col-md-4 col-form-label text-md-right">{{ __('Servicio') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_servicioscsc') is-invalid @enderror" data-live-search="true" id="id_servicioscsc" name="id_servicioscsc" value="{{ isset($ticket->id_servicioscsc)?$ticket->id_servicioscsc:old('id_servicioscsc') }}" autofocus>
                                    <option value="">Seleccionar Servicio</option>
                                    @foreach ($servicioscscs as $servicioscsc)
                                        @if($servicioscsc->nombre <> 'Otro')
                                            <option value="{{ $servicioscsc->id }}"
                                            @isset($organizacionjd)
                                                    @if($servicioscsc->id == $serviciosjd->id_servicioscsc)
                                                        selected
                                                    @endif
                                            @endisset
                                                >{{ $servicioscsc->nombre }}</option>
                                        @endif
                                    @endforeach
                                    <option value="Otro">Otro</option>
                                </select>
                                @error('id_servicioscsc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_proyecto" class="col-md-4 col-form-label text-md-right">{{ __('Título del proyecto') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_proyecto') is-invalid @enderror" data-live-search="true" id="id_proyecto" name="id_proyecto" value="{{ isset($ticket->id_proyecto)?$ticket->id_proyecto:old('id_proyecto') }}" autofocus>
                                    <option value="">Seleccionar Proyecto</option>
                                    @foreach ($proyectos as $proyecto)
                                            <option data-subtext="{{ $proyecto->categoria }}" value="{{ $proyecto->id }}"
                                                >{{ $proyecto->titulo }} </option>
                                    @endforeach
                                </select>
                                @error('id_proyecto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                 
                        <div class="form-group row">
                            <label for="nombreservicio" class="col-md-4 col-form-label text-md-right">{{ __('Detalle de servicio') }}</label>

                            <div class="col-md-6">
                                <textarea id="nombreservicio" class="form-control-textarea @error('nombreservicio') is-invalid @enderror" name="nombreservicio" value="{{ old('nombreservicio') }}" placeholder="Opcional" autofocus></textarea>

                                @error('nombreservicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contactos" class="col-md-4 col-form-label text-md-right">{{ __('Registrar en Contactos con el cliente') }}</label>
                        
                            <div class="col-md-6">
                                <label class="switch">
                                        <input type="checkbox" class="warning" id="contactos" name="contactos">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                       

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>