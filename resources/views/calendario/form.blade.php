                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        
                        <div class="form-group row">
                            <label for="id_evento" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de evento') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_evento') is-invalid @enderror" data-live-search="true" name="id_evento" value="{{ isset($evento->id_evento)?$evento->id_evento:old('id_evento') }}" required autocomplete="id_evento" autofocus>
                                    <option value="">Seleccionar tipo de evento</option>
                                    @foreach ($eventos as $evento)
                                        <option value="{{ $evento->id }}" 
                                        @isset($calendario->eventos->id)
                                                @if($evento->id == $calendario->eventos->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $evento->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('id_evento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_sucursal') is-invalid @enderror" data-live-search="true" name="id_sucursal" value="{{ isset($sucursal->id_sucursal)?$sucursal->id_sucursal:old('id_sucursal') }}" autocomplete="id_evento" autofocus>
                                    <option value="">Seleccionar sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}" 
                                        @isset($calendario->sucursals->id)
                                                @if($sucursal->id == $calendario->sucursals->id)
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
                            <label for="ubicacion" class="col-md-4 col-form-label text-md-right">{{ __('Ubicación') }} </label>

                            <div class="col-md-6">
                                <input id="ubicacion" type="text" class="form-control @error('ubicacion') is-invalid @enderror" name="ubicacion" value="{{ isset($calendario->ubicacion)?$calendario->ubicacion:old('ubicacion') }}" autocomplete="ubicacion" autofocus>

                                @error('ubicacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Motivo') }} *</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ isset($calendario->titulo)?$calendario->titulo:old('titulo') }}" autocomplete="titulo" autofocus>

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} </label>

                            <div class="col-md-6">
                                <textarea rows="7" id="descripcion" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" autocomplete="descripcion" autofocus>@isset($calendario->descripcion){{ $calendario->descripcion }}@endisset</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fechainicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio') }} *</label>

                            <div class="col-md-6">
                                <input id="fechainicio" type="date" class="form-control @error('fechainicio') is-invalid @enderror" name="fechainicio" value="{{ isset($calendario->fechainicio)?$calendario->fechainicio:old('fechainicio') }}" onchange="javascript:nodispo();" required>

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
                                <input id="horainicio" type="time" class="form-control @error('horainicio') is-invalid @enderror" name="horainicio" value="{{ isset($calendario->horainicio)?$calendario->horainicio:old('horainicio') }}" autocomplete="horainicio" autofocus>

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
                                <input id="fechafin" type="date" class="form-control @error('fechafin') is-invalid @enderror" name="fechafin" value="{{ isset($calendario->fechafin)?$calendario->fechafin:old('fechafin') }}" onchange="javascript:nodispo();" required>

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
                                <input id="horafin" type="time" class="form-control @error('horafin') is-invalid @enderror" name="horafin" value="{{ isset($calendario->horafin)?$calendario->horafin:old('horafin') }}" autocomplete="horafin" autofocus>

                                @error('horafin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reserva" class="col-md-4 col-form-label text-md-right">{{ __('Reservar sala de reunion') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="reserva"
                                    @isset($calendario->reserva)
                                        @if($calendario->reserva <> '')
                                            checked
                                        @endif
                                    @endisset
                                    >
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_userdis" class="col-md-4 col-form-label text-md-right">{{ __('Disertante/Capacitador') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_userdis') is-invalid @enderror" multiple id="id_userdis" name="id_userdis[]" autofocus>
                                    @isset($calendario_users_dis)
                                    @php 
                                    //array para guardar los users que ya esten asignados en la tarea
                                    $arrtec[] = ""; 
                                    $i=0;
                                    @endphp
                                        @foreach($users as $user)
                                            @foreach($calendario_users_dis as $calendariod)
                                                @if($user->id == $calendariod->id_user)
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
                                    @isset($calendario_users_par)
                                    @php 
                                    //array para guardar los users que ya esten asignados en la tarea
                                    $arrtec[] = ""; 
                                    $i=0;
                                    @endphp
                                        @foreach($users as $user)
                                            @foreach($calendario_users_par as $calendariop)
                                                @if($user->id == $calendariop->id_user)
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

                        <div class="form-group row">
                            <label for="externos" class="col-md-4 col-form-label text-md-right">{{ __('Participantes externos') }}</label>

                            <div class="col-md-6">
                                <textarea rows="7" id="externos" class="form-control-textarea @error('externos') is-invalid @enderror" name="externos" value="{{ old('externos') }}" autocomplete="externos" autofocus>@isset($calendario->externos){{ $calendario->externos }}@endisset</textarea>

                                @error('externos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <!--
                            <label for="movilidad" class="col-md-4 col-form-label text-md-right">{{ __('Movilidad') }} </label>
                            -->
                            <div class="col-md-6">
                                <input id="movilidad" hidden type="text" class="form-control @error('movilidad') is-invalid @enderror" name="movilidad" value="{{ isset($calendario->movilidad)?$calendario->movilidad:old('movilidad') }}" autocomplete="movilidad" autofocus>

                                @error('movilidad')
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