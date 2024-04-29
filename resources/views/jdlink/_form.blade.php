                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($organizacionjd)
                                                @if($organizacion->id == $organizacionjd->CodiOrga)
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

                        
                            <div class="form-group row">
                                <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie de la máquina') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('NumSMaq') is-invalid @enderror" id="NumSMaq" name="NumSMaq" value="{{ isset($jdlink->NumSMaq)?$jdlink->NumSMaq:old('NumSMaq') }}" autofocus>
                                        @isset($jdlink) 
                                            <option value="{{ $jdlink->NumSMaq }}" selected>{{ $jdlink->NumSMaq }} </option>
                                        @endisset
                                    </select>
                                    @error('NumSMaq')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                    @can('haveaccess','maquina.create')
                                        <div class="col-md-2">
                                            <a href="{{ route('maquina.create') }}" title="Crear máquina nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea crear una máquina nueva y salir del registro de conectividad?');"><b>+</b></a>
                                        </div>
                                    @endcan
                            </div>
                       

                        <div class="form-group row">
                            <label for="conectado" class="col-md-4 col-form-label text-md-right">{{ __('Conectado') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->conectado)
                                        @if($jdlink->conectado == 'SI')
                                            <input type="checkbox" class="warning" name="conectado" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="conectado">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="conectado">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="monitoreo" class="col-md-4 col-form-label text-md-right">{{ __('Monitoreo') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->monitoreo)
                                        @if($jdlink->monitoreo == 'SI')
                                            <input type="checkbox" class="warning" name="monitoreo" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="monitoreo">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="monitoreo">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="soporte_siembra" class="col-md-4 col-form-label text-md-right">{{ __('Soporte en siembra') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->soporte_siembra)
                                        @if($jdlink->soporte_siembra == 'SI')
                                            <input type="checkbox" class="warning" name="soporte_siembra" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="soporte_siembra">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="soporte_siembra">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="informes" class="col-md-4 col-form-label text-md-right">{{ __('Informes') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->informes)
                                        @if($jdlink->informes == 'SI')
                                            <input type="checkbox" class="warning" name="informes" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="informes">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="informes">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alertas" class="col-md-4 col-form-label text-md-right">{{ __('Gestión de alertas') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->alertas)
                                        @if($jdlink->alertas == 'SI')
                                            <input type="checkbox" class="warning" name="alertas" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="alertas">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="alertas">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mantenimiento" class="col-md-4 col-form-label text-md-right">{{ __('Mantenimiento') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('mantenimiento') is-invalid @enderror" id="mantenimiento" name="mantenimiento" value="{{ isset($jdlink->mantenimiento)?$jdlink->mantenimiento:old('mantenimiento') }}" autofocus>
                                    @isset($jdlink->mantenimiento)
                                        <option value="{{ $jdlink->mantenimiento }}">{{ $jdlink->mantenimiento }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="Cargado">Cargado</option>
                                </select>
                                @error('mantenimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="actualizacion_comp" class="col-md-4 col-form-label text-md-right">{{ __('Actualización de componentes') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('actualizacion_comp') is-invalid @enderror" id="actualizacion_comp" name="actualizacion_comp" value="{{ isset($jdlink->actualizacion_comp)?$jdlink->actualizacion_comp:old('actualizacion_comp') }}" autofocus>
                                    @isset($jdlink->actualizacion_comp)
                                        <option value="{{ $jdlink->actualizacion_comp }}">{{ $jdlink->actualizacion_comp }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="Bonificado">Bonificado</option>
                                    <option value="Realizado">Realizado</option>
                                </select>
                                @error('actualizacion_comp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="capacitacion_op" class="col-md-4 col-form-label text-md-right">{{ __('Capacitación a operarios') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->capacitacion_op)
                                        @if($jdlink->capacitacion_op == 'SI')
                                            <input type="checkbox" class="warning" name="capacitacion_op" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="capacitacion_op">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="capacitacion_op">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="capacitacion_asesor" class="col-md-4 col-form-label text-md-right">{{ __('Capacitación a asesores agronómicos') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->capacitacion_asesor)
                                        @if($jdlink->capacitacion_asesor == 'SI')
                                            <input type="checkbox" class="warning" name="capacitacion_asesor" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="capacitacion_asesor">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="capacitacion_asesor">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ordenamiento_agro" class="col-md-4 col-form-label text-md-right">{{ __('Ordenamiento de datos agronómicos') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->ordenamiento_agro)
                                        @if($jdlink->ordenamiento_agro == 'SI')
                                            <input type="checkbox" class="warning" name="ordenamiento_agro" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="ordenamiento_agro">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="ordenamiento_agro">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_comienzo" class="col-md-4 col-form-label text-md-right">{{ __('Fecha aprox. de comienzo') }}</label>
                        
                            <div class="col-md-6">
                                <input id="fecha_comienzo" type="date" class="form-control @error('fecha_comienzo') is-invalid @enderror" name="fecha_comienzo" value="{{ isset($jdlink->fecha_comienzo)?$jdlink->fecha_comienzo:old('fecha_comienzo') }}" autofocus>
                        
                                @error('fecha_comienzo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="visita_inicial" class="col-md-4 col-form-label text-md-right">{{ __('Visita Inicial') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('visita_inicial') is-invalid @enderror" id="visita_inicial" name="visita_inicial" value="{{ isset($jdlink->visita_inicial)?$jdlink->visita_inicial:old('visita_inicial') }}" autofocus>
                                    @isset($jdlink->visita_inicial)
                                        <option value="{{ $jdlink->visita_inicial }}">{{ $jdlink->visita_inicial }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="Bonificado">Bonificado</option>
                                    <option value="Realizada">Realizada</option>
                                </select>
                                @error('visita_inicial')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_visita" class="col-md-4 col-form-label text-md-right">{{ __('Fecha visita inicial') }}</label>
                        
                            <div class="col-md-6">
                                <input id="fecha_visita" type="date" class="form-control @error('fecha_visita') is-invalid @enderror" name="fecha_visita" value="{{ isset($jdlink->fecha_visita)?$jdlink->fecha_visita:old('fecha_visita') }}" autofocus>
                        
                                @error('fecha_visita')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="calibracion_implemento" class="col-md-4 col-form-label text-md-right">{{ __('Calibración de implemento') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->calibracion_implemento)
                                        @if($jdlink->calibracion_implemento == 'SI')
                                            <input type="checkbox" class="warning" name="calibracion_implemento" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="calibracion_implemento">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="calibracion_implemento">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ensayo" class="col-md-4 col-form-label text-md-right">{{ __('Ensayo (Combine Advisor)') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('ensayo') is-invalid @enderror" id="ensayo" name="ensayo" value="{{ isset($jdlink->ensayo)?$jdlink->ensayo:old('ensayo') }}" autofocus>
                                    @isset($jdlink->ensayo)
                                        <option value="{{ $jdlink->ensayo }}">{{ $jdlink->ensayo }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="Realizado">Realizado</option>
                                </select>
                                @error('ensayo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="check_list" class="col-md-4 col-form-label text-md-right">{{ __('Check List') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('check_list') is-invalid @enderror" id="check_list" name="check_list" value="{{ isset($jdlink->check_list)?$jdlink->check_list:old('check_list') }}" autofocus>
                                    @isset($jdlink->check_list)
                                        <option value="{{ $jdlink->check_list }}">{{ $jdlink->check_list }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="Bonificado">Bonificado</option>
                                    <option value="Realizado">Realizado</option>
                                </select>
                                @error('check_list')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="limpieza_inyectores" class="col-md-4 col-form-label text-md-right">{{ __('Limpieza de inyectores') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('limpieza_inyectores') is-invalid @enderror" id="limpieza_inyectores" name="limpieza_inyectores" value="{{ isset($jdlink->limpieza_inyectores)?$jdlink->limpieza_inyectores:old('limpieza_inyectores') }}" autofocus>
                                    @isset($jdlink->limpieza_inyectores)
                                        <option value="{{ $jdlink->limpieza_inyectores }}">{{ $jdlink->limpieza_inyectores }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="Realizada">Realizada</option>
                                </select>
                                @error('limpieza_inyectores')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="apivinculada" class="col-md-4 col-form-label text-md-right">{{ __('API vinculada') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->apivinculada)
                                        @if($jdlink->apivinculada == 'SI')
                                            <input type="checkbox" class="warning" name="apivinculada" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="apivinculada">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="apivinculada">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="analisis_final" class="col-md-4 col-form-label text-md-right">{{ __('Analisis final') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('analisis_final') is-invalid @enderror" id="analisis_final" name="analisis_final" value="{{ isset($jdlink->analisis_final)?$jdlink->analisis_final:old('analisis_final') }}" autofocus>
                                    @isset($jdlink->analisis_final)
                                        <option value="{{ $jdlink->analisis_final }}">{{ $jdlink->analisis_final }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="Bonificado">Bonificado</option>
                                    <option value="Realizado">Realizado</option>
                                </select>
                                @error('analisis_final')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hectareas" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de hectareas') }}</label>

                            <div class="col-md-6">
                                <input id="hectareas" type="text" class="form-control" name="hectareas" value="{{ isset($jdlink->hectareas)?$jdlink->hectareas:old('hectareas') }}">
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="calidad_siembra" class="col-md-4 col-form-label text-md-right">{{ __('Relevamiento de calidad de siembra') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->calidad_siembra)
                                        @if($jdlink->calidad_siembra == 'SI')
                                            <input type="checkbox" class="warning" name="calidad_siembra" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="calidad_siembra">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="calidad_siembra">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="muestreo" class="col-md-4 col-form-label text-md-right">{{ __('Muestreo de suelo') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    @isset($jdlink->muestreo)
                                        @if($jdlink->muestreo == 'SI')
                                            <input type="checkbox" class="warning" name="muestreo" checked>
                                        @else
                                            <input type="checkbox" class="warning" name="muestreo">
                                        @endif 
                                    @else
                                        <input type="checkbox" class="warning" name="muestreo">
                                    @endisset
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ambientes" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de ambientes a muestrear') }}</label>

                            <div class="col-md-6">
                                <input id="ambientes" type="number" step="0.01" class="form-control @error('ambientes') is-invalid @enderror" name="ambientes" value="{{ isset($jdlink->ambientes)?$jdlink->ambientes:old('ambientes') }}" autocomplete="ambientes" autofocus>

                                @error('ambientes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo') }}</label>

                            <div class="col-md-6">
                                <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($jdlink->costo)?$jdlink->costo:old('costo') }}" autocomplete="costo" autofocus>

                                @error('costo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @php $aux = 0; @endphp
                        <div class="form-group row">
                            <label for="id_mibonificacion" class="col-md-4 col-form-label text-md-right">{{ __('Beneficios disponibles') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_mibonificacion') is-invalid @enderror" id="id_mibonificacion" name="id_mibonificacion" value="{{ isset($jdlink->id_mibonificacion)?$jdlink->id_mibonificacion:old('id_mibonificacion') }}" autofocus>
                                    <option value="">Seleccionar bonificacion</option>
                                    @isset($misbonificaciones)
                                        @foreach ($misbonificaciones as $mibonificacion)
                                            @isset($jdlink->mibonificacions->id)
                                                @if($mibonificacion->id == $jdlink->mibonificacions->id)
                                                    <option value="{{ $mibonificacion->id }}" selected>{{ $mibonificacion->tipo }} - {{ $mibonificacion->descuento }}% </option>
                                                    @php $aux = $mibonificacion->id ; @endphp
                                                @endif
                                            @endisset
                                            @if($aux <> $mibonificacion->id)
                                                <option value="{{ $mibonificacion->id }}">{{ $mibonificacion->tipo }} - {{ $mibonificacion->descuento }}% </option>
                                            @endif
                                        @endforeach
                                    @endisset
                                </select>
                                @error('id_mibonificacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contrato_firmado" class="col-md-4 col-form-label text-md-right">{{ __('Contrato firmado') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('contrato_firmado') is-invalid @enderror" id="contrato_firmado" name="contrato_firmado" value="{{ isset($jdlink->contrato_firmado)?$jdlink->contrato_firmado:old('contrato_firmado') }}" autofocus>
                                    @isset($jdlink->contrato_firmado)
                                        <option value="{{ $jdlink->contrato_firmado }}">{{ $jdlink->contrato_firmado }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="Confeccionado">Confeccionado</option>
                                    <option value="Enviado al cliente">Enviado al cliente</option>
                                    <option value="Firmado">Firmado</option>
                                    <option value="Validado">Validado</option>
                                </select>
                                @error('contrato_firmado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vencimiento_contrato" class="col-md-4 col-form-label text-md-right">{{ __('Vencimiento de contrato') }}</label>
                        
                            <div class="col-md-6">
                                <input id="vencimiento_contrato" type="date" class="form-control @error('vencimiento_contrato') is-invalid @enderror" name="vencimiento_contrato" value="{{ isset($jdlink->vencimiento_contrato)?$jdlink->vencimiento_contrato:old('vencimiento_contrato') }}" autofocus>
                        
                                @error('vencimiento_contrato')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="factura" class="col-md-4 col-form-label text-md-right">{{ __('Factura') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('factura') is-invalid @enderror" id="factura" name="factura" value="{{ isset($jdlink->factura)?$jdlink->factura:old('factura') }}" autofocus>
                                    @isset($jdlink->factura)
                                        <option value="{{ $jdlink->factura }}">{{ $jdlink->factura }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    <option value="Enviada al cliente">Enviada al cliente</option>
                                    <option value="Pagada">Pagada</option>
                                </select>
                                @error('factura')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="anofiscal" class="col-md-4 col-form-label text-md-right">{{ __('Año fiscal') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('anofiscal') is-invalid @enderror" id="anofiscal" name="anofiscal" value="{{ isset($jdlink->anofiscal)?$jdlink->anofiscal:old('anofiscal') }}" autofocus>
                                    <option value="">Año fiscal</option>
                                    @php $year = date("Y"); @endphp
                                        @for ($i= 2021; $i <= $year + 1 ; $i++)
                                        @isset($jdlink->anofiscal)
                                            @if($jdlink->anofiscal == $i)
                                                <option value="{{$i}}" selected>'{{$i}}</option>
                                            @endif
                                            <option value="{{$i}}">'{{$i}}</option>
                                        @else
                                            <option value="{{$i}}">'{{$i}}</option>
                                        @endisset
                                        @endfor
                                </select>
                                @error('anofiscal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="asesor" class="col-md-4 col-form-label text-md-right">{{ __('¿Quién asesoró al cliente sobre el Paquete de soporte y monitoreo?') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('asesor') is-invalid @enderror" data-live-search="true" id="asesor" name="asesor" value="{{ isset($senal->asesor)?$senal->asesor:old('asesor') }}" required autofocus>
                                    <option value="">Seleccionar colaborador</option>
                                    @isset($asesores)
                                        @foreach ($asesores as $asesor)
                                            @isset($jdlink->asesor)
                                                <option value="{{ $jdlink->asesor }}" 
                                                    selected>{{ $jdlink->asesor }}</option>
                                            @endisset
                                            <option value="{{ $asesor->last_name }} {{ $asesor->name }}" 
                                                >{{ $asesor->last_name }} {{ $asesor->name }}</option>
                                        @endforeach
                                    @endisset
                                    <option value="Otro">Otro</option>
                                    <option value="Ninguno">Ninguno</option>
                                </select>
                                @error('asesor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Registrar'):__('Modificar') }}    
                                </button>
                            </div>
                        </div>