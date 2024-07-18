                        
                 @php
                    use App\entrega_paso;
                @endphp       
                    <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                    @if (($puesto->NombPuEm == 'Administrativo de servicio') OR ($puesto->NombPuEm == 'Coordinador de servicio') OR ($rol->name == 'Admin') OR ($rol->name == 'Gerencia') OR ($rol->name == 'Vendedor'))
             
                        <div class="form-group row">
                            <label for="id_vendedor" class="col-md-4 col-form-label text-md-right">{{ __('Vendedor') }} </label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_vendedor') is-invalid @enderror" readonly data-live-search="true" name="id_vendedor" value="{{ isset($entrega->id_vendedor)?$entrega->id_vendedor:old('id_vendedor') }}" autocomplete="id_vendedor" autofocus>
                                        <option value="{{ $vendedor->id }}" 
                                                    selected
                                            >{{ $vendedor->name }} {{ $vendedor->last_name }}</option>
                                </select>
                                @error('id_vendedor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organización') }} </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" name="id_organizacion" value="{{ isset($entrega->id_organizacion)?$entrega->id_organizacion:old('id_organizacion') }}" autocomplete="id_organizacion" autofocus>
                                    <option value="">Seleccionar organización</option>
                                    @foreach ($organizacions as $organizacion)
                                        <option value="{{ $organizacion->id }}" 
                                        @isset($entrega->id_organizacion)
                                                @if($organizacion->id == $entrega->id_organizacion)
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
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} * </label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_sucursal') is-invalid @enderror" data-live-search="true" name="id_sucursal" value="{{ isset($entrega->id_sucursal)?$entrega->id_organizacion:old('id_sucursal') }}" required autocomplete="id_sucursal" autofocus>
                                    <option value="">Seleccionar sucursal</option>
                                    @foreach ($sucursals as $sucursal)
                                        <option value="{{ $sucursal->id }}" 
                                        @isset($entrega->id_sucursal)
                                                @if($sucursal->id == $entrega->id_sucursal)
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
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }} *</label>

                            <div class="col-md-6">
                            <select class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ isset($entrega->tipo)?$entrega->tipo:old('tipo') }}" required autocomplete="tipo" autofocus>
                                @isset($entrega->tipo)
                                    <option value="{{ $entrega->tipo }}">{{ $entrega->tipo }}</option>
                                @else
                                    <option value="">Seleccionar tipo de equipo</option>
                                @endisset
                                    <option value="COSECHADORA">COSECHADORA</option>
                                    <option value="TRACTOR">TRACTOR</option>
                                    <option value="PULVERIZADORA">PULVERIZADORA</option>
                                    <option value="PICADORA">PICADORA</option>
                                    <option value="SEMBRADORA">SEMBRADORA</option>
                                    <option value="PLATAFORMA-MAICERO">PLATAFORMA/MAICERO</option>
                            </select>
             
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                      
                            <div class="form-group row">
                                <label for="marca" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('marca') is-invalid @enderror" name="marca" value="{{ isset($entrega->marca)?$entrega->marca:old('marca') }}" required autocomplete="marca" autofocus>
                                        @isset($entrega->marca)
                                            <option value="{{ $entrega->marca }}">{{ $entrega->marca }}</option>
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
    
                                    @error('marca')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }} *</label>

                            <div class="col-md-6">
                                <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{ isset($entrega->modelo)?$entrega->modelo:old('modelo') }}" required autocomplete="modelo" autofocus>

                                @error('modelo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pin" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie') }}</label>

                            <div class="col-md-6">
                                <input id="pin" type="text" class="form-control @error('pin') is-invalid @enderror" name="pin" value="{{ isset($entrega->pin)?$entrega->pin:old('pin') }}" placeholder="Opcional" autocomplete="pin" autofocus>

                                @error('pin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="detalle" class="col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>

                            <div class="col-md-6">
                                <textarea id="detalle" class="form-control-textarea @error('detalle') is-invalid @enderror" name="detalle" value="{{ isset($entrega->detalle)?$entrega->detalle:old('detalle')  }}" autocomplete="detalle" placeholder="Opcional" autofocus>@isset($entrega->detalle){{ $entrega->detalle }}@endisset</textarea>

                                @error('detalle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_unidad" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de unidad') }} *</label>

                            <div class="col-md-6">
                            <select class="form-control @error('tipo_unidad') is-invalid @enderror" name="tipo_unidad" value="{{ isset($entrega->tipo_unidad)?$entrega->tipo_unidad:old('tipo_unidad') }}" required autocomplete="tipo_unidad" autofocus>
                                @isset($entrega->tipo_unidad)
                                    <option value="{{ $entrega->tipo_unidad }}">{{ $entrega->tipo_unidad }}</option>
                                @else
                                    <option value="">Seleccionar tipo de unidad</option>
                                @endisset
                                    <option value="Nueva">Nueva</option>
                                    <option value="Usada">Usada</option>
                            </select>
             
                                @error('tipo_unidad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="toma_usado" class="col-md-4 col-form-label text-md-right">{{ __('¿Se tomó un usado por parte de pago?') }} *</label>

                            <div class="col-md-6">
                            <select class="form-control @error('toma_usado') is-invalid @enderror" name="toma_usado" value="{{ isset($entrega->toma_usado)?$entrega->toma_usado:old('toma_usado') }}" required autocomplete="toma_usado" autofocus>
                                @isset($entrega->toma_usado)
                                    <option value="{{ $entrega->toma_usado }}">{{ $entrega->toma_usado }}</option>
                                @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                            </select>
                                @error('toma_usado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @if($modo == 'modificar')
                        @php
                            $x=0;
                            $y=0;
                            $respuesta = 'NO';
                        @endphp
                            @foreach($pasos as $paso)
                                @php
                                    $chk = '';
                                    $deta = '';
                                    $cond = '';
                                    $skip = false;
                                @endphp
                                @foreach($entrega_pasos as $entrega_paso)
                                    @if($entrega_paso->id_paso == $paso->id)
                                        @php
                                            $chk = 'SI';
                                            $deta = $entrega_paso->detalle;
                                            $cond = $entrega_paso->valor_condicion;
                                        @endphp
                                    @endif
                                @endforeach
                                @if (($paso->id_puesto == $puesto->id) OR ($rol->name == 'Admin') OR ($rol->name == 'Gerencia'))
                                    @if($paso->id_paso_anterior <> '')
                                        @php
                                            $entrega_paso = Entrega_paso::where([['id_paso',$paso->id_paso_anterior],
                                                                                ['id_entrega',$entrega->id]])->first();
                                        
                                            //Si la condicion del paso anterior no pertenece a este paso, saltea el foreach para que no aparezca este paso que no pertenece a la condicion seleccionada en el paso anterior
                                            if(isset($entrega_paso)){
                                                if($entrega_paso->valor_condicion <> $paso->valor_condicion_anterior){
                                                    $skip = true;
                                                }
                                            } else{
                                                $skip = true;
                                            }
                                        @endphp
                                    @endif
                                    @if(!$skip)
                                        <div class="form-group row">
                                            <label for="{{ $paso->id }}" class="col-md-4 col-form-label text-md-right">{{ $paso->nombre }}</label>

                                            <div class="col-md-1">
                                                <label class="switch">
                                                    @if($chk == 'SI')
                                                        <input type="checkbox" class="warning" name="{{ $paso->id }}" id="{{ $paso->id }}" checked disabled>
                                                        @php
                                                            $y++;
                                                        @endphp
                                                    @else
                                                        @if(($y == $x) OR ($paso->id_puesto <> $puesto->id))
                                                            <input type="checkbox" class="warning" name="{{ $paso->id }}" id="{{ $paso->id }}">
                                                        @else
                                                            <input type="checkbox" class="warning" name="{{ $paso->id }}" id="{{ $paso->id }}" disabled>
                                                        @endif
                                                    @endif
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="col-md-1"></div>
                                            @if(($y <> $x +1) AND ($y <> $x))
                                                @php
                                                    $respuesta = 'SI';
                                                @endphp
                                            @endif
                                        </div>
                                        @if($paso->condicion == 'SI')
                                            <div id="{{ 'condicion'.$paso->id }}" @if($chk <> 'SI') style="display: none;" @endif>
                                                <div class="form-group row">
                                                    <label for="{{'condicion'.$paso->id }}" class="col-md-4 col-form-label text-md-right">{{ __('Respuesta') }}</label>
                        
                                                    <div class="col-md-6">
                                                        <select class="form-control @error('toma_usado') is-invalid @enderror" id="{{'condicion'.$paso->id }}" name="{{'condicion'.$paso->id }}" @if($chk == 'SI') disabled @endif value="{{ isset($cond)?$cond:old('cond') }}" autofocus>
                                                            @if($cond <> '')
                                                                <option value="{{ $cond }}">{{ $cond }}</option>
                                                            @endif
                                                                <option value="NO">NO</option>
                                                                <option value="SI">SI</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div id="{{ 'detallediv'.$paso->id }}" @if($chk <> 'SI') style="display: none;" @endif>
                                            <div class="form-group row">
                                                <label for="{{'detalle'.$paso->id }}" class="col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>
                    
                                                <div class="col-md-6">
                                                        <textarea id="{{'detalle'.$paso->id }}" class="form-control-textarea" name="{{'detalle'.$paso->id }}" placeholder="Opcional" @if($chk == 'SI') disabled @endif>@isset($deta){{ $deta }}@endisset</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                @endif
                                @php
                                    $x++;
                                @endphp
                            @endforeach
                            <br>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-6">
                                    <a href="{{ route('entrega.files',$entrega->id) }}" class="btn btn-warning">Subir fotos</a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-6">
                                    <a href="{{ route('viaje.create') }}" class="btn btn-warning">Compartir el viaje a campo</a>
                                </div>
                            </div>
                            @if(($respuesta == 'SI') AND (($rol->name <> 'Admin') AND ($rol->name <> 'Gerencia')))
                                    <div class="col-md-6 offset-md-4"><p style="color:red;">Debe terminar el paso anterior</p></div>
                            @endif
                        @endif
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ $modo=='crear' ? __('Crear'):__('Enviar') }}
                                  
                                </button>
                            </div>
                        </div>