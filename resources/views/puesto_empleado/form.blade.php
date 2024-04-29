                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="NombPuEm" class="col-md-4 col-form-label text-md-right">{{ __('NombPuEm') }} *</label>

                            <div class="col-md-6">
                                <input id="NombPuEm" type="text" class="form-control @error('NombPuEm') is-invalid @enderror" name="NombPuEm" value="{{ isset($puesto_empleado->NombPuEm)?$puesto_empleado->NombPuEm:old('NombPuEm') }}" required autocomplete="NombPuEm" autofocus>

                                @error('NombPuEm')
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