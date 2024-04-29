@php
    use App\campo;
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
                            <a class="btn btn-secondary float-right" href="{{ route('campo.index') }}">
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
                            <th scope="col">Lotes</th>
                            <th scope="col">Hectáreas</th>
                            <th scope="col">Fecha</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($campos as $campo)
                            @php
                                $hectareas = Campo::where([['campos.op_fin',$campo->op_fin], ['campos.org_id',$campo->CodiOrga]])
                                                    ->sum('campos.op_ha');
                                $lotes = Campo::where([['campos.op_fin',$campo->op_fin], ['campos.org_id',$campo->CodiOrga]])
                                                    ->count('campos.op_ha');
                                $idcampo = Campo::where([['campos.op_fin',$campo->op_fin], ['campos.org_id',$campo->CodiOrga]])
                                                    ->first();
                            @endphp
                            @can('haveaccess','campo.show')
                            <tr href="{{ route('campo.show',$idcampo) }}">
                            @else
                            <tr>
                            @endcan
                            @if ($organizacion->NombOrga == "Sala Hnos Demo")
                                <th scope="row">Sala Hnos Demo</th>
                            @else
                                <th scope="row">{{ $campo->NombOrga }}</th>
                            @endif
                            <th scope="row">{{ $lotes }}</th>
                            <th scope="row">{{ $hectareas }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($campo->op_fin)) }}</th>
                            @can('haveaccess','campo.show')
                            <th><a href="{{ route('campo.show',$idcampo) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $campos->links() !!}
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
