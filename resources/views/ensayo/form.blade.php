                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }}</label>

                            <div class="col-md-6">
                                <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($ensayo->fecha)?$ensayo->fecha:old('fecha') }}" autocomplete="fecha" placeholder="Opcional" autofocus>

                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($reclamo->id_organizacion)?$reclamo->id_organizacion:old('id_organizacion') }}" required>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($orga_sucu)
                                                @if($organizacion->id == $orga_sucu->id)
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
                            @can('haveaccess','organizacion.create')
                            <div class="col-md-2">
                                <a href="{{ route('organizacion.create') }}" title="Crear organización nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea ccrear una organización nueva y salir del formulario de registro de queja/reclamo?');"><b>+</b></a>
                            </div>
                            @endcan
                        </div>
                        
                        <div class="form-group row">
                            <label for="TipoMaq" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de máquina') }} *</label>
                    
                            <div class="col-md-6">

                                <select class="form-control @error('TipoMaq') is-invalid @enderror" id="TipoMaq" name="TipoMaq" value="{{ old('TipoMaq') }}" required autofocus>
                                @isset($ensayo->TipoMaq)
                                    <option value="{{ $ensayo->TipoMaq }}">{{ $ensayo->TipoMaq }}</option>
                                @else
                                    <option value="">Seleccionar</option>
                                @endisset
                                    <option value="COSECHADORA">COSECHADORA</option>
                                    <option value="TRACTOR">TRACTOR</option>
                                    <option value="PULVERIZADORA">PULVERIZADORA</option>
                                    <option value="PULVERIZADORA PLA">PULVERIZADORA PLA</option>
                                    <option value="SEMBRADORA">SEMBRADORA</option>
                                    <option value="ROTOENFARDADORA">ROTOENFARDADORA</option>
                            </select>
                    
                            <span class="text-danger" id="TipoMaqError"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ModeMaq" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }} *</label>

                            <div class="col-md-6">
                                <input id="ModeMaq" type="text" class="form-control @error('ModeMaq') is-invalid @enderror" name="ModeMaq" value="{{ isset($ensayo->ModeMaq)?$ensayo->ModeMaq:old('ModeMaq') }}" autocomplete="ModeMaq" placeholder="S770 - 8230R - 7200J" required autofocus>

                                @error('ModeMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="nserie" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie') }}</label>

                            <div class="col-md-6">
                                <input id="nserie" type="text" class="form-control @error('nserie') is-invalid @enderror" name="nserie" value="{{ isset($ensayo->nserie)?$ensayo->nserie:old('nserie') }}" autocomplete="nserie" placeholder="Opcional" autofocus>

                                @error('nserie')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="cultivo" class="col-md-4 col-form-label text-md-right">{{ __('Cultivo') }} *</label>
                    
                            <div class="col-md-6">

                                <select class="form-control @error('cultivo') is-invalid @enderror" id="cultivo" name="cultivo" value="{{ old('cultivo') }}" required autofocus>
                                @isset($ensayo->cultivo)
                                    <option value="{{ $ensayo->cultivo }}">{{ $ensayo->cultivo }}</option>
                                @else
                                    <option value="">Seleccionar</option>
                                @endisset
                                    <option value="SOJA">SOJA</option>
                                    <option value="MAIZ">MAIZ</option>
                                    <option value="TRIGO">TRIGO</option>
                                    <option value="MANI">MANI</option>
                                    <option value="OTRO">OTRO</option>
                                    <option value="NO APLICA CULTIVO">NO APLICA CULTIVO</option>
                            </select>
                    
                            <span class="text-danger" id="TipoMaqError"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zona" class="col-md-4 col-form-label text-md-right">{{ __('Zona geográfica/Ubicación') }} *</label>

                            <div class="col-md-6">
                                <input id="zona" type="text" class="form-control @error('zona') is-invalid @enderror" name="zona" value="{{ isset($ensayo->zona)?$ensayo->zona:old('zona') }}" autocomplete="zona" placeholder="Río Cuarto" required autofocus>

                                @error('zona')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="archivo" class="col-md-4 col-form-label text-md-right">{{ __('PDF') }} *</label>
                    
                            <div class="col-md-6">
                                @if ($modo == 'crear')
                                    <input id="archivo" type="file" class="form-control-file" name="archivo" accept=".pdf" autofocus required>
                                @else
                                    <input id="archivo" type="file" class="form-control-file" name="archivo" accept=".pdf" autofocus>
                                @endif 
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion/Conclusión') }}</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" autocomplete="descripcion" autofocus rows="8">@isset($ensayo->descripcion){{ $ensayo->descripcion }}@endisset</textarea>

                                @error('descripcion')
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