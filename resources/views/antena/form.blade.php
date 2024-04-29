                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="NombAnte" class="col-md-4 col-form-label text-md-right">{{ __('NombAnte') }} *</label>

                            <div class="col-md-6">
                                <input id="NombAnte" type="text" class="form-control @error('NombAnte') is-invalid @enderror" name="NombAnte" value="{{ isset($antena->NombAnte)?$antena->NombAnte:old('NombAnte') }}" required autocomplete="NombAnte" autofocus>

                                @error('NombAnte')
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