                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_etapa" class="col-md-4 col-form-label text-md-right">{{ __('Etapa') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_etapa') is-invalid @enderror" name="id_etapa" value="{{ isset($paso->id_etapa)?$paso->id_etapa:old('id_etapa') }}" required autocomplete="id_etapa" autofocus>
                                    <option value="">Seleccionar etapa</option>
                                    @foreach ($etapas as $etapa)
                                        <option value="{{ $etapa->id }}" 
                                        @isset($paso->id_etapa)
                                                @if($etapa->id == $paso->id_etapa)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $etapa->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('id_etapa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_puesto" class="col-md-4 col-form-label text-md-right">{{ __('Puesto de responsable') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_puesto') is-invalid @enderror" name="id_puesto" value="{{ isset($paso->id_puesto)?$paso->id_puesto:old('id_puesto') }}" required autocomplete="id_puesto" autofocus>
                                    <option value="">Seleccionar etapa</option>
                                    @foreach ($puestos as $puesto)
                                        <option value="{{ $puesto->id }}" 
                                        @isset($paso->id_puesto)
                                                @if($puesto->id == $paso->id_puesto)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $puesto->NombPuEm }}</option>
                                    @endforeach
                                </select>
                                @error('id_puesto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Paso') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($paso->nombre)?$paso->nombre:old('nombre') }}" required autocomplete="nombre" autofocus>

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
                                <input id="orden" type="number" class="form-control @error('orden') is-invalid @enderror" name="orden" value="{{ isset($paso->orden)?$paso->orden:old('orden') }}" required autocomplete="orden" autofocus>

                                @error('orden')
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