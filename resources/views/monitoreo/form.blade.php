                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" required>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($organizacionjd)
                                                @if($organizacion->id == $organizacionjd->id)
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
                        </div>
                        
                        @isset($monitoreo_maquinas[0])
                            @php
                                $rep = 0;
                            @endphp
                        @else
                            @php
                                $rep = 1;
                            @endphp
                        @endisset
                        @for($i = $rep; $i <= 20; $i++)
                            @isset($monitoreo_maquinas[$i])
                                <div id='equipo{{ $i }}' style='display: block'>
                            @else
                                @if ($i == 1)
                                    <div id='equipo{{ $i }}' style='display: block'>
                                @else
                                    <div id='equipo{{ $i }}' style='display: none'>
                                @endif
                            @endisset

                                <div class="form-group row">
                                    <label for="NumSMaq{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie*') }}</label>

                                    <div class="col-md-6">
                                        <input id="NumSMaq{{ $i }}" type="text" class="form-control @error('NumSMaq{{ $i }}') is-invalid @enderror" name="NumSMaq{{ $i }}" value="{{ isset($monitoreo_maquinas[$i]['NumSMaq'])?$monitoreo_maquinas[$i]['NumSMaq']:old('NumSMaq'.$i) }}" autocomplete="NumSMaq{{ $i }}" autofocus>

                                        @error('NumSMaq{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="costo{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Costo (US$)*') }}</label>

                                    <div class="col-md-6">
                                        <input id="costo{{ $i }}" type="number" class="form-control @error('costo{{ $i }}') is-invalid @enderror" name="costo{{ $i }}" value="{{ isset($monitoreo_maquinas[$i]['costo'])?$monitoreo_maquinas[$i]['costo']:old('costo'.$i) }}" autocomplete="costo{{ $i }}" onKeyUp="calcular(this);" autofocus>

                                        @error('costo{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                @if($i <> 20)
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <a class="btn btn-warning" id="otro{{ $i }}">Agregar otro</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endfor
                        <br>
                        <div class="form-group row">
                            <label for="costo_total" class="col-md-4 col-form-label text-md-right">{{ __('Costo total (US$)') }}</label>

                            <div class="col-md-6">
                                <input id="costo_total" type="number" class="form-control @error('costo_total') is-invalid @enderror" name="costo_total" value="{{ isset($monitoreo->costo_total)?$monitoreo->costo_total:old('costo_total') }}" autocomplete="costo_total" readonly>

                                @error('costo_total')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="anofiscal" class="col-md-4 col-form-label text-md-right">{{ __('Año fiscal') }}</label>

                            <div class="col-md-6">
                                <input id="anofiscal" type="number" class="form-control @error('anofiscal') is-invalid @enderror" name="anofiscal" value="{{ isset($monitoreo->anofiscal)?$monitoreo->anofiscal:old('anofiscal') }}" autocomplete="anofiscal">

                                @error('anofiscal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mes_facturacion" class="col-md-4 col-form-label text-md-right">{{ __('¿Mes de facturación?') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('mes_facturacion') is-invalid @enderror" id="mes_facturacion" name="mes_facturacion" value="{{ isset($monitoreo->mes_facturacion)?$monitoreo->mes_facturacion:old('mes_facturacion') }}" required autofocus>
                                    @isset($monitoreo->mes_facturacion)
                                        <option value="{{ $monitoreo->mes_facturacion }}">{{ $monitoreo->mes_facturacion }}</option>
                                        <option value="Enero">Enero</option>
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                        <option value="Mayo">Mayo</option>
                                        <option value="Junio">Junio</option>
                                        <option value="Julio">Julio</option>
                                        <option value="Agosto">Agosto</option>
                                        <option value="Septiembre">Septiembre</option>
                                        <option value="Octubre">Octubre</option><option value="Noviembre">Noviembre</option>
                                        <option value="Diciembre">Diciembre</option>
                                    @endisset
                                    <option value="">Seleccionar mes</option>
                                    @if($mes == '01')
                                        <option value="Enero">Enero</option>
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                    @elseif($mes == '02')
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                    @elseif($mes == '03')
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                    @elseif($mes == '04')
                                        <option value="Abril">Abril</option>
                                        <option value="Mayo">Mayo</option>
                                    @elseif($mes == '05')
                                        <option value="Mayo">Mayo</option>
                                        <option value="Junio">Junio</option>
                                    @elseif($mes == '06')
                                        <option value="Junio">Junio</option>
                                        <option value="Julio">Julio</option>
                                    @elseif($mes == '07')
                                        <option value="Julio">Julio</option>
                                        <option value="Agosto">Agosto</option>
                                    @elseif($mes == '08')
                                        <option value="Agosto">Agosto</option>
                                        <option value="Septiembre">Septiembre</option>
                                    @elseif($mes == '09')
                                        <option value="Septiembre">Septiembre</option>
                                        <option value="Octubre">Octubre</option>
                                    @elseif($mes == '10')
                                        <option value="Octubre">Octubre</option>
                                        <option value="Noviembre">Noviembre</option>
                                    @elseif($mes == '11')
                                        <option value="Noviembre">Noviembre</option>
                                        <option value="Diciembre">Diciembre</option>
                                    @elseif($mes == '12')
                                        <option value="Diciembre">Diciembre</option>
                                        <option value="Enero">Enero</option>
                                    @endif
                                </select>
                                @error('mes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de paquete') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ isset($monitoreo->tipo)?$monitoreo->tipo:old('tipo') }}" required autofocus>
                                    @isset($monitoreo->tipo)
                                        <option value="{{ $monitoreo->tipo }}">{{ $monitoreo->tipo }}</option>
                                    @else
                                        <option value="">Seleccionar tipo</option>
                                    @endisset
                                    
                                        <option value="Oro">Oro</option>
                                        <option value="Plata">Plata</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ isset($monitoreo->estado)?$monitoreo->estado:old('estado') }}" required autofocus>
                                    @isset($monitoreo->estado)
                                        <option value="{{ $monitoreo->estado }}">{{ $monitoreo->estado }}</option>
                                    @else
                                        <option value="">Seleccionar estado</option>
                                    @endisset
                                    
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Listo para facturar">Listo para facturar</option>
                                        <option value="Facturado">Facturado</option>
                                        <option value="Cancelado">Cancelado</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="factura" class="col-md-4 col-form-label text-md-right">{{ __('N° de factura') }}</label>

                            <div class="col-md-6">
                                <input id="factura" type="text" class="form-control @error('factura') is-invalid @enderror" name="factura" value="{{ isset($monitoreo->factura)?$monitoreo->factura:old('factura') }}" autocomplete="factura" autofocus>

                                @error('factura')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_facturada" class="col-md-4 col-form-label text-md-right">{{ __('Fecha en que se facturó') }}</label>

                            <div class="col-md-6">
                                <input id="fecha_facturada" type="date" class="form-control @error('fecha_facturada') is-invalid @enderror" name="fecha_facturada" value="{{ isset($monitoreo->fecha_facturada)?$monitoreo->fecha_facturada:old('fecha_facturada') }}" autocomplete="fecha_facturada" autofocus>

                                @error('fecha_facturada')
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