@php
    use App\utilidad;
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>Informes diarios
                </h2></div>
                <div class="card-body">
                    @include('custom.message')
                    
                    @if ($organizacion->NombOrga == "Sala Hnos")
                        @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="tipo" class="form-control mr-sm-2">
                                        <option value="">Buscar por</option>
                                        <option value="NombOrga">Organizacion</option>
                                    </select>
                                    <input class="form-control py-2" type="text" placeholder="Buscar" name="buscarpor">
                                    <span class="input-group-append">
                                        <button class="btn btn-warning" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                        @endif
                        @if ($filtro=="SI")
                            <a class="btn btn-secondary float-right" href="{{ route('utilidad.indexdiario') }}">
                                <i class="fa fa-times"> </i>
                                {{ $busqueda }}
                            </a>
                        @endif
                    @endif
                <br>
                <br>
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Organización</th>
                            <th scope="col">Fecha</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($utilidads as $utilidad)
                            @can('haveaccess','utilidad.showdiario')
                            @php
                            $hoy = Carbon::today();
                            if($utilidad->FecIUtil == $hoy){
                                $ayer = Carbon::yesterday();
                                $id = $ayer."_".$utilidad->CodiOrga;
                            } else {
                                $id = $utilidad->FecIUtil."_".$utilidad->CodiOrga;
                            }
                            @endphp
                            <tr href="{{ route('utilidad.showdiario',$id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $utilidad->NombOrga }}</th>
                            @if($utilidad->FecIUtil == $hoy)
                                <th scope="row">{{ date('d/m/Y',strtotime($ayer)) }}</th>
                            @else
                                <th scope="row">{{ date('d/m/Y',strtotime($utilidad->FecIUtil)) }}</th>
                            @endif
                            @can('haveaccess','utilidad.showdiario')
                            <th><a href="{{ route('utilidad.showdiario',$id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $utilidads->onEachSide(0)->links() !!}
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
