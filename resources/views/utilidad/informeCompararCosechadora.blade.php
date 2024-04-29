@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Informe de eficiencia de máquina - Sala Hnos') }}
                    <button class="btn btn-success float-right" onclick="printDiv()" >
                        <i class="fa fa-download"></i></button>
                </div>
                <div class="card-body" id="imprimirPDF">
                    
                  <div class="divleft">
                    <h2><b>{{ $datosmaq->NombOrga }}</b></h2>
                  </div>
                  <div class="divright">
                    <h4>CULTIVO - {{ ucfirst($cultivo) }}</h4>
                  </div>
                  <br>
                  <hr>
                  <br>
                  <div class="row">
                        @for ($i = 0; $i <= $cantidad; $i++)
                            <div class="col-md-4 divleft">
                                <h4>{{ $maq[$i]->nombre }}</h4>
                                <hr>
                                <img src="{{ '/imagenes/'. $maq[$i]->TipoMaq. '.png'}}" alt="" height="110px" align="left">
                                <p align="right">{{ $maq[$i]->NumSMaq }}</p>
                                <p align="right">{{ $maq[$i]->ModeMaq }}</p>
                                <p align="right">Horas de motor: {{ $maq[$i]->horas }} hs.</p>
                            </div>
                        @endfor
                    </div>
                    <br>
                    <div class="row"><h5><b><u>Fecha de informe: </u></b> </h5> _ {{ date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}</div>
                    <br>
                        <div class="table-responsive-md">
                            <table class="table table-hover">
                            
                                <thead>
                                    <tr>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">N° de serie</th>
                                    <th scope="col">Hs Trilla</th>
                                    <th scope="col">Superficie cosechada por hora</th>
                                    <th scope="col">Consumo de combustible por hectárea</th>
                                    <th scope="col">Ralentí</th>
                                    <th scope="col">Virajes con cabecero engranado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @for ($i=0; $i <= $cantidad; $i++)
                                        <tr>
                                        <th scope="row">{{ $maq[$i]->ModeMaq }}</th>
                                        <th scope="row">{{ $maq[$i]->nombre }}</th>
                                        <th scope="row">{{ $maq[$i]->NumSMaq }}</th>
                                        <th scope="row">{{ number_format($diftrilla[$i],0) }} hs</th>
                                        <th scope="row">{{ number_format($superficie[$i],1) }} has</th>
                                        <th scope="row">{{ number_format($consumo[$i],1) }} lts</th>
                                        <th scope="row">{{ number_format($ralenti[$i],1) }} %</th>
                                        <th scope="row">{{ number_format($separadordevirajes[$i],1) }} %</th>
                                        </tr>
                                  
                                @endfor
                                </tbody>
                                </table>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Superficie cosechada por hora (Has)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la cantidad de hectáreas que realiza la máquina por cada hora de trabajo. Para mejorar este indicador se debe analizar la velocidad de trabajo, junto con el factor de carga de motor y variables de terreno y cultivo que limiten el incremento de velocidad.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_superficie"></div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Consumo de combustible por hectárea (Lts)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al consumo de combustible (en litros) por cada hectárea trabajada. Para mejorar este indicador se debe analizar la superficie cosechada por hora junto a la velocidad de trabajo y el factor de carga de motor además variables de terreno y cultivo que limiten el incremento de velocidad.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_consumo"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Velocidad (km/h)</h3>
                                    <br>
                                    <div id="chart_velocidad"></div>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Factor de carga del motor (%)</h3>
                                    <br>
                                    <div id="chart_cargamotor"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Ralenti (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al porcentaje de tiempo que está la máquina en marcha sin realizar ningun trabajo. Para mejorar este indicador se debe analizar los tiempos de marcha inproductivos tanto con tolva llena como con tolva vacia, si tiene que esperar mucho tiempo hasta que llegue la tolva, si se pone en marcha para calentar el motor, tiempos de limpieza, etc..')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_ralenti"></div>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Ralenti con tolva llena (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al porcentaje de tiempo que está la máquina en marcha sin realizar ningun trabajo y con la tolva llena. Para mejorar este indicador se tienen que analizar los tiempos inproductivos de máquina en marcha y tolva llena como ser cuando la máquina espera a la tolva para descargar o analizar la logística de trabajo en el lote.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_ralentillena"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Ralenti con tolva vacia (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al porcentaje de tiempo que está la máquina en marcha sin realizar ningun trabajo y con la tolva vacía. Para mejorar este indicador se deben analizar los tiempos que se encuentra en marcha inproductivos como ser tiempos de calentamiento, limpieza, reparación, mantenimiento, etc.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_ralentivacia"></div>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Separador de virajes con cabecero engranado (%)</h3>
                                     <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                     <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al tiempo en que la plataforma o cabezal se encuentra embrallada y no ingrsando cultivo (como por ejemplo el giro en la cabecera). Para mejorar este indicador se deben analizar los factores de apertura de melgas, formato del lote, etc.')" title="Detalle" height="30px" alt="">
                                      </div>
                                     </div>
                                     <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_separadordevirajes"></div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            
                            <div class="row justify-content-center"><h2><u>Utilización de tecnología</u></h2></div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Autotrac (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la utilización del piloto automático AutoTrac.')" title="Autotrac" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_autotrac"></div>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Velocidad autom. de molinete (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la utilización de velocidad de molinete de forma automática.')" title="Velocidad del molinete" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_velmolinete"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">HarvestSmart (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la automatización de velocidad de cosecha según la cantidad de cultivo que ingrese a la máquina le va a permitir incrementar o reducir la velocidad.')" title="Harvest Smart" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_harvest"></div>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Altura automática de la plataforma (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la regulación de la altura de la plataforma de manera automática segun lo establecido o configurado por el operario.')" title="Altura automática de plataforma" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_alturaplataforma"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Mantener automáticamente (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-12" align="right" style="padding-right:5%">
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la automatización de la máquina en ser S700 con ProDrive donde la máquina regula el espaciado de trilla en rotor, apertura de zaranda y zarandón y velocidad de viento (cada 3 minutos) para mantener la calidad de grano que el operario definió como óptimo.')" title="Harvest Smart" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_mantenerauto"></div>
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

        function printDiv() {
            document.getElementById('imprimirPDF').style.width='1500px';
            window.print();
            //window.cardova.plugins.printer.print('<h1> Prueba PDF </h>');
            document.getElementById('imprimirPDF').style.width='auto';
        }

      function drawChart() {
          //Definimos variable leyenda
        var leyenda = ["Velocidad", "{{ $maq[0]->nombre }}",
           @if (!empty($maq[1]))
            "{{ $maq[1]->nombre}}", 
           @endif
           @if (!empty($maq[2]))
            "{{ $maq[2]->nombre}}", 
           @endif
           @if (!empty($maq[3]))
            "{{ $maq[3]->nombre}}", 
           @endif
           @if (!empty($maq[4]))
            "{{ $maq[4]->nombre}}", 
           @endif
           @if (!empty($maq[5]))
            "{{ $maq[5]->nombre}}", 
           @endif
           @if (!empty($maq[6]))
            "{{ $maq[6]->nombre}}", 
           @endif
            ];

        var columnas = [0, 1,
                        { calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation" },
                          @if (!empty($maq[1]))
                            2,
                            { calc: "stringify",
                            sourceColumn: 2,
                            type: "string",
                            role: "annotation" },
                          @endif
                          @if (!empty($maq[2]))
                            3,
                            { calc: "stringify",
                            sourceColumn: 3,
                            type: "string",
                            role: "annotation" },
                          @endif
                          @if (!empty($maq[3]))
                            4,
                            { calc: "stringify",
                            sourceColumn: 4,
                            type: "string",
                            role: "annotation" },
                          @endif
                          @if (!empty($maq[4]))
                            5,
                            { calc: "stringify",
                            sourceColumn: 5,
                            type: "string",
                            role: "annotation" },
                          @endif
                          @if (!empty($maq[5]))
                            6,
                            { calc: "stringify",
                            sourceColumn: 6,
                            type: "string",
                            role: "annotation" },
                          @endif
                          @if (!empty($maq[6]))
                            7,
                            { calc: "stringify",
                            sourceColumn: 7,
                            type: "string",
                            role: "annotation" },
                          @endif];

          /////////------ SUPERFICIE COSECHADA POR HORA-------////////
          var data = google.visualization.arrayToDataTable([leyenda,
            ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($superficie[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($superficie[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($superficie[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($superficie[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($superficie[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($superficie[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($superficie[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

          var options = {
          
          backgroundColor: { fill:'transparent' },
          chartArea:{top:20,bottom:40,width:"93%",height:"80%"},
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "90%"},
          vAxis: {
              minValue: 0
            },
        colors: ["#367C2B","#FFDE00","#27251F","#3490dc","#f6993f","#e3342f","#6c757d"],
        selectionMode: 'multiple',
        tooltip: {trigger: 'selection'},
                  
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_superficie"));
        chart.draw(view, options);


        /////////------ CONSUMO DE COMBUSTIBLE POR HECTAREA-------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($consumo[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($consumo[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($consumo[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($consumo[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($consumo[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($consumo[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($consumo[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_consumo"));
        chart.draw(view, options);


          /////////------ VELOCIDAD-------////////
        var data = google.visualization.arrayToDataTable([leyenda,
            ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($velocidad[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($velocidad[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($velocidad[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($velocidad[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($velocidad[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($velocidad[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($velocidad[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_velocidad"));
        chart.draw(view, options);


          /////////------ FACTOR DE CARGA DEL MOTOR-------////////
          var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($factordecarga[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($factordecarga[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($factordecarga[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($factordecarga[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($factordecarga[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($factordecarga[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($factordecarga[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_cargamotor"));
        chart.draw(view, options);


        /////////------ RALENTI-------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($ralenti[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($ralenti[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($ralenti[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($ralenti[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($ralenti[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($ralenti[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($ralenti[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_ralenti"));
        chart.draw(view, options);


        /////////------ RALENTI CON TOLVA LLENA-------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($ralentillena[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($ralentillena[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($ralentillena[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($ralentillena[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($ralentillena[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($ralentillena[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($ralentillena[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_ralentillena"));
        chart.draw(view, options);

        /////////------ RALENTI CON TOLVA VACIA-------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($ralentivacia[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($ralentivacia[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($ralentivacia[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($ralentivacia[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($ralentivacia[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($ralentivacia[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($ralentivacia[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_ralentivacia"));
        chart.draw(view, options);


        /////////------ SEPARADOR DE VIRAJES CON CABECERO ENGRANADO------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($separadordevirajes[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($separadordevirajes[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($separadordevirajes[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($separadordevirajes[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($separadordevirajes[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($separadordevirajes[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($separadordevirajes[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_separadordevirajes"));
        chart.draw(view, options);


        /////////------ AUTOTRAC------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($autotrac[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($autotrac[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($autotrac[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($autotrac[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($autotrac[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($autotrac[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($autotrac[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_autotrac"));
        chart.draw(view, options);


        /////////------ VELOCIDAD AUTOMATICA DEL MOLINETE------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($velmolinete[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($velmolinete[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($velmolinete[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($velmolinete[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($velmolinete[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($velmolinete[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($velmolinete[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_velmolinete"));
        chart.draw(view, options);


        /////////------ HARVEST SMART------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($harvest[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($harvest[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($harvest[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($harvest[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($harvest[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($harvest[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($harvest[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_harvest"));
        chart.draw(view, options);


        /////////------ ALTURA AUTOMATICA DE PLATAFORMA------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($alturaplataforma[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($alturaplataforma[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($alturaplataforma[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($alturaplataforma[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($alturaplataforma[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($alturaplataforma[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($alturaplataforma[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_alturaplataforma"));
        chart.draw(view, options);


        /////////------ MANTENER AUTOMÁTICAMENTE------////////
        var data = google.visualization.arrayToDataTable([leyenda,
        ['{{date('d/m/Y',strtotime($finicio))}} - {{date('d/m/Y',strtotime($ffin))}}',
            @if (!empty($maq[0]))
                {{ number_format($mantenerauto[0],1) }},
            @endif
            @if (!empty($maq[1]))
                {{ number_format($mantenerauto[1],1) }},
            @endif
            @if (!empty($maq[2]))
                {{ number_format($mantenerauto[2],1) }},
            @endif
            @if (!empty($maq[3]))
                {{ number_format($mantenerauto[3],1) }},
            @endif
            @if (!empty($maq[4]))
                {{ number_format($mantenerauto[4],1) }},
            @endif
            @if (!empty($maq[5]))
                {{ number_format($mantenerauto[5],1) }},
            @endif
            @if (!empty($maq[6]))
                {{ number_format($mantenerauto[6],1) }},
            @endif
            ],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns(columnas);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_mantenerauto"));
        chart.draw(view, options);
    }

  </script>

@endsection
