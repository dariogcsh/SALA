@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Envio de informes
                    @can('haveaccess','informe.create')
                    <a href="{{ route('informe.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
                </h2></div>
                <div class="card-body">
                    @include('custom.message')
                    <strong><u>Máquinas:</u> {{ $cantinformes }}</strong>
                    <br>
                    <br>
                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Organizacion</th>
                                <th scope="col">Máquina</th>
                                <th scope="col">Fecha inicio de cultivo</th>
                                <th scope="col">Hs de trilla ultimo informe</th>
                                <th scope="col">Hs de trilla actuales</th>
                                <th scope="col">Fecha ultimas hs trilla</th>
                                <th scope="col">Cultivo</th>
                                <th scope="col">Estado</th>
                                <th scope="col"></th>
                                <th colspan=3></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0;
                                    $x = 0; @endphp
                            @foreach ($informes as $info)
                                <tr>
                                <th scope="row">{{ $info->NombOrga }}</th>
                                <th scope="row">{{ $info->NumSMaq }}</th>
                                <th scope="row">{{ $info->FecIInfo }}</th>
                                <th scope="row">{{ $info->HsTrInfo }}</th>
                                <th scope="row">
                                @if (empty($fecha_valor[$i]['ValoUtil'])) 
                                    @php 
                                        $fecha_valor[$i]['ValoUtil'] = 0; 
                                        $fecha_valor[$i]['FecFUtil'] = "00/00/0000"; 
                                    @endphp
                                @endif 
                                {{$fecha_valor[$i]['ValoUtil']}}</th>
                                @php $difhoras = $fecha_valor[$i]['ValoUtil'] - $info->HsTrInfo; @endphp
                                <th scope="row">{{date("d/m/Y", strtotime($fecha_valor[$i]['FecFUtil']))}}</th>
                                
                                @if($difhoras >= 50)
                                <th scope="row">Para enviar</th>
                                <form id="{{ $x }}">
                                    @csrf
                                
                                <th scope="row">
                                    <input id="desde{{$x}}" type="date" value="{{ $info->FecIInfo }}">
                                </th>
                                    <th scope="row">
                                        <select class="form-control" id="CultInfo{{$x}}" name="CultInfo{{$x}}" autofocus>
                                            <option value="{{$info->CultInfo}}">{{$info->CultInfo}}</option>
                                            <option value="Soja">Soja</option>
                                            <option value="Maiz">Maiz</option>
                                            <option value="Trigo">Trigo</option>
                                            <option value="Girasol">Girasol</option>
                                        </select>
                                    </th>
                                    <input id="hasta{{$x}}" hidden type="text" value="{{ $fecha_valor[$i]['FecFUtil'] }}">
                                    <input id="NumSMaq{{$x}}" hidden type="text" value="{{ $info->NumSMaq }}">
                                    <input id="CodiOrga{{$x}}" hidden type="text" value="{{ $info->CodiOrga }}">
                                    <input id="HsTrInfo{{$x}}" hidden type="text" value="{{ $fecha_valor[$i]['ValoUtil']}}}">
                                    <input id="TipoInfo{{$x}}" hidden type="text" value="Eficiencia">
                                    
                                    <input id="EstaInfo{{$x}}" hidden type="text" value="Enviado">
                                    <input id="URLInfo{{$x}}" hidden type="text" value="{{ route('utilidad.historial') }}">
                                    <th scope="row"><button class="forminforme btn btn-warning btn-block" id="enviar{{$x}}" value="{{$x}}">Enviar</button></th>
                                </form>
                                <th scope="row"><a href="{{ url('/utilidad/'.$info->id) }}" class="btn btn-success btn-block" >Ver</a></th>
                                @php 
                                $x++;
                                @endphp
                                @else
                                <th scope="row">{{$info->CultInfo}}</th>
                                <th scope="row">Enviado</th>
                                @endif
                                @can('haveaccess','informe.edit')
                                <th><a href="{{ route('informe.edit',$info->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                                @endcan
                                </tr>
                                @php 
                                $i++; 
                                @endphp
                            @endforeach
                            </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $informes->onEachSide(0)->links() !!}
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
    $('.forminforme').click(function(){
        var opcion = confirm('¿Desea enviar informe al cliente?');
            if (opcion == true) { 
                var id = $(this).val();
                var id_boton = $(this).attr('id');
                boton_envio = document.getElementById(id_boton);
                var FecIInfo = $("#desde"+id).val();
                var FecFInfo = $("#hasta"+id).val();
                var NumSMaq = $("#NumSMaq"+id).val();
                var CodiOrga = $("#CodiOrga"+id).val();
                var HsTrInfo = $("#HsTrInfo"+id).val();
                var TipoInfo = $("#TipoInfo"+id).val();
                var CultInfo = $("#CultInfo"+id).val();
                var EstaInfo = $("#EstaInfo"+id).val();
                var URLInfo = $("#URLInfo"+id).val();
                var _token = $('input[name="_token"]').val();
                var path = "{{ route('informe.storeinfo') }}";
                $.ajax({
                    url: path,
                    method:"POST",
                    data:{ _token:_token, FecIInfo:FecIInfo, FecFInfo:FecFInfo, NumSMaq:NumSMaq, CodiOrga:CodiOrga, 
                        HsTrInfo:HsTrInfo, TipoInfo:TipoInfo, CultInfo:CultInfo, EstaInfo:EstaInfo, URLInfo:URLInfo},
                    complete:function()
                    {
                      boton_envio.disabled='true';
                    },
                    error: function(){
                          alert("No se puede enviar notificación de informe");
                    },
                    success:function(respuesta)
                    {
                     alert(respuesta)
                    }
                  });
            } else {
                alert("Se ha cancelado el envío del informe");
            }
        
    });
});
</script>
@endsection
