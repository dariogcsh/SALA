                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo de equipo') }} *</label>

                            <div class="col-md-6">
                                <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{ isset($tipo_paquete_mant->modelo)?$tipo_paquete_mant->modelo:old('modelo') }}" autocomplete="modelo" autofocus>

                                @error('modelo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Horas *') }} </label>

                            <div class="col-md-6">
                                <input id="horas" type="number" step="0.01" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($tipo_paquete_mant->horas)?$tipo_paquete_mant->horas:old('horas') }}" autofocus>

                                @error('horas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo (US$) *') }} </label>

                            <div class="col-md-6">
                                <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($tipo_paquete_mant->costo)?$tipo_paquete_mant->costo:old('costo') }}" autofocus>

                                @error('costo')
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