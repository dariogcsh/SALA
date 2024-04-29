                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
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
                                    <select class="form-control @error('NumSMaq') is-invalid @enderror" id="NumSMaq" multiple name="NumSMaq[]" onchange="javascript:suma()" value="{{ isset($jdlink->NumSMaq)?$jdlink->NumSMaq:old('NumSMaq') }}" autofocus>
                                        <option value="otra">Debe seleccionar una organizacion</option>
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
                            <label for="basico" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Plan Standard') }}</h5></label>

                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="basico" checked disabled>
                                    <span class="slider round"></span>
                                </label>
                                <br>
                               <i> <br> - Digitalización de Sistema de Producción en Operation Center.
                                <br> - Ordenamiento de datos agronómicos en el Operation Center y generación de archivo de configuración para equipos John Deere.
                                <br> - Capacitación de Operation Center.
                                <br> - Carga de plan de mantenimiento en Operation Center.
                                <br> - Se informaran alertas de relevancia a la persona designada por el dueño/encargado de la organización para evitar roturas o daños en el equipo.
                                (Dispone de 120 minutos de soporte telefónico por alertas que emita el equipo o de asistencias que se registren en la App de SALA).
                                <br> - Informe de eficiencia de uso de cosechadora.
                                <br> - Informe Agronómico diario en SALA App.
                                <br> - Gestión de alertas de posibles ocurrencias en un futuro inmediato (Expert Alert).
                                <br> - Beneficios exclusivos para Clientes Conectados.
                                <br> - Servicio de diagnóstico a distancia.
                                <br></i>
                            </div>
                            <div class="col-md-1"><b>US$ 650</b></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="actualizacion_comp" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Actualización de componentes') }}</h5></label>

                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="actualizacion_comp" id="actualizacion_comp" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i><br> - Actualización de receptor Star Fire
                                <br> - Actualización de pantalla Green Star
                                <br> - Actualización de unidad de control SSU
                                <br> (Se realizara en concesionario en caso de no adherir a la Visita Inicial)</i>
                            </div>
                            <div class="col-md-1"><b>US$ 100</b></div>
                            <div class="col-md-2" id="desc"></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="visita_inicial" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Visita Inicial') }}</h5></label>


                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="visita_inicial" id="visita_inicial" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i><br> - Incluye viaje a campo
                                <br> - Configuración de parámetros de documentación
                                <br> - Capacitación de uso de la cosechadora
                                <br> - Capacitación de limpieza
                                <br> - Capacitación de ajustes de cosechadora y plataforma</i>
                            </div>
                            <div class="col-md-1"><b>US$ 200</b></div>
                            <div class="col-md-2" id="desc_visita"></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="capacitacion_op" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Capacitación a operarios') }}</h5></label>

                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="capacitacion_op" id="capacitacion_op" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                               <i> <br> - Capacitación para 2 operarios en concesionaria
                                <br> - Uso y funcionamiento de cosechadora
                                <br> - Mantenimiento de cosechadora
                                <br> - Automatización de cosechadora según corresponda</i>
                            </div>
                            <div class="col-md-1"><b>US$ 100</b></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="capacitacion_asesor" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Capacitación a asesor agronómico') }}</h5></label>

                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="capacitacion_asesor" id="capacitacion_asesor" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                               <i> <br> - Capacitación para el asesor agronómico de la organización
                                <br> - 4 módulos de utilización de herramientas del Centro de Operaciones, para visualización de mapeo con sus
                                capas en cada una de sus labores, gestión de líneas de guiados y marcadores, ordenamiento de los datos agronómicos,
                                API's vinculadas para la generación de prescripciones y para visualización de imágenes NDV en el Centro de Operaciones.</i>
                            </div>
                            <div class="col-md-1"><b>US$ 100</b></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="ensayo" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Ensayo de automatización (Solo Combine Advisor)') }}</h5></label>

                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="ensayo" id="ensayo" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i><br> - Incluye viaje a campo
                                <br> - Se analiza la calidad de grano en tolva con la máquina sin automatizar
                                <br> - Se analiza la calidad de grano en tolva con la maquina automatizada
                                <br> - Se analizan tiempos de cosecha con ambos estados de funcionamiento
                                <br> - Se analiza productividad de la máquina comparando ambos estados</i>
                            </div>
                            <div class="col-md-1"><b>US$ 200</b></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="check_list" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Check List') }}</h5></label>

                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="check_list" id="check_list" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i> <br> - Incluye viaje a campo
                                <br> - Inspección técnica de puntos de mantenimiento
                                <br> - Inspección técnica de piezas de desgaste</i>
                            </div>
                            <div class="col-md-1"><b>US$ 200</b></div>
                            <div class="col-md-2" id="desc_check"></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="limpieza_inyectores" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Limpieza de inyectores') }}</h5></label>
                                
                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="limpieza_inyectores" id="limpieza_inyectores" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i> <br> - Incluye viaje a campo
                                <br> - Incluye servicio de limpieza de inyectores
                                <br> - Incluye consumibles
                                <br>(No incluye filtro de combustible del equipo)</i>
                            </div>
                            <div class="col-md-1"><b>US$ 500</b></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="analisis_final" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Analisis final de campaña') }}</h5></label>

                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="analisis_final" id="analisis_final" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i> <br> Se realizará en el concesionario una reunión donde se analizará diferentes 
                                    indicadores que se obtuvieron durante toda la campaña de cosecha tales como: 
                                    eficiencia de utilización de máquina, informes agronómicos, competencias de 
                                    variedades e híbridos, etc. Como así también indicadores finales de campaña donde 
                                    se analizarán costos de producción y márgenes para analizar las rentabilidades de 
                                    cada uno de los lotes o granjas.</i>
                            </div>
                            <div class="col-md-1"><b>US$ 150</b></div>
                        </div>

                        <div class="form-group row">
                            <label for="mes" class="col-md-4 col-form-label text-md-right"><h5>{{ __('¿Mes de facturación?') }} *</h5></label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('mes') is-invalid @enderror" data-live-search="true" id="mes" name="mes" value="{{ isset($senal->mes)?$senal->mes:old('mes') }}" required autofocus>
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
                        <hr>

                        <div class="form-group row">
                            <label for="asesor" class="col-md-4 col-form-label text-md-right"><h5>{{ __('¿Quién lo asesoró sobre el Paquete de soporte y monitoreo?') }} *</h5></label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('asesor') is-invalid @enderror" data-live-search="true" id="asesor" name="asesor" value="{{ isset($senal->asesor)?$senal->asesor:old('asesor') }}" required autofocus>
                                    <option value="">Seleccione colaborador</option>
                                    @foreach ($asesores as $asesor)
                                        <option value="{{ $asesor->last_name }} {{ $asesor->name }}" 
                                            >{{ $asesor->last_name }} {{ $asesor->name }}</option>
                                    @endforeach
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
                        
                        <div class="row justify-content-center">
                            <h3><label for="">US$ <input type="number" name="costo" id="costo" value="650" readonly></label><small> + IVA </small></h3>
                        </div>
                        <div class="row justify-content-center">
                            <em>(Por máquina)</em>
                        </div>
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{  __('Enviar') }}    
                                </button>
                            </div>
                        </div>