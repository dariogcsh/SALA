                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_vsat" class="col-md-4 col-form-label text-md-right">{{ __('Id VSat') }} </label>

                            <div class="col-md-6">
                                <input id="id_vsat" type="text" class="form-control @error('id_vsat') is-invalid @enderror" name="id_vsat" value="{{ isset($vehiculo->id_vsat)?$vehiculo->id_vsat:old('id_vsat') }}" autocomplete="id_vsat" autofocus placeholder="Opcional">

                                @error('id_vsat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre VSat') }} </label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($vehiculo->nombre)?$vehiculo->nombre:old('nombre') }}" autocomplete="nombre" autofocus placeholder="Opcional">

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="marca" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }} *</label>
                    
                            <div class="col-md-6">
                                <select class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{ old('marca') }}" autofocus>
                                @isset($vehiculo->marca)
                                    <option value="{{ $vehiculo->marca }}">{{ $vehiculo->marca }}</option>
                                @else
                                    <option value="">Seleccionar</option>
                                @endisset
                                    <option value="Toyota">Toyota</option>
                                    <option value="Volkswagen">Volkswagen</option>
                                    <option value="Ford">Ford</option>
                                    <option value="Honda">Honda</option>
                                    <option value="Peugeot">Peugeot</option>
                                    <option value="Mercedes Benz">Mercedes Benz</option>
                                    <option value="Volvo">Volvo</option>
                                    <option value="Renault">Renault</option>
                                    <option value="Fiat">Fiat</option>
                            </select>
                    
                            <span class="text-danger" id="marcaError"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }} * </label>

                            <div class="col-md-6">
                                <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{ isset($vehiculo->modelo)?$vehiculo->modelo:old('modelo') }}" required autocomplete="modelo" autofocus>

                                @error('modelo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ano" class="col-md-4 col-form-label text-md-right">{{ __('Año') }} </label>

                            <div class="col-md-6">
                                <input id="ano" type="number" class="form-control @error('ano') is-invalid @enderror" name="ano" value="{{ isset($vehiculo->ano)?$vehiculo->ano:old('ano') }}" required autocomplete="ano" autofocus>

                                @error('ano')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="patente" class="col-md-4 col-form-label text-md-right">{{ __('Patente') }} * </label>

                            <div class="col-md-6">
                                <input id="patente" type="text" class="form-control @error('patente') is-invalid @enderror" name="patente" value="{{ isset($vehiculo->patente)?$vehiculo->patente:old('patente') }}" required placeholder="AA111BB" autocomplete="patente" autofocus>

                                @error('patente')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nvehiculo" class="col-md-4 col-form-label text-md-right">{{ __('N° Vehiculo SALA') }} </label>

                            <div class="col-md-6">
                                <input id="nvehiculo" type="number" class="form-control @error('nvehiculo') is-invalid @enderror" name="nvehiculo" value="{{ isset($vehiculo->nvehiculo)?$vehiculo->nvehiculo:old('nvehiculo') }}" required autocomplete="nvehiculo" autofocus>

                                @error('nvehiculo')
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
                                    <option value="">Seleccionar</option>
                                    @foreach($sucursals as $sucursal)
                                    <option value="{{ $sucursal->id }}"
                                    @isset($vehiculo->id_sucursal)
                                        @if($sucursal->id == $vehiculo->id_sucursal)
                                            selected
                                        @endif
                                    @endisset
                                    >{{ $sucursal->NombSucu }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_registro" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Registro (Leasing/SALA)') }} </label>

                            <div class="col-md-6">
                                <input id="tipo_registro" type="text" class="form-control @error('tipo_registro') is-invalid @enderror" name="tipo_registro" value="{{ isset($vehiculo->tipo_registro)?$vehiculo->tipo_registro:old('tipo_registro') }}" autocomplete="tipo_registro" autofocus>

                                @error('tipo_registro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="seguro" class="col-md-4 col-form-label text-md-right">{{ __('Seguro') }} </label>

                            <div class="col-md-6">
                                <input id="seguro" type="text" class="form-control @error('seguro') is-invalid @enderror" name="seguro" value="{{ isset($vehiculo->seguro)?$vehiculo->seguro:old('seguro') }}" placeholder="Opcional" autocomplete="seguro" autofocus>

                                @error('seguro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vto_poliza" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de vencimiento poliza') }} </label>

                            <div class="col-md-6">
                                <input id="vto_poliza" type="date" class="form-control @error('vto_poliza') is-invalid @enderror" name="vto_poliza" value="{{ isset($vehiculo->vto_poliza)?$vehiculo->vto_poliza:old('vto_poliza') }}" autocomplete="vto_poliza" autofocus>

                                @error('vto_poliza')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nchasis" class="col-md-4 col-form-label text-md-right">{{ __('N° Chasis') }} </label>

                            <div class="col-md-6">
                                <input id="nchasis" type="text" class="form-control @error('nchasis') is-invalid @enderror" name="nchasis" value="{{ isset($vehiculo->nchasis)?$vehiculo->nchasis:old('nchasis') }}" placeholder="Opcional" autocomplete="nchasis" autofocus>

                                @error('nchasis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nmotor" class="col-md-4 col-form-label text-md-right">{{ __('N° de motor') }} </label>

                            <div class="col-md-6">
                                <input id="nmotor" type="text" class="form-control @error('nmotor') is-invalid @enderror" name="nmotor" value="{{ isset($vehiculo->nmotor)?$vehiculo->nmotor:old('nmotor') }}" placeholder="Opcional" autocomplete="nmotor" autofocus>

                                @error('nmotor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="departamento" class="col-md-4 col-form-label text-md-right">{{ __('Departamento') }} *</label>
                    
                            <div class="col-md-6">
                                <select class="form-control @error('departamento') is-invalid @enderror" id="departamento" name="departamento" value="{{ old('departamento') }}" required autofocus>
                                @isset($vehiculo->departamento)
                                    <option value="{{ $vehiculo->departamento }}">{{ $vehiculo->departamento }}</option>
                                @else
                                    <option value="">Seleccionar</option>
                                @endisset
                                    <option value="Ventas">Ventas</option>
                                    <option value="Servicio">Servicio</option>
                                    <option value="RAC">RAC</option>
                                    <option value="Soluciones integrales">Soluciones integrales</option>
                                    <option value="Administracion">Administracion</option>
                                    <option value="RRHH">RRHH</option>
                                    <option value="Transporte de carga">Transporte de carga</option>
                                    <option value="Gerencia">Gerencia</option>
                            </select>
                    
                            <span class="text-danger" id="departamentoError"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>