                        
                        
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
                                <select class="form-control @error('NumSMaq') is-invalid @enderror" id="NumSMaq" multiple name="NumSMaq[]"  value="{{ isset($jdlink->NumSMaq)?$jdlink->NumSMaq:old('NumSMaq') }}" autofocus>
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

                        <div class="form-group row justify-content-center">
                            <div class="col-md-1"></div>
                            <div class="col-md-10" style="text-align: center"><label for="basico"><h4><u>{{ __('Paquete de soporte agronómico de siembra') }}</u></h4></label></div>
                            <div class="col-md-1"></div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Generación de prescripciones utilizando mapas de rendimiento e imágenes satelitales') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                            <ul><li>
                            Refiere a la ambientación de los lotes desde el Centro de Soluciones Conectadas mediante la combinación y análisis de diferentes capas de mapas de rendimiento e imágenes satelitales de alta calidad. La ambientación se validará conjuntamente con el cliente y/o asesor agronómico considerando historial del lote, rotaciones de cultivos, etc y definiendo tipos de insumos y dosis para la prescripción.
                            </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Actualización de componentes de Agricultura de Precisión (monitor, receptor y controladores)') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Corresponde a actualización de receptor StarFire™, monitor GreenStar™ y controlador SSU. Se configurarán todos los parámetros de documentación para que el tractor esté en condiciones de mapear y se configurarán todos los parámetros del implemento para poder realizar la siembra y/o fertilización variable. 
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Regulación y calibración de piloto automático a campo') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Corresponde un viaje a campo previo a la siembra para regular y calibrar el piloto automático en el tractor con un implemento a utilizar para la siembra.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Carga de prescripciones en el monitor del tractor') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Corresponde a la importación del archivo de prescripción al monitor y posterior conversión del archivo Shapefile para que sea ejecutado correctamente.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Control de ejecución correcta de prescripción en el tractor') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Se controlará que el tractor y sembradora estén ejecutando de manera correcta lo que se indica en la prescripción correspondiente.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Control a campo de calidad de siembra') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Corresponde a un viaje a campo para controlar la calidad de siembra (espaciado entre semillas y profundidad de siembra).
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Control de anomalías a través de imágenes satelitales') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Hace referencia al control de alguna ocurrencia o anomalía que pudiera ocurrir en el lote, a través de una API vinculada al Centro
                                de Operaciones que brinda imágenes de NDVI periódicamente.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Capacitación a operarios y asesor agronómico') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Corresponde a una capacitación previa a la siembra para dos operadores referida a la configuración del monitor, de piloto automático, carga de prescripción, gestión y configuración para el registro de datos. También hace referencia a la capacitación para un asesor agronómico sobre el uso y utilidad de todas las herramientas que se encuentran en el Centro de Operaciones.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Seguimiento de carga de mapas de siembra en el Centro de Operaciones') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Se realizará un seguimiento periódico de la correcta carga de información y mapeo enviado vía remota por el tractor al Centro de Operaciones.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Soporte telefónico') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Se brindará soporte telefónico para maquinistas, asesores agronómicos, encargados, etc sobre configuraciones de pantallas, fallas, alertas,
                                utilización de tecnologías de maquinaria, utilización de herramientas del Centro de Operaciones, informes, etc.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Acceso total a la App de Sala Hnos. y sus herramientas') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Se brindará acceso total a todas las herramientas de la App de Sala Hnos para visualizar informes agronómicos, informes de ef iciencia de uso del tractor, puede solicitar asistencia a través de la misma y beneficiarse de bonificaciones que se cargar a lo largo del año para clientes conectados. También a través de este medio se le informará qué acción tomo la concesionaria ante la aparición de alguna alerta de gravedad en la unidad monitoreada.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Carga de plan de mantenimiento en JDLink') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Se cargará en la herramienta JDLink un plan de mantenimiento correspondiente al equipo según manual de mantenimiento y recomendaciones de técnicos especialistas. Esta herramienta informará 50 hs antes de llegar a un plan, cuales son las tareas correspondientes a realizar sobre el equipo, a través de una notificación de la App de JDLink y App de Sala Hnos.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Gestión de alertas proactivas y predictivas de tractor') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Hace referencia al monitoreo de alertas de gravedad que pudiera arrojar el equipo. Ante dicho acontecimiento el concesionario tomará acciones para comunicar dichas alertas y a qué refieren, si se puede seguir trabajando es necesario realizar algún servicio, etc. Esta acción realizada por el concesionario será informada a través de la App de Sala Hnos. para su conocimiento. También se gestionarán las alertas predictivas (Expert Alert) que permiten anticiparnos a una posible falla y realizar el servicio necesario en tiempo y forma evitando tiempos de máquina parada.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Informes agronómicos y de eficiencia de uso del tractor') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Corresponde a la generación de informes agronómicos semanales con indicadores de avances de siembra. También se generará un informe de eficiencia de uso del tractor cada 50 hs de motor y se notificará la generación y disponibilidad del mismo a través de la App de Sala Hnos. para su análisis.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Servicio de diagnóstico a distancia') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Para el caso de tener que hacerse un diagnóstico sobre el equipo por alguna falla, este diagnóstico se puede realizar via remota a distancia gracias a la telemetría JDLink, permitiendo ahorrar tiempos y costos de traslados para su realización.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Ordenamiento de datos agronómicos en el Centro de Operaciones') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Hace referencia al ordenamiento de datos agronómicos en el Centro de Operaciones, se realizarán los limites de todos los lotes, se ajustará la estructura de nombres de Clientes, Granjas y Campos según se indique, se realizarán combinaciones para el caso de duplicar se lotes con diferentes labores, correcciones en los limites, nombres, etc. Una vez realizado dicho ordenamiento se generará un archivo de configuración con toda esta estructura ordenada para que se cargue en la unidad y envíe la información de manera ordenada.
                                </li></ul>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                            <label class="col-md-10 col-form-label"><h5><span class="amarillo">{{ __('Análisis final de campaña') }}</span></h5></label>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <ul><li>
                                Se realizará en el Centro de Soluciones Conectadas un análisis final, donde se observarán diferentes informes agronómicos, mapeos comparativos de dosis planificada vs. dosis aplicada, informes de calidad de siembra y de eficiencia de uso del tractor.
                                </li></ul>
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

                        <div class="form-group row">
                            <label for="hectareas" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de Has.') }}</label>
    
                            <div class="col-md-4">
                                <input id="hectareas" type="text" class="form-control @error('hectareas') is-invalid @enderror" name="hectareas" value="{{  old('cantidad') }}" autofocus>
    
                                @error('hectareas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                    
                        <div class="form-group row">
                            <label for="costoh" class="col-md-4 col-form-label text-md-right">{{ __('Precio p/ha. US$ ') }}</label>
    
                            <div class="col-md-4">
                                <input id="costoh" type="text" class="form-control @error('costoh') is-invalid @enderror" name="costoh" value=""  disabled autofocus>
    
                                @error('costoh')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Precio total US$ ') }}</label>
    
                            <div class="col-md-4">
                                <input id="costo" type="text" class="form-control @error('costo') is-invalid @enderror" name="costo" value=""  readonly autofocus>
    
                                @error('costo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{  __('Enviar') }}    
                                </button>
                            </div>
                        </div>