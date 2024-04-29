@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Gestión de la información CSC
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
                    <a class="btn btn-secondary float-right" href="{{ route('detalle_ticket.index') }}">
                        <i class="fa fa-times"> </i>
                        {{ $busqueda }}
                    </a>
                @endif
                    <br>
                    <div class="row"></div>
                <br>
                
                    @php
                        $rep_serv = 0;
                        $rep_orga = 0;
                        $rep_sucu = 0;
                    @endphp
                    
                 <!--Accordion wrapper-->
                 <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingOne">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne" aria-expanded="false"
                            aria-controls="collapseOne">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Ranking Servicios CSC
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
                                            <th scope="col">Servicio</th>
                                            <th scope="col">Minutos</th>
                                            <th scope="col">Horas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($ranking_servicios as $ranking)
                                         <tr></tr>
                                            <th scope="row">{{ $ranking->nombre }}</th>
                                            <th scope="row">{{ $ranking->time }}</th>
                                            <th scope="row">{{ number_format($ranking->time / 60,1) }}</th>
                                            </tr>
                                            @php
                                                $nombre_s[$rep_serv] = $ranking->nombre;
                                                $time_s[$rep_serv] = $ranking->time;
                                                $rep_serv++;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <div id="chart_servicio"></div>
                </div>
                <!-- Accordion wrapper -->  

                 <!--Accordion wrapper-->
                 <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headinTwo">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo" aria-expanded="false"
                            aria-controls="collapseTwo">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Ranking Organizaciones
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
                                            <th scope="col">Organización</th>
                                            <th scope="col">Minutos</th>
                                            <th scope="col">Horas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($ranking_organizaciones as $ranking)
                                         <tr></tr>
                                            <th scope="row">{{ $ranking->NombOrga }}</th>
                                            <th scope="row">{{ $ranking->time }}</th>
                                            <th scope="row">{{ number_format($ranking->time / 60,1) }}</th>
                                            </tr>
                                            @php
                                                $nombre_o[$rep_orga] = $ranking->NombOrga;
                                                $time_o[$rep_orga] = $ranking->time;
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

                 <!--Accordion wrapper-->
                 <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headinThre">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseThre" aria-expanded="false"
                            aria-controls="collapseThre">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Ranking Sucursales
                            </h4>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseThre" class="collapse" role="tabpanel" aria-labelledby="headingThre"
                            data-parent="#accordionEx1">
                            <div class="card-body">
                                <div class="table-responsive-md">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Minutos</th>
                                            <th scope="col">Horas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($ranking_sucursales as $ranking)
                                         <tr></tr>
                                            <th scope="row">{{ $ranking->NombSucu }}</th>
                                            <th scope="row">{{ $ranking->time }}</th>
                                            <th scope="row">{{ number_format($ranking->time / 60,1) }}</th>
                                            </tr>
                                            @php
                                                $nombre_su[$rep_sucu] = $ranking->NombSucu;
                                                $time_su[$rep_sucu] = $ranking->time;
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

     /*   var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            ['Trabajando (hs)', 20],
            ['Ralenti (hs)', 10],
            ['Transporte (hs)', 10],
            ]);
*/
          /////////------ GRAFICO PIE DE HS DE TRABAJO RALENTI Y TRANSPORTE-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_serv; $i++)
                ['{{ $nombre_s[$i] }}', {{ $time_s[$i] }}],
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
          var chart = new google.visualization.PieChart(document.getElementById('chart_servicio'));
          chart.draw(data, options);

          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_orga; $i++)
                ['{{ $nombre_o[$i] }}', {{ number_format($time_o[$i],0) }}],
            @endfor
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#F39C12", "#D35400","#7F8C8D","#212F3D","#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_organizacion'));
          chart.draw(data, options);

          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_sucu; $i++)
                ['{{ $nombre_su[$i] }}', {{ $time_su[$i] }}],
            @endfor
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#16A085","#27AE60","#F1C40F","#F39C12", "#D35400","#7F8C8D","#212F3D","#C0392B","#8E44AD","#2980B9"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_sucursal'));
          chart.draw(data, options);
        }

</script>

@endsection