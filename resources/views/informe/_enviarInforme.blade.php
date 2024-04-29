@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Envio de informes</div>
                <div class="card-body">
                    @include('custom.message')
                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Organizacion</th>
                                <th scope="col">Máquina</th>
                                <th scope="col">Fecha inicio de cultivo</th>
                                <th scope="col">Hs de motor/trilla ultimo informe</th>
                                <th scope="col">Hs de motor/trilla actuales</th>
                                <th scope="col">Fecha ultimas hs motor</th>
                                <th scope="col">Cultivo</th>
                                <th scope="col">Estado</th>
                                <th scope="col"></th>
                                <th colspan=3></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0;
                                    $x = 0; @endphp
                                <!-- En caso de que no se haya registrado ningun informe aún, se selecciona 
                                una fecha de inicio segun el tipo de máquina y la época del año en el que
                                se encuentre -->
                                @php
                                    $año = date("Y", strtotime($hoy));
                                    $noviembre = date($año."-11-01 23:59:59");
                                    $octubre = date($año."-10-01 23:59:59");
                                    $marzo = date($año."-03-01 23:59:59");
                                @endphp
                            @foreach ($informes as $info)
                                <tr>
                                <th scope="row">{{ $info->NombOrga }}</th>
                                <th scope="row">{{ $info->NumSMaq }}</th>
                                <th scope="row">
                                <!-- En caso de que no se haya registrado ningun informe aún, se selecciona 
                                    una fecha de inicio segun el tipo de máquina y la época del año en el que
                                    se encuentre -->
                                @if (($hoy > $noviembre) AND ($info->TipoMaq == "COSECHADORA"))
                                    @php $info->FecIInfo = $noviembre; @endphp
                                    {{ date("d/m/Y", strtotime($info->FecIInfo))  }}
                                @elseif ((empty($info->FecIInfo ) OR ($info->FecIInfo  < $marzo )) AND ($hoy > $marzo) AND ($info->TipoMaq == "COSECHADORA"))
                                    @php $info->FecIInfo = $marzo; @endphp
                                    {{ date("d/m/Y", strtotime($info->FecIInfo))  }}
                                @elseif (($hoy > $octubre) AND ($info->TipoMaq == "TRACTOR"))
                                    @php $info->FecIInfo = $octubre; @endphp
                                    {{ date("d/m/Y", strtotime($info->FecIInfo))  }}
                                @else
                                    {{ date("d/m/Y", strtotime($info->FecIInfo))  }}
                                @endif
                                </th>
                                <th scope="row">
                                @if ($info->TipoMaq == "COSECHADORA")
                                    {{ $info->HsTrInfo }}
                                @else
                                    @isset($info->HsTrInfo)
                                        {{ $info->HsTrInfo }}
                                    @else
                                        <!-- Calcula la hora de motor inicial-->
                                        @foreach($fechahoras as $fechahora)
                                            @php $fechacomparativa =  date($fechahora->created_at); @endphp
                                            @if(($info->NumSMaq == $fechahora->NumSMaq) AND ($info->FecIInfo >= $fechacomparativa))
                                                @php 
                                                    $info->HsTrInfo = $fechahora->horas;
                                                    break; 
                                                @endphp
                                            @endif
                                        @endforeach
                                            {{ $info->HsTrInfo }}
                                    @endisset
                                @endif
                                </th>

                                <th scope="row">
                                @if (empty($fecha_valor[$i]['ValoUtil'])) 
                                    @php 
                                        $fecha_valor[$i]['ValoUtil'] = 0; 
                                        $fecha_valor[$i]['FecFUtil'] = "Sin fecha"; 
                                    @endphp
                                @endif 

                                @if($info->TipoMaq == "COSECHADORA")
                                    {{$fecha_valor[$i]['ValoUtil']}}</th>
                                    @php 
                                        $hsmotor = $fecha_valor[$i]['ValoUtil'];
                                    @endphp
                                @else
                                    {{$info->horas}}</th>
                                    @php 
                                        $hsmotor = $info->horas;
                                    @endphp
                                @endif
                                @php $difhoras = $hsmotor - $info->HsTrInfo; @endphp

                                @if($info->TipoMaq == "COSECHADORA")
                                    <th scope="row">{{date("d/m/Y", strtotime($fecha_valor[$i]['FecFUtil']))}}</th>
                                        @php 
                                            $fechafin = $fecha_valor[$i]['FecFUtil'];
                                        @endphp
                                @else
                                <!-- Calcula la ultima hora de motor registrada-->
                                    @foreach($fechahoras as $fechahora)
                                        @if($info->NumSMaq == $fechahora->NumSMaq)
                                            <th scope="row">{{date("d/m/Y", strtotime($fechahora->created_at))}}</th>
                                            @php 
                                                $fechafin = $fechahora->created_at;
                                                break; 
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                                @if($difhoras >= 50)
                                <th scope="row">Para enviar</th>
                                <form id="{{ $x }}">
                                    @csrf
                                
                                <th scope="row">
                                    <input id="desde{{$x}}" type="date" value="{{ date("Y-m-d", strtotime($info->FecIInfo))  }}">
                                </th>
                                @if($info->TipoMaq == "COSECHADORA")
                                    <th scope="row">
                                        <select class="form-control" id="CultInfo{{$x}}" name="CultInfo{{$x}}" autofocus>
                                            <option value="{{$info->CultInfo}}">{{$info->CultInfo}}</option>
                                            <option value="Soja">Soja</option>
                                            <option value="Maiz">Maiz</option>
                                            <option value="Trigo">Trigo</option>
                                        </select>
                                    </th>
                                @else
                                    <th scope="row">
                                        <select class="form-control" id="CultInfo{{$x}}" name="CultInfo{{$x}}" autofocus>
                                            <option value="Siembra">Siembra</option>
                                        </select>
                                    </th>
                                @endif
                    
                                    <input id="hasta{{$x}}" hidden type="text" value="{{ $fechafin }}">
                                    <input id="NumSMaq{{$x}}" hidden type="text" value="{{ $info->NumSMaq }}">
                                    <input id="CodiOrga{{$x}}" hidden type="text" value="{{ $info->CodiOrga }}">
                                    <input id="HsTrInfo{{$x}}" hidden type="text" value="{{ $hsmotor}}">
                                    <input id="TipoInfo{{$x}}" hidden type="text" value="Eficiencia">
                                    
                                    <input id="EstaInfo{{$x}}" hidden type="text" value="Enviado">
                                    <input id="URLInfo{{$x}}" hidden type="text" value="{{ route('utilidad.historial') }}">
                                    <th scope="row"><button class="forminforme btn btn-warning btn-block" id="enviar{{$x}}" value="{{$x}}">Enviar</button></th>
                                </form>
                                <th scope="row"><a href="{{ url('/utilidad/'.$info->CodiInfo) }}" class="btn btn-success btn-block" >Ver</a></th>
                                @php 
                                $x++;
                                @endphp
                                @else
                                <th scope="row">{{$info->CultInfo}}</th>
                                <th scope="row">Enviado</th>
                                @endif
                                  
                                </tr>
                                @php 
                                $i++; 
                                @endphp
                            @endforeach
                            </tbody>
                            </table>
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
                var path = "{{ route('informe.store') }}";
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
