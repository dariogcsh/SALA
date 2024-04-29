                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($reclamo->id_organizacion)?$reclamo->id_organizacion:old('id_organizacion') }}" required>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($orga_sucu)
                                                @if($organizacion->id == $orga_sucu->id)
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
                            <label for="id_sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_sucursal') is-invalid @enderror" data-live-search="true" id="id_sucursal" name="id_sucursal" value="{{ isset($reclamo->id_sucursal)?$reclamo->id_sucursal:old('id_sucursal') }}" required>
                                    <option value="">Seleccionar sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}" 
                                        @isset($orga_sucu)
                                                @if($sucursal->id == $orga_sucu->ids)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $sucursal->NombSucu }}</option>
                                    @endforeach
                                </select>
                                @error('id_sucursal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }} *</label>

                            <div class="col-md-6">
                                <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($reclamo->fecha)?$reclamo->fecha:old('fecha') }}" required autocomplete="fecha" autofocus>

                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="origen" class="col-md-4 col-form-label text-md-right">{{ __('Origen') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('origen') is-invalid @enderror" id="origen" name="origen" value="{{ isset($reclamo->origen)?$reclamo->origen:old('origen') }}" required autofocus>
                                    @isset($reclamo->origen)
                                        <option value="{{ $reclamo->origen }}">{{ $reclamo->origen }}</option>
                                    @else
                                        <option value="">Seleccionar origen</option>
                                    @endisset
                                        <option value="Auditoria interna">Auditoria interna</option>
                                        <option value="Auditoria externa">Auditoria externa</option>
                                        <option value="Queja/Reclamo">Queja/Reclamo</option>
                                        <option value="Proceso interno">Proceso interno</option>
                                </select>
                                @error('origen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hallazgo" class="col-md-4 col-form-label text-md-right">{{ __('Hallazgo') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('hallazgo') is-invalid @enderror" id="hallazgo" name="hallazgo" value="{{ isset($reclamo->hallazgo)?$reclamo->hallazgo:old('hallazgo') }}" required autofocus>
                                    @isset($reclamo->hallazgo)
                                        <option value="{{ $reclamo->hallazgo }}">{{ $reclamo->hallazgo }}</option>
                                    @else
                                        <option value="">Seleccionar hallazgo</option>
                                    @endisset
                                        <option value="NC menor">NC menor</option>
                                        <option value="NC mayor">NC mayor</option>
                                </select>
                                @error('hallazgo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="proceso" class="col-md-4 col-form-label text-md-right">{{ __('Proceso') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('proceso') is-invalid @enderror" id="proceso" name="proceso" value="{{ isset($reclamo->proceso)?$reclamo->proceso:old('proceso') }}" required autofocus>
                                    @isset($reclamo->proceso)
                                        <option value="{{ $reclamo->proceso }}">{{ $reclamo->proceso }}</option>
                                    @else
                                        <option value="">Seleccionar proceso</option>
                                    @endisset
                                        <option value="Ventas">Ventas</option>
                                        <option value="Servicios">Servicios</option>
                                        <option value="Repuestos">Repuestos</option>
                                        <option value="Administracion">Administracion</option>
                                        <option value="Soluciones integrales">Soluciones integrales</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre_cliente" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de cliente') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre_cliente" type="text" class="form-control @error('nombre_cliente') is-invalid @enderror" name="nombre_cliente" value="{{ isset($reclamo->nombre_cliente)?$reclamo->nombre_cliente:old('nombre_cliente') }}" required autocomplete="nombre_cliente" autofocus>

                                @error('nombre_cliente')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} *</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" required autocomplete="descripcion" autofocus rows="8">@isset($reclamo->descripcion){{ $reclamo->descripcion }}@endisset</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ isset($reclamo->estado)?$reclamo->estado:old('estado') }}" required autofocus>
                                    @isset($reclamo->estado)
                                        <option value="{{ $reclamo->estado }}">{{ $reclamo->estado }}</option>
                                    @else
                                        <option value="">Seleccionar estado</option>
                                    @endisset
                                        <option value="Abierta">Abierta</option>
                                        <option value="En proceso">En proceso</option>
                                        <option value="Cerrada">Cerrada</option>
                                        <option value="Eficaz">Eficaz</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
<br>
                        <h3>Acción de contingencia</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="accion_contingencia" class="col-md-4 col-form-label text-md-right">{{ __('Acción de contingencia') }} </label>

                            <div class="col-md-6">
                                <textarea id="accion_contingencia" class="form-control-textarea @error('accion_contingencia') is-invalid @enderror" name="accion_contingencia" value="{{ old('accion_contingencia') }}" autocomplete="accion_contingencia" autofocus rows="8"
                                @isset($reclamo->id_user_contingencia)
                                    @if($reclamo->id_user_contingencia <> auth()->id())
                                        readonly
                                    @endif
                                @endisset
                                >@isset($reclamo->accion_contingencia){{ $reclamo->accion_contingencia }}@endisset</textarea>

                                @error('accion_contingencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_contingencia" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user_contingencia') is-invalid @enderror" data-live-search="true" id="id_user_contingencia" name="id_user_contingencia" value="{{ isset($reclamo->id_user_contingencia)?$reclamo->id_user_contingencia:old('id_user_contingencia') }}">
                                    <option value="">Seleccionar responsable</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuario_contingencia)
                                                @if($usuario->id == $usuario_contingencia->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user_contingencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_limite_contingencia" class="col-md-4 col-form-label text-md-right">{{ __('Fecha límite') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_limite_contingencia" type="date" class="form-control @error('fecha_limite_contingencia') is-invalid @enderror" name="fecha_limite_contingencia" value="{{ isset($reclamo->fecha_limite_contingencia)?$reclamo->fecha_limite_contingencia:old('fecha_limite_contingencia') }}" autocomplete="fecha_limite_contingencia" autofocus>

                                @error('fecha_limite_contingencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <h3>Análisis de causa realizado</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="causa" class="col-md-4 col-form-label text-md-right">{{ __('Análisis de causa realizado') }} </label>

                            <div class="col-md-6">
                                <textarea id="causa" class="form-control-textarea @error('causa') is-invalid @enderror" name="causa" value="{{ old('causa') }}" autocomplete="causa" autofocus rows="8"
                                @isset($reclamo->id_user_responsable)
                                    @if($reclamo->id_user_responsable <> auth()->id())
                                        readonly
                                    @endif
                                @endisset
                                >@isset($reclamo->causa){{ $reclamo->causa }}@endisset</textarea>

                                @error('causa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_responsable" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user_responsable') is-invalid @enderror" data-live-search="true" id="id_user_responsable" name="id_user_responsable" value="{{ isset($reclamo->id_user_responsable)?$reclamo->id_user_responsable:old('id_user_responsable') }}">
                                    <option value="">Seleccionar responsable</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuario_responsable)
                                                @if($usuario->id == $usuario_responsable->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user_responsable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_contacto" class="col-md-4 col-form-label text-md-right">{{ __('Fecha límite') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_contacto" type="date" class="form-control @error('fecha_contacto') is-invalid @enderror" name="fecha_contacto" value="{{ isset($reclamo->fecha_contacto)?$reclamo->fecha_contacto:old('fecha_contacto') }}" autocomplete="fecha_contacto" autofocus>

                                @error('fecha_contacto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h3>Acción correctiva</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="id_user_correctiva" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_user_correctiva') is-invalid @enderror" multiple id="id_user_correctiva" name="id_user_correctiva[]" autofocus>
                                    @isset($usuarios_correctiva)
                                    @php 
                                    
                                    //array para guardar los users que ya esten asignados en la tarea
                                    $arrtec[] = ""; 
                                    $i=0;
                                    @endphp
                                        @foreach($usuarios as $usuario)
                                            @foreach($usuarios_correctiva as $user_c)
                                                @if($usuario->id == $user_c->id_user_correctiva)
                                                    <option class="{{ $usuario->id }}" value="{{ $usuario->id }}" selected>{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                                    @php 
                                                    //guardo el/los usuario que ya esta asignado en la tarea en un array
                                                    $arrtec[$i] = $usuario->id;
                                                    $i++; 
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <!--Comparo si el usuario del foreach esta dentro del array, caso contrario se asigna el option-->
                                            @if(!in_array($usuario->id, $arrtec))
                                                <option class="{{ $usuario->id }}" value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                            @endif
                                            @php 
                                            //Vuelvo i a 0 ya que hay una nueva iteracion
                                            $i = 0; 
                                            @endphp
                                        @endforeach
                                    @else
                                        @isset($usuarios)
                                            @foreach($usuarios as $usuario)
                                                <option class="{{ $usuario->id }}" value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                            @endforeach
                                        @endisset
                                    @endisset
                                </select>
                                @error('id_user_correctiva')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_limite_correctiva" class="col-md-4 col-form-label text-md-right">{{ __('Fecha límite') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_limite_correctiva" type="date" class="form-control @error('fecha_limite_correctiva') is-invalid @enderror" name="fecha_limite_correctiva" value="{{ isset($reclamo->fecha_limite_correctiva)?$reclamo->fecha_limite_correctiva:old('fecha_limite_correctiva') }}" autocomplete="fecha_limite_correctiva" autofocus>

                                @error('fecha_limite_correctiva')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <h3>Verificación implementación</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="verificacion_implementacion" class="col-md-4 col-form-label text-md-right">{{ __('Verificación implementación') }} </label>

                            <div class="col-md-6">
                                <textarea id="verificacion_implementacion" class="form-control-textarea @error('verificacion_implementacion') is-invalid @enderror" name="verificacion_implementacion" value="{{ old('verificacion_implementacion') }}" autocomplete="verificacion_implementacion" autofocus rows="8"
                                @isset($reclamo->id_user_implementacion)
                                    @if($reclamo->id_user_implementacion <> auth()->id())
                                        readonly
                                    @endif
                                @endisset
                                >@isset($reclamo->verificacion_implementacion){{ $reclamo->verificacion_implementacion }}@endisset</textarea>

                                @error('verificacion_implementacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_implementacion" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user_implementacion') is-invalid @enderror" data-live-search="true" id="id_user_implementacion" name="id_user_implementacion" value="{{ isset($reclamo->id_user_implementacion)?$reclamo->id_user_implementacion:old('id_user_implementacion') }}">
                                    <option value="">Seleccionar responsable</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuario_implementacion)
                                                @if($usuario->id == $usuario_implementacion->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user_implementacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_implementacion" class="col-md-4 col-form-label text-md-right">{{ __('Fecha implementacion') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_implementacion" type="date" class="form-control @error('fecha_implementacion') is-invalid @enderror" name="fecha_implementacion" value="{{ isset($reclamo->fecha_implementacion)?$reclamo->fecha_implementacion:old('fecha_implementacion') }}" autocomplete="fecha_implementacion" autofocus>

                                @error('fecha_implementacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h3>Medición eficiencia</h3>
                        <hr>

                        <div class="form-group row">
                            <label for="medicion_eficiencia" class="col-md-4 col-form-label text-md-right">{{ __('Medición eficiencia') }} </label>

                            <div class="col-md-6">
                                <textarea id="medicion_eficiencia" class="form-control-textarea @error('medicion_eficiencia') is-invalid @enderror" name="medicion_eficiencia" value="{{ old('medicion_eficiencia') }}" autocomplete="medicion_eficiencia" autofocus rows="8"
                                @isset($reclamo->id_user_eficiencia)
                                    @if($reclamo->id_user_eficiencia <> auth()->id())
                                        readonly
                                    @endif
                                @endisset
                                >@isset($reclamo->medicion_eficiencia){{ $reclamo->medicion_eficiencia }}@endisset</textarea>

                                @error('medicion_eficiencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user_eficiencia" class="col-md-4 col-form-label text-md-right">{{ __('Responsable') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user_eficiencia') is-invalid @enderror" data-live-search="true" id="id_user_eficiencia" name="id_user_eficiencia" value="{{ isset($reclamo->id_user_eficiencia)?$reclamo->id_user_eficiencia:old('id_user_eficiencia') }}">
                                    <option value="">Seleccionar responsable</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuario_eficiencia)
                                                @if($usuario->id == $usuario_eficiencia->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user_eficiencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_eficiencia" class="col-md-4 col-form-label text-md-right">{{ __('Fecha medición') }} </label>

                            <div class="col-md-6">
                                <input id="fecha_eficiencia" type="date" class="form-control @error('fecha_eficiencia') is-invalid @enderror" name="fecha_eficiencia" value="{{ isset($reclamo->fecha_eficiencia)?$reclamo->fecha_eficiencia:old('fecha_eficiencia') }}" autocomplete="fecha_eficiencia" autofocus>

                                @error('fecha_eficiencia')
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