@php
    use app\User;
    use app\organizacion;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Órdenes de trabajo 
                @can('haveaccess','ordentrabajo.create')
                    <a href="{{ route('ordentrabajo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                    <div class="col-md-3">
                        <a class="btn btn-light" href="{{ route('ordentrabajo.historial') }}">Historial de trabajos</a>
                    </div>
                </div>
                <br>
                <div class="row">
                        @foreach ($ordentrabajos as $orden)
                        <div class="col-lg-2 col-md-4 col-sm-12">
                            @if ($organizacion->NombOrga == "Sala Hnos")
                                <div class="title-dark"><h5>{{ $orden->NombOrga }}</h5></div>
                            @endif
                            <br>
                            <div class="card mb-3 border-dark">
                                @if ($orden->estado == "Enviado")
                                    <div class="card-text text-white bg-danger text-center">
                                @elseif ($orden->estado == "En ejecucion")
                                    <div class="card-text text-dark bg-warning text-center">
                                @elseif ($orden->estado == "Finalizado")
                                    <div class="card-text text-white bg-success text-center">
                                @else
                                    <div class="card-text text-white bg-dark text-center">
                                @endif
                                     <b>{{ $orden->estado }}</b>
                                    </div>
                               
                                    <div class="card-body">
                                        @if ($orden->tipo == "Aplicacion")
                                            <p class="card-text text-center"><img class="img img-responsive float-left" src="/imagenes/PULVERIZADORA.png" height="50px"></p>
                                            <p class="card-text text-center"><b>APLICACIÓN</b></p>
                                        @elseif ($orden->tipo == "Fertilizacion")
                                            <p class="card-text text-center"><img class="img img-responsive float-left" src="/imagenes/SEMBRADORA.png" height="50px"></p>
                                            <p class="card-text text-center"><b>FERTILIZACIÓN</b></p>
                                        @elseif ($orden->tipo == "Siembra")
                                            <p class="card-text text-center"><img class="img img-responsive float-left" src="/imagenes/SEMBRADORA.png" height="50px"></p>
                                            <p class="card-text text-center"><b>SIEMBRA</b></p>
                                        @else
                                            <p class="card-text text-center"><img class="img img-responsive float-left" src="/imagenes/COSECHADORA.png" height="50px"></p>
                                            <p class="card-text text-center"><b>COSECHA</b></p>
                                        @endif
                                        <hr>
                                            <p class="card-text text-justify"><b>Lote:</b> {{ $orden->name }}, <small>{{ $orden->client }}, {{ $orden->farm }}</small></p>
                                            <p class="card-text text-justify"><b>Superficie:</b> {{ $orden->has }} Has.</p>
                                        @php
                                            $usuariotrabajo = User::where('id',$orden->id_usuariotrabajo)->first();
                                        @endphp
                                        <p class="card-text text-justify"><b>Operario:</b> {{ $usuariotrabajo->last_name }} {{ $usuariotrabajo->name }}</p>

                                        @if($orden->fechaindicada == '')
                                            <p class="card-text text-justify"><b>Fecha indicada:</b> {{ $orden->fechaindicada }}</p>
                                        @else
                                            <p class="card-text text-justify"><b>Fecha indicada:</b> {{ date('d/m/Y',strtotime($orden->fechaindicada)) }}</p>
                                        @endif
                                        <p class="card-text text-justify"><b>Prescripción:</b> {{ $orden->prescripcion }}</p>
                                        @if($orden->fechainicio == '')
                                            <p class="card-text text-justify"><b>Fecha inicio:</b> {{ $orden->fechainicio }}</p>
                                        @else
                                            <p class="card-text text-justify"><b>Fecha inicio:</b> {{ date('d/m/Y',strtotime($orden->fechainicio)) }}</p>
                                        @endif
                                        @if($orden->fechafin == '')
                                            <p class="card-text text-justify"><b>Fecha fin:</b> {{ $orden->fechafin }}</p>
                                        @else
                                            <p class="card-text text-justify"><b>Fecha fin:</b> {{ date('d/m/Y',strtotime($orden->fechafin)) }}</p>
                                        @endif

                                    
                                    </div>
                                    <div class="card-footer bg-transparent border-dark text-center">
                                        <a class="btn btn-success" href="{{ route('ordentrabajo.show',$orden->id) }}">Detalles</a>
                                        @if($orden->estado == "Enviado")
                                            <button class="btn btn-warning" id="{{ $orden->id }}" name="iniciar">Iniciar</button>
                                        @elseif($orden->estado == "En ejecucion")
                                            <button class="btn btn-dark" id="{{ $orden->id }}" name="terminar">Terminar</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
document.addEventListener("DOMContentLoaded", function(e) {

var elBotones = document.querySelectorAll("button");
console.log(elBotones);

/*Asignamos  función para escuchar*/
for (var i = 0; i < elBotones.length; i++) {
  elBotones[i].addEventListener("click", manejarBotones, false)
}


});

/*Podremos usar  this.id  para identificar cada botón*/
function manejarBotones(e) {
    e.preventDefault();
        var id = $(this).attr('id');
        var tipo = $(this).attr('name');
        var _token = $('input[name="_token"]').val();
      
        if(tipo == 'iniciar'){
            var opcion = confirm('¿Esta seguro que desea iniciar la orden de trabajo?');
                if (opcion == true) {
                    $.ajax({
                        url:"{{ route('ordentrabajo.iniciar') }}",
                        method:"POST",
                        data:{_token:_token, id:id},
                        error:function()
                        {
                            alert("Ha ocurrido un error, intentelo más tarde");
                        },
                        success:function(data)
                        {   
                            location.reload();
                        },
                    })
                }
        } else {
                var opcion = confirm('¿Esta seguro que desea finalizar la orden de trabajo?');
                if (opcion == true) {
                    $.ajax({
                        url:"{{ route('ordentrabajo.terminar') }}",
                        method:"POST",
                        data:{_token:_token, id:id},
                        error:function()
                        {
                            alert("Ha ocurrido un error, intentelo más tarde");
                        },
                        success:function(data)
                        {   
                            location.reload();
                        },
                    })
                }
        }
}

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
