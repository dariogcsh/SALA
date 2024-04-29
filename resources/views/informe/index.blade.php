@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Historial de informes</h2>
                    <br>
                    @if ($vista=="sucursal")
                        <a href="{{ route('informe.index') }}" title="Ver solicitudes del concesionario">Concesionario</a>
                        <b> / Sucursal</b>
                        @elseif($vista=="concesionario")
                        <form name="formulario1">
                            <input type="hidden" name="sucu" value="sucursal">
                        </form>
                        <b>Concesionario / </b>
                        <a href="javascript:enviar_formulario1()" title="Ver solicitudes de mi sucursal">Sucursal</a>
                    @endif
                </div>
                <div class="card-body">
                        @if ($filtro=="")
                            <form class="form-inline float-right">
                                <div class="row">
                                    <div class="input-group col-md-12">
                                        <select name="tipo" class="form-control mr-sm-2">
                                            <option value="">Buscar por</option>
                                            @if($nomborg->NombOrga == 'Sala Hnos')
                                                <option value="organizacions.NombOrga">Organizacion</option>
                                            @endif
                                            <option value="maquinas.NumSMaq">N° de serie</option>
                                            <option value="CultInfo">Cultivo</option>
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
                            <a class="btn btn-secondary float-right" href="{{ route('informe.index') }}">
                                <i class="fa fa-times"> </i>
                                {{ $busqueda }}
                            </a>
                        @endif
                    
                    <br>
                    <br>

                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Organizacion</th>
                                <th scope="col">Máquina</th>
                                <th scope="col">Fecha ultimo Informe</th>
                                <th scope="col">Hs de trilla ultimo informe</th>
                                <th scope="col">Cultivo</th>
                                <th scope="col"></th>
                                <th colspan=3></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($informes as $info)
                                <tr href="{{ url('/utilidad/'.$info->id) }}"> 
                                <th scope="row">{{ $info->NombOrga }}</th>
                                <th scope="row">{{ $info->NumSMaq }}</th>
                                <th scope="row">{{ date("d/m/Y", strtotime($info->FecFInfo)) }}</th>
                                <th scope="row">{{ $info->HsTrInfo }}</th>
                                <th scope="row">{{ $info->CultInfo }}</th>
                                <th scope="row"><a href="{{ url('/utilidad/'.$info->id) }}">Generar este informe</a></th>
                                </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $informes->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="application/javascript">
    function enviar_formulario1(){
            document.formulario1.submit()
        }
    $(document).ready(function(){
           //$('table tr').click(function(){
            $('table tr').click(function(){
                if ($(this).attr('href')) {
                    window.location = $(this).attr('href');
                }
               
               return false;
           });
    });
    </script>
@endsection
