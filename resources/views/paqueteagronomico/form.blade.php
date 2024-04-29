                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" required autofocus>
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
                                    <select class="form-control @error('NumSMaq') is-invalid @enderror" id="NumSMaq" multiple name="NumSMaq[]" value="{{ isset($jdlink->NumSMaq)?$jdlink->NumSMaq:old('NumSMaq') }}" autofocus>
                                        <option value="">Debe seleccionar una organizacion</option>
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
                            <label for="ambientes" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Identificación de ambientes ') }}</h5></label>

                            <div class="col-md-6">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="ambientes" checked disabled>
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i> <br> - Mediante la utilización de imágenes NDVI históricas y mapas de rendimientos se 
                                    identifica la variabilidad en los lotes, realizando porsteriormente una zonificación por 
                                    ambientes de manejo.
                                <br> - Visita a campo donde se recorren los diferentes ambientes de manejo para validar la 
                                    zonificación realizada.
                                <br></i>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <label for="variables" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Cuantificación de las variables') }}</h5></label>

                            <div class="col-md-6">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="variables" checked disabled>
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i> <br> - Se realiza un muestreo de suelo dirigido georreferenciado, en donde se van a tomar 
                                    una muestra por ambiente para determinar características físicas y químicas. Luego se cargan 
                                    los puntos del muestreo de suelo y los análisis de suelo en la cuenta de Centro de Operaciones 
                                    del Cliente y en la App de Sala hnos.
                                <br> - Ensayos de densidad y fertilización por ambientes o zonas de manejo.
                                <br> - Reunión con el cliente para definir la estrategia de fertilización a utilizar, 
                                    densidades e híbridos de cada ambiente.
                                <br> - Elaboración de las prescripciones finales con ensayo de dosis fija testigo,  
                                    envío de la misma al cliente con la cantidad de insumos necesarios (semillas y fertilizantes) 
                                    por lote, para que pueda gestionar la compra de los mismos.
                                <br></i>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <label for="marcha" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Puesta en marcha') }}</h5></label>

                            <div class="col-md-6">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="marcha" checked disabled>
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i> <br> - Regulación de piloto automático, y actualización de todos los componentes de 
                                    agricultura de precisión.
                                <br> - Puesta a punto de sembradora John Deere o Pla, incluye regulación de corte por sección y 
                                    dosis variable (fertilización y semillas).
                                <br> - Carga de la prescripción en en el monitor de siembra y configuración de la maquinaria 
                                    para que ejecute dicha órden de trabajo.
                                <br> - Control inicial a campo de ejecución correcta de prescripción y seguimiento posterior vía 
                                    remota.
                                <br> - En cultivo emergente se realiza un conteo del stand de plantas logradas.
                                <br> - Muestreo de refertilización nitrogenada para posterior elaboracion de prescripcion de 
                                    aplicación variable.
                                <br> - Se realiza una asistencia al momento de realizar la fertilización nitrogenada para 
                                    cargar las prescripciones y calibrar el equipo de dosificación variable
                                <br></i>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <label for="basico" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Seguimiento en campaña y análisis final ') }}</h5></label>

                            <div class="col-md-6">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="basico" checked disabled>
                                    <span class="slider round"></span>
                                </label>
                                <br>
                               <i> <br> - Carga automática de imágenes NDVI semanalmente en la App de Sala.
                                <br> - Servicio de diagnóstico a distancia para maquinaria John Deere conectada.
                                <br> - Prevención de fallas futuras con Expert Alerts.
                                <br> - Informes diarios y semanales de eficiencia de utilización de máquina y agronómicos en 
                                    la App de Sala hnos.
                                <br> - Gestion de alertas de maquinaria John Deere.
                                <br> - Ordenamiento de datos agronómicos en Centro de Operaciones.
                                <br> - Momento oportuno de cosecha mediante el seguimiento de imágenes satelitales.
                                <br> - Procesamiento de mapas de cosecha.
                                <br> - Análisis final económico y agronómico de cada lote.
                                <br> - Soporte telefónico.
                                <br> - Capacitaciones agronómicas.
                                <br></i>
                            </div>
                        </div>
                        <hr>
                        
                        <div class="form-group row">
                            <label for="asesor" class="col-md-4 col-form-label text-md-right"><h5>{{ __('¿Quién lo asesoró sobre el Paquete de soporte y monitoreo?') }} *</h5></label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('asesor') is-invalid @enderror" data-live-search="true" id="asesor" name="asesor" value="{{ isset($senal->asesor)?$senal->asesor:old('asesor') }}" required autofocus>
                                    <option value="">Seleccionar colaborador</option>
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
                    <!--
                        <div class="row justify-content-center">
                            <h3><label for="">US$ <input type="number" name="costoph" id="costoph" value="7" readonly></label><small> p/Ha.</small></h3>
                        </div>
                    -->
                        <div class="row justify-content-center">
                            <h3><label for="">Lotes <input type="number" name="lotes" id="lotes" placeholder="Ej: 8" required></label></h3>
                        </div>
                        <div class="row justify-content-center">
                            <h3><label for="">Hectáreas <input type="number" name="hectareas" id="hectareas" placeholder="Ej: 1200" required></label></h3>
                        </div>
                    <!--
                        <div class="row justify-content-center">
                            <h3><label for="">US$ <input type="number" name="costo" id="costo" readonly></label><small> + IVA</small></h3>
                        </div>
                    -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{  __('Presupuestar') }}    
                                </button>
                            </div>
                        </div>