                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción de propuesta') }} *</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" rows="6" name="descripcion" required autocomplete="descripcion" autofocus>{{ isset($ideaproyecto->descripcion)?$ideaproyecto->descripcion:old('descripcion') }}</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if ($modo <> 'crear')
                            <div class="form-group row">
                                <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }} *</label>

                                <div class="col-md-6">
                                    <select class="form-control @error('estado') is-invalid @enderror" name="estado"  autocomplete="estado" autofocus>
                                    @isset($ideaproyecto->estado)
                                        <option value="{{ $ideaproyecto->estado }}">{{ $ideaproyecto->estado }}</option>
                                    @else
                                        <option value="">Estado</option>
                                    @endisset
                                        <option value="Pendiente de aprobacion">Pendiente de aprobacion</option>
                                        <option value="Transferido a proyectos">Transferido a proyectos</option>
                                        <option value="No es viable">No es viable</option>
                                        <option value="Propuesta finalizada">Propuesta finalizada</option>
                                </select>

                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>