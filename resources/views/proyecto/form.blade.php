                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                
                        <div class="form-group row" hidden>
                            <label for="id_propuesta" class="col-md-4 col-form-label text-md-right">{{ __('ideaproyecto') }}</label>

                            <div class="col-md-6">
                                <input id="id_propuesta" type="text" class="form-control @error('id_propuesta') is-invalid @enderror" name="id_propuesta" value="{{ isset($ideaproyecto)?$ideaproyecto:old('ideaproyecto') }}" autocomplete="ideaproyecto" autofocus>

                                @error('id_propuesta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('categoria') is-invalid @enderror" name="categoria" required autocomplete="categoria" autofocus>
                                @isset($proyecto->categoria)
                                    <option value="{{ $proyecto->categoria }}">{{ $proyecto->categoria }}</option>
                                @else
                                    <option value="">Seleccionar categoria</option>
                                @endisset
                                    <option value="Soluciones Integrales">Soluciones Integrales</option>
                                    <option value="SALA App/API">SALA App/API</option>
                            </select>

                                @error('categoria')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título') }} *</label>
                        
                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ isset($proyecto->titulo)?$proyecto->titulo:old('titulo') }}" required autofocus>
                        
                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción del proyecto') }} *</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" rows="6" name="descripcion" required autocomplete="descripcion" autofocus>{{ isset($proyecto->descripcion)?$proyecto->descripcion:old('descripcion') }} {{ isset($idea_descripcion->descripcion)?$idea_descripcion->descripcion:old('descripcion') }}</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio de proyecto') }}</label>
                        
                            <div class="col-md-6">
                                <input id="inicio" type="date" class="form-control @error('inicio') is-invalid @enderror" name="inicio" value="{{ isset($proyecto->inicio)?$proyecto->inicio:old('inicio') }}" autofocus>
                        
                                @error('inicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="finalizacion" class="col-md-4 col-form-label text-md-right">{{ __('Fecha estimada de finalización de proyecto') }}</label>
                        
                            <div class="col-md-6">
                                <input id="finalizacion" type="date" class="form-control @error('finalizacion') is-invalid @enderror" name="finalizacion" value="{{ isset($proyecto->finalizacion)?$proyecto->finalizacion:old('finalizacion') }}" autofocus>
                        
                                @error('finalizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Horas estimadas') }}</label>
                        
                            <div class="col-md-6">
                                <input id="horas" type="text" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($proyecto->horas)?$proyecto->horas:old('horas') }}" autofocus>
                        
                                @error('horas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_responsable" class="col-md-4 col-form-label text-md-right">{{ __('Responsables') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_responsable') is-invalid @enderror" multiple id="id_responsable" name="id_responsable[]" autofocus>
                                    @isset($responsables)
                                    @php 
                                    //array para guardar los tecnicos que ya esten asignados en la tarea
                                    $arrtec[] = ""; 
                                    $i=0;
                                    @endphp
                                        @foreach($usuarios as $usuario)
                                            @foreach($responsables as $responsable)
                                                @if($usuario->id == $responsable->id_user)
                                                    <option value="{{ $usuario->id }}" selected>{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                                    @php 
                                                    //guardo el/los tecnico que ya esta asignado en la tarea en un array
                                                    $arrtec[$i] = $usuario->id;
                                                    $i++; 
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <!--Comparo si el tecnico del foreach esta dentro del array, caso contrario se asigna el option-->
                                            @if(!in_array($usuario->id, $arrtec))
                                                <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                            @endif
                                            @php 
                                            //Vuelvo i a 0 ya que hay una nueva iteracion
                                            $i = 0; 
                                            @endphp
                                        @endforeach
                                    @else
                                        @isset($usuarios)
                                            @foreach($usuarios as $usuario)
                                                <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                            @endforeach
                                        @endisset
                                    @endisset
                                </select>
                                @error('id_responsable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="presupuesto" class="col-md-4 col-form-label text-md-right">{{ __('Presupuesto (US$)') }}</label>

                            <div class="col-md-6">
                                <input id="presupuesto" type="number" class="form-control @error('presupuesto') is-invalid @enderror" value="{{ isset($proyecto->presupuesto)?$proyecto->presupuesto:old('presupuesto') }}" name="presupuesto" autocomplete="presupuesto" autofocus>

                                @error('presupuesto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Avance (%)') }}</label>

                            <div class="col-md-6">
                                <input id="estado" type="number" class="form-control @error('estado') is-invalid @enderror" value="{{ isset($proyecto->estado)?$proyecto->estado:old('estado') }}" name="estado" autocomplete="estado" autofocus>

                                @error('estado')
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