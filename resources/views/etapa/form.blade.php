                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Etapa') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($etapa->nombre)?$etapa->nombre:old('nombre') }}" required autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="orden" class="col-md-4 col-form-label text-md-right">{{ __('Orden') }} *</label>

                            <div class="col-md-6">
                                <input id="orden" type="number" class="form-control @error('orden') is-invalid @enderror" name="orden" value="{{ isset($etapa->orden)?$etapa->orden:old('orden') }}" required autocomplete="orden" autofocus>

                                @error('orden')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_unidad" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de unidad') }} *</label>

                            <div class="col-md-6">
                            <select class="form-control @error('tipo_unidad') is-invalid @enderror" name="tipo_unidad" value="{{ isset($entrega->tipo_unidad)?$entrega->tipo_unidad:old('tipo_unidad') }}" required autocomplete="tipo_unidad" autofocus>
                                @isset($etapa->tipo_unidad)
                                    <option value="{{ $etapa->tipo_unidad }}">{{ $etapa->tipo_unidad }}</option>
                                @else
                                    <option value="">Seleccionar tipo de unidad</option>
                                @endisset
                                    <option value="Nueva">Nueva</option>
                                    <option value="Usada">Usada</option>
                            </select>
             
                                @error('tipo_unidad')
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