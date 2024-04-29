@php
    use App\interaccion;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Estadisticas de interacciones en la App
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
                    <a class="btn btn-secondary float-right" href="{{ route('interaccions.gestion') }}">
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
                        $rep_modulo = 0;
                        $rep_visitas = 0;
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Módulos más visitados
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
                                                        <th scope="col">Modulos</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($ranking_modulos as $ranking)
                                                    <tr></tr>
                                                        <th scope="row">{{ $ranking->modulo }}</th>
                                                        <th scope="row">{{ $ranking->cantidad }}</th>
                                                        </tr>
                                                        @php
                                                            $nombre_e[$rep_modulo] = $ranking->modulo;
                                                            $cant_e[$rep_modulo] = $ranking->cantidad;
                                                            $rep_modulo++;
                                                        @endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_modulo"></div>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Visitas por día
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
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Cantidad visitas clientes</th>
                                                        <th scope="col">Cantidad visitas SALA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i < $cantidadDias; $i++)
                                                    <tr></tr>
                                                        <th scope="row">{{ $fecha_array[$i] }}</th>
                                                        <th scope="row">{{ $visitas[$i] }}</th>
                                                        <th scope="row">{{ $visitas_conce[$i] }}</th>
                                                        </tr>
                                                        @php
                                                            $nombre_v[$rep_visitas] = $fecha_array[$i];
                                                            $cant_v[$rep_visitas] = $visitas[$i];
                                                            $cant_vc[$rep_visitas] = $visitas_conce[$i];
                                                            $rep_visitas++;
                                                        @endphp
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_visitas"></div>
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
                                        <i class="fas fa-angle-down rotate-icon"></i> Visitas por sucursal
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
                                        <i class="fas fa-angle-down rotate-icon"></i> Visitas por organización
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
                                        <i class="fas fa-angle-down rotate-icon"></i> Visitas por tipo de usuario
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
                                        <i class="fas fa-angle-down rotate-icon"></i> Visitas por usuario
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


           /////////------ GRAFICO MODULOS-------////////
           var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_modulo; $i++)
                ['{{ $nombre_e[$i] }}', {{ $cant_e[$i] }}],
            @endfor
            ]);

            // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_modulo'));
          chart.draw(data, options);



                //GRAFICO DE VISITAS POR DIA
                var data = google.visualization.arrayToDataTable([
                  ['Dia', 'Usuarios clientes', 'Usuarios SALA'],
                  @for ($i=0; $i < $rep_visitas; $i++)
                    ['{{date('d/m/Y',strtotime($nombre_v[$i]))}}', {{ $cant_v[$i] }}, {{ $cant_vc[$i] }}],
                  @endfor
                ]);

                var options = {
                  height:'300',
                  chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
                  legend: {position: 'top', maxLines: 3},
                  colors: ["#C0392B","#8E44AD"],
                  selectionMode: 'multiple',
                  tooltip: {trigger: 'selection'},
                  aggregationTarget: 'category',
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_visitas'));
                chart.draw(data, options);



            


        
        }

</script>
@endsection