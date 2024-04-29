                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_bonificacion" class="col-md-4 col-form-label text-md-right">{{ __('Bonificacion') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_bonificacion') is-invalid @enderror" name="id_bonificacion" value="{{ $bonificacion->id }}" disabled autofocus>           
                                    <option value="{{ $bonificacion->id }}">{{ $bonificacion->tipo }}</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organización') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_organizacion') is-invalid @enderror" name="id_organizacion" value="{{ $organizacion->id }}" disabled autofocus>           
                                    <option value="{{ $organizacion->id }}">{{ $organizacion->NombOrga }}</option>
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ old('estado') }}" autofocus>           
                                    <option value="{{ $mibonificacion->estado }}">{{ $mibonificacion->estado }}</option>
                                    <option value="Solicitado">Solicitado</option>
                                    <option value="Aceptado">Aceptar</option>
                                    <option value="Cancelado">Cancelar</option>
                                    <option value="Rechazado">Rechazar</option>
                                    <option value="Aplicado">Aplicar</option>
                                </select>
                                @error('estado')
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