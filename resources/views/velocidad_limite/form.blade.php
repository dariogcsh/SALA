                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

                        
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>
                            <div class="col-md-6">
                                @if ($modo == 'crear')
                                    <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ old('id_organizacion') }}" autofocus> 
                                @else
                                    <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ old('id_organizacion') }}" disabled autofocus> 
                                @endif
                                    @isset($organ)
                                        <option value="{{ $organ->id }}">{{ $organ->NombOrga }} </option>
                                    @else
                                        <option value="">Seleccionar organizacion</option>
                                        @foreach($organizaciones as $orga)
                                            <option value="{{ $orga->id }}">{{ $orga->NombOrga }} </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        

                        <div class="form-group row">
                            <label for="pin" class="col-md-4 col-form-label text-md-right">{{ __('Pin') }} *</label>
                            
                            <div class="col-md-6">
                                @if ($modo == 'crear')
                                    <select class="form-control @error('pin') is-invalid @enderror" id="pin" name="pin" value="{{ old('pin') }}" autofocus> 
                                @else
                                    <select class="form-control @error('pin') is-invalid @enderror" id="pin" name="pin" value="{{ old('pin') }}" disabled autofocus> 
                                @endif
                                        @isset($velocidad_limite)
                                            <option value="{{ $velocidad_limite->pin }}">
                                                {{ $velocidad_limite->pin }}
                                            </option>
                                        @else
                                        <option value="">Seleccionar maquinaria</option>
                                            @if($organizacion->NombOrga <> "Sala Hnos")
                                                @foreach($maquinas as $maquina)
                                                    <option value="{{ $maquina->id }}">
                                                    {{ $maquina->ModeMaq }} - {{ $maquina->NumSMaq }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endisset
                                   
                                </select>
                                @error('pin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                            
                            @can('haveaccess','maquina.create')
                            <div class="col-md-2">
                                <a href="{{ route('maquina.create') }}" title="Crear máquina nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea ccrear una máquina nueva y salir de la solicitud de asistencia?');"><b>+</b></a>
                            </div>
                            @endcan
                            
                        </div>

                        <div class="form-group row">
                            <label for="limite" class="col-md-4 col-form-label text-md-right">{{ __('Velocidad máxima (km/h)') }} *</label>

                            <div class="col-md-6">
                                <input id="limite" type="text" class="form-control @error('limite') is-invalid @enderror" name="limite" value="{{ isset($velocidad_limite->limite)?$velocidad_limite->limite:old('limite') }}" autocomplete="limite" autofocus>

                                @error('limite')
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