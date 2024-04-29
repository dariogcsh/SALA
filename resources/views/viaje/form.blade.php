                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($organizacionjd)
                                                @if($organizacion->id == $organizacionjd->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $organizacion->NombOrga }}</option>
                                    @endforeach
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                            <div class="form-group row">
                                <label for="id_user" class="col-md-4 col-form-label text-md-right">{{ __('Usuarios') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('id_user') is-invalid @enderror" multiple id="id_user" name="id_user[]" value="{{ isset($jdlink->id_user)?$jdlink->id_user:old('id_user') }}" autofocus>
                                        @php
                                            //array para guardar los users que ya esten asignados en la tarea
                                            $arrtec[] = ""; 
                                            $i=0;
                                        @endphp
                                        @isset($usuariosjd)
                                            @foreach($usuariosjd as $usuariojd)
                                                @isset($users_selected)
                                                    @foreach($users_selected as $user_selected)
                                                            @if($user_selected->id == $usuariojd->id)
                                                                <option value="{{ $usuariojd->id }}" selected>{{ $usuariojd->name }} {{ $usuariojd->last_name }}</option>
                                                                @php
                                                                    $arrtec[$i] = $usuariojd->id;
                                                                    $i++; 
                                                                @endphp
                                                            @endif
                                                    @endforeach
                                                    @if(!in_array($usuariojd->id, $arrtec))
                                                        <option value="{{ $usuariojd->id }}"> {{ $usuariojd->name }} {{ $usuariojd->last_name }}</option>
                                                    @endif
                                                @else
                                                    <option value="{{ $usuariojd->id }}">{{ $usuariojd->name }} {{ $usuariojd->last_name }}</option>
                                                @endisset
                                            @endforeach
                                        @endisset
                                    </select>
                                    @error('id_user')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_vehiculo" class="col-md-4 col-form-label text-md-right">{{ __('Vehículo') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('id_vehiculo') is-invalid @enderror" data-live-search="true" id="id_vehiculo" name="id_vehiculo" value="{{ isset($senal->id_vehiculo)?$senal->id_vehiculo:old('id_vehiculo') }}" autofocus>
                                        <option value="">Seleccionar vehículo</option>
                                        @foreach ($vehiculos as $vehiculo)
                                            <option value="{{ $vehiculo->id }}" 
                                            @isset($viaje)
                                                    @if($vehiculo->id == $viaje->id_vehiculo)
                                                        selected
                                                    @endif
                                            @endisset
                                                >{{ $vehiculo->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_vehiculo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="minutos" class="col-md-4 col-form-label text-md-right">{{ __('Duración (minutos)') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="minutos" type="number" class="form-control @error('minutos') is-invalid @enderror" name="minutos" value="{{ isset($viaje->minutos)?$viaje->minutos:old('minutos') }}" required autocomplete="minutos" autofocus>
    
                                    @error('minutos')
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