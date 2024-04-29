                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <input type="text" hidden value="{{ $organizacion }}" id="id_organizacion" name="id_organizacion"> 
                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }} *</label>
                        
                            <div class="col-md-6">
                                <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" value="{{ isset($insumo->categoria)?$insumo->categoria:old('categoria') }}" required autocomplete="categoria" autofocus>
                                    @isset($insumo->categoria)
                                        <option value="{{ $insumo->categoria }}">{{ $insumo->categoria }}</option>
                                    @else
                                        <option value="">Seleccionar</option>
                                    @endisset
                                        <option value="Variedad/Hibrido">Variedad/Hibrido</option>
                                        <option value="Producto quimico">Producto quimico</option>    
                                </select>
                                <span class="text-danger" id="categoriaError"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_marcainsumo" class="col-md-4 col-form-label text-md-right">{{ __('Marca comercial') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('id_marcainsumo') is-invalid @enderror" id="id_marcainsumo" name="id_marcainsumo" value="{{ old('id_marcainsumo') }}" required autofocus> 
                                    <option value="">Seleccionar</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{ $marca->id }}"
                                        @isset($insumo->id_marcainsumo)
                                            @if ($marca->id == $insumo->id_marcainsumo)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $marca->nombre }} </option>
                                    @endforeach
                                </select>
                                @error('id_marcainsumo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <a title="Crear marca nueva" class="btn btn-warning float-left" onclick="javascript:mostrarInputMarca()"><b>+</b></a>
                            </div>
                        </div>

                        <div id="marca_nueva" name="marca_nueva" style="display: none;">
                            <div class="form-group row">
                                <label for="marcainsumo" class="col-md-4 col-form-label text-md-right">{{ __('Marca nueva') }} *</label>

                                <div class="col-md-6">
                                    <input id="marcainsumo" type="text" class="form-control @error('marcainsumo') is-invalid @enderror" name="marcainsumo" autocomplete="marcainsumo" autofocus>

                                    @error('marcainsumo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($insumo->nombre)?$insumo->nombre:old('nombre') }}" required autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="producto_quimico" name="producto_quimico" style="display: none;">
                            <div class="form-group row">
                                <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>
                            
                                <div class="col-md-6">
                                    <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ isset($insumo->tipo)?$insumo->tipo:old('tipo') }}" autocomplete="tipo" autofocus>
                                        @isset($insumo->tipo)
                                            <option value="{{ $insumo->tipo }}">{{ $insumo->tipo }}</option>
                                        @else
                                            <option value="">Seleccionar</option>
                                        @endisset
                                            <option value="Herbicida">Herbicida</option>
                                            <option value="Insecticida">Insecticida</option>  
                                            <option value="Fungicida">Fungicida</option>
                                            <option value="Coadyudantes">Coadyudantes</option> 
                                    </select>
                                    <span class="text-danger" id="categoriaError"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="principio_activo" class="col-md-4 col-form-label text-md-right">{{ __('Principio activo') }}</label>

                                <div class="col-md-6">
                                    <input id="principio_activo" type="number" step="0.01" class="form-control @error('principio_activo') is-invalid @enderror" name="principio_activo" value="{{ isset($insumo->principio_activo)?$insumo->principio_activo:old('principio_activo') }}" autocomplete="principio_activo" autofocus>

                                    @error('principio_activo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="concentracion" class="col-md-4 col-form-label text-md-right">{{ __('Concentración') }}</label>

                                <div class="col-md-6">
                                    <input id="concentracion" type="number" step="0.01" class="form-control @error('concentracion') is-invalid @enderror" name="concentracion" value="{{ isset($insumo->concentracion)?$insumo->concentracion:old('concentracion') }}" autocomplete="concentracion" autofocus>

                                    @error('concentracion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bultos" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de bolsas/tanques') }}</label>

                            <div class="col-md-6">
                                <input id="bultos" type="number" class="form-control @error('bultos') is-invalid @enderror" name="bultos" value="{{ isset($insumo->bultos)?$insumo->bultos:old('bultos') }}" autocomplete="bultos" autofocus>

                                @error('bultos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cantxbulto" class="col-md-4 col-form-label text-md-right">{{ __('Capacidad de bolsa/tanque (Kg/Lts)') }}</label>

                            <div class="col-md-6">
                                <input id="cantxbulto" type="number" class="form-control @error('cantxbulto') is-invalid @enderror" name="cantxbulto" value="{{ isset($insumo->cantxbulto)?$insumo->cantxbulto:old('cantxbulto') }}" autocomplete="cantxbulto" autofocus>

                                @error('cantxbulto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="litros" class="col-md-4 col-form-label text-md-right">{{ __('Litros') }}</label>

                            <div class="col-md-6">
                                <input id="litros" type="number" step="0.01" class="form-control @error('litros') is-invalid @enderror" name="litros" value="{{ isset($insumo->litros)?$insumo->litros:old('litros') }}" autocomplete="litros" autofocus>

                                @error('litros')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="peso" class="col-md-4 col-form-label text-md-right">{{ __('Peso (Kg)') }}</label>

                            <div class="col-md-6">
                                <input id="peso" type="number" step="0.01" class="form-control @error('peso') is-invalid @enderror" name="peso" value="{{ isset($insumo->peso)?$insumo->peso:old('peso') }}" autocomplete="peso" autofocus>

                                @error('peso')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semillas" class="col-md-4 col-form-label text-md-right">{{ __('Semillas') }}</label>

                            <div class="col-md-6">
                                <input id="semillas" type="number"  class="form-control @error('semillas') is-invalid @enderror" name="semillas" value="{{ isset($insumo->semillas)?$insumo->semillas:old('semillas') }}" autocomplete="semillas" autofocus>

                                @error('semillas')
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