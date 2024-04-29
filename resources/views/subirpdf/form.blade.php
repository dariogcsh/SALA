                        
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ isset($subirpdf->titulo)?$subirpdf->titulo:old('titulo') }}" autocomplete="titulo" placeholder="Opcional" autofocus>

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inlineRadioOptions" class="col-md-4 col-form-label text-md-right"></label>
                            
                            @isset($subirpdf->ventastipo)
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        @if ($subirpdf->ventastipo == "Precios")
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="precios" value="Precios" checked>
                                        @else
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="Precios" value="Precios">
                                        @endif
                                        <label class="form-check-label" for="Precios">Lista de precios</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        @if ($subirpdf->ventastipo == "Varios")
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="varios" value="Varios" checked>
                                        @else
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="varios" value="Varios">
                                        @endif
                                        <label class="form-check-label" for="Varios">Formularios varios</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        @if ($subirpdf->ventastipo == "ams")
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="ams" value="ams" checked>
                                        @else
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="ams" value="ams">
                                        @endif
                                        <label class="form-check-label" for="ams">Condiciones comerciales AMS</label>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="precios" onchange="handleChange(this);" value="Precios" checked>
                                        <label class="form-check-label" for="Precios">Precios</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="varios" onchange="handleChange(this);" value="Varios">
                                        <label class="form-check-label" for="Varios">Varios</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="ams" onchange="handleChange(this);" value="ams">
                                        <label class="form-check-label" for="ams">Condiciones comerciales</label>
                                    </div>
                                </div>
                            @endisset
                        </div>        
               

                        <div class="form-group row">
                            <label for="archivo" class="col-md-4 col-form-label text-md-right">{{ __('PDF') }} *</label>
                    
                            <div class="col-md-6">
                                <input id="archivo" type="file" class="form-control-file" name="archivo" accept=".pdf" value="C:\Users\AMS 2\Downloads\Grupo Emerger 7R230 22-11.pdf" autofocus required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>