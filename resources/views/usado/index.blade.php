@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de usados 
                @can('haveaccess','usado.create')
                    <a href="{{ route('usado.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                    <div class="form-group col-md-2">
                        <form name="formulario1">
                            <select name="tipo_maquina" id="tipo_maquina" class="form-control" onchange="javascript:enviar_formulario1()">
                                @isset ($tipo_maquina)
                                    @if($tipo_maquina == "COSECHADORA")
                                        <option value="COSECHADORA" selected>COSECHADORAS</option>
                                        <option value="TRACTOR">TRACTORES</option>
                                        <option value="PULVERIZADORA">PULVERIZADORAS</option>
                                        <option value="SEMBRADORA">SEMBRADORAS</option>
                                        <option value="PLATAFORMA">PLATAFORMAS</option>
                                        <option value="ROTOENFARDADORA">ROTOENFARDADORAS</option>
                                        <option value="EQUIPOS VENDIDOS">EQUIPOS VENDIDOS</option>
                                    @elseif($tipo_maquina == "TRACTOR")
                                        <option value="COSECHADORA">COSECHADORAS</option>
                                        <option value="TRACTOR" selected>TRACTORES</option>
                                        <option value="PULVERIZADORA">PULVERIZADORAS</option>
                                        <option value="SEMBRADORA">SEMBRADORAS</option>
                                        <option value="PLATAFORMA">PLATAFORMAS</option>
                                        <option value="ROTOENFARDADORA">ROTOENFARDADORAS</option>
                                        <option value="EQUIPOS VENDIDOS">EQUIPOS VENDIDOS</option>
                                    @elseif($tipo_maquina == "PULVERIZADORA")
                                        <option value="COSECHADORA">COSECHADORAS</option>
                                        <option value="TRACTOR">TRACTORES</option>
                                        <option value="PULVERIZADORA" selected>PULVERIZADORAS</option>
                                        <option value="SEMBRADORA">SEMBRADORAS</option>
                                        <option value="PLATAFORMA">PLATAFORMAS</option>
                                        <option value="ROTOENFARDADORA">ROTOENFARDADORAS</option>
                                        <option value="EQUIPOS VENDIDOS">EQUIPOS VENDIDOS</option>
                                    @elseif($tipo_maquina == "SEMBRADORA")
                                        <option value="COSECHADORA">COSECHADORAS</option>
                                        <option value="TRACTOR">TRACTORES</option>
                                        <option value="PULVERIZADORA">PULVERIZADORAS</option>
                                        <option value="SEMBRADORA" selected>SEMBRADORAS</option>
                                        <option value="PLATAFORMA">PLATAFORMAS</option>
                                        <option value="ROTOENFARDADORA">ROTOENFARDADORAS</option>
                                        <option value="EQUIPOS VENDIDOS">EQUIPOS VENDIDOS</option>
                                    @elseif($tipo_maquina == "PLATAFORMA")
                                        <option value="COSECHADORA">COSECHADORAS</option>
                                        <option value="TRACTOR">TRACTORES</option>
                                        <option value="PULVERIZADORA">PULVERIZADORAS</option>
                                        <option value="SEMBRADORA">SEMBRADORAS</option>
                                        <option value="PLATAFORMA"selected>PLATAFORMAS</option>
                                        <option value="ROTOENFARDADORA">ROTOENFARDADORAS</option>
                                        <option value="EQUIPOS VENDIDOS">EQUIPOS VENDIDOS</option>
                                    @elseif($tipo_maquina == "ROTOENFARDADORA")
                                        <option value="COSECHADORA">COSECHADORAS</option>
                                        <option value="TRACTOR">TRACTORES</option>
                                        <option value="PULVERIZADORA">PULVERIZADORAS</option>
                                        <option value="SEMBRADORA">SEMBRADORAS</option>
                                        <option value="PLATAFORMA">PLATAFORMAS</option>
                                        <option value="ROTOENFARDADORA" selected>ROTOENFARDADORAS</option>
                                        <option value="EQUIPOS VENDIDOS">EQUIPOS VENDIDOS</option>
                                    @elseif($tipo_maquina == "EQUIPOS VENDIDOS")
                                        <option value="COSECHADORA">COSECHADORAS</option>
                                        <option value="TRACTOR">TRACTORES</option>
                                        <option value="PULVERIZADORA">PULVERIZADORAS</option>
                                        <option value="SEMBRADORA">SEMBRADORAS</option>
                                        <option value="PLATAFORMA">PLATAFORMAS</option>
                                        <option value="ROTOENFARDADORA">ROTOENFARDADORAS</option>
                                        <option value="EQUIPOS VENDIDOS" selected>EQUIPOS VENDIDOS</option>
                                    @endif
                                @endisset
                            </select>
                        </form>
                    </div>
                    <div class="form-group col-md-2">
                        <a class="btn btn-block btn-secondary" href="{{ route('subirpdf.indexusados') }}">Formulario de usados</a>
                    </div>
                </div>
                <br>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Equipo</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Año</th>
                            <th scope="col">Horas de motor</th>
                            <th scope="col">Horas de trilla</th>
                            <th scope="col">US$</th>
                            <th scope="col">Ex dueño</th>
                            <th scope="col">Fecha limite de reserva</th>
                            <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($usados as $usado)
                            @can('haveaccess','usado.show')
                                @if ($usado->estado == "Reservado")
                                    <tr href="{{ route('usado.show',$usado->id) }}">
                                @elseif ($usado->estado == "Progreso")
                                    <tr  href="{{ route('usado.createUpdate',$usado->id) }}">
                                @else
                                    <tr href="{{ route('usado.show',$usado->id) }}">
                                @endif
                            @endcan
                            @if(($usado->tipo == 'PULVERIZADORA') AND ($usado->marca == 'PLA'))
                                <th scope="row"><img class="img img-responsive" src="{{ '/imagenes/PULVERIZADORAPLA.png' }}" height="30px"></th>
                            @elseif(($usado->tipo == 'SEMBRADORA') AND ($usado->marca == 'PLA'))
                                <th scope="row"><img class="img img-responsive" src="{{ '/imagenes/SEMBRADORAPLA.png' }}" height="30px"></th>
                            @elseif(($usado->tipo == 'PLATAFORMA DE MAIZ') OR ($usado->tipo == 'PLATAFORMA DE GIRASOL') OR ($usado->tipo == 'PLATAFORMA SINFIN') OR ($usado->tipo == 'PLATAFORMA DRAPER'))
                                <th scope="row"><img class="img img-responsive" src="{{ '/imagenes/DRAPER.png' }}" height="30px"></th>
                            @else
                                <th scope="row"><img class="img img-responsive" src="{{ '/imagenes/'.$usado->tipo.'.png' }}" height="30px"></th>
                            @endif
                            <th scope="row">{{ $usado->marca }}</th>
                            <th scope="row">{{ $usado->modelo }}</th>
                            <th scope="row">{{ $usado->ano }}</th>
                            <th scope="row">{{ number_format($usado->horasm) }}</th>
                            <th scope="row">{{ number_format($usado->horast) }}</th>
                            <th scope="row">{{ number_format($usado->precio) }}</th>
                            <th scope="row">Ex {{ $usado->excliente }}</th>
                            @isset($usado->fechahasta)
                                <th scope="row">{{ date('d/m/Y',strtotime($usado->fechahasta)) }}</th>
                            @else
                                <th></th>
                            @endisset
                            @can('haveaccess','usado.show')
                                @if ($usado->estado == "Reservado")
                                    <th><a href="{{ route('usado.show',$usado->id) }}">Unidad reservada</a> </th>
                                @elseif ($usado->estado == "Vendido")
                                    <th><a href="{{ route('usado.show',$usado->id) }}">Unidad vendida</a> </th>
                                @elseif ($usado->estado == "Progreso")
                                    <th><a class="btn btn-danger" href="{{ route('usado.createUpdate',$usado->id) }}">Registro incompleto</a></th>
                                    <th>
                                        <a id="{{$usado->id}}" href="#" class="usado_eliminar btn btn-dark btn-block">Eliminar usado</a>
                                    </th>
                                @else
                                    <th><a href="{{ route('usado.show',$usado->id) }}">Disponible</a> </th>
                                @endif
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $usados->onEachSide(0)->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">

function enviar_formulario1(){
            document.formulario1.submit()
        }

$(document).ready(function(){
       $('table tr').click(function(){
        if ($(this).attr('href')) {
           window.location = $(this).attr('href');
        }
           return false;
       });

    $('.usado_eliminar').click(function(event){
        event.preventDefault();
        var id_usado = $(this).attr("id");
        var _token = $('input[name="_token"]').val(); 
        confirmacion = confirm('¿Desea eliminar la carga del usado?');
        if(confirmacion == true){
            $.ajax({
                url:"{{ route('usado.eliminar_carga') }}",
                method:"POST",
                data:{_token:_token, id_usado:id_usado},
                error:function()
                {
                    alert("Ha ocurrido un error, intentelo más tarde");
                },
                success:function()
                {   
                    window.location = "{{ route('usado.index') }}"; // Cambia esta ruta por la deseada
                },
            })
        }else{
            window.location = "{{ route('usado.index') }}"; // Cambia esta ruta por la deseada
        }
    });
});
</script>
@endsection
