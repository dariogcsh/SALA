@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Gestión paquetes de mantenimiento
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
                    <a class="btn btn-secondary float-right" href="{{ route('man_maq.gestion') }}">
                        <i class="fa fa-times"> </i>
                        {{ $busqueda }}
                    </a>
                @endif
                    <br>
                    <div class="row"></div>
                <br>
                
                    @php
                        $rep_sucu = 0;
                        $rep_esta = 0;
                        $rep_tipo = 0;
                        $rep_modelo = 0;
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Paquetes de mantenimiento por sucursal
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Paquetes de mantenimiento por estado
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
                                                        <th scope="col">Sucursal</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($cant_estados as $c_estado)
                                                    <tr></tr>
                                                        <th scope="row">{{ $c_estado->estado }}</th>
                                                        <th scope="row">{{ $c_estado->cantidad }}</th>
                                                        </tr>
                                                        @php
                                                            $nombre_e[$rep_esta] = $c_estado->estado;
                                                            $cant_e[$rep_esta] = $c_estado->cantidad;
                                                            $rep_esta++;
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Paquetes de mantenimiento por tipo
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
                                                        <th scope="col">Tipo</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($cant_tipos as $tipos)
                                                    <tr></tr>
                                                        <th scope="row">{{ $tipos->TipoMaq }}</th>
                                                        <th scope="row">{{ $tipos->cantidad }}</th>
                                                        </tr>
                                                        @php
                                                            $nombre_t[$rep_tipo] = $tipos->TipoMaq;
                                                            $cant_t[$rep_tipo] = $tipos->cantidad;
                                                            $rep_tipo++;
                                                        @endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_tipo"></div>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Paquetes de mantenimiento por modelo
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
                                                        <th scope="col">Modelos</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($cant_modelos as $modelo)
                                                    <tr></tr>
                                                        <th scope="row">{{ $modelo->ModeMaq }}</th>
                                                        <th scope="row">{{ $modelo->cantidad }}</th>
                                                        </tr>
                                                        @php
                                                            $nombre_m[$rep_modelo] = $modelo->ModeMaq;
                                                            $cant_m[$rep_modelo] = $modelo->cantidad;
                                                            $rep_modelo++;
                                                        @endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_modelo"></div>
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
          /////////------ GRAFICO PIE DE HS DE TRABAJO RALENTI Y TRANSPORTE-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Sucursales', 'Horas'],
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



          //////---ESTADOS----////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_esta; $i++)
                ['{{ $nombre_e[$i] }}', {{ number_format($cant_e[$i],0) }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_estado'));
          chart.draw(data, options);

          //////---TIPOS----////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_tipo; $i++)
                ['{{ $nombre_t[$i] }}', {{ number_format($cant_t[$i],0) }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_tipo'));
          chart.draw(data, options);

          //////---MODELOS----////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_modelo; $i++)
                ['{{ $nombre_m[$i] }}', {{ number_format($cant_m[$i],0) }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_modelo'));
          chart.draw(data, options);
        }

</script>
@endsection