                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }} *</label>

                            <div class="col-md-6">
                                <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($guardiasadmin->fecha)?$guardiasadmin->fecha:old('fecha') }}" autocomplete="fecha" autofocus>

                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>
                            <div class="col-md-6">
                                <select name="id_sucursal" id="id_sucursal" class="form-control">
                                <option value="">Seleccionar sucursal</option>
                                    @foreach($sucursals as $sucursal)
                                    <option value="{{ $sucursal->id }}"
                                    @isset($guardiasadmin->sucursals->NombSucu)
                                        @if($sucursal->NombSucu == $guardiasadmin->sucursals->NombSucu)
                                            selected
                                        @endif
                                    @endisset
                                    >{{ $sucursal->NombSucu }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>