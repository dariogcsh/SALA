@php 
use App\planservicio; 
use App\maquina;
use Carbon\Carbon;
@endphp
@php
$hoyplan = Carbon::today();
$cantec = Planservicio::join('users','planservicios.id_user','=','users.id')
                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                        ->where([['id_tarea',$tarea->id],['tareas.fechaplan','>=',$hoyplan],
                                ['nseriemaq','NOT LIKE','%No_valido%']])->count();
@endphp

<div class="card mb-3 border-dark">
    @if ($tarea->ubicacion == "Campo")
        <div class="card-header text-white bg-success">
    @elseif ($tarea->ubicacion == "Taller")
        <div class="card-header text-dark bg-warning">
    @else
        <div class="card-header text-dark bg-default">
    @endif
    <div class="d-flex justify-content-between">
        <div>
            @isset($tarea->id_user)
                <a class="buttonc" name="{{$tarea->id}}{{$tarea->id_user}}"><h5>{{ $tarea->NombOrga }} </h5></a> 
            @else
                <a class="buttonc" name="{{$tarea->id}}"><h5>{{ $tarea->NombOrga }} </h5></a> 
            @endisset
        </div>
        <div>
            <button class="btn btn-secundary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </button>
        
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @if (Request::url() == route('tarea.index'))
                @can('haveaccess','tarea.edit')
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="preos">A presupuestar</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="presupuestado">Servicio presupuestado</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="repuestos">Esperando repuestos</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="pendiente">Pendiente programación</a>
                @endcan
            @else
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="programado">Programado</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="postergado">Postergado</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="preos">A represupuestar</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="repuestos">Esperando repuestos</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="pendientefact">Pendiente de facturar</a>
                @can('haveaccess','tarea.edit')
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="finalizado">Terminado</a>
                @endcan
            @endif
              @can('haveaccess','tarea.edit')
              <div class="dropdowns-divider"></div>
                    <a class="dropdown-item" href="{{ route('tarea.edit',$tarea->id) }}"><i class="fas fa-edit"></i> <b>Editar</b></a>
                @endcan
            </div>
            </div>
        </div>
        </div>
        @if($tarea->estado <> "Programado")
        @if($tarea->estado == "Pendiente de facturar")
            <div class="card-text text-center text-white bg-primary">
        @elseif($tarea->estado == "Servicio finalizado")
            <div class="card-text text-center text-white bg-dark">
        @else
            <div class="card-text text-center text-white bg-danger">
        @endif
            
                {{ $tarea->estado }}
            </div>
        @endif
            @isset($tarea->id_user)
                <div id="display{{$tarea->id}}{{$tarea->id_user}}" style="display: none;">
            @else
                <div id="display{{$tarea->id}}" style="display: none;">
            @endisset
    
        <div class="card-body">
            
            <p class="card-text text-justify"><b>Tarea:</b> {{ $tarea->descripcion }}</p>
            <hr>
            <p class="card-text text-center"><b>Técnicos</b></p>
            @php
                $tecnicos = Planservicio::join('users','planservicios.id_user','=','users.id')
                                        ->where('id_tarea',$tarea->id)->get();
            @endphp
            @isset($tecnicos)
                @foreach($tecnicos as $tecnico)
                    <h6 class="bg-light text-center">{{ $tecnico->name }} {{ $tecnico->last_name }}</h6>
                @endforeach
            @endisset
        </div>
        <div class="card-footer bg-transparent border-dark text-center">
            @php
            $maquina = Maquina::where('NumSMaq', $tarea->nseriemaq)->first();
            @endphp

            <h6 class="card-text text-center"><b>{{ $maquina->ModeMaq }}</b></h6>
            <p class="card-text text-center">{{ $tarea->nseriemaq }}</p>
        </div>
    </div>
</div>

