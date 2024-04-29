@extends('layouts.app')

@php
    use App\jdlink;
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Maquinas trabajando 
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <!-- Button trigger modal -->
                <u><b>Cantidad: </b></u>{{$cantreg}}
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Organización</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Velocidad</th>
                            <th scope="col">Rumbo</th>
                            <th scope="col">Combustible en el depósito</th>
                            <th scope="col">N° de serie</th>
                            <th scope="col">Fecha - Hora</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($maqbrs as $maqbr)
                            
                                <tr>
                                    @php
                                        $jdlink_count = Jdlink::where([['jdlinks.NumSMaq',$maqbr->pin],['jdlinks.monitoreo','SI'],['jdlinks.vencimiento_contrato','>',$hoy]])->count();
                                    @endphp
                            @if($jdlink_count > 0)
                            <th><img src="{{ asset('/imagenes/averde.png') }}"  height="20" title="Respuesta del concesionario"></th>
                            @else
                            <th></th>
                            @endif
                            <th scope="row"><a href="{{ route('maquina.show',$maqbr->idmaq) }}" title="Detalle"><img class="img img-responsive" src="{{ '/imagenes/'.$maqbr->TipoMaq.'.png' }}" height="30px"></a></th>
                            <th scope="row">{{ $maqbr->ModeMaq }}</th>
                            <th scope="row">{{ $maqbr->NombOrga }}</th>
                            <th scope="row">{{ $maqbr->NombSucu }}</th>
                            <th scope="row">{{ $maqbr->estado }}</th>
                            <th scope="row">{{ $maqbr->velocidad }}</th>
                            <th scope="row">{{ $maqbr->direccion }}</th>
                            <th scope="row">{{ $maqbr->tanque }} %</th>
                            <th scope="row">{{ $maqbr->pin }}</th>
                            <th scope="row">{{  date('d/m/Y h:i:s a',strtotime($maqbr->fecha)) }}</th>
                            @can('haveaccess','maq_breadcrumb.show')
                                <th><a href="{{ route('maq_breadcrumb.show',$maqbr->id) }}" title="Detalle"><img src="{{ asset('/imagenes/gps.png') }}"  height="25"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $maqbrs->onEachSide(0)->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<script type="text/javascript">
  function actualizar(){location.reload(true);}
//Función para actualizar cada 60 segundos(30000 milisegundos)
  setInterval("actualizar()",30000);
</script>
@endsection