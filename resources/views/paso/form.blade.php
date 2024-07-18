                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_etapa" class="col-md-4 col-form-label text-md-right">{{ __('Etapa') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_etapa') is-invalid @enderror" data-live-search="true" id="id_etapa" name="id_etapa" value="{{ isset($paso->id_etapa)?$paso->id_etapa:old('id_etapa') }}" required autocomplete="id_etapa" autofocus>
                                    <option value="">Seleccionar etapa</option>
                                    @foreach ($etapas as $etapa)
                                        <option value="{{ $etapa->id }}" data-subtext="{{$etapa->tipo_unidad }}"
                                        @isset($paso->id_etapa)
                                                @if($etapa->id == $paso->id_etapa)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $etapa->nombre }} </option>
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
                                <select class="selectpicker form-control @error('id_puesto') is-invalid @enderror" data-live-search="true" name="id_puesto" value="{{ isset($paso->id_puesto)?$paso->id_puesto:old('id_puesto') }}" required autocomplete="id_puesto" autofocus>
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
                            <label for="id_paso_anterior" class="col-md-4 col-form-label text-md-right">{{ __('¿El paso anterior condiciona al actual?') }}</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_paso_anterior') is-invalid @enderror" data-live-search="true" name="id_paso_anterior" value="{{ isset($paso->id_paso_anterior)?$paso->id_paso_anterior:old('id_paso_anterior') }}" autocomplete="id_paso_anterior" autofocus>
                                    <option value="">Seleccionar paso (opcional)</option>
                                    @foreach ($pasos as $listap)
                                        <option value="{{ $listap->id }}" data-subtext="{{$listap->tipo_unidad }}"
                                        @isset($paso->id_paso_anterior)
                                                @if($listap->id == $paso->id_paso_anterior)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $listap->nombre }} </option>
                                    @endforeach
                                </select>
                                @error('id_paso_anterior')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="valor_condicion_anterior" class="col-md-4 col-form-label text-md-right">{{ __('Valor de la condición del paso anterior') }}</label>

                            <div class="col-md-6">
                            <select class="form-control @error('valor_condicion_anterior') is-invalid @enderror" name="valor_condicion_anterior" value="{{ isset($paso->valor_condicion_anterior)?$paso->valor_condicion_anterior:old('valor_condicion_anterior') }}" autocomplete="valor_condicion_anterior" autofocus>
                                @isset($paso->valor_condicion_anterior)
                                    <option value="{{ $paso->valor_condicion_anterior }}">{{ $paso->valor_condicion_anterior }}</option>
                                @endisset
                                    <option value="">Seleccionar (opcional)</option>
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                            </select>
             
                                @error('valor_condicion_anterior')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="orden_ultimo" class="col-md-4 col-form-label text-md-right">{{ __('Ultimo paso dentro de esta etapa') }} </label>

                            <div class="col-md-6">
                                <input id="orden_ultimo" type="text" class="form-control @error('orden_ultimo') is-invalid @enderror" id="orden_ultimo" name="orden_ultimo" disabled autocomplete="orden_ultimo" autofocus>

                                @error('orden_ultimo')
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

                        <div class="form-group row">
                            <label for="condicion" class="col-md-4 col-form-label text-md-right">{{ __('¿Este paso condiciona al siguiente?') }} *</label>

                            <div class="col-md-6">
                            <select class="form-control @error('condicion') is-invalid @enderror" name="condicion" value="{{ isset($paso->condicion)?$paso->condicion:old('condicion') }}" required autocomplete="condicion" autofocus>
                                @isset($paso->condicion)
                                    <option value="{{ $paso->condicion }}">{{ $paso->condicion }}</option>
                                @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    
                            </select>
             
                                @error('condicion')
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