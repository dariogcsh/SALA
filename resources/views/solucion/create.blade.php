@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>Chat Sala Hnos</h3></div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/solucion') }}" enctype="multipart/form-data" id="frm-enviar" name="frm-enviar" onsubmit="document.forms['frm-enviar']['btn-enviar'].disabled=true;">
                        @csrf 
                        @if ($organizacion->id == auth()->user()->CodiOrga)
                            <div align="right" >
                                <div class="border border-warning rounded bg-light col-10 col-sm-8 alert" style="text-align:right;">
                        @else
                            <div align="left" >
                                <div class="border border-success rounded bg-light col-10 col-sm-8 alert">
                        @endif
                        @if($organizacionCliente == '')
                            <small><b>{{ $user->name }} {{ $user->last_name }} -</b> <i>{{ $organizacion->NombOrga }}</small></i>
                        @else
                            <small><i><b>{{ $organizacionCliente->NombOrga }}</b> - Creado por {{ $user->name }} {{ $user->last_name }} de {{ $organizacion->NombOrga }}</small></i>
                        @endif
                        <hr>
                        <u>ID:</u> {{ $asist->id }} <br>
                        @isset($maquina->NumSMaq)
                            @isset($tipoasistencia->NombTiAs)
                                <u>{{ __('NombTiAs') }}:</u> {{ $tipoasistencia->NombTiAs }}<br>
                            @endisset
                            @isset($maquina->TipoMaq)
                                <u>{{ __('TipoMaq') }}:</u> {{ $maquina->TipoMaq }} <br>
                            @endisset
                            @isset($maquina->MarcMaq)
                                <u>{{ __('MarcMaq') }}:</u> {{ $maquina->MarcMaq }} <br>
                            @endisset
                            @isset($maquina->ModeMaq)
                                <u>{{ __('ModeMaq') }}:</u> {{ $maquina->ModeMaq }} <br>
                            @endisset
                            @isset($maquina->NumSMaq)
                                <u>{{ __('NumSMaq') }}:</u> {{ $maquina->NumSMaq }} <br>
                            @endisset
                            @isset($maquina->InscMaq)
                                <u>{{ __('InscMaq') }}:</u> {{ $maquina->InscMaq }} <br>
                            @endisset
                            @isset($pantalla->NombPant)
                                <u>{{ __('NombPant') }}:</u> {{ $pantalla->NombPant }} <br>
                            @endisset
                            @isset($antena->NombAnte )
                                <u>{{ __('NombAnte') }}:</u> {{ $antena->NombAnte }} <br>
                            @endisset
                            @isset($asist->MaPaAsis)
                            <u>{{ __('MaPaAsis') }}:</u> {{ $asist->MaPaAsis }} <br>
                            @endisset
                            @isset($asist->PiloAsis)
                            <u>{{ __('PiloAsis') }}:</u> {{ $asist->PiloAsis }} <br>
                            @endisset
                            @isset($asist->PrimAsis)
                            <u>{{ __('PrimAsis') }}:</u> {{ $asist->PrimAsis }} <br>
                            @endisset
                            @isset($asist->CondAsis)
                            <u>{{ __('CondAsis') }}:</u> {{ $asist->CondAsis }} <br>
                            @endisset
                            @isset($asist->PrueAsis)
                            <u>{{ __('PrueAsis') }}:</u> {{ $asist->PrueAsis }} <br>
                            @endisset
                            @isset($asist->CualAsis)
                            <u>{{ __('CualAsis') }}:</u> {{ $asist->CualAsis }} <br>
                            @endisset
                            @isset($asist->CambAsis)
                            <u>{{ __('CambAsis') }}:</u> {{ $asist->CambAsis }} <br>
                            @endisset
                            @isset($asist->CodDAsis)
                            <u>{{ __('CodDAsis') }}:</u> {{ $asist->CodDAsis }} <br>
                            @endisset
                        @endisset
                        <u>{{ __('DescAsis') }}:</u> {{ $asist->DescAsis }} <br>
                        @isset($asist->DeriAsis)
                        <u>{{ __('DeriAsis') }}:</u> {{ $asist->DeriAsis }} <br>
                        @endisset
            
                        <small><i> {{ date_format($asist->created_at, 'd-m-Y H:i:s') }} </i></small>
                        </div>
                        </div>

                        @foreach ($solucions as $solucion)
                            @if($solucion->tipo == 'estado')
                                <b><u>Estado de asistencia:</u> </b> {{ $solucion->DescSolu }} - {{ date_format($solucion->created_at, 'd/m/Y H:i:s') }}   
                                @if ($solucion->DescSolu == "Asistencia rechazada")
                                    <br>
                                    <b><u>Motivo:</u> </b> {{ $asist->MotiAsis }}
                                    <br>
                                    <b><u>Comentarios:</u> </b> {{ $asist->DeReAsis }}
                                @elseif($solucion->DescSolu == "Asistencia finalizada")
                                    <br>
                                    <b><u>¿Se solucionó el problema?:</u> </b> {{ $asist->ResuAsis }}
                                    <br>
                                    <b><u>¿Se necesitó crear caso D-TAC?:</u> </b> {{ $asist->dtac }}
                                    <br>
                                    <b><u>N° de caso D-TAC:</u> </b> {{ $asist->ndtac }}
                                    <br>
                                    <b><u>Comentarios:</u> </b> {{ $asist->DeReAsis }}
                                @endif
                                <hr>
                            @else
                                @if ($solucion->id_orga == auth()->user()->CodiOrga)
                                    <div align="right">
                                        <div class="border border-warning rounded bg-light col-10 col-sm-8 alert" style="text-align:right;">
                                @else
                                    <div align="left">
                                        <div class="border border-success rounded bg-light col-10 col-sm-8 alert">
                                @endif
                                <small><b>{{ $solucion->name }} {{ $solucion->last_name }} -</b> <i>{{ $solucion->NombOrga }}</i></small>
                                <hr>
                                
                                @if($solucion->tipo == 'texto')
                                    {{ $solucion->DescSolu }}
                                @elseif($solucion->tipo == 'file')
                                    @if ((stripos($solucion->ruta,'JPG') !== false) OR (stripos($solucion->ruta,'JPEG') !== false) OR (stripos($solucion->ruta,'PNG') !== false) OR (stripos($solucion->ruta,'SVG') !== false) OR (stripos($solucion->ruta,'GIF') !== false))
                                        <img src="{{ asset('/img/asistencias/'.$solucion->ruta) }}" class="img-fluid">
                                    @else
                                        <iframe src="{{'http://docs.google.com/gview?url='.asset('/img/asistencias/'.$solucion->ruta).'&embedded=true'}}" style="width:100%; height:375px;" frameborder="0"></iframe>   
                                        <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/img/asistencias/'.$solucion->ruta)}}" class="btn btn-success">Ver archivo adjunto</a>
                                        @endif
                                @endif
                                
                                <br>
                                
                                <small><i> {{ date_format($solucion->created_at, 'd/m/Y H:i:s') }} </i></small>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        @can('haveaccess','asist.edit')
                            <div class="row justify-content-center">
                                <div class="col-sm-6" style="text-align: center;">
                                    <a href="tel:{{ $user->TeleUser }}"><img src="{{ asset('/imagenes/llamar.png') }}" height="15px"> Llamar a {{ $user->name }} {{ $user->last_name }}</a>
                                </div>
                                <br>
                            </div>
                        @endcan
                        <hr>
                   
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4" style="margin-bottom:5px;">
                                <button type="button" class="btn btn-outline-secondary btn-block" id="btn-adjunto" name="btn-adjunto">Adjuntar archivo</button>
                                <div style="display: none" id="adjuntoOk">  
                                    <br>
                                    <div class="alert alert-success" role="alert">
                                        El archivo se adjunto
                                    </div>
                                </div> 
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input hidden type="file" id="adjunto1" name="adjunto1" accept=".jpg,.png,.jpeg,.gif,.svg,.pdf,.xls,.xlsx" onchange="previewImage(1);">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <textarea id="DescSolu" class="form-control-textarea @error('DescSolu') is-invalid @enderror" name="DescSolu" value="{{ old('DescSolu') }}"  placeholder="Respuesta" rows="6" autofocus></textarea>
                                @error('DescSolu')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xs-12" style="margin-bottom:5px;">
                            @can('haveaccess','asist.edit')
                                
                                    <input type="text" hidden id="username" name="username" value="{{ $user->name }}">
                                    <input type="text" hidden id="sucursal" name="sucursal" value="{{ $sucursal->NombSucu }}">
                                    <select class="form-control" name="respuesta" id="respuesta" autofocus> 
                                        <option value="">Seleccionar una respuesta preestablecida</option> 
                                        <option value="1">Hola, soy {{ auth()->user()->name }} de la sucursal de {{ $sucursal->NombSucu }}
                                                . Ahora nos comunicaremos para asistirlo con su problema o consulta.</option>
                                        <option value="2">Estimado {{ $user->name }}, le adjuntamos el presupuesto según la asistencia solicitada. 
                                                Esperamos su aprobación para coordinar un turno o visita a campo.</option>
                                        <option value="3">El día “01/01/21 a partir de las 9:30 hs” lo visitará un técnico para realizar 
                                                las tareas de acuerdo al presupuesto. Esperamos darle la mejor solución y agradecemos su contacto.</option>
                                        <option value="4">El día “01/01/21 a partir de las 8:30 hs” recibiremos la unidad en la sucursal de {{ $sucursal->NombSucu }}
                                                para realizar las tareas de acuerdo al presupuesto. Esperamos darle la mejor solución y agradecemos su contacto.</option>
                                        <option value="5">Esperamos ayudarle en una próxima oportunidad y agradecemos su contacto.</option>
                                    </select>
                                
                            @endcan
                        </div>

                            <div class="col-md-6">
                                <input id="id_asist" type="hidden" class="form-control @error('id_asist') is-invalid @enderror" name="id_asist" value="{{ $asist->id }}" autocomplete="id_asist" autofocus>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('asist.index') }}">Atras</a>
                                </div>
                                
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','asist.edit')
                                        <a href="{{ route('asist.edit', $asist->id) }}" class="btn btn-success btn-block">Cambiar estado</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <button type="submit" class="btn btn-warning btn-block" id="btn-enviar" name="btn-enviar">
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
  /*  function previewImage(nb) {        
        var reader = new FileReader();         
        reader.readAsDataURL(document.getElementById('adjunto'+nb).files[0]);         
        reader.onload = function (e) {             
            document.getElementById('uploadPreview'+nb).src = e.target.result;         
        };     
    } */
 
$( document ).ready(function() {
    
 
    $('#respuesta').change(function(){
            if ($(this).val() != ''){ 
                var value = $(this).val();             
                var _token = $('input[name="_token"]').val();
                var user = $('#username').val();
                var sucursal = $('#sucursal').val();
                $.ajax({
                    url:"{{ route('solucion.respauto') }}",
                    method:"POST",
                    data:{value:value, user:user, sucursal:sucursal, _token:_token},
                    success:function(result)
                    {
                        $('#DescSolu').val(result); 
                    },
                    error:function(){
                        alert("Ha ocurrido un error, intente nuevamente más tarde");
                    }
                })
            }
    });
               

    $( "#btn-adjunto" ).click(function() {
        $("#adjunto1").click();
    });

    $( "#adjunto1" ).change(function() {
        adjuntoOk = document.getElementById("adjuntoOk");
        adjuntoOk.style.display='block';
    });

}); 

    </script>
@endsection