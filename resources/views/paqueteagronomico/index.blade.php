@php
    use App\maquina;
@endphp   
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de paquetes agronómicos 
                @can('haveaccess','paqueteagronomico.create')
                <a href="{{ route('paqueteagronomico.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Organización</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Equipos monitoreados</th>
                            <th scope="col">Altimetría</th>
                            <th scope="col">Suelo</th>
                            <th scope="col">Compactación</th>
                            <th scope="col">Hectareas monitoreadas</th>
                            <th scope="col">Cant. Lotes</th>
                            <th scope="col">Costo</th>
                            <th scope="col">Año fiscal</th>
                            <th scope="col">Vencimiento</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($paqueteagronomicos as $paqueteagronomico)
                            @can('haveaccess','paqueteagronomico.show')
                            <tr href="{{ route('paqueteagronomico.show',$paqueteagronomico->id) }}">
                            @else
                            <tr>
                            @endcan
                                <th scope="row">{{ $paqueteagronomico->NombOrga }}</th>
                                <th scope="row">{{ $paqueteagronomico->NombSucu }}</th>
                                @php
                                    $maquinas = Maquina::join('jdlinks','maquinas.NumSMaq','=','jdlinks.NumSMaq')
                                                        ->join('paquete_maquinas','jdlinks.id','=','paquete_maquinas.id_jdlink')
                                                        ->where('paquete_maquinas.id_paquete',$paqueteagronomico->id)->get();
                                @endphp
                                <th scope="row">
                                @foreach($maquinas as $maquina)
                                    {{ $maquina->ModeMaq }} <span>{{ $maquina->NumSMaq }}</span> - 
                                @endforeach
                                </th>
                                <th scope="row">{{ $paqueteagronomico->altimetria }}</th>
                                <th scope="row">{{ $paqueteagronomico->suelo }}</th>
                                <th scope="row">{{ $paqueteagronomico->compactacion }}</th>
                                <th scope="row">{{ $paqueteagronomico->hectareas }}</th>
                                <th scope="row">{{ $paqueteagronomico->lotes }}</th>
                                <th scope="row">{{ $paqueteagronomico->costo }}</th>
                                <th scope="row">{{ $paqueteagronomico->anofiscal }}</th>
                                <th scope="row">{{ $paqueteagronomico->vencimiento }}</th>
                            @can('haveaccess','paqueteagronomico.show')
                                <th><a href="{{ route('paqueteagronomico.show',$paqueteagronomico->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $paqueteagronomicos->onEachSide(0)->links() !!}
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
