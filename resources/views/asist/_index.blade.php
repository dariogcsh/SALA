@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Asistencias</h2>
                @if ($vista=="sucursal")
                    <a href="{{ route('asist.index') }}" title="Ver solicitudes del concesionario">Concesionario</a>
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
                
                @include('custom.message')
              
                @can('haveaccess','asist.create')
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <a href="{{ route('asist.createchat') }}" class="btn btn-success btn-block"><b>Solicitar asistencia</b></a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <a href="{{ route('asist.create') }}" class="btn btn-light btn-block"><b>Solicitar asistencia detallada*</b></a>
                        </div>
                    </div>
                </div>
                <br>
                <p>*La asistencia detallada nos permite realizar un diagnóstico más preciso y rápido previo a contactarlo.</p>
                @endcan
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th></th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha última modificación</th>
                            <th scope="col">Sucursal</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($asistencias as $asist)
                            @can('haveaccess','asist.index')
                                @if ($asist->EstaAsis == "Asistencia finalizada")
                                    <tr href="{{ route('asist.show',$asist->id) }}" class="evtclick" title="Chat">
                                @else
                                    <tr href="{{ route('asist.show',$asist->id) }}" class="clicksinpromp" title="Chat">
                                @endif
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $asist->id }}</th>
                            @if ((($asist->InscOrga == "SI") AND ($asist->EstaAsis == "Solicitud")) OR (($asist->MaPaAsis == "SI") AND ($asist->EstaAsis == "Solicitud")))
                                <th><img src="{{ asset('/imagenes/arojo.png') }}"  height="20" title="Asistencia urgente"></th>
                            @elseif (($asist->EstaAsis == "Respondido") OR ($asist->EstaAsis == "Presupuestado"))
                                <th><img src="{{ asset('/imagenes/averde.png') }}"  height="20" title="Respuesta del concesionario"></th>
                            @elseif (($asist->EstaAsis == "Asistencia finalizada") OR ($asist->EstaAsis == "Asistencia rechazada"))
                                <th></th>
                            @elseif (($asist->EstaAsis == "Derivacion a campo") OR ($asist->EstaAsis == "Derivacion a taller"))
                                <th><img src="{{ asset('/imagenes/agris.png') }}"  height="20" title="Derivacion a campo/Turno en taller"></th>
                            @else
                                <th><img src="{{ asset('/imagenes/aamarillo.png') }}"  height="20" title="Asistencia solicitada"></th>
                            @endif
                            <th scope="row">{{ $asist->NombOrga }}</th>
                            <th scope="row">{{ $asist->EstaAsis }}</th>
                            <th scope="row">{{  date('d/m/Y',strtotime($asist->updated_at)) }}</th>
                            <th scope="row">{{ $asist->NombSucu }}</th>
                            @can('haveaccess','asist.create')
                                @if ($asist->EstaAsis == "Asistencia finalizada")
                                    <th><a href="{{ route('asist.show',$asist->id) }}" class="evtclick" title="Chat"><img src="{{ asset('/imagenes/chat.png') }}"  height="20"></a> </th>
                                @else
                                    <th><a href="{{ route('asist.show',$asist->id) }}" class="clicksinpromp" title="Chat"><img src="{{ asset('/imagenes/chat.png') }}"  height="20"></a> </th>
                                @endif
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $asistencias->links() !!}
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
            document.formulario1.submit();
        }


$(document).ready(function(){
       $('.evtclick').click(function(){
        if ($(this).attr('href')) {
        var opcion = confirm('Esta asistencia ya ha sido finalizada ¿Desea reabrirla? (solo si se refiere a la misma asistencia anteriormente solicitada)');
            if (opcion == true) {
                window.location = $(this).attr('href');
            }
        }
       });

       $('.clicksinpromp').click(function(){
        if ($(this).attr('href')) {
            window.location = $(this).attr('href');
        }
       });
});
</script>
@endsection
