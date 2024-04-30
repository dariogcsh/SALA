@php
    use App\entrega_paso;
    use App\paso;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de entregas unidades usadas 
                @can('haveaccess','entrega.create')
                <a href="{{ route('entrega.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Último paso cumplido</th>
                            <th scope="col">Avance de entrega</th>
                            <th scope="col">Siguiente paso</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Pin</th>
                            <th scope="col">Sucursal de entrega</th>
                            <th scope="col">Detalle</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($entregas as $entrega)
                            @can('haveaccess','entrega.show')
                                <tr href="{{ route('entrega.show',$entrega->id) }}">
                            @else
                                <tr>
                            @endcan
                            @if($entrega->marca == 'PLA')
                                <th scope="row"><img class="img img-responsive" src="{{ '/imagenes/'.$entrega->tipo.'PLA.png' }}" height="30px"></th>
                            @else
                                <th scope="row"><img class="img img-responsive" src="{{ '/imagenes/'.$entrega->tipo.'.png' }}" height="30px"></th>
                            @endif
                            
                            @php
                                $npasos = Entrega_paso::where('id_entrega',$entrega->id)->count();
                                $ultimopaso = Entrega_paso::select('pasos.nombre','pasos.orden')
                                                        ->join('pasos','entrega_pasos.id_paso','=','pasos.id')
                                                        ->where('id_entrega',$entrega->id)
                                                        ->orderBy('pasos.orden','desc')->first();
                                $pasosiguiente = Paso::select('pasos.nombre','puesto_empleados.NombPuEm')
                                                    ->join('etapas','pasos.id_etapa','=','etapas.id')
                                                    ->join('puesto_empleados','pasos.id_puesto','=','puesto_empleados.id')
                                                    ->where([['pasos.orden','>',$ultimopaso->orden], 
                                                            ['etapas.tipo_unidad', $entrega->tipo_unidad]])
                                                    ->orderBy('pasos.orden','asc')->first();
                                $completado = $npasos / $pasostotales * 100;
                            @endphp
                            <th scope="row">{{ $ultimopaso->nombre }}</th>
                            <th scope="row">
                                <div class="progress">
                                    @if($completado == 100)
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:{{ $completado }}%">{{ number_format($completado,0) }} %</div>
                                @else
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width:{{ $completado }}%">{{ number_format($completado,0) }} %</div>
                                @endif  </div>
                            </th>
                            @isset($pasosiguiente)
                                <th scope="row">{{ $pasosiguiente->nombre }} - <span style="color: gray; font-size:12px;">{{ $pasosiguiente->NombPuEm }}</span></th>
                            @else
                            <th scope="row" style="color: green;">Procesos copletados</th>
                            @endisset
                            
                            @if(!isset($entrega->NombOrga))
                                <th scope="row" style="color: red;">Sin asignar</th>
                            @else
                                <th scope="row">{{ $entrega->NombOrga }}</th>
                            @endif
                            <th scope="row">{{ $entrega->marca }}</th>
                            <th scope="row">{{ $entrega->modelo }}</th>
                            <th scope="row">{{ $entrega->pin }}</th>
                            <th scope="row">{{ $entrega->NombSucu }}</th>
                            <th scope="row">{{ $entrega->detalle }}</th>
                            @can('haveaccess','entrega.show')
                            <th><a href="{{ route('entrega.show',$entrega->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $entregas->onEachSide(0)->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
$(document).ready(function(){
       $('table tr').click(function(){
        if ($(this).attr('href')) {
           window.location = $(this).attr('href');
        }
           return false;
       });
});
</script>
@endsection
