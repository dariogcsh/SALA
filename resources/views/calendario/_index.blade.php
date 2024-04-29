@php
    use Carbon\Carbon;
    use App\calendario;
    use App\calendario_user;
    use App\calendario_archivo;
@endphp

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Calendario 
                @can('haveaccess','calendario.create')
                <a href="{{ route('calendario.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                    @include('custom.message')
                    <div class="row">
                        <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                            @can('haveaccess','calendario.index')
                            <a class="btn btn-warning btn-block" href="{{ route('capacitacion.index') }}">Administrar capacitaciones</a>
                            @endcan
                        </div>
                    </div>
                    <form name="formulario1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="id_usuario" class="col-md-4 col-form-label text-md-right">{{ __('Usuarios') }}</label>
        
                                    <div class="col-md-5">
                                        <select class="form-control @error('id_usuario') is-invalid @enderror" multiple id="id_usuario" name="id_usuario[]" autofocus>
                                            @isset($usuarios)
                                            @php 
                                            //array para guardar los users que ya esten asignados en la tarea
                                            $arrtec[] = ""; 
                                            $i=0;
                                            @endphp
                                                @foreach($lista_users as $user)
                                                    @foreach($usuarios as $usuario)
                                                        @if($user->id == $usuario->id)
                                                            <option value="{{ $user->id }}" selected>{{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                                            @php 
                                                            //guardo el/los user que ya esta asignado en la tarea en un array
                                                            $arrtec[$i] = $user->id;
                                                            $i++; 
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    <!--Comparo si el user del foreach esta dentro del array, caso contrario se asigna el option-->
                                                    @if(!in_array($user->id, $arrtec))
                                                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                                    @endif
                                                    @php 
                                                    //Vuelvo i a 0 ya que hay una nueva iteracion
                                                    $i = 0; 
                                                    @endphp
                                                @endforeach
                                            @else
                                                @isset($users)
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}"> {{ $user->name }} {{ $user->last_name }} | {{ $user->NombSucu }} | {{ $user->NombPuEm }}</option>
                                                    @endforeach
                                                @endisset
                                            @endisset
                                        </select>
                                        @error('id_usuario')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <button class="btn btn-success" onclick="javascript:enviar_formulario()">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <select style="text-align: center" class="form-control @error('ano') is-invalid @enderror" id="ano" name="ano" value="{{ isset($ano)?$ano:old('ano') }}" onchange="javascript:enviar_formulario()" autocomplete="ano" autofocus>
                                @isset($ano)
                                    <option value="{{ $ano }}">{{ $ano }}</option>
                                @else
                                    @php
                                        $anoactual = Carbon::today()->format('Y');
                                    @endphp
                                    <option value="{{ $anoactual }}">{{ $anoactual }}</option>
                                @endisset
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2031">2031</option>
                                    <option value="2032">2032</option>
                                    <option value="2033">2033</option>
                                    <option value="2034">2034</option>
                                    <option value="2035">2035</option>
                                    <option value="2036">2036</option>
                                    <option value="2037">2037</option>
                                    <option value="2038">2038</option>
                                    <option value="2039">2039</option>
                                    <option value="2040">2040</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select style="text-align: center" class="form-control @error('mes') is-invalid @enderror" id="mes" name="mes" value="{{ isset($mes)?$mes:old('mes') }}" onchange="javascript:enviar_formulario()" autocomplete="mes" autofocus>
                                    @isset($mes)
                                    @php
                                        if ($mes == 1) {
                                                $mesm = "Enero";
                                            }
                                            if ($mes == 2) {
                                                $mesm = "Febrero";
                                            }
                                            if ($mes == 3) {
                                                $mesm = "Marzo";
                                            }
                                            if ($mes == 4) {
                                                $mesm = "Abril";
                                            }
                                            if ($mes == 5) {
                                                $mesm = "Mayo";
                                            }
                                            if ($mes == 6) {
                                                $mesm = "Junio";
                                            }
                                            if ($mes == 7) {
                                                $mesm = "Julio";
                                            }
                                            if ($mes == 8) {
                                                $mesm = "Agosto";
                                            }
                                            if ($mes == 9) {
                                                $mesm = "Septiembre";
                                            }
                                            if ($mes == 10) {
                                                $mesm = "Octubre";
                                            }
                                            if ($mes == 11) {
                                                $mesm = "Noviembre";
                                            }
                                            if ($mes == 12) {
                                                $mesm = "Diciembre";
                                            }
                                    @endphp
                                        <option value="{{ $mes }}">{{ $mesm }}</option>
                                    @else
                                        @php
                                            $mesactual = Carbon::today()->format('m');
                                            if ($mesactual == 1) {
                                                $mesm = "Enero";
                                            }
                                            if ($mesactual == 2) {
                                                $mesm = "Febrero";
                                            }
                                            if ($mesactual == 3) {
                                                $mesm = "Marzo";
                                            }
                                            if ($mesactual == 4) {
                                                $mesm = "Abril";
                                            }
                                            if ($mesactual == 5) {
                                                $mesm = "Mayo";
                                            }
                                            if ($mesactual == 6) {
                                                $mesm = "Junio";
                                            }
                                            if ($mesactual == 7) {
                                                $mesm = "Julio";
                                            }
                                            if ($mesactual == 8) {
                                                $mesm = "Agosto";
                                            }
                                            if ($mesactual == 9) {
                                                $mesm = "Septiembre";
                                            }
                                            if ($mesactual == 10) {
                                                $mesm = "Octubre";
                                            }
                                            if ($mesactual == 11) {
                                                $mesm = "Noviembre";
                                            }
                                            if ($mesactual == 12) {
                                                $mesm = "Diciembre";
                                            }
                                        @endphp
                                        <option value="{{ $mesactual }}">{{ $mesm }}</option>
                                    @endisset
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                    
                        </div>
                    </form>
                    <div class="table-responsive-md">
                        <table border class="table table-hover" style="text-align: center;">
                            <thead>
                                <tr>
                                <th scope="col">DO</th>
                                <th scope="col">LU</th>
                                <th scope="col">MA</th>
                                <th scope="col">MI</th>
                                <th scope="col">JU</th>
                                <th scope="col">VI</th>
                                <th scope="col">SA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $x = 0;
                                @endphp
                                @foreach($usuarios as $usuario)
                                    @php
                                       $usuario_id[$x] = $usuario->id;
                                       $x++; 
                                    @endphp
                                    
                                @endforeach
                                @php
                                
                                    $startDate = Carbon::createFromDate($ano, $mes, '01'); //returns current day
                                    $lastDayM = Carbon::createFromDate($ano, $mes, '01'); //returns current day
                                    $firstDay = $startDate->firstOfMonth();
                                    $primero = $firstDay->format('l');
                                    $hoy = $firstDay->subDay();
                                    $lastDay = $lastDayM->endOfMonth();
                                    $ultimo = $lastDay->format('j');
                                    $eventos = Calendario::select('calendarios.id','calendarios.ubicacion','calendarios.fechainicio',
                                                                    'calendarios.fechafin','calendarios.horainicio','calendarios.horafin',
                                                                    'calendarios.titulo','calendarios.descripcion','calendarios.movilidad',
                                                                    'calendarios.reserva','sucursals.NombSucu','eventos.nombre','calendarios.externos',
                                                                    'users.name','users.last_name', 'calendarios.id_capacitacion')
                                                        ->join('calendario_users','calendarios.id','=','calendario_users.id_calendario')
                                                        ->join('eventos','calendarios.id_evento','=','eventos.id')
                                                        ->leftjoin('sucursals','calendarios.id_sucursal','=','sucursals.id')
                                                        ->join('users','calendarios.id_user','=','users.id')
                                                        ->where([['fechainicio','>=',$firstDay], ['fechainicio','<=',$lastDay]])
                                                        ->whereIn('calendario_users.id_user',$usuario_id)
                                                        ->distinct('calendarios.id')
                                                        ->orderBy('fechainicio','asc')->get();
                                    $jdus = Calendario::select('calendarios.id','calendarios.ubicacion','calendarios.fechainicio',
                                                                    'calendarios.fechafin','calendarios.horainicio','calendarios.horafin',
                                                                    'calendarios.titulo','calendarios.descripcion','calendarios.movilidad',
                                                                    'calendarios.reserva','sucursals.NombSucu','eventos.nombre','calendarios.externos',
                                                                    'users.name','users.last_name')
                                                        ->join('calendario_users','calendarios.id','=','calendario_users.id_calendario')
                                                        ->join('eventos','calendarios.id_evento','=','eventos.id')
                                                        ->leftjoin('sucursals','calendarios.id_sucursal','=','sucursals.id')
                                                        ->join('users','calendarios.id_user','=','users.id')
                                                        ->where([['fechainicio','>=',$firstDay],['fechainicio','<=',$lastDay], 
                                                                ['eventos.nombre','LIKE','%JDU%']])
                                                        ->whereIn('calendario_users.id_user',$usuario_id)
                                                        ->distinct('calendario.id')
                                                        ->orderBy('fechainicio','asc')->get();
                                @endphp
                                <tr>
                                    @if($primero == "Sunday")
                                        @php
                                            $i = 1;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 2;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 3;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 4;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 5;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 6;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 7;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $dias = 8;
                                        @endphp
                                    @endif 
                                    @if($primero == "Monday")
                                        <th scope="row"></th>
                                        @php
                                            $i = 1;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 2;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 3;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 4;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 5;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 6;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $dias = 7;
                                        @endphp
                                    @endif 
                                    @if($primero == "Tuesday")
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        @php
                                            $i = 1;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 2;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 3;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 4;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 5;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $dias = 6;
                                        @endphp
                                    @endif 
                                    @if($primero == "Wednesday")
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        @php
                                            $i = 1;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 2;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 3;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 4;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $dias = 5;
                                        @endphp
                                    @endif 
                                    @if($primero == "Thursday")
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        @php
                                            $i = 1;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 2;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $i = 3;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $dias = 4;
                                        @endphp
                                    @endif 
                                    @if($primero == "Friday")
                                    @php
                                    $i = 1;
                                    $hoy = $hoy->addDay();
                                    $hoyf = $hoy->format('Y-m-d');
                                    $dia = $hoy->format('l');
                                    $cant = 0;
                                    $fecha = 0;
                                    $negro = 0;
                                    $verde = 0;
                                @endphp
                                @include('calendario.fecha')
                                @php
                                    $i = 2;
                                    $hoy = $hoy->addDay();
                                    $hoyf = $hoy->format('Y-m-d');
                                    $dia = $hoy->format('l');
                                    $cant = 0;
                                    $fecha = 0;
                                    $negro = 0;
                                    $verde = 0;
                                @endphp
                                @include('calendario.fecha')
                                @php
                                    $dias = 3;
                                @endphp
                                    @endif 
                                    @if($primero == "Saturday")
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        <th scope="row"></th>
                                        @php
                                            $i = 1;
                                            $hoy = $hoy->addDay();
                                            $hoyf = $hoy->format('Y-m-d');
                                            $dia = $hoy->format('l');
                                            $cant = 0;
                                            $fecha = 0;
                                            $negro = 0;
                                            $verde = 0;
                                        @endphp
                                        @include('calendario.fecha')
                                        @php
                                            $dias = 2;
                                        @endphp
                                    @endif 
                                </tr>
                            @for($i = $dias; $i <= $ultimo; $i++)
                                @php
                                    $hoy = $hoy->addDay();
                                    $hoyf = $hoy->format('Y-m-d');
                                    $dia = $hoy->format('l');
                                    $cant = 0;
                                    $fecha = 0;
                                    $negro = 0;
                                    $verde = 0;
                                @endphp
                                @if($dia == "Sunday")
                                    <tr>
                                @endif

                                @include('calendario.fecha')

                                @if($dia == "Saturday")
                                    </tr>
                                @endif
                            @endfor
                            </tbody>
                        </table>
                    </div>
                    
                    <div id="evento">
                            @php
                                $startDate = Carbon::createFromDate($ano, $mes, '01'); //returns current day  
                                $firstDay = $startDate->firstOfMonth();
                                $hoy = $firstDay->subDay();
                            @endphp
                        @for($i = 1; $i <= $ultimo; $i++)
                            @php
                                $hoy = $hoy->addDay();
                                $hoyf = $hoy->format('Y-m-d');
                            @endphp
                                <div id="disp{{ $i }}" style="display: none;"> 
                                @foreach($eventos as $evento) 
                                    @if(($evento->fechainicio >= $hoyf) AND ($evento->fechafin <= $hoyf))
                                        <div class="card">
                                            <div class="card-header"><h3>{{ $evento->nombre }}@if(stripos($evento->nombre,'JDU')) <img src="{{ asset('/imagenes/JDU.png') }}"  height="30" style="margin-right: 10px;">@endif</h3></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Inicio</h4>
                                                <img src="{{ asset('/imagenes/calendario2.png') }}"  height="30" style="margin-right: 10px;">   {{ date('d/m/Y',strtotime($evento->fechainicio)) }} | {{ $evento->horainicio }} hs
                                                <hr>
                                            </div>
                                            <br>
                                            <div class="col-md-6">
                                                <h4>Finalización</h4>
                                                <img src="{{ asset('/imagenes/calendario2.png') }}"  height="30" style="margin-right: 10px;">{{ date('d/m/Y',strtotime($evento->fechafin)) }} | {{ $evento->horafin }} hs
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Sucursal</h4>
                                                <img src="{{ asset('/imagenes/interno.png') }}"  height="30" style="margin-right: 10px;">
                                                @isset($evento->NombSucu)
                                                    {{ $evento->NombSucu }}
                                                @else
                                                   
                                                @endisset 
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>Ubicación</h4>
                                                <img src="{{ asset('/imagenes/gps.png') }}"  height="30" style="margin-right: 10px;">
                                                @isset($evento->ubicacion)
                                                    {{ $evento->ubicacion }}
                                                @else
                                                    {{ $evento->NombSucu }}
                                                @endisset 
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                @isset($evento->titulo)
                                                    <h5>Título</h5>
                                                    {{ $evento->titulo }}
                                                    <hr>
                                                @endisset
                                            </div>
                                            <div class="col-md-6">
                                                @isset($evento->descripcion)
                                                    <h5>Descripción</h5>
                                                    {{ $evento->descripcion }}
                                                    <hr>
                                                @endisset
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Creado por</h5>
                                                <img src="{{ asset('/imagenes/creadorpor.png') }}"  height="20" style="margin-right: 10px;">
                                                    {{ $evento->name }} {{ $evento->last_name }}
                                                <hr>
                                            </div>
                                        </div>
                                        @php
                                            $userdis = Calendario_user::select('users.name','users.last_name')
                                                                    ->join('users','calendario_users.id_user','=','users.id')
                                                                    ->where([['calendario_users.id_calendario',$evento->id],
                                                                            ['calendario_users.tipo', 'Disertante']])->get();
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Disertantes</h5>
                                                <img src="{{ asset('/imagenes/organizacion.png') }}"  height="30" style="margin-right: 10px;">
                                                @foreach($userdis as $userdi)
                                                {{ $evento->ubicacion }}{{ $userdi->name }} {{ $userdi->last_name }} - 
                                                @endforeach
                                                <hr>
                                            </div>
                                        @php
                                            $userpar = Calendario_user::select('users.name','users.last_name')
                                                                    ->join('users','calendario_users.id_user','=','users.id')
                                                                    ->where([['calendario_users.id_calendario',$evento->id],
                                                                            ['calendario_users.tipo', 'Participante']])->get();
                                        @endphp
                                            <div class="col-md-6">
                                                <h5>Participantes</h5>
                                                <img src="{{ asset('/imagenes/organizacion.png') }}"  height="30" style="margin-right: 10px;">
                                                @foreach($userpar as $userpa)
                                                {{ $userpa->name }} {{ $userpa->last_name }} - 
                                                @endforeach
                                                <hr>
                                            </div>
                                        </div>
                                        @if($evento->externos <> '')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>Participantes externos</h5>
                                                    <img src="{{ asset('/imagenes/organizacion.png') }}"  height="30" style="margin-right: 10px;">
                                                    @isset($evento->externos)
                                                        {{ $evento->externos }}
                                                    @else
                                                    
                                                    @endisset 
                                                    <hr>
                                                </div>
                                            </div>
                                        @endif
                                        @if($evento->reserva <> '')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>Reserva</h5>
                                                    <img src="{{ asset('/imagenes/reunion.png') }}"  height="30" style="margin-right: 10px;">
                                                    @isset($evento->reserva)
                                                        {{ $evento->reserva }}
                                                    @else
                                                    
                                                    @endisset 
                                                    <hr>
                                                </div>
                                            </div>
                                        @endif
                                        @php
                                            $archivos = Calendario_archivo::where('id_calendario',$evento->id)->get();
                                        @endphp
                                        @if(!empty($archivos))
                                        <div class="row">
                                            <div class="col-md-12">
                                            <h5>Fotos</h5>
                                                @foreach($archivos as $archivo)
                                                    <a data-toggle="modal" data-target="#{{ $archivo->path }}"><img src="{{ asset('img/eventos/'.$archivo->path) }}"  height="100" style="margin-right: 10px;"></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="{{ $archivo->path }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <img src="{{ asset('img/eventos/'.$archivo->path) }}"  width="100%" style="margin-right: 10px;">
                                                            </div>
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                        <br>
                                        
                                        <div class="row">
                                            <div class="col-xs-12 col-md-2" style="margin-bottom:5px;">
                                                @can('haveaccess','calendario.edit') 
                                                    <a href="{{ route('calendario.files',$evento->id) }}" class="btn btn-success btn-block">Subir foto</a>
                                                @endcan
                                            </div>
                                            @if($evento->id_capacitacion == '')
                                                <div class="col-xs-12 col-md-2" style="margin-bottom:5px;">
                                                    @can('haveaccess','calendario.edit') 
                                                        <a href="{{ route('calendario.edit',$evento->id) }}" class="btn btn-warning btn-block">Editar</a>
                                                    @endcan
                                                </div>
                                                <div class="col-xs-12 col-md-2" style="margin-bottom:5px;">
                                                    @can('haveaccess','calendario.destroy')
                                                        <form action="{{ route('calendario.destroy',$evento->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                                                        </form>
                                                    @endcan
                                                </div> 
                                            @endif
                                        </div> 
                                        <br>
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="application/javascript">
function enviar_formulario(){
            document.formulario1.submit()
        }
//Lee la clase donde se hizo click
document.querySelectorAll(".click").forEach(el => {
  el.addEventListener("click", e => {
    const id = e.target.getAttribute("id");
            var divevento = document.getElementById('disp'+id);
            if(divevento.style.display=='none'){
                divevento.style.display='block';
            } else {
                divevento.style.display='none';
            }
  });
});
$(document).ready(function(){
    //Es para el formato de select multiple
    $("#id_usuario").multipleSelect({
        filter: true
    });

       
});
</script>
@endsection

