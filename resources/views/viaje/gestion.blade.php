@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Gestión viajes a campo compartidos
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
                    <a class="btn btn-secondary float-right" href="{{ route('viaje.gestion') }}">
                        <i class="fa fa-times"> </i>
                        {{ $busqueda }}
                    </a>
                @endif
                    <br>
                    <div class="row"></div>
                <br>
                
                    @php
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
                                <i class="fas fa-angle-down rotate-icon"></i> Ranking viajes compartidos por sucursal
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
          /////////------ GRAFICO PIE DE HS DE TRABAJO RALENTI Y TRANSPORTE-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_sucu; $i++)
                ['{{ $nombre_s[$i] }}', {{ number_format($cant_s[$i],0) }}],
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
        }

</script>
@endsection