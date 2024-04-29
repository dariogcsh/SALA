                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_vsat" class="col-md-4 col-form-label text-md-right">{{ __('Id VSat') }} *</label>

                            <div class="col-md-6">
                                <input id="id_vsat" type="text" class="form-control @error('id_vsat') is-invalid @enderror" name="id_vsat" value="{{ isset($vehiculo->id_vsat)?$vehiculo->id_vsat:old('id_vsat') }}" required autocomplete="id_vsat" autofocus>

                                @error('id_vsat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($vehiculo->nombre)?$vehiculo->nombre:old('nombre') }}" required autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="patente" class="col-md-4 col-form-label text-md-right">{{ __('Patente') }} </label>

                            <div class="col-md-6">
                                <input id="patente" type="text" class="form-control @error('patente') is-invalid @enderror" name="patente" value="{{ isset($vehiculo->patente)?$vehiculo->patente:old('patente') }}" autocomplete="patente" autofocus>

                                @error('patente')
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