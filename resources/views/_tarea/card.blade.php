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
    @isset($tarea->id_user)
        <a class="buttonc" name="{{$tarea->id}}{{$tarea->id_user}}"><h5>{{ $tarea->NombOrga }} </h5></a> </div>
    @else
        <a class="buttonc" name="{{$tarea->id}}"><h5>{{ $tarea->NombOrga }} </h5></a> </div>
    @endisset
    
            <button class="btn btn-secundary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-h"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @if (Request::url() == route('tarea.index'))
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="preos">Pre OS</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="presupuestado">Servicio presupuestado</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="repuestos">Esperando repuestos</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="pendiente">Pendiente programación</a>
                
                @if($cantec > 0)
                    <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="programado">Programado</a>
                @else
                    <a class="dropdown-item clestado disabled">Programado</a>
                @endif
            @else
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="programado">Programado</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="ejecucion">En ejecución</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="pausado">Pausado</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="autorizacion">Esperando autorización</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="pieza">Esperando pieza</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="recibida">Pieza recibida</a>
                <a class="dropdown-item clestado" id="{{ $tarea->id }}" name="finalizado">Servicio finalizado</a>
            @endif
              @can('haveaccess','tarea.edit')
              <div class="dropdowns-divider"></div>
                    <a class="dropdown-item" href="{{ route('tarea.edit',$tarea->id) }}"><i class="fas fa-edit"></i> <b>Editar</b></a>
                @endcan
            </div>
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

