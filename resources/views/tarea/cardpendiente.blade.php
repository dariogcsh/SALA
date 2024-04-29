@php 
    use App\planservicio; 
    use App\maquina;
    use App\organizacion;
    use App\sucursal;
    $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
    $sucursals = Sucursal::orderBy('id','desc')->get();
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
            @can('haveaccess','tarea.edit')
                @include('tarea.modal',['tareas' => $tarea->id, 'organizaciones' => $organizaciones, 'sucursals' => $sucursals])
            @endcan
            </div>
        </div>
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

