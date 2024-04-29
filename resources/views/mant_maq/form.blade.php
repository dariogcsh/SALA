@php
    use App\paquetemant;
    use App\mant_maq;
@endphp                       
                        
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                    <form name="formulario1">
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($senal->id_organizacion)?$senal->id_organizacion:old('id_organizacion') }}" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @isset($organ)
                                        @foreach ($organizaciones as $organizacion)
                                            @if($organ == $organizacion->id)
                                                <option value="{{ $organizacion->id }}" selected
                                                    >{{ $organizacion->NombOrga }}</option>
                                            @else
                                                <option value="{{ $organizacion->id }}" 
                                                    >{{ $organizacion->NombOrga }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($organizaciones as $organizacion)
                                            <option value="{{ $organizacion->id }}" 
                                                >{{ $organizacion->NombOrga }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                            <div class="form-group row">
                                <label for="pin" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie de la máquina') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('pin') is-invalid @enderror" id="pin" name="pin" value="{{ isset($mant_maq->pin)?$mant_maq->pin:old('pin') }}" autofocus>
                                        <option value="otra">Debe seleccionar una organizacion</option>
                                        @isset($pinmaq)
                                            @foreach($maqs as $maq)
                                                @if($pinmaq == $maq->NumSMaq)
                                                    <option value="{{ $maq->NumSMaq }}" selected
                                                        >{{ $maq->ModeMaq }} - {{ $maq->NumSMaq }}</option>
                                                @else
                                                    <option value="{{ $maq->NumSMaq }}" 
                                                        >{{ $maq->ModeMaq }} - {{ $maq->NumSMaq }}</option>
                                                @endif
                                            @endforeach
                                        @endisset
                                    </select>
                                    @error('pin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                    @can('haveaccess','maquina.create')
                                        <div class="col-md-2">
                                            <a href="{{ route('maquina.create') }}" title="Crear máquina nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea crear una máquina nueva y salir del registro de conectividad?');"><b>+</b></a>
                                        </div>
                                    @endcan
                            </div>

                            <div class="form-group row">
                                <label for="id_tipo_paquete_mant" class="col-md-4 col-form-label text-md-right">{{ __('Paquete de mantenimiento') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('id_tipo_paquete_mant') is-invalid @enderror" id="id_tipo_paquete_mant" name="id_tipo_paquete_mant"  onchange="javascript:enviar_formulario1()" value="{{ isset($mant_maq->id_tipo_paquete_mant)?$mant_maq->id_tipo_paquete_mant:old('id_tipo_paquete_mant') }}" autofocus>
                                        <option value="">Debe seleccionar una máquina</option>
                                        @isset($modelo)
                                            <option value="{{ $modelo->id }}" selected
                                                >{{ $modelo->modelo }}</option>
                                        @endisset
                                    </select>
                                    @error('id_tipo_paquete_mant')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </form>

                        
                        <form method="POST" action="{{ url('/mant_maq') }}">
                            @csrf
                            @isset($pinmaq)
                            <br>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="title-dark-warning"><h3><b>Mantenimiento  {{ $modelo->modelo }}</b></h3></div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <br>
                                <input type="text" hidden value="{{ $organ }}" id="organizacion" name="organizacion">
                                <input type="text" hidden value="{{ $pinmaq }}" id="maquina" name="maquina">
                                <input type="text" hidden value="{{ $modelo->id }}" id="paquete" name="paquete">
                            @endisset
                            
                        @isset($tipo_paquete_mants)
                            @foreach($tipo_paquete_mants as $tipo_paquete_mant)
                                @php
                                    $paquetemants = Paquetemant::where('id_tipo_paquete_mant', $tipo_paquete_mant->id)
                                                                ->groupBy('paquetemants.descripcion')
                                                                ->groupBy('paquetemants.horas')
                                                                ->orderBy('paquetemants.horas','asc')->get();  
                                @endphp
                                @foreach($paquetemants as $paquetemant)
                                    @php
                                        $i = 0; 
                                        $cant = Mant_maq::where([['id_paquetemant', $paquetemant->id],['pin',$pinmaq]])->count();
                                        $i = $i + $cant;
                                    @endphp
                                @endforeach
                                @if($i == 0)
                                    <div class="form-group row">
                                        
                                        <label for="{{$tipo_paquete_mant->costo}}" class="col-md-4 col-form-label text-md-right"><h5> Paquete de {{ $tipo_paquete_mant->horas }} Horas</h5></label>

                                        <div class="col-md-5">
                                            <label class="switch">
                                                <input type="checkbox" class="warning" name="chk[]" id="{{ $tipo_paquete_mant->costo }}" value="{{ $tipo_paquete_mant->id }}">
                                                <span class="slider round"></span>
                                            </label>
                                            <br>
                                            <br>
                                            <i> 
                                                @foreach($paquetemants as $paquetemant)
                                                    @isset($horas)
                                                        @if($horas <> $paquetemant->horas)
                                                            <div class="title-success">Mantenimiento a las {{ $paquetemant->horas }} hs</div>
                                                            @php
                                                            $horas = $paquetemant->horas;
                                                            @endphp
                                                        @endif
                                                    @else
                                                        @php
                                                            $horas = $paquetemant->horas;
                                                        @endphp 
                                                        <div class="title-success">Mantenimiento a las {{ $paquetemant->horas }} hs</div>
                                                    @endisset
                                                    <p>- {{ $paquetemant->descripcion }}</p>
                                                @endforeach
                                            </i>
                                        </div>
                                        <div class="col-md-2"><b>US$ {{ $tipo_paquete_mant->costo }}</b></div>
                                    </div>
                                    <hr>
                                @else
                                <div class="form-group row">
                                        
                                    <label for="{{$tipo_paquete_mant->costo}}" class="col-md-4 col-form-label text-md-right"><h5> Paquete de {{ $tipo_paquete_mant->horas }} Horas</h5> <span style="color: red">Paquete ya contratado</span></label>
                                        
                                </div>
                                @endif
                            @endforeach
                                    <div class="row justify-content-center">
                                        <h3><label for="">US$ <input type="number" name="costo" id="costo" readonly></label><small> + IVA </small></h3>
                                    </div>
                                    <br>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-success" id="btn-enviar" disabled>
                                            {{  __('Enviar') }}    
                                            </button>
                                        </div>
                                    </div>
                                @endisset
                            </form>