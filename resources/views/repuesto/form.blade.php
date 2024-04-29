                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Código') }} *</label>

                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ isset($repuesto->codigo)?$repuesto->codigo:old('codigo') }}" autocomplete="codigo" autofocus>

                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($repuesto->nombre)?$repuesto->nombre:old('nombre') }}" autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo (US$) *') }} </label>

                            <div class="col-md-6">
                                <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($repuesto->costo)?$repuesto->costo:old('costo') }}" autofocus>

                                @error('costo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="margen" class="col-md-4 col-form-label text-md-right">{{ __('Margen (%$) *') }} </label>

                            <div class="col-md-6">
                                <input id="margen" type="number" step="0.01" class="form-control @error('margen') is-invalid @enderror" name="margen" value="{{ isset($repuesto->margen)?$repuesto->margen:old('margen') }}" autofocus>

                                @error('margen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="venta" class="col-md-4 col-form-label text-md-right">{{ __('Venta (US$) *') }} </label>

                            <div class="col-md-6">
                                <input id="venta" type="number" step="0.01" class="form-control @error('venta') is-invalid @enderror" name="venta" value="{{ isset($repuesto->venta)?$repuesto->venta:old('venta') }}" autofocus>

                                @error('venta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jdpart" class="col-md-4 col-form-label text-md-right">{{ __('JDPart (US$) *') }} </label>

                            <div class="col-md-6">
                                <input id="jdpart" type="number" step="0.01" class="form-control @error('jdpart') is-invalid @enderror" name="jdpart" value="{{ isset($repuesto->jdpart)?$repuesto->jdpart:old('jdpart') }}" autofocus>

                                @error('jdpart')
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