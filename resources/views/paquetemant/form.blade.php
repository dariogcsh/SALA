                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_tipo_paquete_mant" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de paquete') }}</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('id_tipo_paquete_mant') is-invalid @enderror" data-live-search="true" id="id_tipo_paquete_mant" name="id_tipo_paquete_mant" value="{{ old('id_tipo_paquete_mant') }}" required autofocus> 
                                    <option value="">Seleccionar tipo de paquete</option>
                                    @foreach($tipopaquetes as $tipopaquete)
                                        @isset ($paquetemant->id_tipo_paquete_mant)
                                            @if($paquetemant->id_tipo_paquete_mant == $tipopaquete->id)
                                                <option value="{{ $tipopaquete->id }}" data-subtext="{{ $tipopaquete->horas.' hs' }}" selected>{{ $tipopaquete->modelo }} </option>
                                            @endif
                                        @endisset
                                            <option value="{{ $tipopaquete->id }}" data-subtext="{{ $tipopaquete->horas.' hs' }}">{{ $tipopaquete->modelo }} </option>
                                    @endforeach
                                </select>
                                @error('id_tipo_paquete_mant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción de tarea') }} *</label>

                            <div class="col-md-6">
                                <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ isset($paquetemant->descripcion)?$paquetemant->descripcion:old('descripcion') }}" required autocomplete="descripcion" autofocus>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Horas') }} *</label>

                            <div class="col-md-6">
                                <input id="horas" type="number" step="0.01" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($paquetemant->horas)?$paquetemant->horas:old('horas') }}" required autocomplete="horas" autofocus>

                                @error('horas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_repuesto" class="col-md-4 col-form-label text-md-right">{{ __('Repuesto') }}</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('id_repuesto') is-invalid @enderror" data-live-search="true" id="id_repuesto" name="id_repuesto" value="{{ old('id_repuesto') }}"  autofocus> 
                                    <option value="">Seleccionar repuesto/servicio</option>
                                    @foreach($repuestos as $repuesto)
                                        @isset ($paquetemant->id_repuesto)
                                            @if($paquetemant->id_repuesto == $repuesto->id)
                                                <option value="{{ $repuesto->id }}" data-subtext="{{ $repuesto->codigo.' hs' }}" selected>{{ $repuesto->nombre }} </option>
                                            @endif
                                        @endisset
                                            <option value="{{ $repuesto->id }}" data-subtext="{{ $repuesto->codigo.' hs' }}">{{ $repuesto->nombre }} </option>
                                    @endforeach
                                </select>
                                @error('id_repuesto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cantidad" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }} *</label>

                            <div class="col-md-6">
                                <input id="cantidad" type="numeric" class="form-control @error('cantidad') is-invalid @enderror" name="cantidad" value="{{ isset($paquetemant->cantidad)?$paquetemant->cantidad:old('cantidad') }}" required value="1" autocomplete="cantidad" autofocus>

                                @error('cantidad')
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