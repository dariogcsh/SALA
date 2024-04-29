                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('CodiOrga') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" value="{{ isset($organizacion->CodiOrga)?$organizacion->CodiOrga:old('CodiOrga') }}" required autocomplete="CodiOrga" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizacions as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($maquina->organizacions->NombOrga)
                                                @if($organizacion->NombOrga == $maquina->organizacions->NombOrga)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $organizacion->NombOrga }}</option>
                                    @endforeach
                                </select>
                                @error('CodiOrga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @can('haveaccess','maquina.edit')
                            <div class="form-group row">
                        @else
                            <div class="form-group row" hidden>
                        @endcan

                            <label for="idjdlink" class="col-md-4 col-form-label text-md-right">{{ __('Codigo JDLink') }} </label>

                            <div class="col-md-6">
                                <input id="idjdlink" type="text" class="form-control @error('idjdlink') is-invalid @enderror" name="idjdlink" value="{{ isset($maquina->idjdlink)?$maquina->idjdlink:old('idjdlink') }}"  placeholder="(Opcional))" autofocus>

                                @error('idjdlink')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="TipoMaq" class="col-md-4 col-form-label text-md-right">{{ __('TipoMaq') }} *</label>

                            <div class="col-md-6">
                            <select class="form-control @error('TipoMaq') is-invalid @enderror" name="TipoMaq" value="{{ isset($maquina->TipoMaq)?$maquina->TipoMaq:old('TipoMaq') }}" required autocomplete="TipoMaq" autofocus>
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
                                <select class="form-control @error('MarcMaq') is-invalid @enderror" name="MarcMaq" value="{{ isset($maquina->MarcMaq)?$maquina->MarcMaq:old('MarcMaq') }}" required autocomplete="MarcMaq" autofocus>
                                    @isset($maquina->MarcMaq)
                                        <option value="{{ $maquina->MarcMaq }}">{{ $maquina->MarcMaq }}</option>
                                    @else
                                        <option value="">Seleccionar la marca</option>
                                    @endisset
                                        <option value="JOHN DEERE">JOHN DEERE</option>
                                        <option value="PLA">PLA</option>
                                        <option value="MASSEY FERGUSON">MASSEY FERGUSON</option>
                                        <option value="CASE IH">CASE IH</option>
                                        <option value="NEW HOLLAND">NEW HOLLAND</option>
                                        <option value="DEUTZ - FAHR">DEUTZ - FAHR</option>
                                        <option value="AGCO ALLIS">AGCO ALLIS</option>
                                        <option value="CAIMAN">CAIMAN</option>
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
                            <label for="harvest_smart" class="col-md-4 col-form-label text-md-right">{{ __('Harvest Smart') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('harvest_smart') is-invalid @enderror" name="harvest_smart" value="{{ isset($maquina->harvest_smart)?$maquina->harvest_smart:old('harvest_smart') }}" required autocomplete="harvest_smart" autofocus>
                                    @isset($maquina->harvest_smart)
                                        <option value="{{ $maquina->harvest_smart }}">{{ $maquina->harvest_smart }}</option>
                                    @endisset
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                </select>

                                @error('harvest_smart')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="combine_advisor" class="col-md-4 col-form-label text-md-right">{{ __('Combine Advisor') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('combine_advisor') is-invalid @enderror" name="combine_advisor" value="{{ isset($maquina->combine_advisor)?$maquina->combine_advisor:old('combine_advisor') }}" required autocomplete="combine_advisor" autofocus>
                                    @isset($maquina->combine_advisor)
                                        <option value="{{ $maquina->combine_advisor }}">{{ $maquina->combine_advisor }}</option>
                                    @endisset
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                        <option value="READY">READY</option>
                                </select>

                                @error('combine_advisor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ModeMaq" class="col-md-4 col-form-label text-md-right">{{ __('ModeMaq') }} *</label>

                            <div class="col-md-6">
                                <input id="ModeMaq" type="text" class="form-control @error('ModeMaq') is-invalid @enderror" name="ModeMaq" value="{{ isset($maquina->ModeMaq)?$maquina->ModeMaq:old('ModeMaq') }}" required autocomplete="ModeMaq" placeholder="S780" autofocus>

                                @error('ModeMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('NumSMaq') }} *</label>

                            <div class="col-md-6">
                                <input id="NumSMaq" type="text" class="form-control @error('NumSMaq') is-invalid @enderror" name="NumSMaq" value="{{ isset($maquina->NumSMaq)?$maquina->NumSMaq:old('NumSMaq') }}" autocomplete="NumSMaq" placeholder="1J0S780SCB0745903" autofocus>

                                @error('NumSMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="CanPMaq" class="col-md-4 col-form-label text-md-right">{{ __('CanPMaq') }}</label>

                            <div class="col-md-6">
                                <input id="CanPMaq" type="number" class="form-control @error('CanPMaq') is-invalid @enderror" name="CanPMaq" value="{{ isset($maquina->CanPMaq)?$maquina->CanPMaq:old('CanPMaq') }}" autocomplete="CanPMaq" placeholder="45" autofocus>

                                @error('CanPMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="MaicMaq" class="col-md-4 col-form-label text-md-right">{{ __('MaicMaq') }}</label>

                            <div class="col-md-6">
                                <input id="MaicMaq" type="number" step="0.01" class="form-control @error('MaicMaq') is-invalid @enderror" name="MaicMaq" value="{{ isset($maquina->MaicMaq)?$maquina->MaicMaq:old('MaicMaq') }}" autocomplete="MaicMaq" placeholder="8.40" autofocus>

                                @error('MaicMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @can('haveaccess','maquina.edit')
                            <div class="form-group row">
                        @else
                            <div class="form-group row" hidden>
                        @endcan
                        
                                <label for="InscMaq" class="col-md-4 col-form-label text-md-right">{{ __('Monitoreado') }}</label>

                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('InscMaq') is-invalid @enderror" data-live-search="true" name="InscMaq" value="{{ old('InscMaq') }}" autocomplete="InscMaq" autofocus>
                                        @isset($maquina->InscMaq)
                                                    @if($maquina->InscMaq == 'NO')
                                                    <option value="NO" selected>NO</option>
                                                    <option value="SI">SI</option>
                                                    @elseif($maquina->InscMaq == 'SI')
                                                    <option value="NO">NO</option>
                                                    <option value="SI" selected>SI</option>
                                                    @endif
                                        @else
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                        @endisset
                                    </select>
                                    @error('InscMaq')
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