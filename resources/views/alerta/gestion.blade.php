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
                <div class="card-header"><h2>Estadisticas de alertas
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
                    @endphp
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Alertas por severidad
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
                                                        <th scope="col">Severidad</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr></tr>
                                                        <th scope="row">Otro</th>
                                                        <th scope="row">{{ $otro }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Amarillas</th>
                                                        <th scope="row">{{ $amarillas }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Rojas</th>
                                                        <th scope="row">{{ $rojas }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Naranjas</th>
                                                        <th scope="row">{{ $naranjas }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Mantenimiento preventivo</th>
                                                        <th scope="row">{{ $mantenimientos }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Verde</th>
                                                        <th scope="row">{{ $verde }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Test</th>
                                                        <th scope="row">{{ $test }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Desconocido</th>
                                                        <th scope="row">{{ $desconocido }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Consult manufacturer</th>
                                                        <th scope="row">{{ $manufacture }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_severidad"></div>
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
                                                        @foreach($ranking_sucursales as $sucursal)
                                                        <tr></tr>
                                                        <th scope="row">{{ $sucursal->NombSucu }}</th>
                                                        <th scope="row">{{ $sucursal->cantidad }}</th>
                                                            </tr>
                                                            @php
                                                                $valor[$rep_sucu] = $sucursal->cantidad;
                                                                $sucu_store[$rep_sucu] = $sucursal->NombSucu;
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
                                <div id="chart_sucursal"></div>
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
                                    <div class="card-header" role="tab" id="headingThree">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Estados de asistencias por organización
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
                                                        <th scope="col">Organización</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($ranking_organizaciones as $organizacion)
                                                            <tr></tr>
                                                            <th scope="row">{{ $organizacion->NombOrga }}</th>
                                                            <th scope="row">{{ $organizacion->cantidad }}</th>
                                                                </tr>
                                                                @php
                                                                    $valor[$rep_orga] = $organizacion->cantidad;
                                                                    $organ[$rep_orga] = $organizacion->NombOrga;
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
                                <div id="chart_organizacion"></div>
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
                                        <a data-toggle="collapse" data-parent="#accordionRx" href="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Respuestas ante las alertas
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
                                                        <th scope="col">Tipo de respuesta a las alertas</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr></tr>
                                                        <th scope="row">Respuesta automática</th>
                                                        <th scope="row">{{ $respuesta_auto }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Respuesta del usuario</th>
                                                        <th scope="row">{{ $respuesta_user }}</th>
                                                        </tr>
                                                        <tr></tr>
                                                        <th scope="row">Sin responder</th>
                                                        <th scope="row">{{ $sin_respuesta }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_respuesta"></div>
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
                                    <div class="card-header" role="tab" id="headingFive">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Respuestas ante las alertas por sucursal
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
                                                        <th scope="col">Tipo de respuesta a las alertas</th>
                                                        <th scope="col">Sucursal</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($respuesta_user_sucu as $resp_user)
                                                            <tr></tr>
                                                            <th scope="row">Respondido por el concesionario</th>
                                                            <th scope="row">{{ $resp_user->NombSucu }}</th>
                                                            <th scope="row">{{ $resp_user->cantidad }}</th>
                                                            </tr>
                                                        @endforeach
                                                        @foreach($respuesta_auto_sucu as $resp_auto)
                                                            <tr></tr>
                                                            <th scope="row">Respondido automáticamente</th>
                                                            <th scope="row">{{ $resp_user->NombSucu }}</th>
                                                            <th scope="row">{{ $resp_auto->cantidad }}</th>
                                                            </tr>
                                                        @endforeach
                                                        @foreach($sin_respuesta_sucu as $sin_resp)
                                                            <tr></tr>
                                                            <th scope="row">Sin respuesta</th>
                                                            <th scope="row">{{ $sin_resp->NombSucu }}</th>
                                                            <th scope="row">{{ $sin_resp->cantidad }}</th>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_respuesta_sucu"></div>
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

          /////////------ GRAFICO PIE DE SEVERIDAD-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Severidad', 'Cantidad'],
            ['Otro', {{ $otro }}],
            ['Amarillas', {{ $amarillas }}],
            ['Rojas', {{ $rojas }}],
            ['Naranja', {{ $naranjas }}],
            ['Mantenimiento preventivo', {{ $mantenimientos }}],
            ['Verde', {{ $verde }}],
            ['Test', {{ $test }}],
            ['Desconocido', {{ $desconocido }}],
            ['Consult manufacturer', {{ $manufacture }}],
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ['#27251F',"#FFDE00","#e3342f","#f6993f","#6c757d",'#367C2B','#6cb2eb','#e1805b','#95b353'],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_severidad'));
          chart.draw(data, options);



           /////////------ GRAFICO PIE DE SUCURSALES-------////////
           var data = new google.visualization.arrayToDataTable([
            ['Sucursal', 'Cantidad'],
            @for ($i=0; $i < $rep_sucu; $i++)
                ['{{ $sucu_store[$i] }}', {{ $valor[$i] }}],
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
          var chart = new google.visualization.PieChart(document.getElementById('chart_sucursal'));
          chart.draw(data, options);


          /////////------ GRAFICO PIE DE ORGANIZACIONES-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Organizacion', 'Cantidad'],
            @for ($i=0; $i < $rep_orga; $i++)
                ['{{ $organ[$i] }}', {{ $valor[$i] }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_organizacion'));
          chart.draw(data, options);


          /////////------ GRAFICO PIE RESPUESTAS-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Severidad', 'Cantidad'],
            ['Respuestas automáticas', {{ $respuesta_auto }}],
            ['Respuestas del concesionario', {{ $respuesta_user }}],
            ['Sin respuestas', {{ $sin_respuesta }}],
            ]);

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_respuesta'));
            chart.draw(data, options);


            /////////------ GRAFICO CANTIDAD DE ESTADOS POR SUCURSAL-------////////
            var data = google.visualization.arrayToDataTable([
                    ['Genre', 'Respuesta del concesionario','Respuesta automática','Sin respuesta'],
                    @for ($x=0; $x < $rep_suc_nombre; $x++)
                        ['{{ $sucursal_nombre[$x] }}',
                        @php
                            $pico_u = 0;
                        @endphp
                        @foreach($respuesta_user_sucu as $resp_user)
                            @if ($resp_user->NombSucu == $sucursal_nombre[$x]) 
                            @php
                                $pico_u = 1;
                            @endphp
                                {{ $resp_user->cantidad }},
                            @endif
                        @endforeach
                        @if ($pico_u == 0) 
                            0,
                        @endif

                        @php
                            $pico_a = 0;
                        @endphp
                        @foreach($respuesta_auto_sucu as $resp_auto)
                            @if ($resp_auto->NombSucu == $sucursal_nombre[$x]) 
                            @php
                                $pico_a = 1;
                            @endphp
                                {{ $resp_auto->cantidad }},
                            @endif
                        @endforeach
                        @if ($pico_a == 0) 
                            0,
                        @endif

                        @php
                            $pico_s = 0;
                        @endphp
                        @foreach($sin_respuesta_sucu as $sin_resp)
                            @if ($sin_resp->NombSucu == $sucursal_nombre[$x]) 
                            @php
                                $pico_s = 1;
                            @endphp
                                {{ $sin_resp->cantidad }},
                            @endif
                        @endforeach
                        @if ($pico_s == 0) 
                            0,
                        @endif
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

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_respuesta_sucu"));
              chart.draw(data, options);
        }

</script>
@endsection