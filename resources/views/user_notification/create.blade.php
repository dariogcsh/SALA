@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sucursal nueva') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/user_notification') }}">
                        @csrf           
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p>
                        <div class="form-group row">
                            <label for="destinatario" class="col-md-4 col-form-label text-md-right">{{ __('Destinatario') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('destinatario') is-invalid @enderror" name="destinatario" id="destinatario" value="{{ old('destinatario') }}" required autofocus> 
                                <option value="">Seleccionar</option>
                                <option value="externo">Externo</option>
                                <option value="interno">Interno</option>
                            </select>
                                @error('destinatario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipoenvio" class="col-md-4 col-form-label text-md-right">{{ __('Enviar a') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('tipoenvio') is-invalid @enderror" name="tipoenvio" id="tipoenvio" value="{{ old('tipoenvio') }}" required autofocus> 
                                
                            </select>
                                @error('tipoenvio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div id='segmentos' style="display: none">
                            <div class="form-group row">
                                <label for="segmento" class="col-md-4 col-form-label text-md-right">{{ __('Segmento') }} *</label>
                                <div class="col-md-6">
                                <select class="form-control @error('segmento') is-invalid @enderror" data-live-search="true" name="segmento" id="segmento" value="{{ old('segmento') }}" title="Seleccionar" autofocus> 
                                    <option value="">Seleccionar</option>
                                    <option value="monitoreo">Paquetes de monitoreo</option>
                                    <option value="cosechadoras">Cosechadoras</option>
                                    <option value="tractores">Tractores</option>
                                    <option value="pulverizadoras">Pulverizadoras</option>
                                    <option value="S700">Serie 700</option>
                                    <option value="S600">Serie 600</option>
                                    <option value="pla">PLA</option>
                                    <option value="sinmonitoreo">Sin paquete de monitoreo</option>
                                </select>
                                    @error('segmento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id='organizacion' style="display: none">
                            <div class="form-group row">
                                <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                                <div class="col-md-6">
                                <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar" autofocus> 
                                        @foreach($organizaciones as $organizacion)
                                            <option value="{{ $organizacion->id }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                            >{{ $organizacion->NombOrga }} </option>
                                        @endforeach
                                </select>
                                    @error('CodiOrga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id='usuario' style="display: none">
                            <div class="form-group row">
                                <label for="id_user" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }} *</label>
                                <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_user') is-invalid @enderror" data-live-search="true" name="id_user" id="id_user" value="{{ old('id_user') }}" title="Seleccionar" autofocus> 
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}" data-subtext="{{ $usuario->NombOrga }}"
                                            >{{ $usuario->last_name }} {{ $usuario->name }} </option>
                                        @endforeach 
                                </select>
                                    @error('id_user')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }} *</label>

                            <div class="col-md-6">
                                <textarea id="body" type="text" class="form-control-textarea @error('body') is-invalid @enderror" name="body" value="{{ old('body') }}" required autofocus></textarea>

                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <label for="path" class="col-md-4 col-form-label text-md-right">{{ __('Path (vista donde se abre cuando pulsa la notificacion)') }} *</label>
                                <div class="col-md-6">
                                <select class="form-control @error('path') is-invalid @enderror" name="path" id="path" value="{{ old('path') }}" required autofocus> 
                                    <option value="">Seleccionar</option>
                                    <option value="Personalizado">{{ 'Personalizado' }} </option>
                                    <option value="/user_notification/index">{{ 'Notificaciones' }} </option>
                                    <option value="/home">{{ 'Inicio' }} </option>
                                    <option value="/user">{{ 'Usuarios' }} </option>
                                    <option value="/asistencia">{{ 'Asistencias' }} </option>
                                    <option value="/bonificacion">{{ 'Beneficios' }} </option>
                                    <option value="/informe">{{ 'Eficiencia de maquina' }} </option>
                                    <option value="/reporte_agronomico">{{ 'Informe agronomico' }} </option>
                                    <option value="/externo">{{ 'Enlaces externos' }} </option>
                                    
                                </select>
                                    @error('path')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="personalizacion" style="display: none;">
                                <div class="form-group row">
                                    <label for="link_vista" class="col-md-4 col-form-label text-md-right">{{ __('URL de visualización') }} *</label>
        
                                    <div class="col-md-6">
                                        <input id="link_vista" type="text" class="form-control @error('link_vista') is-invalid @enderror" name="link_vista" value="{{ old('link_vista') }}" autofocus>
        
                                        @error('link_vista')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="externo" style="display: none;">
                                <div class="form-group row">
                                    <label for="link_vista" class="col-md-4 col-form-label text-md-right">{{ __('URL de visualización') }} *</label>
        
                                    <div class="col-md-6">
                                        <input id="link_vista" type="text" class="form-control @error('link_vista') is-invalid @enderror" name="link_vista" value="{{ old('link_vista') }}" autofocus>
        
                                        @error('link_vista')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
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
@endsection
@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    $('#destinatario').change(function(){
            if ($(this).val() != ''){ 
                var destino = $(this).val();
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('user_notification.cboDestinatario') }}",
                    method:"POST",
                    data:{destino:destino, _token:_token},
                    success:function(result)
                    {
                        $('#tipoenvio').html(result); 
                    },
                    error:function()
                    {
                        alert("Se ha producido un error, intentelo más tarde");
                    },
                });
            }
    });
    
    $('#tipoenvio').change(function(){
            if ($(this).val() != ''){ 
                var tipoenvio = $(this).val();
                var destinatario = $('#destinatario').val();
                div_segmento = document.getElementById("segmentos");
                div_usuario = document.getElementById("usuario");
                div_organizacion = document.getElementById("organizacion");
                if ((tipoenvio == "organizacion") && (destinatario == "externo")){
                    div_organizacion.style.display='block';
                    div_usuario.style.display='none';
                    div_segmento.style.display='none';
                } else{
                    if (tipoenvio == "usuario") {
                        div_organizacion.style.display='none';
                        div_usuario.style.display='block';
                        div_segmento.style.display='none';
                    } else{
                        if ((tipoenvio == "segmento") && (destinatario == "externo")){
                            div_organizacion.style.display='none';
                            div_usuario.style.display='none';
                            div_segmento.style.display='block';
                        } else {
                            div_organizacion.style.display='none';
                            div_usuario.style.display='none';
                            div_segmento.style.display='none';
                        }
                    }
                }
            }
    });

    $('#path').change(function(){
        if ($(this).val() != ''){ 
                var url_vista = $(this).val();
                var div_personalizado = document.getElementById("personalizacion");
                var div_externo = document.getElementById("externo");
                if (url_vista == "Personalizado") {
                    div_personalizado.style.display='block';
                } else {
                    div_personalizado.style.display='none';
                }
        }
    });
});
</script>
@endsection