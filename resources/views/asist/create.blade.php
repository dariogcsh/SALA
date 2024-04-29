@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Solicitar asistencia</h2></div>

                <div class="card-body">
                    <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                    <form action="{{ url('/asist') }}" method="post" id="formulario">
                    @csrf
                    @method('post')

                        <div class="container">

                            @if($organizacion->NombOrga == "Sala Hnos")
                                <div class="form-group row">
                                    <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>
                                    <div class="col-md-6">
                                    <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ old('id_organizacion') }}" autofocus> 
                                            <option value="">Seleccionar organizacion</option>
                                            @foreach($organizaciones as $orga)
                                            <option value="{{ $orga->id }}">{{ $orga->NombOrga }} </option>
                                            @endforeach
                                        </select>
                                        @error('id_organizacion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label for="id_asistenciatipo" class="col-md-4 col-form-label text-md-right">{{ __('id_asistenciatipo') }} *</label>
                                <div class="col-md-6">
                                <select class="form-control @error('id_asistenciatipo') is-invalid @enderror" name="id_asistenciatipo" value="{{ old('id_asistenciatipo') }}" autofocus> 
                                        <option value="">Seleccionar tipo de asistencia</option>
                                        @foreach($asistencias as $asistencia)
                                        <option value="{{ $asistencia->id }}"
                                        >{{ $asistencia->NombTiAs }} </option>
                                        @endforeach
                                    </select>
                                    @error('id_asistenciatipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_maquina" class="col-md-4 col-form-label text-md-right">{{ __('id_maquina') }} *</label>
                                
                                <div class="col-md-6">
                                    <select class="form-control @error('id_maquina') is-invalid @enderror" id="id_maquina" name="id_maquina" value="{{ old('id_maquina') }}" autofocus> 
                                        @if($organizacion->NombOrga == "Sala Hnos")
                                            
                                        @else
                                            <option value="">Seleccionar maquinaria</option>
                                            @foreach($maquinas as $maquina)
                                                        <option value="{{ $maquina->id }}">
                                                        {{ $maquina->ModeMaq }} - {{ $maquina->NumSMaq }}
                                                        </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('id_maquina')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <br>
                                </div>
                                @can('haveaccess','maquina.create')
                                <div class="col-md-2">
                                    <a href="{{ route('maquina.create') }}" title="Crear máquina nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea ccrear una máquina nueva y salir de la solicitud de asistencia?');"><b>+</b></a>
                                </div>
                                @endcan
                                
                            </div>

                            <div class="form-group row">
                                <label for="id_pantalla" class="col-md-4 col-form-label text-md-right">{{ __('id_pantalla') }}</label>
                                <div class="col-md-6">
                                <select class="form-control @error('id_pantalla') is-invalid @enderror" name="id_pantalla" value="{{ old('id_pantalla') }}" autofocus> 
                                        <option value="">Seleccionar pantalla</option>
                                        @foreach($pantallas as $pantalla)
                                                    <option value="{{ $pantalla->id }}"
                                                    >{{ $pantalla->NombPant }} </option>
                                        @endforeach
                                            
                                    </select>
                                    @error('id_pantalla')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_antena" class="col-md-4 col-form-label text-md-right">{{ __('id_antena') }}</label>
                                <div class="col-md-6">
                                <select class="form-control @error('id_antena') is-invalid @enderror" name="id_antena" value="{{ old('id_antena') }}" autofocus> 
                                        <option value="">Seleccionar antena</option>
                                        @foreach($antenas as $antena)
                                                    <option value="{{ $antena->id }}"
                                                    >{{ $antena->NombAnte }} </option>
                                        @endforeach
                                            
                                    </select>
                                    @error('id_antena')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="MaPaAsis" class="col-md-4 col-form-label text-md-right">{{ __('MaPaAsis') }}</label>

                                <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" class="warning" name="MaPaAsis">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="PiloAsis" class="col-md-4 col-form-label text-md-right">{{ __('PiloAsis') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control @error('PiloAsis') is-invalid @enderror" name="PiloAsis" value="{{ old('PiloAsis') }}" autofocus>           
                                        <option value="Integrado">Integrado</option>
                                        <option value="Universal">Universal</option>
                                    </select>
                                    @error('PiloAsis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="TipoAsis" class="col-md-4 col-form-label text-md-right">{{ __('TipoAsis') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control @error('TipoAsis') is-invalid @enderror" name="TipoAsis" value="{{ old('TipoAsis') }}" autofocus>           
                                        <option value="Permanente">Permanente</option>
                                        <option value="Intermitente">Intermitente</option>
                                    </select>
                                    @error('TipoAsis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="PrimAsis" class="col-md-4 col-form-label text-md-right">{{ __('PrimAsis') }}</label>

                                <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" class="warning" name="PrimAsis">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="CondAsis" class="col-md-4 col-form-label text-md-right">{{ __('CondAsis') }}</label>

                                <div class="col-md-6">
                                    <input id="CondAsis" type="text" class="form-control @error('CondAsis') is-invalid @enderror" name="CondAsis" value="{{ old('CondAsis') }}" autocomplete="CondAsis" autofocus>

                                    @error('CondAsis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="PrueAsis" class="col-md-4 col-form-label text-md-right">{{ __('PrueAsis') }}</label>

                                <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" class="warning" name="PrueAsis" id="PrueAsis" onchange="javascript:mostrarInput()">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div id="idcual" style="display: none;">
                                <div class="form-group row">
                                    <label for="CualAsis" class="col-md-4 col-form-label text-md-right">{{ __('CualAsis') }}</label>

                                    <div class="col-md-6">
                                        <input id="CualAsis" type="text" class="form-control @error('CualAsis') is-invalid @enderror" name="CualAsis" value="{{ old('CualAsis') }}" autocomplete="CualAsis" autofocus>

                                        @error('CualAsis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label for="CambAsis" class="col-md-4 col-form-label text-md-right">{{ __('CambAsis') }}</label>

                                    <div class="col-md-6">
                                        <input id="CambAsis" type="text" class="form-control @error('CambAsis') is-invalid @enderror" name="CambAsis" value="{{ old('CambAsis') }}" autocomplete="CambAsis" autofocus>

                                        @error('CambAsis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="CodDAsis" class="col-md-4 col-form-label text-md-right">{{ __('CodDAsis') }}</label>

                            <div class="col-md-6">
                                <input id="CodDAsis" type="text" class="form-control @error('CodDAsis') is-invalid @enderror" name="CodDAsis" value="{{ old('CodDAsis') }}" autocomplete="CodDAsis" autofocus>

                                @error('CodDAsis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="DescAsis" class="col-md-4 col-form-label text-md-right">{{ __('DescAsis') }} *</label>

                            <div class="col-md-6">
                                <textarea id="DescAsis" class="form-control-textarea @error('DescAsis') is-invalid @enderror" name="DescAsis" value="{{ old('DescAsis') }}" required autocomplete="DescAsis" autofocus></textarea>

                                @error('DescAsis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="form-group row">
                                <label for="DeriAsis" class="col-md-4 col-form-label text-md-right">{{ __('DeriAsis') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control @error('DeriAsis') is-invalid @enderror" name="DeriAsis" id="DeriAsis" value="{{ old('DeriAsis') }}" autofocus>           
                                        <option value="Telefonica">Telefonica</option>
                                        <option value="Turno para soporte a campo">Turno para soporte a campo</option>
                                    </select>
                                    @error('DeriAsis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                            <button type="button" onclick="return pregunta();" class="btn btn-success" id="btn-enviar" name="btn-enviar">
                                    {{ __('Enviar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    
        $('#id_organizacion').change(function(){   

            if ($(this).val() != ''){ 
                var select = 'CodiOrga';
                var value = $(this).val();           
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('asist.fetch') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#id_maquina').html(result); 
                    },
                    error:function(){
                        alert("Ha ocurrido un error, intentelo más tarde");
                    }
                })
            }
        });

    });
    function pregunta(){
        const boton = document.getElementById("btn-enviar");
        boton.setAttribute('disabled', "true");
        var texto = document.getElementById("DeriAsis").value;
        if(texto == "Telefonica"){
            var opcion = confirm('¿Confirma la solicitud de asistencia?');
            if (opcion == true) {
                $("#formulario").submit();
            } else {
                alert("Se ha cancelado el envío de solicitud de asistencia");
            }
        } else {
            $("#formulario").submit();
        }
    }
    
    function mostrarInput() {
        cual = document.getElementById("idcual");
        cambio = document.getElementById("idcambio");
        check = document.getElementById("PrueAsis");

        if (check.checked) {
            cual.style.display='block';
            cambio.style.display='block';
        }
        else {
            cual.style.display='none';
            cambio.style.display='none';
        }
    }

</script>
@endsection