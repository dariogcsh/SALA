@php
    use App\paquetemant;
    use App\mant_maq;
@endphp    
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de mantenimientos
                    @if(isset($maquina->ModeMaq)) de {{ $maquina->ModeMaq }} - <span>{{ $maquina->NumSMaq }}</span> @endif
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                @can('haveaccess','mant_maq.edit')
                    <div class="form-group row">
                        <div class="col-md-2">
                            <select class="form-control @error('estado') is-invalid @enderror" name="estado" id="estado">
                                <option value="{{$mant_maq->estado}}">{{$mant_maq->estado}}</option>
                                @if($mant_maq->estado <> 'Solicitado')
                                    <option value="Solicitado">Solicitado</option>
                                @endif
                                @if($mant_maq->estado <> 'Aprobado')
                                    <option value="Aprobado">Aprobado</option>
                                @endif
                                @if($mant_maq->estado <> 'Cancelado')
                                    <option value="Cancelado">Cancelado</option>
                                @endif
                            </select>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-1">
                            <button class="btn btn-success" id="modificar">Modificar</button>
                        </div>
                    </div>
                @endcan
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Tipo de paquete de mantenimiento</th>
                            <th scope="col">Horas de mantenimiento</th>
                            <th scope="col">Servicio</th>
                            @can('haveaccess','mant_maq.edit')
                                <th scope="col">Repuestos</th>
                            @endcan
                            <th scope="col">Realizado</th>
                            <th scope="col">Horas de máquina</th>
                            <th scope="col">Fecha</th>
                            @can('haveaccess','mant_maq.edit')
                                <th scope="col">N° COR</th>
                            @endcan
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($paquetemants as $paquetemant)
                            @can('haveaccess','mant_maq.edit')
                            @php
                                $paquete = Mant_maq::where([['id_paquetemant',$paquetemant->id],['pin',$mant_maq->pin]])->first();
                            @endphp
                                @if($mant_maq->estado == "Aprobado")
                                    <tr href="{{ route('mant_maq.edit',$paquete->id) }}">
                                @else
                                    <tr>
                                @endif
                            @else
                                <tr>
                            @endcan
                                <th scope="row">{{ $paquetemant->horastipo }} hs</th>
                                <th scope="row">{{ $paquetemant->horas }} hs</th>
                            @php
                                $repuestos = Paquetemant::select('repuestos.nombre','repuestos.codigo','paquetemants.cantidad', 'paquetemants.descripcion')
                                                        ->join('repuestos','paquetemants.id_repuesto','=','repuestos.id')
                                                        ->where([['paquetemants.id_tipo_paquete_mant',$paquetemant->id_tipo_paquete_mant],[
                                                                'paquetemants.horas',$paquetemant->horas]])
                                                        ->distinct('paquetemants.id')
                                                        ->orderBy('repuestos.nombre','asc')->get();
                            @endphp
                            <th scope="row">
                                @foreach($repuestos as $repuesto)
                                   <p> {{ $repuesto->descripcion }} </p>
                                @endforeach
                            </th>
                            @can('haveaccess','mant_maq.edit')
                                <th scope="row">
                                @foreach($repuestos as $repuesto)
                                   <p> {{ $repuesto->nombre }} (x{{ $repuesto->cantidad }}) <small>({{ $repuesto->codigo }})</small> </p>
                                @endforeach
                                </th>
                            @endcan
                            <th scope="row">{{ $paquetemant->realizado }}</th>
                            <th scope="row">{{ $paquetemant->horasefectivas }}</th>
                            <th scope="row">{{ $paquetemant->fecha }}</th>
                            @can('haveaccess','mant_maq.edit')
                                <th scope="row">{{ $paquetemant->cor }}</th>
                            @else
                                <th></th>
                            @endcan
                            @can('haveaccess','mant_maq.edit')
                                @if($mant_maq->estado == "Aprobado")
                                    <th><a href="{{ route('mant_maq.edit',$paquete->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                                @else
                                    <tr>
                                @endif
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        <input type="text" hidden value="{{ $paquetemant->id }}" id="paquete" name="paquete">
                        <input type="text" hidden value="{{ $mant_maq->pin }}" id="pin" name="pin">
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $paquetemants->links() !!}
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

       $('#modificar').click(function(){
        var estado = $('#estado').val();
        var idpaquete = $('#paquete').val();
        var pin = $('#pin').val();
        var _token = $('input[name="_token"]').val();
        var opcion = confirm('¿Esta seguro que desea modificar el estado del mantenimiento?');
            if (opcion == true) {
                $.ajax({
                    url:"{{ route('mant_maq.modificarestado') }}",
                    method:"POST",
                    data:{_token:_token, estado:estado, idpaquete:idpaquete, pin:pin},
                    success:function(data)
                    {
                        window.location = data.url
                    },
                })
            }
        });
});

</script>
@endsection