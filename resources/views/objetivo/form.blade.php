                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" autofocus> 
                                    
                                    @foreach($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                        >{{ $organizacion->NombOrga }} </option>
                                    @endforeach
                                   
                            </select>
                                @error('CodiOrga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_maquina" class="col-md-4 col-form-label text-md-right">{{ __('Maquina') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('id_maquina') is-invalid @enderror" name="id_maquina" id="id_maquina" value="{{ old('id_maquina') }}" autofocus> 
                                
                            </select>
                                @error('id_maquina')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_tipoobjetivo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de objetivo') }} *</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('id_tipoobjetivo') is-invalid @enderror" data-live-search="true" name="id_tipoobjetivo" id="id_tipoobjetivo" value="{{ old('id_tipoobjetivo') }}" title="Seleccionar Objetivo" autofocus> 
                                    
                                    @foreach($tipoobjetivos as $tipoobjetivo)
                                        <option value="{{ $tipoobjetivo->id }}" 
                                        >{{ $tipoobjetivo->nombre }} </option>
                                    @endforeach
                                   
                            </select>
                                @error('id_tipoobjetivo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ano" class="col-md-4 col-form-label text-md-right">{{ __('Año') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('ano') is-invalid @enderror" name="ano" id="ano" value="{{ old('ano') }}" autofocus> 
                                @isset($objetivo->ano)
                                    <option value="{{ $objetivo->ano }}">{{ $objetivo->ano }}</option>
                                @endisset
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                            </select>
                                @error('ano')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cultivo" class="col-md-4 col-form-label text-md-right">{{ __('Cultivo') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('cultivo') is-invalid @enderror" name="cultivo" id="cultivo" value="{{ old('cultivo') }}" autofocus> 
                                @isset($objetivo->cultivo)
                                    <option value="{{ $objetivo->cultivo }}">{{ $objetivo->cultivo }}</option>
                                @endisset
                                <option value="Soja">Soja</option>
                                <option value="Maíz">Maiz</option>
                                <option value="Trigo">Trigo</option>
                                <option value="Girasol">Girasol</option>
                            </select>
                                @error('cultivo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="objetivo" class="col-md-4 col-form-label text-md-right">{{ __('Objetivo') }} *</label>

                            <div class="col-md-6">
                                <input id="objetivo" type="number" step="0.01" class="form-control @error('objetivo') is-invalid @enderror" name="objetivo" value="{{ isset($objetivo->objetivo)?$objetivo->objetivo:old('objetivo') }}" required autocomplete="objetivo" autofocus>

                                @error('objetivo')
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