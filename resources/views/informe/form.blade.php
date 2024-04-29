                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 

                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" id="CodiOrga" name="CodiOrga" value="{{ old('CodiOrga') }}" autofocus> 
                                    <option value="">Seleccionar organizacion</option>
                                    @foreach($organizaciones as $orga)
                                        @isset($organ)
                                            @if($orga->CodiOrga == $organ->CodiOrga)
                                                <option value="{{ $orga->CodiOrga }}" selected>{{ $orga->NombOrga }} </option>
                                            @endif
                                        @else
                                            <option value="{{ $orga->CodiOrga }}">{{ $orga->NombOrga }} </option>
                                        @endisset   
                                    @endforeach
                                </select>
                                @error('CodiOrga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('NumSMaq') }} *</label>
                            
                            <div class="col-md-6">
                                <select class="form-control @error('NumSMaq') is-invalid @enderror" id="NumSMaq" name="NumSMaq" value="{{ old('NumSMaq') }}" autofocus> 
                                        @isset($maquina)
                                            <option value="{{ $maquina->NumSMaq }}">
                                            {{ $maquina->ModeMaq }} - {{ $maquina->NumSMaq }}
                                            </option>
                                        @endisset
                                </select>
                                @error('NumSMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="FecIInfo" class="col-md-4 col-form-label text-md-right">{{ __('Fecha Inicial de informe') }} *</label>

                            <div class="col-md-6">
                                <input id="FecIInfo" type="date" class="form-control @error('FecIInfo') is-invalid @enderror" name="FecIInfo" value="{{ isset($informe->FecIInfo)?$informe->FecIInfo:old('FecIInfo') }}" required autocomplete="FecIInfo" autofocus>

                                @error('FecIInfo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="FecFInfo" class="col-md-4 col-form-label text-md-right">{{ __('Fecha Final de informe') }} *</label>

                            <div class="col-md-6">
                                <input id="FecFInfo" type="date" class="form-control @error('FecFInfo') is-invalid @enderror" name="FecFInfo" value="{{ isset($informe->FecFInfo)?$informe->FecFInfo:old('FecFInfo') }}" required autocomplete="FecFInfo" autofocus>

                                @error('FecFInfo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="HsTrInfo" class="col-md-4 col-form-label text-md-right">{{ __('Horas de trilla') }} *</label>

                            <div class="col-md-6">
                                <input id="HsTrInfo" type="text" class="form-control @error('HsTrInfo') is-invalid @enderror" name="HsTrInfo" value="{{ isset($informe->HsTrInfo)?$informe->HsTrInfo:old('HsTrInfo') }}" required autocomplete="FecIInfo" autofocus>

                                @error('HsTrInfo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="TipoInfo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de informe') }}</label>
                            
                            <div class="col-md-6">
                                <select class="form-control @error('TipoInfo') is-invalid @enderror" id="TipoInfo" name="TipoInfo" value="{{ old('TipoInfo') }}" autofocus> 
                                    <option value="Eficiencia">Eficiencia</option>
                                </select>
                                @error('TipoInfo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="CultInfo" class="col-md-4 col-form-label text-md-right">{{ __('Cultivo') }} *</label>
                            
                            <div class="col-md-6">
                                <select class="form-control @error('CultInfo') is-invalid @enderror" id="CultInfo" name="CultInfo" value="{{ old('CultInfo') }}" autofocus> 
                                    @isset($info)
                                        <option value="{{$info->CultInfo}}">{{$info->CultInfo}}</option>
                                    @endisset
                                    <option value="Soja">Soja</option>
                                    <option value="Maiz">Maiz</option>
                                    <option value="Trigo">Trigo</option>
                                    <option value="Girasol">Girasol</option>
                                    <option value="Siembra">Siembra</option>
                                </select>
                                @error('CultInfo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="EstaInfo" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                            
                            <div class="col-md-6">
                                <select class="form-control @error('EstaInfo') is-invalid @enderror" id="EstaInfo" name="EstaInfo" value="{{ old('EstaInfo') }}" autofocus> 
                                    <option value=""> </option>
                                    <option value="Enviado">Enviado</option>
                                </select>
                                @error('EstaInfo')
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