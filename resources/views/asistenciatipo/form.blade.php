                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="NombTiAs" class="col-md-4 col-form-label text-md-right">{{ __('NombTiAs') }} *</label>

                            <div class="col-md-6">
                                <input id="NombTiAs" type="text" class="form-control @error('NombTiAs') is-invalid @enderror" name="NombTiAs" value="{{ isset($asistenciatipo->NombTiAs)?$asistenciatipo->NombTiAs:old('NombTiAs') }}" required autocomplete="NombTiAs" autofocus>

                                @error('NombTiAs')
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