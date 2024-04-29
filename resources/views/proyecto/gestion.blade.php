@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Gestión de proyectos CSC
                </h2></div>
                <div class="card-body">
                @include('custom.message')

                    @php
                        $rep_sucu = 0;
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Cantidad de proyectos segun estado
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
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Terminados</th>
                                                        <th scope="row">{{ $cant_terminados }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">En progreso</th>
                                                        <th scope="row">{{ $cant_progreso }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">No iniciados</th>
                                                        <th scope="row">{{ $cant_noiniciados }}</th>
                                                    </tr>
                                                        
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Cantidad de proyectos por FY
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
                                                        <th scope="col">Año</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i <= $diff; $i++)
                                                    <tr></tr>
                                                        <th scope="row">{{ $FY[$i] }}</th>
                                                        <th scope="row">{{ $cant_FY[$i] }}</th>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_cantidad_evo"></div>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Horas de proyectos segun estado
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
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Terminados</th>
                                                        <th scope="row">{{ $hs_terminados }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">En progreso</th>
                                                        <th scope="row">{{ $hs_progreso }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">No iniciados</th>
                                                        <th scope="row">{{ $hs_noiniciados }}</th>
                                                    </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_horas"></div>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Horas de proyectos por FY
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
                                                        <th scope="col">Año</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i <= $diff; $i++)
                                                    <tr></tr>
                                                        <th scope="row">{{ $FY[$i] }}</th>
                                                        <th scope="row">{{ $hs_FY[$i] }}</th>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_hs_evo"></div>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Costo de proyectos segun estado
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
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Terminados</th>
                                                        <th scope="row">{{ $costo_terminados }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">En progreso</th>
                                                        <th scope="row">{{ $costo_progreso }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">No iniciados</th>
                                                        <th scope="row">{{ $costo_noiniciados }}</th>
                                                    </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_costo"></div>
                            </div>
                            <!-- Accordion wrapper -->  
                        </div>

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
                                            <i class="fas fa-angle-down rotate-icon"></i> Costo de proyectos por FY
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
                                                        <th scope="col">Año</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i <= $diff; $i++)
                                                    <tr></tr>
                                                        <th scope="row">{{ $FY[$i] }}</th>
                                                        <th scope="row">{{ $costo_FY[$i] }}</th>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_costo_evo"></div>
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
          /////////------ Cantidad de proyectos por estados-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Cantidad'],
            ['Terminados', {{ number_format($cant_terminados,0) }}],
            ['En progreso', {{ number_format($cant_progreso,0) }}],
            ['No iniciados', {{ number_format($cant_noiniciados,0) }}],
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
          var chart = new google.visualization.PieChart(document.getElementById('chart_cantidad'));
          chart.draw(data, options);

          /////////------ Horas de proyectos por estados-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Cantidad'],
            ['Terminados', {{ number_format($hs_terminados,0) }}],
            ['En progreso', {{ number_format($hs_progreso,0) }}],
            ['No iniciados', {{ number_format($hs_noiniciados,0) }}],
            ]);

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_horas'));
            chart.draw(data, options);


            /////////------ Costo de proyectos por estados-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Cantidad'],
            ['Terminados', {{ $costo_terminados }}],
            ['En progreso', {{ $costo_progreso }}],
            ['No iniciados', {{ $costo_noiniciados }}],
            ]);

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_costo'));
            chart.draw(data, options);



           /////////------ Evolucion de cantidad de proyectos-------////////
            var data = google.visualization.arrayToDataTable([
                ["Año", "Evolucion cantidad de proyectos"],
                @for ($i=0; $i <= $diff; $i++)
                    ['{{ $FY[$i] }}', {{ number_format($cant_FY[$i],0) }}],
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

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_cantidad_evo"));
              chart.draw(view, options);


              /////////------ Evolucion de horas de proyectos-------////////
            var data = google.visualization.arrayToDataTable([
                ["Año", "Evolucion horas de proyectos"],
                @for ($i=0; $i <= $diff; $i++)
                    ['{{ $FY[$i] }}', {{ number_format($hs_FY[$i],0) }}],
                @endfor
              ]);

              var view = new google.visualization.DataView(data);
              view.setColumns([0, 1,
                              { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" },
                              ]);

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_hs_evo"));
              chart.draw(view, options);


              /////////------ Evolucion de costos de proyectos-------////////
            var data = google.visualization.arrayToDataTable([
                ["Año", "Evolucion costos de proyectos"],
                @for ($i=0; $i <= $diff; $i++)
                    ['{{ $FY[$i] }}', {{ $costo_FY[$i] }}],
                @endfor
              ]);

              var view = new google.visualization.DataView(data);
              view.setColumns([0, 1,
                              { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" },
                              ]);

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_costo_evo"));
              chart.draw(view, options);


        }

</script>
@endsection