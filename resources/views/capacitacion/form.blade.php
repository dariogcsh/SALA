                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de capacitación') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($capacitacion->nombre)?$capacitacion->nombre:old('nombre') }}" autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }} *</label>

                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ isset($capacitacion->codigo)?$capacitacion->codigo:old('codigo') }}" autocomplete="codigo" autofocus>

                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('tipo') is-invalid @enderror" data-live-search="true" name="tipo" value="{{ isset($capacitacion->tipo)?$capacitacion->tipo:old('tipo') }}" autocomplete="tipo" autofocus>
                                    @isset($capacitacion)
                                        <option value="{{ $capacitacion->tipo }}" selected>{{ $capacitacion->tipo }}</option>
                                    @else
                                        <option value="">Seleccionar tipo</option>
                                    @endisset
                                    <option value="John Deere">John Deere</option>
                                    <option value="Higiene y seguridad industrial">Higiene y seguridad industrial</option>
                                    <option value="PLA">PLA</option>
                                    <option value="Interna">Interna</option>
                                    <option value="Externa">Externa</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="modalidad" class="col-md-4 col-form-label text-md-right">{{ __('Modalidad') }}</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('modalidad') is-invalid @enderror" data-live-search="true" name="modalidad" value="{{ isset($capacitacion->modalidad)?$capacitacion->modalidad:old('modalidad') }}" autocomplete="modalidad" autofocus>
                                    @isset($capacitacion)
                                        <option value="{{ $capacitacion->modalidad }}" selected>{{ $capacitacion->modalidad }}</option>
                                    @else
                                        <option value="">Seleccionar modalidad</option>
                                    @endisset
                                    <option value="Aula de aprendizaje a distancia">Aula de aprendizaje a distancia</option>
                                    <option value="Formacion basada en la Web">Formacion basada en la Web</option>
                                    <option value="Formacion con CDI">Formacion con CDI</option>
                                    <option value="Aprendizaje informal">Aprendizaje informal </option>
                                    <option value="Classroom">Classroom</option>
                                    <option value="Evaluaciones">Evaluaciones</option>
                                </select>
                                @error('modalidad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="valoracion" class="col-md-4 col-form-label text-md-right">{{ __('Valoración') }} </label>

                            <div class="col-md-6">
                                <textarea rows="7" id="valoracion" class="form-control-textarea @error('valoracion') is-invalid @enderror" name="valoracion" value="{{ old('valoracion') }}" autocomplete="valoracion" autofocus>@isset($capacitacion->valoracion){{ $capacitacion->valoracion }}@endisset</textarea>

                                @error('valoracion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fechainicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio') }} *</label>

                            <div class="col-md-6">
                                <input id="fechainicio" type="date" class="form-control @error('fechainicio') is-invalid @enderror" name="fechainicio" value="{{ isset($capacitacion->fechainicio)?$capacitacion->fechainicio:old('fechainicio') }}" onchange="javascript:nodispo();" required>

                                @error('fechainicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="horainicio" class="col-md-4 col-form-label text-md-right">{{ __('Hora de inicio') }} </label>

                            <div class="col-md-6">
                                <input id="horainicio" type="time" class="form-control @error('horainicio') is-invalid @enderror" name="horainicio" value="{{ isset($horarios->horainicio)?$horarios->horainicio:old('horainicio') }}" autocomplete="horainicio" autofocus>

                                @error('horainicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fechafin" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de finalización') }} *</label>

                            <div class="col-md-6">
                                <input id="fechafin" type="date" class="form-control @error('fechafin') is-invalid @enderror" name="fechafin" value="{{ isset($capacitacion->fechafin)?$capacitacion->fechafin:old('fechafin') }}" onchange="javascript:nodispo();" required>

                                @error('fechafin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="horafin" class="col-md-4 col-form-label text-md-right">{{ __('Hora de finalización') }} </label>

                            <div class="col-md-6">
                                <input id="horafin" type="time" class="form-control @error('horafin') is-invalid @enderror" name="horafin" value="{{ isset($horarios->horafin)?$horarios->horafin:old('horafin') }}" autocomplete="horafin" autofocus>

                                @error('horafin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de horas') }} *</label>

                            <div class="col-md-6">
                                <input id="horas" type="number" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($capacitacion->horas)?$capacitacion->horas:old('horas') }}" autocomplete="horas" autofocus>

                                @error('horas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo US$') }} *</label>

                            <div class="col-md-6">
                                <input id="costo" type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" name="costo" value="{{ isset($capacitacion->costo)?$capacitacion->costo:old('costo') }}" autocomplete="costo" autofocus>

                                @error('costo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_userdis" class="col-md-4 col-form-label text-md-right">{{ __('Capacitador') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_userdis') is-invalid @enderror" multiple id="id_userdis" name="id_userdis[]" autofocus>
                                    @isset($capacitacion_users_dis)
                                    @php 
                                    //array para guardar los users que ya esten asignados en la tarea
                                    $arrtec[] = ""; 
                                    $i=0;
                                    @endphp
                                        @foreach($users as $user)
                                            @foreach($capacitacion_users_dis as $capacitaciond)
                                                @if($user->id == $capacitaciond->id_user)
                                                    <option class="{{ $user->id }}" value="{{ $user->id }}" selected>{{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                                    @php 
                                                    //guardo el/los user que ya esta asignado en la tarea en un array
                                                    $arrtec[$i] = $user->id;
                                                    $i++; 
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <!--Comparo si el user del foreach esta dentro del array, caso contrario se asigna el option-->
                                            @if(!in_array($user->id, $arrtec))
                                                <option class="{{ $user->id }}" value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                            @endif
                                            @php 
                                            //Vuelvo i a 0 ya que hay una nueva iteracion
                                            $i = 0; 
                                            @endphp
                                        @endforeach
                                    @else
                                        @isset($users)
                                            @foreach($users as $user)
                                                <option class="{{ $user->id }}" value="{{ $user->id }}"> {{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                            @endforeach
                                        @endisset
                                    @endisset
                                </select>
                                @error('id_userdis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_userpar" class="col-md-4 col-form-label text-md-right">{{ __('Participante') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_userpar') is-invalid @enderror" multiple id="id_userpar" name="id_userpar[]" autofocus>
                                    @isset($capacitacion_users_par)
                                    @php 
                                    //array para guardar los users que ya esten asignados en la tarea
                                    $arrtec[] = ""; 
                                    $i=0;
                                    @endphp
                                        @foreach($users as $user)
                                            @foreach($capacitacion_users_par as $capacitacionp)
                                                @if($user->id == $capacitacionp->id_user)
                                                    <option class="{{ $user->id }}" value="{{ $user->id }}" selected>{{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                                    @php 
                                                    //guardo el/los user que ya esta asignado en la tarea en un array
                                                    $arrtec[$i] = $user->id;
                                                    $i++; 
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <!--Comparo si el user del foreach esta dentro del array, caso contrario se asigna el option-->
                                            @if(!in_array($user->id, $arrtec))
                                                <option class="{{ $user->id }}" value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                            @endif
                                            @php 
                                            //Vuelvo i a 0 ya que hay una nueva iteracion
                                            $i = 0; 
                                            @endphp
                                        @endforeach
                                    @else
                                        @isset($users)
                                            @foreach($users as $user)
                                                <option class="{{ $user->id }}" value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                            @endforeach
                                        @endisset
                                    @endisset
                                </select>
                                @error('id_userpar')
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