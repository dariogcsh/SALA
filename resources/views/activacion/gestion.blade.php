@php
    use App\activacion;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Estadisticas de activaciones y suscripciones
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Cantidad de activaciones/suscripciones de señal
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
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0; $i <= $diff; $i++)
                                                    <tr></tr>
                                                        <th scope="row">{{ $FY[$i] }}</th>
                                                        <th scope="row">{{ $alquileres_cant[$i] }}</th>
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
                                    <div class="card-header" role="tab" id="headingOne">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> USD de activaciones/suscripciones de señal
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
                                                        <th scope="row">{{ number_format($alquileres_usd[$i],0) }}</th>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_usd"></div>
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
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Cantidad de activaciones/suscripciones por mes y año fiscal
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
                                                                <th scope="row">{{ $alquiler_mes[$i][$x] }}</th>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> USD de activaciones/suscripciones por mes y año fiscal
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
                                                            <th scope="row">{{ number_format($alquiler_mes_usd[$i][$x],0) }}</th>
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
                                <div id="chart_mes_usd"></div>
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
                                    <div class="card-header" role="tab" id="headingSeven">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        <h4 class="mb-0">
                                            <i class="fas fa-angle-down rotate-icon"></i> Duracion de activaciones/suscripciones de señal
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
                                                        <th scope="col">Tipo de alquiler FY {{ $año_FY }}</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($tipos_senal as $tipo)
                                                        <tr></tr>
                                                            <th scope="row">{{ $tipo->duracion }} año</th>
                                                            <th scope="row">{{ $tipo->cantidad }}</th>
                                                            </tr>
                                                            @php
                                                                $nombre_ts[$rep_tipo_senal] = $tipo->duracion.' año';
                                                                $cant_ts[$rep_tipo_senal] = $tipo->cantidad;
                                                                $rep_tipo_senal++;
                                                            @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_tipo_senal"></div>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Estados de activaciones/suscripciones
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
                                                        <th scope="col">Estado FY {{ $año_FY }}</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($senal_estados as $estado)
                                                        <tr></tr>
                                                            <th scope="row">{{ $estado->estado }}</th>
                                                            <th scope="row">{{ $estado->cantidad }}</th>
                                                            </tr>
                                                            @php
                                                                $nombre_e[$rep_esta] = $estado->estado;
                                                                $cant_e[$rep_esta] = $estado->cantidad;
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
                    <br>
                    
                    @if ($filtro=="NO")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="año_fiscal" id="año_fiscal">
                                        @for($i = 1; $i <= $diff; $i++)
                                            @if($FY[$i] == $año)
                                                <option value="{{ $FY[$i] }}" selected>{{ $FY[$i] }}</option>
                                            @else
                                                <option value="{{ $FY[$i] }}">{{ $FY[$i] }}</option>
                                            @endif
                                        @endfor
                                    </select>
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
                        <a class="btn btn-secondary float-right" href="{{ route('activacion.gestion') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                <br>
                <br>
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
                                            <i class="fas fa-angle-down rotate-icon"></i> Renovación de activaciones/suscripciones
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
                                                        <th scope="col">Tipo</th>
                                                        <th scope="col">Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($alquileres_FY_pasado as $alquiler_FY_pasado)
                                                            @php
                                                                $renovacion = Activacion::where([['created_at','>',$año_FY_pasado.'-10-31 23:59:59'], 
                                                                                            ['created_at','<',$año_FY.'-11-01 00:00:01'],
                                                                                            ['estado','<>','Cancelado'],
                                                                                            ['nserie',$alquiler_FY_pasado->nserie]])->count();
                                                                if ($renovacion > 0) {
                                                                    $renov_cant = $renov_cant + 1;
                                                                }
                                                            @endphp
                                                        @endforeach
                                                        <tr></tr>
                                                            <th scope="col">Activaciones/suscripciones FY {{ $año_FY_pasado }}</th>
                                                            <th scope="row">{{ $cantidad_alquileres_FY_pasado - $renov_cant }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col">Renovaciones FY {{ $año_FY }}</th>
                                                            <th scope="row">{{ $renov_cant }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->
                                <div id="chart_renovacion"></div>
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
                ["Sucursal", "Cantidad de alquileres"],
                @for ($i=0; $i <= $diff; $i++)
                    ['{{ $FY[$i] }}', {{ number_format($alquileres_cant[$i],0) }}],
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

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_cantidad"));
              chart.draw(view, options);


///////////////// ---------- DOLARES DE ALQUILERES DE SEÑAL---------- ///////////////
              var data = google.visualization.arrayToDataTable([
                ["Sucursal", "USD de alquileres de señal"],
                @for ($i=0; $i <= $diff; $i++)
                    ['{{ $FY[$i] }}', {{ $alquileres_usd[$i] }}],
                @endfor
              ]);

              var view = new google.visualization.DataView(data);
              view.setColumns([0, 1,
                              { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" },
                              ]);

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_usd"));
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
                        {{ $alquiler_mes[$x][$i] }},
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
                        {{ $alquiler_mes_usd[$x][$i] }},
                    @endfor
                    ],
                  @endfor
                ]);

                var chart = new google.visualization.AreaChart(document.getElementById('chart_mes_usd'));
                chart.draw(data, options);


                  /////////------ GRAFICO TIPOS DE ALQUILERES-------////////
                var data = new google.visualization.arrayToDataTable([
                ['Tipo', 'Cantidad'],
                @for ($i=0; $i < $rep_tipo_senal; $i++)
                    ['{{ $nombre_ts[$i] }}', {{ $cant_ts[$i] }}],
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
                var chart = new google.visualization.PieChart(document.getElementById('chart_tipo_senal'));
                chart.draw(data, options);


                /////////------ GRAFICO ESTADOS-------////////
                var data = new google.visualization.arrayToDataTable([
                ['Estado', 'Horas'],
                @for ($i=0; $i < $rep_esta; $i++)
                    ['{{ $nombre_e[$i] }}', {{ $cant_e[$i] }}],
                @endfor
                ]);

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('chart_estado'));
                chart.draw(data, options);



                 /////////------ GRAFICO RENOVACIÓN-------////////
                 var data = new google.visualization.arrayToDataTable([
                ['Renovacion', 'Cantidad'],
                ['Renovación', {{ $renov_cant }}],
                ['Alquileres FY pasado', {{ $cantidad_alquileres_FY_pasado - $renov_cant }}],
                ]);

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('chart_renovacion'));
                chart.draw(data, options);


            }
</script>
@endsection