                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="NombSucu" class="col-md-4 col-form-label text-md-right">{{ __('NombSucu') }} *</label>

                            <div class="col-md-6">
                                <input id="NombSucu" type="text" class="form-control @error('NombSucu') is-invalid @enderror" name="NombSucu" value="{{ isset($sucursal->NombSucu)?$sucursal->NombSucu:old('NombSucu') }}" required autocomplete="NombSucu" autofocus>

                                @error('NombSucu')
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