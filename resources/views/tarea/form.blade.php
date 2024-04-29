                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                @isset($tarea->id_organizacion)
                                    <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($tarea->id_organizacion)?$tarea->id_organizacion:old('id_organizacion') }}" autocomplete="id_organizacion" disabled autofocus>
                                @else
                                    <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($tarea->id_organizacion)?$tarea->id_organizacion:old('id_organizacion') }}" autocomplete="id_organizacion" autofocus>
                                @endisset
                                
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($tarea->organizacions->NombOrga)
                                                @if($organizacion->NombOrga == $tarea->organizacions->NombOrga)
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
                                <br>
                            </div>
                            @can('haveaccess','organizacion.create')
                            <div class="col-md-2">
                                <a title="Crear organización nueva" class="btn btn-warning float-left" onclick="javascript:mostrarInputOrga()"><b>+</b></a>
                            </div>
                            @endcan
                        </div>
                        @isset($tarea->id_organizacion)
                        @else
                        <div id="organizacion_nueva" name="organizacion_nueva" style="display: none;">
                            <div class="form-group row">
                                <label for="NombOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organización / Razón social') }}</label>

                                <div class="col-md-6">
                                    <input id="NombOrga" type="text" class="form-control @error('NombOrga') is-invalid @enderror" name="NombOrga" autocomplete="NombOrga" autofocus>

                                    @error('NombOrga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="CodiSucu" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>
                                <div class="col-md-6">
                                    <select name="CodiSucu" id="CodiSucu" class="form-control">
                                        @foreach($sucursals as $sucursal)
                                            <option value="{{ $sucursal->id }}">{{ $sucursal->NombSucu }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endisset

                        <div class="form-group row">
                            <label for="nseriemaq" class="col-md-4 col-form-label text-md-right">{{ __('Maquina') }} *</label>
                            
                            <div class="col-md-6">
                                <select class="form-control @error('nseriemaq') is-invalid @enderror" id="nseriemaq" name="nseriemaq" value="{{ isset($tarea->nseriemaq)?$tarea->nseriemaq:old('nseriemaq') }}" autofocus> 
                                    @isset($tarea->nseriemaq)
                                            @foreach($maquinas as $maquina)
                                                @if($maquina->NumSMaq == $tarea->nseriemaq)
                                                    <option value="{{ $maquina->NumSMaq }}" selected>{{ $maquina->NumSMaq }}</option>
                                                @else
                                                    <option value="{{ $maquina->NumSMaq }}">{{ $maquina->NumSMaq }}</option>
                                                @endif
                                            @endforeach
                                    @endisset
                                </select>
                                @error('nseriemaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                            @can('haveaccess','maquina.create')
                            <div class="col-md-2">
                                <a title="Crear máquina nueva" class="btn btn-warning float-left" onclick="javascript:mostrarInputMaq();"><b>+</b></a>
                            </div>
                            @endcan
                            
                        </div>

                        <div id="maquina_nueva" name="maquina_nueva" style="display: none;">
                            <div class="form-group row">
                                <label for="TipoMaq" class="col-md-4 col-form-label text-md-right">{{ __('TipoMaq') }} *</label>
    
                                <div class="col-md-6">
                                @isset($tarea->nseriemaq)
                                    <select class="form-control @error('TipoMaq') is-invalid @enderror" name="TipoMaq" value="{{ isset($maquina->TipoMaq)?$maquina->TipoMaq:old('TipoMaq') }}" autocomplete="TipoMaq" disabled autofocus>
                                @else
                                    <select class="form-control @error('TipoMaq') is-invalid @enderror" name="TipoMaq" value="{{ isset($maquina->TipoMaq)?$maquina->TipoMaq:old('TipoMaq') }}" autocomplete="TipoMaq" autofocus>
                                @endisset
                                
                                    @isset($maquina->TipoMaq)
                                        <option value="{{ $maquina->TipoMaq }}">{{ $maquina->TipoMaq }}</option>
                                    @else
                                        <option value="">Seleccionar tipo de maquina</option>
                                    @endisset
                                        <option value="COSECHADORA">COSECHADORA</option>
                                        <option value="TRACTOR">TRACTOR</option>
                                        <option value="PULVERIZADORA">PULVERIZADORA</option>
                                        <option value="PICADORA">PICADORA</option>
                                        <option value="SEMBRADORA">SEMBRADORA</option>
                                        <option value="PLATAFORMA-MAICERO">PLATAFORMA/MAICERO</option>
                                </select>
                 
                                    @error('TipoMaq')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="MarcMaq" class="col-md-4 col-form-label text-md-right">{{ __('MarcMaq') }} *</label>
    
                                <div class="col-md-6">
                                    @isset($tarea->nseriemaq)
                                        <select class="form-control @error('MarcMaq') is-invalid @enderror" name="MarcMaq" value="{{ isset($maquina->MarcMaq)?$maquina->MarcMaq:old('MarcMaq') }}" autocomplete="MarcMaq" disabled autofocus>
                                    @else
                                        <select class="form-control @error('MarcMaq') is-invalid @enderror" name="MarcMaq" value="{{ isset($maquina->MarcMaq)?$maquina->MarcMaq:old('MarcMaq') }}" autocomplete="MarcMaq" autofocus>
                                    @endisset
                                    
                                    @isset($maquina->MarcMaq)
                                        <option value="{{ $maquina->MarcMaq }}">{{ $maquina->MarcMaq }}</option>
                                    @else
                                        <option value="">Seleccionar la marca</option>
                                    @endisset
                                        <option value="JOHN DEERE">JOHN DEERE</option>
                                        <option value="MASSEY FERGUSON">MASSEY FERGUSON</option>
                                        <option value="CASE IH">CASE IH</option>
                                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                                        <option value="DEUTZ - FAHR">DEUTZ - FAHR</option>
                                        <option value="AGCO ALLIS">AGCO ALLIS</option>
                                        <option value="OTRA">OTRA</option>
                                </select>
    
                                    @error('MarcMaq')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="ModeMaq" class="col-md-4 col-form-label text-md-right">{{ __('ModeMaq') }} *</label>
    
                                <div class="col-md-6">
                                    @isset($tarea->nseriemaq)
                                        <input id="ModeMaq" type="text" class="form-control @error('ModeMaq') is-invalid @enderror" name="ModeMaq" value="{{ isset($maquina->ModeMaq)?$maquina->ModeMaq:old('ModeMaq') }}" autocomplete="ModeMaq" placeholder="Ej: S780" disabled autofocus>
                                    @else
                                        <input id="ModeMaq" type="text" class="form-control @error('ModeMaq') is-invalid @enderror" name="ModeMaq" value="{{ isset($maquina->ModeMaq)?$maquina->ModeMaq:old('ModeMaq') }}" autocomplete="ModeMaq" placeholder="Ej: S780" autofocus>
                                    @endisset
                                    
    
                                    @error('ModeMaq')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @isset($maquina->NumSMaq)
                                <div class="form-group row">
                                    <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('NumSMaq') }} *</label>
        
                                    <div class="col-md-6">
                                        <input id="NumSMaq" type="text" class="form-control @error('NumSMaq') is-invalid @enderror" name="NumSMaq" value="{{ isset($maquina->NumSMaq)?$maquina->NumSMaq:old('NumSMaq') }}" autocomplete="NumSMaq" placeholder="Ej: S780" autofocus>
        
                                        @error('NumSMaq')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endisset
                        </div>

                        <div class="form-group row">
                            <label for="ncor" class="col-md-4 col-form-label text-md-right">{{ __('N° COR') }}</label>

                            <div class="col-md-6">
                                <input id="ncor" type="number" class="form-control @error('ncor') is-invalid @enderror" name="ncor" value="{{ isset($tarea->ncor)?$tarea->ncor:old('ncor') }}" autocomplete="ncor" autofocus>

                                @error('ncor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Tareas') }} *</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" rows="5" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" required autocomplete="descripcion" autofocus>{{ isset($tarea->descripcion)?$tarea->descripcion:old('descripcion') }}</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="id_tecnico" class="col-md-4 col-form-label text-md-right">{{ __('Técnico') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_tecnico') is-invalid @enderror" multiple id="id_tecnico" name="id_tecnico[]" autofocus>
                                    @isset($planservicios)
                                    @php 
                                    //array para guardar los tecnicos que ya esten asignados en la tarea
                                    $arrtec[] = ""; 
                                    $i=0;
                                    @endphp
                                        @foreach($tecnicos as $tecnico)
                                            @foreach($planservicios as $plan)
                                                @if($tecnico->id == $plan->id_user)
                                                    <option value="{{ $tecnico->id }}" selected>{{ $tecnico->name }} {{ $tecnico->last_name }}</option>
                                                    @php 
                                                    //guardo el/los tecnico que ya esta asignado en la tarea en un array
                                                    $arrtec[$i] = $tecnico->id;
                                                    $i++; 
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <!--Comparo si el tecnico del foreach esta dentro del array, caso contrario se asigna el option-->
                                            @if(!in_array($tecnico->id, $arrtec))
                                                <option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->last_name }}</option>
                                            @endif
                                            @php 
                                            //Vuelvo i a 0 ya que hay una nueva iteracion
                                            $i = 0; 
                                            @endphp
                                        @endforeach
                                    @else
                                        @isset($tecnicos)
                                            @foreach($tecnicos as $tecnico)
                                                <option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->last_name }}</option>
                                            @endforeach
                                        @endisset
                                    @endisset
                                </select>
                                @error('id_tecnico')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ubicacion" class="col-md-4 col-form-label text-md-right">{{ __('Ubicación') }}</label>
                            
                            <div class="col-md-6">
                                <select class="form-control @error('turno') is-invalid @enderror" id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" autofocus> 
                                    @isset($tarea->ubicacion)
                                        <option value="{{ $tarea->ubicacion }}">{{ $tarea->ubicacion }}</option>
                                    @endisset
                                    <option value="Indefinido">Indefinido</option>
                                    <option value="Taller">Taller</option>
                                    <option value="Campo">Campo</option>
                                </select>
                                @error('ubicacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prioridad" class="col-md-4 col-form-label text-md-right">{{ __('Prioridad') }}</label>
                            
                            <div class="col-md-6">
                                <select class="form-control @error('turno') is-invalid @enderror" id="prioridad" name="prioridad" value="{{ old('prioridad') }}" autofocus> 
                                    @isset($tarea->prioridad)
                                        <option value="{{ $tarea->prioridad }}">{{ $tarea->prioridad }}</option>
                                    @endisset
                                    <option value="">Seleccionar prioridad</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Media">Media</option>
                                    <option value="Baja">Baja</option>
                                </select>
                                @error('prioridad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="fechaplan" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio de tarea') }}</label>
                        
                            <div class="col-md-6">
                                <input id="fechaplan" type="date" class="form-control @error('fechaplan') is-invalid @enderror" name="fechaplan" value="{{ isset($tarea->fechaplan)?$tarea->fechaplan:old('fechaplan') }}" autofocus>
                        
                                @error('fechaplan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fechafplan" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de fin de tarea') }}</label>
                        
                            <div class="col-md-6">
                                <input id="fechafplan" type="date" class="form-control @error('fechafplan') is-invalid @enderror" name="fechafplan" value="{{ isset($tarea->fechafplan)?$tarea->fechafplan:old('fechafplan') }}" autofocus>
                        
                                @error('fechafplan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="turno" class="col-md-4 col-form-label text-md-right">{{ __('Turno') }}</label>
                            
                            <div class="col-md-6">
                                <select class="form-control @error('turno') is-invalid @enderror" id="turno" name="turno" value="{{ old('turno') }}" autofocus> 
                                    @isset($tarea->turno)
                                        <option value="{{ $tarea->turno }}">{{ $tarea->turno }}</option>
                                    @endisset
                                    <option value="">Seleccionar turno</option>
                                    <option value="Mañana">Mañana</option>
                                    <option value="Tarde">Tarde</option>
                                    <option value="Mañana y tarde">Mañana y tarde</option>
                                </select>
                                @error('turno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Modificar') }}
                                </button>
                            </div>
                        </div>