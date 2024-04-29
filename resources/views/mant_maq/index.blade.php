@php
    use App\mant_maq;
    use App\organizacion;
@endphp    
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de Paquetes de mantenimiento 
                @can('haveaccess','mant_maq.create')
                <a href="{{ route('mant_maq.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">N° de serie</th>
                            <th scope="col">Horas actuales</th>
                            <th scope="col">Tipos de paquetes contratados</th>
                            <th scope="col">Estado</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($mant_maqs as $mant_maq)
                            @php
                                $st="";
                            @endphp
                            @can('haveaccess','mant_maq.show')
                                <tr href="{{ route('mant_maq.show',$mant_maq->id) }}">
                            @else
                                <tr>
                            @endcan
                                <th scope="row">{{ $mant_maq->id }}</th>
                                @if(isset($mant_maq->NombOrga))
                                    <th scope="row">{{ $mant_maq->NombOrga }}</th>
                                @else
                                    @php
                                        $value = explode("-", $mant_maq->pin);
                                        $st = stripos($mant_maq->pin, "otra");
                                        $organ = Organizacion::where('id',$value[1])->first();
                                    @endphp
                                    <th scope="row">{{ $organ->NombOrga }}</th>
                                @endif
                                <th scope="row">{{ $mant_maq->NombSucu }}</th>
                                <th scope="row">{{ $mant_maq->ModeMaq }}</th>
                                @if($st<>"")
                                    @php
                                        $str = stripos($mant_maq->pin, "otra");
                                    @endphp
                                    @if($str !== false)
                                        <th scope="row">Máquina sin PIN</th>
                                        <th scope="row"></th>
                                    @else
                                        <th scope="row">{{ $mant_maq->pin }}</th>
                                        <th scope="row">{{ $mant_maq->horas }}</th>
                                    @endif
                                @else
                                    @php
                                        $str = stripos($mant_maq->pin, "otra");
                                    @endphp
                                    @if($str !== false)
                                        <th scope="row">Máquina sin PIN</th>
                                        <th scope="row"></th>
                                    @else
                                        <th scope="row">{{ $mant_maq->pin }}</th>
                                        <th scope="row">{{ $mant_maq->horas }}</th>
                                    @endif
                                @endif
                                
                            @php
                                $tipo_paquetes = Mant_maq::select('tipo_paquete_mants.horas')
                                                        ->join('paquetemants','mant_maqs.id_paquetemant','=','paquetemants.id')
                                                        ->join('tipo_paquete_mants','paquetemants.id_tipo_paquete_mant','=','tipo_paquete_mants.id')
                                                        ->where([['mant_maqs.pin',$mant_maq->pin],['mant_maqs.id',$mant_maq->id]])
                                                        ->groupBy('mant_maqs.pin')
                                                        ->groupBy('tipo_paquete_mants.horas')
                                                        ->orderBy('tipo_paquete_mants.horas','asc')
                                                        ->get();
                            @endphp
                                <th scope="row">
                            @foreach($tipo_paquetes as $tipo_paquete)
                                {{ $tipo_paquete->horas }} hs - 
                            @endforeach
                                </th>
                                <th scope="row">{{ $mant_maq->estado }}</th>
                            @can('haveaccess','mant_maq.show')
                                <th><a href="{{ route('mant_maq.show',$mant_maq->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                                </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $mant_maqs->onEachSide(0)->links() !!}
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
