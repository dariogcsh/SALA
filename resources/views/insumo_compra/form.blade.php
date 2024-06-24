                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="fecha_compra" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de compra') }} *</label>

                            <div class="col-md-6">
                                <input id="fecha_compra" type="date" class="form-control @error('fecha_compra') is-invalid @enderror" name="fecha_compra" value="{{ isset($insumo_compra->fecha_compra)?$insumo_compra->fecha_compra:old('fecha_compra') }}" required autofocus>

                                @error('fecha_compra')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nfactura" class="col-md-4 col-form-label text-md-right">{{ __('N° de factura') }} </label>

                            <div class="col-md-6">
                                <input id="nfactura" type="text" class="form-control @error('nfactura') is-invalid @enderror" name="nfactura" value="{{ isset($insumo_compra->nfactura)?$insumo_compra->nfactura:old('nfactura') }}" placeholder="(Opcional)" autofocus>

                                @error('nfactura')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }} *</label>
                        
                            <div class="col-md-6">
                                <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" value="{{ isset($insumo->categoria)?$insumo->categoria:old('categoria') }}" required autocomplete="categoria" autofocus>
                                    @isset($insumo->categoria)
                                        <option value="{{ $insumo->categoria }}">{{ $insumo->categoria }}</option>
                                    @else
                                        <option value="">Seleccionar</option>
                                    @endisset
                                        <option value="Variedad/Hibrido">Variedad/Hibrido</option>
                                        <option value="Fertilizante">Fertilizante</option>  
                                        <option value="Producto quimico">Producto quimico</option>    
                                </select>
                                <span class="text-danger" id="categoriaError"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_insumo" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('id_insumo') is-invalid @enderror" id="id_insumo" name="id_insumo" value="{{ old('id_insumo') }}" required autofocus> 
                                @isset($insumo->categoria)
                                    <option value="{{ $insumo->id }}">{{ $insumo->nombreinsumo }} ({{ $insumo->nombremarca }})</option>
                                @endisset
                            </select>
                                @error('id_insumo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <a title="Crear nuevo insumo" class="btn btn-warning float-left" onclick="javascript:mostrarInputMarca()"><b>+</b></a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="proveedor" class="col-md-4 col-form-label text-md-right">{{ __('Proveedor') }} </label>

                            <div class="col-md-6">
                                <input id="proveedor" type="text" class="form-control @error('proveedor') is-invalid @enderror" name="proveedor" value="{{ isset($insumo_compra->proveedor)?$insumo_compra->proveedor:old('proveedor') }}" placeholder="(Opcional)"  autocomplete="proveedor" autofocus>

                                @error('proveedor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="litros" class="col-md-4 col-form-label text-md-right">{{ __('Litros') }} *</label>

                            <div class="col-md-6">
                                <input id="litros" type="decimal" step="0.01" class="form-control @error('litros') is-invalid @enderror" name="litros" value="{{ isset($insumo_compra->litros)?$insumo_compra->litros:old('litros') }}" autofocus>

                                @error('litros')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="peso" class="col-md-4 col-form-label text-md-right">{{ __('Kg') }} *</label>

                            <div class="col-md-6">
                                <input id="peso" type="decimal" step="0.01" class="form-control @error('peso') is-invalid @enderror" name="peso" value="{{ isset($insumo_compra->peso)?$insumo_compra->peso:old('peso') }}" autofocus>

                                @error('peso')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bultos" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de bolsas') }} *</label>

                            <div class="col-md-6">
                                <input id="bultos" type="decimal" step="0.01" class="form-control @error('bultos') is-invalid @enderror" name="bultos" value="{{ isset($insumo_compra->bultos)?$insumo_compra->bultos:old('bultos') }}" autofocus>

                                @error('bultos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <label for="semillas" class="col-md-4 col-form-label text-md-right">{{ __('Semillas por bolsa') }} *</label>

                            <div class="col-md-6">
                                <input id="semillas" type="text" class="form-control @error('semillas') is-invalid @enderror" name="semillas" value="{{ isset($insumo_compra->semillas)?$insumo_compra->semillas:old('semillas') }}" autocomplete="semillas" autofocus>

                                @error('semillas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio (US$) por unidad de medida') }} *</label>

                            <div class="col-md-6">
                                <input id="precio" type="decimal" step="0.01" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ isset($insumo_compra->precio)?$insumo_compra->precio:old('precio') }}"  required autofocus>

                                @error('precio')
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