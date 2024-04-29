                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="NombPant" class="col-md-4 col-form-label text-md-right">{{ __('NombPant') }} *</label>

                            <div class="col-md-6">
                                <input id="NombPant" type="text" class="form-control @error('NombPant') is-invalid @enderror" name="NombPant" value="{{ isset($pantalla->NombPant)?$pantalla->NombPant:old('NombPant') }}" required autocomplete="NombPant" autofocus>

                                @error('NombPant')
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