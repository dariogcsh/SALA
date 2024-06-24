                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                         <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" name="id_organizacion" id="id_organizacion" value="{{ old('id_organizacion') }}" title="Seleccionar Organizacion" required autofocus> 
                                    @if($organizacion->NombOrga == "Sala Hnos")
                                        @foreach($organizaciones as $organ)
                                            <option value="{{ $organ->id }}" data-subtext="{{ $organ->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                @isset($organizacionshow)
                                                    @if($organ->id == $organizacionshow->id)
                                                        selected
                                                    @endif
                                                @endisset
                                                >{{ $organ->NombOrga }} </option>
                                        @endforeach
                                    @else
                                        @isset($organizacionshow)
                                            <option value="{{ $organizacionshow->id }}" data-subtext="{{ $organizacionshow->InscOrga == 'SI' ? 'Monitoreado':'' }}" selected>{{ $organizacionshow->NombOrga }} </option>
                                        @else
                                                    <option value="{{ $organizacion->id }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                        >{{ $organizacion->NombOrga }} </option>
                                        @endisset
                                    @endif
                                 
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_cliente" class="col-md-4 col-form-label text-md-right">{{ __('Cliente') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('id_cliente') is-invalid @enderror" name="id_cliente" id="id_cliente" value="{{ old('id_cliente') }}" required autofocus> 
                                @isset($clientes)
                                    @foreach($clientes as $cli)
                                        @isset($cliente)
                                        <option value="{{ $cli->id }}"
                                            @if($cli->id == $cliente->id)
                                                selected
                                            @endif
                                            >{{ $cli->nombre }} </option>
                                        @endisset
                                    @endforeach 
                                @endisset      
                            </select>
                                @error('id_cliente')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de granja') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($granja->nombre)?$granja->nombre:old('nombre') }}" required autocomplete="nombre" autofocus>

                                @error('nombre')
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