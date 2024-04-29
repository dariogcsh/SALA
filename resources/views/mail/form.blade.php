                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="OrgaMail" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('OrgaMail') is-invalid @enderror" data-live-search="true" name="OrgaMail" id="OrgaMail" value="{{ old('OrgaMail') }}" title="Seleccionar organizacion" autofocus> 
                                    
                                    @foreach($organizaciones as $organizacion)
                                    <option value="{{ $organizacion->id }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                        @isset($mail->organizacions->NombOrga)
                                                @if($organizacion->NombOrga == $mail->organizacions->NombOrga)
                                                    selected
                                                @endif
                                        @endisset
                                    >{{ $organizacion->NombOrga }} </option>
                                    @endforeach
                                   
                            </select>
                                @error('OrgaMail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="UserMail" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }} *</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('UserMail') is-invalid @enderror" data-live-search="true" name="UserMail" id="UserMail" value="{{ old('UserMail') }}" title="Seleccionar usuario" autofocus> 
                                    
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" data-subtext="{{ $usuario->NombOrga }}"
                                            @isset($mail->users->id)
                                                @if($usuario->id == $mail->users->id)
                                                    selected
                                                @endif
                                        @endisset
                                        >{{ $usuario->last_name }} {{ $usuario->name }} </option>
                                    @endforeach
                                   
                            </select>
                                @error('UserMail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="TipoMail" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de envio de correo') }} *</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('TipoMail') is-invalid @enderror" data-live-search="true" name="TipoMail" id="TipoMail" value="{{ old('TipoMail') }}" title="Seleccionar tipo de mail" autofocus>     
                                @isset($mail->TipoMail)
                                    @if ($mail->TipoMail == "Para")
                                        <option value="Para" selected>Para:</option> 
                                    @elseif($mail->TipoMail == "Copia")
                                        <option value="Copia" selected>CC:</option> 
                                    @elseif($mail->TipoMail == "Copia oculta") 
                                        <option value="Copia oculta" selected>CCO:</option> 
                                    @endif 
                                @endisset  
                                    <option value="Para">Para:</option> 
                                    <option value="Copia">CC:</option> 
                                    <option value="Copia oculta">CCO:</option>
                            </select>
                                @error('TipoMail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="TiInMail" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de informe') }} *</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('TiInMail') is-invalid @enderror" data-live-search="true" name="TiInMail" id="TiInMail" value="{{ old('TiInMail') }}" title="Seleccionar tipo de informe" autofocus>     
                                @isset($mail->TiInMail)
                                    <option value="{{ $mail->TiInMail }}" selected>{{ $mail->TiInMail }}</option> 
                                @endisset
                                <option value="Eficiencia de maquina">Eficiencia de maquina</option>   
                                <option value="Notificaciones de alertas">Notificaciones de alertas</option>  
                                <option value="Agronomico">Agronomico</option>    
                            </select>
                                @error('TiInMail')
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