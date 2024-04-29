                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo/Título') }} *</label>

                            <div class="col-md-6">
                                <input id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ isset($bonificacion->tipo)?$bonificacion->tipo:old('tipo') }}" required autocomplete="tipo" autofocus>

                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descuento" class="col-md-4 col-form-label text-md-right">{{ __('Descuento %') }}</label>

                            <div class="col-md-6">
                                <input id="descuento" type="number" class="form-control @error('descuento') is-invalid @enderror" name="descuento" value="{{ isset($bonificacion->descuento)?$bonificacion->descuento:old('descuento') }}" autocomplete="descuento" placeholder="(Opcional)" autofocus>

                                @error('descuento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo US$') }}</label>

                            <div class="col-md-6">
                                <input id="costo" type="number" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($bonificacion->costo)?$bonificacion->costo:old('costo') }}" placeholder="(Opcional)" autofocus>

                                @error('costo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imagen" class="col-md-4 col-form-label text-md-right">{{ __('Imagen') }} *</label>
                    
                            <div class="col-md-6">
                                <input id="imagen" type="file" class="form-control-file" name="imagen" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>
                            </div>
                        </div>
                    
                            <div class="form-group row">
                                <label for="imgSubir" class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6">
                                <img src="{{ isset($bonificacion->imagen)?asset('img/bonificaciones/'.$bonificacion->imagen):asset('imagenes/subir.png') }}" id="imgSubir" class="img img-responsive" width="150px">
                                </div>
                            </div> 
                     

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }} *</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" required autocomplete="descripcion" autofocus>{{ isset($bonificacion->descripcion)?$bonificacion->descripcion:old('descripcion') }}</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="desde" class="col-md-4 col-form-label text-md-right">{{ __('Vigencia desde') }} *</label>
                        
                            <div class="col-md-6">
                                <input id="desde" type="date" class="form-control @error('desde') is-invalid @enderror" name="desde" value="{{ isset($bonificacion->desde)?$bonificacion->desde:old('desde') }}" autofocus>
                                
                                @error('desde')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hasta" class="col-md-4 col-form-label text-md-right">{{ __('Vigencia hasta') }} *</label>
                        
                            <div class="col-md-6">
                                <input id="hasta" type="date" class="form-control @error('hasta') is-invalid @enderror" name="hasta" value="{{ isset($bonificacion->hasta)?$bonificacion->hasta:old('hasta') }}" autofocus>
                                
                                @error('hasta')
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