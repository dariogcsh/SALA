                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }} de organizacion en Centro de Operaciones</label>

                            <div class="col-md-6">
                                <input id="CodiOrga" type="number" class="form-control @error('CodiOrga') is-invalid @enderror" name="CodiOrga" value="{{ isset($organizacion->CodiOrga)?$organizacion->CodiOrga:old('CodiOrga') }}" autocomplete="CodiOrga" autofocus>

                                @error('CodiOrga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="NombOrga" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }} *</label>

                            <div class="col-md-6">
                                <input id="NombOrga" type="text" class="form-control @error('NombOrga') is-invalid @enderror" name="NombOrga" value="{{ isset($organizacion->NombOrga)?$organizacion->NombOrga:old('NombOrga') }}" required autocomplete="NombOrga" autofocus>

                                @error('NombOrga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="form-group row">
                                <label for="CodiSucu" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>
                                <div class="col-md-6">
                                    <select name="CodiSucu" id="CodiSucu" class="form-control">
                                        @foreach($sucursals as $sucursal)
                                        <option value="{{ $sucursal->id }}"
                                        @isset($organizacion->sucursals->NombSucu)
                                            @if($sucursal->NombSucu == $organizacion->sucursals->NombSucu)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $sucursal->NombSucu }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="InscOrga" class="col-md-4 col-form-label text-md-right">{{ __('Monitoreado') }}</label>

                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('InscOrga') is-invalid @enderror" data-live-search="true" name="InscOrga" value="{{ old('InscOrga') }}" autocomplete="InscOrga" autofocus>
                                        @isset($organizacion->InscOrga)
                                                    @if($organizacion->InscOrga == 'NO')
                                                    <option value="NO" selected>NO</option>
                                                    <option value="SI">SI</option>
                                                    @elseif($organizacion->InscOrga == 'SI')
                                                    <option value="NO">NO</option>
                                                    <option value="SI" selected>SI</option>
                                                    @endif
                                        @else
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                        @endisset
                                    </select>
                                    @error('InscOrga')
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