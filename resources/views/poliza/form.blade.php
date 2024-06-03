                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ isset($subirpdf->titulo)?$subirpdf->titulo:old('titulo') }}" autocomplete="titulo" placeholder="Opcional" autofocus>

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>     
               
                        <div class="form-group row">
                            <label for="ruta" class="col-md-4 col-form-label text-md-right">{{ __('PDF') }} *</label>
                    
                            <div class="col-md-6">
                                <input id="ruta" type="file" class="form-control-file" name="ruta" accept=".pdf" value="C:\Users\AMS 2\Downloads\Grupo Emerger 7R230 22-11.pdf" autofocus required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>