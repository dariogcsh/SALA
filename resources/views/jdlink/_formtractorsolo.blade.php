                        
                        
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
                                <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie del tractor') }} *</label>
    
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
                                            <a href="{{ route('maquina.create') }}" title="Crear tractor nuevo" class="btn btn-warning float-left" onclick="return confirm('¿Desea crear una máquina nueva y salir del registro de conectividad?');"><b>+</b></a>
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
                               <i> <br> - Soporte y capacitación digital del centro de operaciones
                                <br> - Ordenamiento de datos en Operations Center
                                <br> - Digitalización de todo el sistema de producción
                                <br> - Acceso total a la App SALA
                                <br> - Informe de eficiencia de uso de tractor diario y semanal
                                <br> - Informe Agronómicos diarios
                                <br> - Carga de plan de mantenimiento
                                <br> - Gestión de alertas de posibles ocurrencias en un futuro inmediato (Expert Alert)
                                <br></i>
                            </div>
                            <div class="col-md-1"><b>US$ 300</b></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="alertas" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Monitoreo y soporte de alertas') }}</h5></label>

                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="alertas" id="alertas" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i><br> - Se informaran  alertas de relevancia a la persona designada por el dueño/encargado de la 
                                        organización para evitar roturas o daños en el equipo.</i>
                            </div>
                            <div class="col-md-1"><b>US$ 100</b></div>
                            <div class="col-md-2" id="desc"></div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="capacitacion" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Capacitación a operarios') }}</h5></label>


                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="capacitacion" id="capacitacion" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i><br> - Corresponde a una capacitación previa a la Siembra para dos operadores 
                                        en el Concesionario referida al uso y manejo de pantallas Gen4 y/o GS3
                            </i>
                            </div>
                            <div class="col-md-1"><b>US$ 100</b></div>
                            <div class="col-md-2" id="desc_visita"></div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <label for="calidad_siembra" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Relevamiento de calidad de siembra') }}</h5></label>
                                
                            <div class="col-md-5">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="calidad_siembra" id="calidad_siembra" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i> <br> - Refiere a un ensayo a campo en el cual se va a cuantificar la calidad de siembra de la plantadora, midiendo parámetros como coeficiente de variación, 
                                    desvío estándar, singulación, espaciado entre semillas y profundidad de siembra. Los resultados del ensayo serán cargados y trabajados en la 
                                    herramienta Agronomy Analyzer de John Deere y se entregará un informe analítico final. </i>
                            </div>
                            <div class="col-md-1"><b>US$ 250</b></div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <label for="muestreo" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Muestreo de suelo') }}</h5></label>
                                
                            <div class="col-md-3">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="muestreo" id="muestreo" onchange="javascript:suma()">
                                    <span class="slider round"></span>
                                </label>
                                <br>
                                <i> <br> - Corresponde a la toma de una muestra compuesta de suelo conformada por 10 submuestras por ambientes, siendo éstas: Nitrógeno, fosforo y 
                                    materia orgánica, y las condiciones de suelo como PH y conductividad eléctrica. Dichas muestras serán enviadas al laboratorio para su respectivo
                                    análisis (contempla viaje a campo, laboratorio y analisis final).                                    
                                    </i>
                            </div>
                            <div class="col-md-2"><b>US$ 80 por ambiente</b></div>
                            <div class="col-md-1"><input type="text" id="analisis" name="analisiss" disabled></div>
                        </div>
                        <hr>

                        <div id="muestreo_suelo" style="display:none">
                            <div class="form-group row">
                                <label for="ambientes" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Cantidad de ambientes') }}</h5></label>
                                    <input type="number" class="warning" name="ambientes" id="ambientes" onchange="javascript:suma()" value="1">
                            </div>
                            <hr>
                        </div>
                        
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

                        <div class="row justify-content-center">
                            <h3><label for="">US$ <input type="number" name="costo" id="costo" value="300" readonly></label><small> + IVA</small></h3>
                        </div>
                        <div class="row justify-content-center">
                            <em>(Por equipo)</em>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{  __('Enviar') }}    
                                </button>
                            </div>
                        </div>