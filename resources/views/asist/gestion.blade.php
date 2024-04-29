@php
    use App\asist;
    use App\solucion;
    use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Estadisticas de asistencias
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                @if ($filtro=="")
                    <form class="form-inline float-right">
                        <div class="row">
                            <div class="input-group col-md-12">
                                <input class="form-control" type="date" name="fecha_inicio" value="{{ $desde }}">
                                <input class="form-control" type="date" name="fecha_fin" value="{{ $hasta }}">
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
                    <a class="btn btn-secondary float-right" href="{{ route('asist.gestion') }}">
                        <i class="fa fa-times"> </i>
                        {{ $busqueda }}
                    </a>
                @endif
                    <br>
                    <div class="row"></div>
                <br>
                
                    @php
                        $rep_sucu = 0;
                        $rep_orga = 0;
                        $rep_puesto = 0;
                        $rep_colab = 0;
                        $rep_estado = 0;
                        $rep_conteo = 0;
                        $rep_esta = 0;
                        $rep_sucursal = 0;
                    @endphp
                    <div class="row">
                        <div class="col-md-6">
                            <!--Accordion wrapper-->
                            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                                <!-- Accordion card -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingFive">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Estados de las asistencias
                                        </h4>
                                        </a>
                                    </div>
                                    <!-- Card body -->
                                    <div id="collapseFive" class="collapse" role="tabpanel" aria-labelledby="headingFive"
                                        data-parent="#accordionEx1">
                                        <div class="card-body">
                                            <div class="table-responsive-md">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Estados</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($ranking_estados as $ranking)
                                                    <tr></tr>
                                                        <th scope="row">{{ $ranking->EstaAsis }}</th>
                                                        <th scope="row">{{ $ranking->cantidad }}</th>
                                                        </tr>
                                                        @php
                                                            $nombre_e[$rep_estado] = $ranking->EstaAsis;
                                                            $cant_e[$rep_estado] = $ranking->cantidad;
                                                            $rep_estado++;
                                                        @endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_estado"></div>
                            </div>
                            <!-- Accordion wrapper -->  
                        </div>

                        <div class="col-md-6">
                            <!--Accordion wrapper-->
                            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                                <!-- Accordion card -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingEight">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseEight" aria-expanded="false"
                                        aria-controls="collapseEight">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Estados de asistencias por sucursal
                                        </h4>
                                        </a>
                                    </div>
                                    <!-- Card body -->
                                    <div id="collapseEight" class="collapse" role="tabpanel" aria-labelledby="headingEight"
                                        data-parent="#accordionEx1">
                                        <div class="card-body">
                                            <div class="table-responsive-md">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Sucursal</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($estados_sucursal as $estado_sucu)
                                                        <tr></tr>
                                                            <th scope="row">{{ $estado_sucu->NombSucu }} ({{ $estado_sucu->EstaAsis }})</th>
                                                            <th scope="row">{{ $estado_sucu->cantidad }}</th>
                                                            </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @foreach($sucursales as $sucursal)
                                                @foreach($estados as $estado)
                                                    @php
                                                        $cant = DB::table('asists')
                                                                            ->selectRaw('COUNT(asists.id) as cantidad')
                                                                            ->join('users','asists.id_user','=','users.id')
                                                                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                                                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                            ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59'],
                                                                                    ['asists.EstaAsis', $estado->EstaAsis], ['sucursals.NombSucu', $sucursal->NombSucu]])
                                                                            ->first();
                                                                            
                                                        $valor[$rep_sucursal][$rep_esta] = $cant->cantidad;
                                                        $rep_esta++;
                                                    @endphp
                                                @endforeach
                                                @php
                                                    $sucu_store[$rep_sucursal] = $sucursal->NombSucu;
                                                    $rep_sucursal++;
                                                    $rep_esta = 0;
                                                @endphp
                                            @endforeach
                                            @foreach($estados as $estado)
                                                @php
                                                    $state[$rep_esta] = $estado->EstaAsis;
                                                    $rep_esta++;
                                                @endphp
                                            @endforeach
                                          @php
                                            //dd($valor);
                                          @endphp
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_stack"></div>
                            </div>
                            <!-- Accordion wrapper -->  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!--Accordion wrapper-->
                            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                                <!-- Accordion card -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingSix">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Tiempo promedio de primera respuesta
                                        </h4>
                                        </a>
                                    </div>
                                    <!-- Card body -->
                                    <div id="collapseSix" class="collapse" role="tabpanel" aria-labelledby="headingSix"
                                        data-parent="#accordionEx1">
                                        <div class="card-body">
                                            <div class="table-responsive-md">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Sucursal</th>
                                                        <th scope="col">Tiempo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $c_sucursal = 0;
                                                        @endphp
                                                    @foreach ($sucursales_asistencia as $sucursal)
                                                    @php

                                                    $cont = 0;
                                                    $tiempo = 0;
                                                        $sucursales_asist = Asist::select('asists.id','asists.created_at')
                                                                                        ->join('users','asists.id_user','=','users.id')
                                                                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                                                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                                        ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59'], 
                                                                                                ['sucursals.NombSucu',$sucursal->NombSucu]])
                                                                                        ->get();

                                                        if($sucursales_asist->count() > 0){
                                                            foreach ($sucursales_asist as $asistencia) {
                                                                $solucion = Solucion::select('created_at','id')
                                                                                    ->where([['id_asist',$asistencia->id], ['id_user','<>','999']])
                                                                                    ->orderBy('solucions.created_at','ASC')
                                                                                    ->first();
                                                                if(isset($solucion)){
                                                                    $fecha_inicio = $asistencia->created_at;
                                                                    $fecha_fin = $solucion->created_at;  
                                                                                                                        
                                                                    $tiempo_respuesta = $fecha_inicio->diffInMinutes($fecha_fin);
                                                                    $cont++;
                                                                    $tiempo = $tiempo + $tiempo_respuesta;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @if($cont <> 0)
                                                        @php
                                                            $tiempo_promedio = $tiempo / $cont;
                                                        @endphp
                                                        
                                                        <tr></tr>
                                                            <th scope="row">{{ $sucursal->NombSucu }}</th>
                                                            <th scope="row">{{ $tiempo_promedio }}</th>
                                                            </tr>
                                                            @php
                                                                $nombre_tp[$c_sucursal] = $sucursal->NombSucu ;
                                                                $cant_tp[$c_sucursal] = $tiempo_promedio;
                                                                $c_sucursal++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_tiempos"></div>
                            </div>
                            <!-- Accordion wrapper -->  
                        </div>

                        <div class="col-md-6">
                            <!--Accordion wrapper-->
                            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                                <!-- Accordion card -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingSeven">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Tiempo de resolución de solicitud
                                        </h4>
                                        </a>
                                    </div>
                                    <!-- Card body -->
                                    <div id="collapseSeven" class="collapse" role="tabpanel" aria-labelledby="headingSeven"
                                        data-parent="#accordionEx1">
                                        <div class="card-body">
                                            <div class="table-responsive-md">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Sucursal</th>
                                                        <th scope="col">Tiempo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $c_sucursal_c = 0;
                                                        @endphp
                                                    @foreach ($sucursales_asistencia as $sucursal)
                                                    @php
                                                    
                                                    $cont = 0;
                                                    $tiempo = 0;
                                                        $sucursales_asist = Asist::select('asists.id','asists.created_at')
                                                                                        ->join('users','asists.id_user','=','users.id')
                                                                                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                                                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                                        ->where([['asists.created_at','>=',$desde.' 00:00:01'], ['asists.created_at','<=',$hasta.' 23:59:59'], 
                                                                                                ['sucursals.NombSucu',$sucursal->NombSucu]])
                                                                                        ->get();
                                                                                        
                                                        if($sucursales_asist->count() > 0){
                                                            foreach ($sucursales_asist as $asistencia) {
                                                                $asist_fin = Asist::select('FFinAsis','id')
                                                                                    ->where([['id',$asistencia->id], ['EstaAsis','LIKE','%finalizada%']])
                                                                                    ->first();
                                                                                   
                                                                if(isset($asist_fin)){
                                                                    $fecha_inicio = $asistencia->created_at;
                                                                    $fecha_fin = $asist_fin->FFinAsis;                                    
                                                                    $tiempo_finalizacion = $fecha_inicio->diffInMinutes($fecha_fin);
                                                                    $cont++;
                                                                    $tiempo = $tiempo + $tiempo_finalizacion;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @if($cont <> 0)
                                                        @php
                                                            $tiempo_promedio = $tiempo / $cont;
                                                        @endphp
                                                        
                                                        <tr></tr>
                                                            <th scope="row">{{ $sucursal->NombSucu }}</th>
                                                            <th scope="row">{{ $tiempo_promedio }}</th>
                                                            </tr>
                                                            @php
                                                                $nombre_tf[$c_sucursal_c] = $sucursal->NombSucu ;
                                                                $cant_tf[$c_sucursal_c] = $tiempo_promedio;
                                                                $c_sucursal_c++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_tiempo_fin"></div>
                            </div>
                            <!-- Accordion wrapper -->  
                        </div>
                    </div>

                <div class="row">
                    <div class="col-md-6">   
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <!-- Accordion card -->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingOne">
                                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne" aria-expanded="false"
                                    aria-controls="collapseOne">
                                    <h4 class="mb-0">
                                        <i class="fas fa-angle-down rotate-icon"></i> Sucursales con asistencias
                                    </h4>
                                    </a>
                                </div>
                                <!-- Card body -->
                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne"
                                    data-parent="#accordionEx1">
                                    <div class="card-body">
                                        <div class="table-responsive-md">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Sucursal</th>
                                                    <th scope="col">Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($ranking_sucursales as $ranking)
                                                <tr></tr>
                                                    <th scope="row">{{ $ranking->NombSucu }}</th>
                                                    <th scope="row">{{ $ranking->cantidad }}</th>
                                                    </tr>
                                                    @php
                                                        $nombre_s[$rep_sucu] = $ranking->NombSucu;
                                                        $cant_s[$rep_sucu] = $ranking->cantidad;
                                                        $rep_sucu++;
                                                    @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->
                            <div id="chart_sucursales"></div>
                        </div>
                        <!-- Accordion wrapper -->  
                    </div>

                    <div class="col-md-6">
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <!-- Accordion card -->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingTwo">
                                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    <h4 class="mb-0">
                                        <i class="fas fa-angle-down rotate-icon"></i> Organizaciones con asistencias
                                    </h4>
                                    </a>
                                </div>
                                <!-- Card body -->
                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo"
                                    data-parent="#accordionEx1">
                                    <div class="card-body">
                                        <div class="table-responsive-md">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Organiación</th>
                                                    <th scope="col">Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($ranking_organizaciones as $ranking)
                                                <tr></tr>
                                                    <th scope="row">{{ $ranking->NombOrga }}</th>
                                                    <th scope="row">{{ $ranking->cantidad }}</th>
                                                    </tr>
                                                    @php
                                                        $nombre_o[$rep_orga] = $ranking->NombOrga;
                                                        $cant_o[$rep_orga] = $ranking->cantidad;
                                                        $rep_orga++;
                                                    @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->
                            <div id="chart_organizaciones"></div>
                        </div>
                        <!-- Accordion wrapper -->  
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6">
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <!-- Accordion card -->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingThree">
                                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    <h4 class="mb-0">
                                        <i class="fas fa-angle-down rotate-icon"></i> Puesto de colaborador que responde asistencias
                                    </h4>
                                    </a>
                                </div>
                                <!-- Card body -->
                                <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree"
                                    data-parent="#accordionEx1">
                                    <div class="card-body">
                                        <div class="table-responsive-md">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Puesto colaborador</th>
                                                    <th scope="col">Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($ranking_puesto as $ranking)
                                                <tr></tr>
                                                    <th scope="row">{{ $ranking->NombPuEm }}</th>
                                                    <th scope="row">{{ $ranking->cantidad }}</th>
                                                    </tr>
                                                    @php
                                                        $nombre_p[$rep_puesto] = $ranking->NombPuEm;
                                                        $cant_p[$rep_puesto] = $ranking->cantidad;
                                                        $rep_puesto++;
                                                    @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->
                            <div id="chart_puestos"></div>
                        </div>
                        <!-- Accordion wrapper -->  
                    </div>

                    <div class="col-md-6">
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <!-- Accordion card -->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingFour">
                                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    <h4 class="mb-0">
                                        <i class="fas fa-angle-down rotate-icon"></i> Colaborador que responde asistencias
                                    </h4>
                                    </a>
                                </div>
                                <!-- Card body -->
                                <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour"
                                    data-parent="#accordionEx1">
                                    <div class="card-body">
                                        <div class="table-responsive-md">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Colaborador</th>
                                                    <th scope="col">Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($ranking_colaborador as $ranking)
                                                <tr></tr>
                                                    <th scope="row">{{ $ranking->name }} {{ $ranking->last_name }}</th>
                                                    <th scope="row">{{ $ranking->cantidad }}</th>
                                                    </tr>
                                                    @php
                                                        $nombre_c[$rep_colab] = $ranking->name.' '.$ranking->last_name;
                                                        $cant_c[$rep_colab] = $ranking->cantidad;
                                                        $rep_colab++;
                                                    @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->
                            <div id="chart_colaborador"></div>
                        </div>
                        <!-- Accordion wrapper -->  
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(window).resize(function(){
    drawChart();
    });

      google.charts.load("current", {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
          /////////------ GRAFICO PIE DE SUCURSALES-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_sucu; $i++)
                ['{{ $nombre_s[$i] }}', {{ $cant_s[$i] }}],
            @endfor
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F","#F39C12", "#D35400","#7F8C8D","#212F3D"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_sucursales'));
          chart.draw(data, options);



          /////////------ GRAFICO ORGANIZACIONES-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_orga; $i++)
                ['{{ $nombre_o[$i] }}', {{ $cant_o[$i] }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_organizaciones'));
          chart.draw(data, options);



          /////////------ GRAFICO PUESTOS-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_puesto; $i++)
                ['{{ $nombre_p[$i] }}', {{ $cant_p[$i] }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_puestos'));
          chart.draw(data, options);




          /////////------ GRAFICO COLABORADOR-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_colab; $i++)
                ['{{ $nombre_c[$i] }}', {{ $cant_c[$i] }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_colaborador'));
          chart.draw(data, options);


           /////////------ GRAFICO ESTADOS-------////////
           var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_estado; $i++)
                ['{{ $nombre_e[$i] }}', {{ $cant_e[$i] }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_estado'));
          chart.draw(data, options);



          /////////------ GRAFICO TIEMPOS DE RESPUESTA POR SUCURSAL-------////////
        var data = google.visualization.arrayToDataTable([
                ["Sucursal", "Tiempo de respuesta (minutos)"],
                @for ($i=0; $i < $c_sucursal; $i++)
                    ['{{ $nombre_tp[$i] }}', {{ $cant_tp[$i] }}],
                @endfor
              ]);

              var options = {
                height:'300',
                bar: {groupWidth: "45%"},
                chartArea:{top:20,bottom:30,width:"93%",height:"80%"},
                legend: {position: 'top', maxLines: 3},
                colors: ["#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F","#F39C12", "#D35400","#7F8C8D","#212F3D"],
                vAxis: {
                    minValue: 0
                },
                selectionMode: 'multiple',
                tooltip: {trigger: 'selection'},
                aggregationTarget: 'category',
              }

              var view = new google.visualization.DataView(data);
              view.setColumns([0, 1,
                              { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" },
                              ]);

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_tiempos"));
              chart.draw(view, options);

               /////////------ GRAFICO TIEMPOS DE RESPUESTA POR SUCURSAL-------////////
                var data = google.visualization.arrayToDataTable([
                        ["Sucursal", "Tiempo de finalización (minutos)"],
                        @for ($i=0; $i < $c_sucursal_c; $i++)
                            ['{{ $nombre_tf[$i] }}', {{ $cant_tf[$i] }}],
                        @endfor
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: "stringify",
                                    sourceColumn: 1,
                                    type: "string",
                                    role: "annotation" },
                                ]);

                var chart = new google.visualization.ColumnChart(document.getElementById("chart_tiempo_fin"));
                chart.draw(view, options);


                /////////------ GRAFICO CANTIDAD DE ESTADOS POR SUCURSAL-------////////
                var data = google.visualization.arrayToDataTable([
                    ['Genre', 
                    @for ($i=0; $i < $rep_esta; $i++)
                             '{{ $state[$i] }}',
                    @endfor
                    ],
                    @for ($x=0; $x < $rep_sucursal; $x++)
                    ['{{ $sucu_store[$x] }}',
                        @for ($z=0; $z < $rep_esta; $z++)
                                {{ $valor[$x][$z] }},
                        @endfor
                        ],
                    @endfor
                ]);

                var options = {
                    height: 300,
                    chartArea:{top:20,bottom:60,width:"93%",height:"80%"},
                    legend: { position: 'top', maxLines: 3 },
                    bar: { groupWidth: '75%' },
                    isStacked: true
                };

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_stack"));
              chart.draw(data, options);
        }

</script>
@endsection