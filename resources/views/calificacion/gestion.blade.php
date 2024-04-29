@php
    use App\activacion;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Estadisticas de calificaciones de asistencias
                </h2></div>
                <div class="card-body">
                @include('custom.message')

                @php
                    $rep_esta = 0;
                    $renovacion = 0;
                    $renov_cant = 0;
                    $rep_tipo_senal = 0;
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Cantidad de calificaciones
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
                                                        <th scope="col">Año</th>
                                                        <th scope="col">Cantidad de calificaciones</th>
                                                        <th scope="col">Cantidad de asistencias finalizadas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i <= $diff; $i++)
                                                    <tr></tr>
                                                        <th scope="row">{{ $FY[$i] }}</th>
                                                        <th scope="row">{{ $calificaciones_cant[$i] }}</th>
                                                        <th scope="row">{{ $asistencias_cant[$i] }}</th>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_cantidad"></div>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Cantidad de calificaciones por mes y año fiscal
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
                                                        <th scope="col">Año fiscal y mes</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i <= $diff; $i++)
                                                        @for($x = 0; $x < 12; $x++)
                                                            <tr></tr>
                                                                <th scope="row">FY{{ $FY[$i] }} {{ $mes_nombre[$x] }}</th>
                                                                <th scope="row">{{ $calificacion_mes[$i][$x] }}</th>
                                                            </tr>
                                                        @endfor
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_mes"></div>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Promedio de puntaje obtenido de 1 a 5
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
                                                        <th scope="col">Año</th>
                                                        <th scope="col">US$</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i <= $diff; $i++)
                                                    <tr></tr>
                                                        <th scope="row">{{ $FY[$i] }}</th>
                                                        <th scope="row">{{ number_format($puntos_prom[$i],0) }}</th>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_puntos_prom"></div>
                            </div>
                            <!-- Accordion wrapper -->  
                        </div>

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
                                            <i class="fas fa-angle-down rotate-icon"></i> Puntaje obtenido por mes y año fiscal de 1 a 5
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
                                                        <th scope="col">Año fiscal</th>
                                                        <th scope="col">US$</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i <= $diff; $i++)
                                                        @for($x = 0; $x < 12; $x++)
                                                        <tr></tr>
                                                            <th scope="row">{{ $FY[$i] }}</th>
                                                            <th scope="row">{{ number_format($puntos_mes[$i][$x],0) }}</th>
                                                            </tr>
                                                        @endfor
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_mes_puntos"></div>
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


          /////////------ GRAFICO CANTIDAD DE ALQUILERES DE SEÑAL-------////////
        var data = google.visualization.arrayToDataTable([
                ["Sucursal", "Cantidad de calificaciones", 'Cantidad de asistencias'],
                @for ($i=0; $i <= $diff; $i++)
                    ['{{ $FY[$i] }}', {{ number_format($calificaciones_cant[$i],0) }}, {{ number_format($asistencias_cant[$i],0) }}],
                @endfor
              ]);

              var options = {
                height:'300',
                bar: {groupWidth: "45%"},
                chartArea:{top:20,bottom:30,width:"93%",height:"80%"},
                legend: {position: 'top', maxLines: 3},
                colors: ['#FFDE00',"#367C2B"],
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
                2,
                { calc: "stringify",
                  sourceColumn: 2,
                  type: "string",
                  role: "annotation" }
                ]);

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_cantidad"));
              chart.draw(view, options);


///////////////// ---------- DOLARES DE ALQUILERES DE SEÑAL---------- ///////////////
              var data = google.visualization.arrayToDataTable([
                ["Sucursal", "Puntos promedio"],
                @for ($i=0; $i <= $diff; $i++)
                    ['{{ $FY[$i] }}', {{ number_format($puntos_prom[$i],1) }}],
                @endfor
              ]);

              var options = {
                height:'300',
                bar: {groupWidth: "45%"},
                chartArea:{top:20,bottom:30,width:"93%",height:"80%"},
                legend: {position: 'top', maxLines: 3},
                colors: ["#367C2B"],
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

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_puntos_prom"));
              chart.draw(view, options);
    

            //GRAFICO DE CANTIDADES DE ALQUILERES DE SEÑAL POR MES Y AÑO
            var data = google.visualization.arrayToDataTable([
                  ['Year',
                @for ($i=0; $i <= $diff; $i++)
                        '{{$FY[$i]}}',
                @endfor
                    ],
                  @for ($i=0; $i < 12; $i++)
                    ['{{$mes_nombre[$i]}}',
                    @for ($x=0; $x <= $diff; $x++)
                        {{ $calificacion_mes[$x][$i] }},
                    @endfor
                    ],
                  @endfor
                ]);

                var options = {
                  backgroundColor: { fill:'transparent' },
                  height:'300',
                  chartArea:{top:20,bottom:50,width:"93%",height:"80%"},
                  legend: {position: 'top', maxLines: 3},
                  colors: ["#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F","#F39C12", "#D35400","#7F8C8D","#212F3D"],
                  selectionMode: 'multiple',
                  tooltip: {trigger: 'selection'},
                  aggregationTarget: 'category',
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_mes'));
                chart.draw(data, options);


                //GRAFICO DE USD DE ALQUILERES DE SEÑAL POR MES Y AÑO
                var data = google.visualization.arrayToDataTable([
                  ['Year',
                @for ($i=0; $i <= $diff; $i++)
                        '{{$FY[$i]}}',
                @endfor
                    ],
                  @for ($i=0; $i < 12; $i++)
                    ['{{$mes_nombre[$i]}}',
                    @for ($x=0; $x <= $diff; $x++)
                        {{ $puntos_mes[$x][$i] }},
                    @endfor
                    ],
                  @endfor
                ]);

                var chart = new google.visualization.AreaChart(document.getElementById('chart_mes_puntos'));
                chart.draw(data, options);

            }
</script>
@endsection