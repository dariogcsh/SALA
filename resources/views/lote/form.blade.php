                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                         <div class="form-group row">
                            <label for="org_id" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                            <div class="col-md-6">
                                    <select class="selectpicker form-control @error('org_id') is-invalid @enderror" data-live-search="true" name="org_id" id="org_id" value="{{ old('org_id') }}" title="Seleccionar Organizacion" required autofocus> 
                                        @if($organizacion->NombOrga == "Sala Hnos")
                                        @foreach($organizaciones as $organ)
                                            <option value="{{ $organ->CodiOrga }}" data-subtext="{{ $organ->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                @isset($organizacionshow)
                                                    @if($organ->id == $organizacionshow->id)
                                                        selected
                                                    @endif
                                                @endisset
                                                >{{ $organ->NombOrga }} </option>
                                        @endforeach
                                    @else
                                        @isset($organizacionshow)
                                            <option value="{{ $organizacionshow->id }}" data-subtext="{{ $organizacionshow->InscOrga == 'SI' ? 'Monitoreado':'' }}" selected>{{ $organizacionshow->NombOrga }} </option>
                                        @else
                                                    <option value="{{ $organizacion->CodiOrga }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                        >{{ $organizacion->NombOrga }} </option>
                                        @endisset
                                    @endif
                            </select>
                                @error('org_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="client" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de cliente') }} *</label>

                            <div class="col-md-6">
                                <input id="client" type="text" class="form-control @error('client') is-invalid @enderror" name="client" value="{{ isset($lote->client)?$lote->client:old('client') }}" required autocomplete="client" autofocus>

                                @error('client')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="farm" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de granja') }} *</label>

                            <div class="col-md-6">
                                <input id="farm" type="text" class="form-control @error('farm') is-invalid @enderror" name="farm" value="{{ isset($lote->farm)?$lote->farm:old('farm') }}" required autocomplete="farm" autofocus>

                                @error('farm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de lote') }} *</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($lote->name)?$lote->name:old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
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