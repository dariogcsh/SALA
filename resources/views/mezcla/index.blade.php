@php
    use App\insumo;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lista de mezclas de tanque 
                @can('haveaccess','mezcla.create')
                <a href="{{ route('mezcla.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            @if($organizacion->NombOrga == 'Sala Hnos')
                                <th scope="col">Organización</th>
                            @else
                                <th scope="col">#</th>
                            @endif
                            <th scope="col">Nombre de mezcla</th>
                            <th scope="col">Insumos</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($mezclas as $mezcla)
                            @can('haveaccess','mezcla.show')
                            <tr href="{{ route('mezcla.show',$mezcla->id) }}">
                            @else
                            <tr>
                            @endcan
                            @if($organizacion->NombOrga == 'Sala Hnos')
                                <th scope="row">{{ $mezcla->NombOrga }}</th>
                            @else
                                <th scope="row">{{ $mezcla->id }}</th>
                            @endif
                            <th scope="row">{{ $mezcla->nombre }}</th>
                            @php
                                $insumos = Insumo::select('marcainsumos.nombre as marca','insumos.nombre','mezcla_insus.cantidad')
                                                ->join('mezcla_insus','insumos.id','=','mezcla_insus.id_insumo')
                                                ->join('marcainsumos', 'insumos.id_marcainsumo','=','marcainsumos.id')
                                                ->where('mezcla_insus.id_mezcla',$mezcla->id)->get();
                            @endphp
                            <th scope="row">
                                @foreach($insumos as $insumo)
                                    <p>  {{ $insumo->marca }} {{ $insumo->nombre }} - {{ $insumo->cantidad }} lts </p>
                                @endforeach
                            </th>
                            @can('haveaccess','mezcla.show')
                                <th><a href="{{ route('mezcla.show',$mezcla->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $mezclas->links() !!}
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
