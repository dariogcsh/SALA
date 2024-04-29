                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título') }} *</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ isset($noticia->titulo)?$noticia->titulo:old('titulo') }}" required autocomplete="titulo" autofocus>

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if($modo == "crear")
                            <div class="form-group row">
                                <label for="noticia" class="col-md-4 col-form-label text-md-right">Fotos</label>

                                <div class="col-sm-6">
                                    <input type="file" class="form-control" id="archivo[]" name="archivo[]" multiple="">
                                    
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }} </label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" autocomplete="descripcion" autofocus>{{ isset($noticia->descripcion)?$noticia->descripcion:old('descripcion') }}</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fuente" class="col-md-4 col-form-label text-md-right">{{ __('Fuente') }} </label>

                            <div class="col-md-6">
                                <input id="fuente" type="text" class="form-control @error('fuente') is-invalid @enderror" name="fuente" value="{{ isset($noticia->fuente)?$noticia->fuente:old('fuente') }}" autocomplete="fuente" autofocus>

                                @error('fuente')
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