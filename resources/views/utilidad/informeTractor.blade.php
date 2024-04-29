@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Informe de eficiencia de tractor - Sala Hnos') }}
                  <button class="btn btn-success float-right" onclick="printDiv()" >
                    <i class="fa fa-download"></i></button>
                </div>
                <div class="card-body" id="imprimirPDF">
                  <div class="divleft">
                    <h2><b>{{ $datosmaq->NombOrga }}</b></h2>
                  </div>
                  <br>
                  <hr>
                  <br>
                  <div>
                    <div class="col-md-6 divleft">
                      <h4>{{ $maquina->TipoMaq }}</h4>
                      <hr>
                      <img src="{{ '/imagenes/'. $maquina->TipoMaq. '.png'}}" alt="" height="110px" align="left">
                      <p align="right">{{ $maquina->nombre }}</p>
                      <p align="right">{{ $maquina->ModeMaq }}</p>
                      <p align="right">{{ $maquina->NumSMaq }}</p>
                      <hr>
                      <br>
                      <h4>TEMPERATURAS</h4>
                      <hr>
                      <div id="chart_temperaturas"></div>
                      <div class="row justify-content-center">
                        <div class="col-sm-4"><b>Max. aceite:</b> {{ date('d/m/Y',strtotime($diahidraulicomax->FecIUtil)) }}</div> 
                        <div class="col-sm-4"><b>Max. refrig:</b> {{ date('d/m/Y',strtotime($diarefrigerantemax->FecIUtil)) }}</div>
                      </div>
                      <br>
                      
                    </div>
                    <div class="col-md-6 divleft">
                      <h4>UTILIZACIÓN DE LA TECNOLOGÍA</h4>
                      <hr>
                      <div id="chart_tecnologia"></div>
                      <br>
                    </div>
                        <div class="col-md-6 divright">
                          <h4>USO SEGUN EL ESTADO</h4>
                          <hr>
                          <div id="chart_estado"></div>
                          <br>
                          <br>
                        </div>
                      </div>
                        <div class="table-responsive-md">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Periodo</th>
                                    <th scope="col">Desde</th>
                                    <th scope="col">Hasta</th>
                                    <th scope="col">Hs motor</th>
                                    <th scope="col">Superficie sembrada por hora</th>
                                    <th scope="col">Consumo de combustible por hectárea</th>
                                    <th scope="col">Ralentí</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @for ($i=0; $i <= $periodos; $i++)
                                    @if($i >= $periodos -1)
                                            <tr>
                                            <th scope="row">Acumulado</th>
                                            <th scope="row">{{ date('d/m/Y',strtotime($fechainicio[$i])) }}</th>
                                            <th scope="row">{{ date('d/m/Y',strtotime($fechafin[$i])) }}</th>
                                            <th scope="row"></th>
                                            <th scope="row">{{ number_format($superficie[$i],1) }} has</th>
                                            <th scope="row">{{ number_format($consumo[$i],1) }} lts</th>
                                            <th scope="row">{{ number_format($ralenti[$i],1) }} %</th>
                                            </tr>
                                    @else
                                        <tr>
                                        <th scope="row">P{{ $i + 1}}</th>
                                        <th scope="row">{{ date('d/m/Y',strtotime($fechainicio[$i])) }}</th>
                                        <th scope="row">{{ date('d/m/Y',strtotime($fechafin[$i])) }}</th>
                                        <th scope="row">{{ number_format($trabajandohs[$i] + $ralentihs[$i] + $transportehs[$i],0) }} hs</th>
                                        <th scope="row">{{ number_format($superficie[$i],1) }} has</th>
                                        <th scope="row">{{ number_format($consumo[$i],1) }} lts</th>
                                        <th scope="row">{{ number_format($ralenti[$i],1) }} %</th>
                                        </tr>
                                    @endif
                                @endfor
                                </tbody>
                                </table>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Superficie trabajada por hora (Has)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($totalrefsuperficie,1) }}</h5>
                                      </div>
                                      <div class="col-md-6" align="right" style="padding-right:5%">
                                        @php $porc10 = ($objetivosuperficie * 1.1 - $objetivosuperficie ) @endphp
                                        @if(($superficie[$periodos + 1] > ($objetivosuperficie - $porc10)) AND ($superficie[$periodos + 1] < $objetivosuperficie))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($superficie[$periodos + 1] < $objetivosuperficie)
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @else
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @endif
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la cantidad de hectáreas que realiza la máquina por cada hora de trabajo. Para mejorar este indicador se debe analizar la velocidad de trabajo, junto con el factor de carga de motor y variables de terreno y cultivo que limiten el incremento de velocidad.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_superficie"></div>
                                    <div class="form-group row">
                                      <label for="detallesuperficie" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detallesuperficie') is-invalid @enderror" name="detallesuperficie" id="detallesuperficie"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $fechainicio[$i] }}/{{ $fechafin[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $fechainicio[$i] }} - {{ $fechafin[$i] }}</option>
                                            @endfor
                                        </select>
                                       </div>
                                    </div>
                                      <div class="text-center" id="carga_superficie" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_superficie_detallado" ></div>
                                    <br>
                                </div>
                                
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Consumo de combustible por hectárea (Lts)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($totalrefconsumo,1) }}</h5>
                                      </div>
                                      <div class="col-md-6" align="right" style="padding-right:5%">
                                        @php $porc10 = ($objetivoconsumo * 1.1 - $objetivoconsumo ) @endphp
                                        @if(($consumo[$periodos + 1] < ($objetivoconsumo + $porc10)) AND ($consumo[$periodos + 1] > $objetivoconsumo))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($consumo[$periodos + 1] > $objetivoconsumo)
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @else
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @endif
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al consumo de combustible (en litros) por cada hectárea trabajada. Para mejorar este indicador se debe analizar la superficie cosechada por hora junto a la velocidad de trabajo y el factor de carga de motor además variables de terreno y cultivo que limiten el incremento de velocidad.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_consumo"></div>
                                    <div class="form-group row">
                                      <label for="detalleconsumo" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detalleconsumo') is-invalid @enderror" name="detalleconsumo" id="detalleconsumo"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $fechainicio[$i] }}/{{ $fechafin[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $fechainicio[$i] }} - {{ $fechafin[$i] }}</option>
                                            @endfor
                                        </select>
                                       </div>
                                    </div>
                                      <div class="text-center" id="carga_consumo" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_consumo_detallado" ></div>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Velocidad (km/h)</h3>
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($totalrefvelocidad,1) }}</h5>
                                      </div>
                                    </div>
                                    <br>
                                    <div id="chart_velocidad"></div>
                                    <div class="form-group row">
                                      <label for="detallevelocidad" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detallevelocidad') is-invalid @enderror" name="detallevelocidad" id="detallevelocidad"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $fechainicio[$i] }}/{{ $fechafin[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $fechainicio[$i] }} - {{ $fechafin[$i] }}</option>
                                            @endfor
                                        </select>
                                       </div>
                                    </div>
                                      <div class="text-center" id="carga_velocidad" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_velocidad_detallado" ></div>
                                    <br>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Factor de carga del motor (%)</h3>
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($reffactordecarga,1) }}</h5>
                                      </div>
                                    </div>
                                    <br>
                                    <div id="chart_cargamotor"></div>
                                    <div class="form-group row">
                                      <label for="detallefactor" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detallefactor') is-invalid @enderror" name="detallefactor" id="detallefactor"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $fechainicio[$i] }}/{{ $fechafin[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $fechainicio[$i] }} - {{ $fechafin[$i] }}</option>
                                            @endfor
                                        </select>
                                       </div>
                                    </div>
                                      <div class="text-center" id="carga_factor" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_factor_detallado" ></div>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <h3 style="text-align: center">RPM</h3>
                                <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                <div class="row">
                                  <div class="col-md-6" align="left" style="padding-left:5%">
                                    <h5><i>Referencia:</i> {{ number_format($refrpm,0) }}</h5>
                                  </div>
                                </div>
                                <br>
                                <!-- fin de condicional -->
                                <div id="chart_rpm"></div>
                                <div class="form-group row">
                                  <label for="detallerpm" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                    <div class="col-md-6">
                                    <select class="detalle form-control @error('detallerpm') is-invalid @enderror" name="detallerpm" id="detallerpm"  title="Seleccionar periodo" autofocus> 
                                        <option value="">Seleccionar período</option>
                                        @for ($i=0; $i <= $periodos; $i++)
                                              <option value="{{ $fechainicio[$i] }}/{{ $fechafin[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $fechainicio[$i] }} - {{ $fechafin[$i] }}</option>
                                        @endfor
                                    </select>
                                   </div>
                                </div>
                                  <div class="text-center" id="carga_rpm" style="display: none">
                                    <div class="spinner-grow text-warning" role="status">
                                      <span class="sr-only">Loading...</span>
                                    </div>
                                  </div>
                                  <div id="chart_rpm_detallado" ></div>
                                <br>
                              </div>

                                <div class="col-md-6">
                                    <h3 style="text-align: center">Ralenti (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($refralenti,1) }}</h5>
                                      </div>
                                      <div class="col-md-6" align="right" style="padding-right:5%">
                                        @php $porc10 = ($objetivoralenti * 1.1 - $objetivoralenti ) @endphp
                                        @if(($ralenti[$periodos + 1] < ($objetivoralenti + $porc10)) AND ($ralenti[$periodos + 1] > $objetivoralenti))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($ralenti[$periodos + 1] > $objetivoralenti)
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @else
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @endif
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al porcentaje de tiempo que está la máquina en marcha sin realizar ningun trabajo. Para mejorar este indicador se debe analizar los tiempos de marcha inproductivos tanto con tolva llena como con tolva vacia, si tiene que esperar mucho tiempo hasta que llegue la tolva, si se pone en marcha para calentar el motor, tiempos de limpieza, etc..')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_ralenti"></div>
                                    <div class="form-group row">
                                      <label for="detalleralenti" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detalleralenti') is-invalid @enderror" name="detalleralenti" id="detalleralenti"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $fechainicio[$i] }}/{{ $fechafin[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $fechainicio[$i] }} - {{ $fechafin[$i] }}</option>
                                            @endfor
                                        </select>
                                       </div>
                                    </div>
                                      <div class="text-center" id="carga_ralenti" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_ralenti_detallado" ></div>
                                    <br>
                                </div>
                            </div>
                            
                            <h4>OPORTUNIDADES DE AHORRO DE COMBUSTIBLE</h4>
                            <hr>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="table-responsive-md">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                          <th scope="col"></th>
                                          <th scope="col">Lts. consumidos</th>
                                          <th scope="col">Lts. objetivo</th>
                                          <th scope="col">Lts. ahorrados</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <tr>
                                                <th scope="row">Consumo en ralenti</th>
                                                <th scope="row">{{ number_format($consumoralenti,0) }} Lts.</th>
                                                <th scope="row">{{ number_format($consumoralentiobjetivo,0) }} Lts.</th>
                                                <th scope="row">{{number_format($consumoralentiobjetivo - $consumoralenti,0) }} Lts.</th>
                                              </tr>
                                              <tr>
                                                <th scope="row">Totales</th>
                                                <th scope="row">{{ number_format($consumoralenti,0) }} Lts.</th>
                                                <th scope="row">{{ number_format( $consumoralentiobjetivo,0) }} Lts.</th>
                                                <th scope="row">{{number_format((+ $consumoralentiobjetivo) - ($consumoralenti),0) }} Lts.</th>
                                              </tr>
                                      </tbody>
                                  </table>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="table-responsive-md">
                                  <table class="table table-hover" style="text-align: center">
                                      <thead>
                                          <tr>
                                          <th scope="col"> <h4>Lts. ahorrados</h4></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                          <th scope="row"><h2>{{ number_format(($consumoralentiobjetivo) - ($consumoralenti),0) }} Lts.</h2></th>
                                          </tr> 
                                      </tbody>
                                  </table>
                                </div>
                                <div class="form-group row">
                                    
        
                                    <div class="input-group mb-0">
                                      <label for="valor" class="col-md-4 col-form-label text-md-right">{{ __('Valor litro de combustible $') }}</label>
                                        <input id="valor" type="number" step="0.01" class="form-control @error('valor') is-invalid @enderror" name="valor" id="valor" value="{{ old('valor') }}" required autocomplete="valor" autofocus>
        
                                        @error('valor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        
                                          <button type="submit" class="btn btn-warning" onclick="return mostrarValor();">Calcular</button>
                                      
                                    </div>
                                </div>
                                <div class="table-responsive-md">
                                  <table class="table table-hover" style="text-align: center">
                                      <thead>
                                          <tr>
                                          <th scope="col"> Has. ahorrados</th>
                                          <th scope="col"> Valor ahorrados</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                          <th scope="row"><h4>{{ number_format((( $consumoralentiobjetivo) - ($consumoralenti)) / $consumo[$periodos + 1],0) }} Has.</h4></th>
                                            <th scope="row"><h4 style="display: none;" id="valorcombustible">  </h4></th>
                                          </tr> 
                                      </tbody>
                                  </table>
                                </div>
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

function mostrarValor() {
    if ($("#valor").val() != ''){ 
                  var inputvalor = $("#valor").val();
                  var combustible = {{ (($consumoralentiobjetivo) - ($consumoralenti)) }};
                  var resultado = inputvalor * combustible; 
                  resultado = Math.round(resultado); 
          }

          valor = document.getElementById("valorcombustible");
          valor.style.display='block';
          valor.innerHTML = '$ ' + resultado.toLocaleString("en-US");
      }

      function printDiv() {
            document.getElementById('imprimirPDF').style.width='1500px';
            window.print();
            //window.cardova.plugins.printer.print('<h1> Prueba PDF </h>');
            document.getElementById('imprimirPDF').style.width='auto';
        }

      google.charts.load("current", {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

          /////////------ GRAFICO PIE DE HS DE TRABAJO RALENTI Y TRANSPORTE-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            ['Trabajando (hs)', {{ number_format($acumtrabajandohs,1) }}],
            ['Ralenti (hs)', {{ number_format($acumralentihs,1) }}],
            ['Transporte (hs)', {{ number_format($acumtransportehs,1) }}],
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0.50,
          colors: ["#367C2B", "#FFDE00", "#27251F"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"97%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_estado'));
          chart.draw(data, options);


          {{$acumtrabajandohs = number_format($acumtrabajandohs,0) }}
        
        // GRAFICO DE UTILIZACIÓN DE TECNOLOGIA-----------------------------------
        var data = google.visualization.arrayToDataTable([
          ['Month','Utilización de Tecnología (hs) ', 'Tiempo en cultivo (hs) '],
          ['AutoTrac™', {{ number_format($autotrac,0) }},  {{$acumtrabajandohs}} ],
        ]);

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

                var options = {
                bar: {groupWidth: "45%"},
                height:'150',
                chartArea:{left:90,top:20,bottom:20,width:"95%",height:"80%"},
                legend: {position: 'top', maxLines: 3},
                seriesType: 'bars',
                hAxis: {
                    minValue: 0
                },
                colors: ["#FFDE00", "#367C2B"],
                };

                var chart = new google.visualization.BarChart(document.getElementById('chart_tecnologia'));
                chart.draw(view, options);

            
                
        //GRAFICO DE TEMPERATURAS PROMEDIO Y MÁXIMAS
        var data = google.visualization.arrayToDataTable([
                ["Temperatura", "{{ $maquina->ModeMaq }} (°C)"],
                ['Prom aceite hidraulico', {{ number_format($temppromhidraulico,0) }}],
                ['Max aceite hidraulico', {{ number_format($tempmaxhidraulico,0) }}],
                ['Prom refrigerante', {{ number_format($temppromrefrigerante,0) }}],
                ['Max refrigerante', {{ number_format($tempmaxrefrigerante,0) }}],
              ]);

              var options = {
                height:'280',
                bar: {groupWidth: "45%"},
                chartArea:{top:20,bottom:30,width:"93%",height:"80%"},
                legend: {position: 'top', maxLines: 3},
                colors: [ "#367C2B"],
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

              var chart = new google.visualization.ColumnChart(document.getElementById("chart_temperaturas"));
              chart.draw(view, options);



          /////////------ SUPERFICIE COSECHADA POR HORA-------////////
          var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (Has)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos - 1; $i++)
              ['{{date('d/m/Y',strtotime($fechainicio[$i]))}} - {{date('d/m/Y',strtotime($fechafin[$i]))}}',
              {{ number_format($superficie[$i],1) }},
              {{ number_format($superficie[$periodos + 1],1) }},
              {{ number_format($objetivosuperficie,1) }}],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation" },
                          2,3,
                        ]);

          var options = {
          
          backgroundColor: { fill:'transparent' },
          chartArea:{top:20,bottom:40,width:"93%",height:"80%"},
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "90%"},
          vAxis: {
              minValue: 0
            },
            series: {1: {type: 'line'},
                      2: {type: 'line'}},
          
            colors: ["#367C2B","#FFDE00","#27251F"],
            selectionMode: 'multiple',
                  tooltip: {trigger: 'selection'},
                  
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_superficie"));
        chart.draw(view, options);


        /////////------ CONSUMO DE COMBUSTIBLE POR HECTAREA-------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (Lts)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos - 1; $i++)
              ['{{date('d/m/Y',strtotime($fechainicio[$i]))}} - {{date('d/m/Y',strtotime($fechafin[$i]))}}', 
              {{ number_format($consumo[$i],1) }},
              {{ number_format($consumo[$periodos + 1],1) }},
              {{ number_format($objetivoconsumo,1) }}],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation" },
                          2,3,
                        ]);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_consumo"));
        chart.draw(view, options);



          /////////------ VELOCIDAD-------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (km/h)", "Acumulado"],
          @for ($i=0; $i <= $periodos - 1; $i++)
              ['{{date('d/m/Y',strtotime($fechainicio[$i]))}} - {{date('d/m/Y',strtotime($fechafin[$i]))}}', 
              {{ number_format($velocidad[$i],1) }},
              {{ number_format($velocidad[$periodos + 1],1) }}],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation" },
                          2,
                        ]);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_velocidad"));
        chart.draw(view, options);


          /////////------ FACTOR DE CARGA DEL MOTOR-------////////
          var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (%)", "Acumulado"],
          @for ($i=0; $i <= $periodos - 1; $i++)
              ['{{date('d/m/Y',strtotime($fechainicio[$i]))}} - {{date('d/m/Y',strtotime($fechafin[$i]))}}', 
              {{ number_format($factordecarga[$i],1) }},
              {{ number_format($factordecarga[$periodos + 1],1) }}],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation" },
                          2,
                        ]);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_cargamotor"));
        chart.draw(view, options);


         /////////------ RPM-------////////
         var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (RPM)", "Acumulado"],
          @for ($i=0; $i <= $periodos - 1; $i++)
              ['{{date('d/m/Y',strtotime($fechainicio[$i]))}} - {{date('d/m/Y',strtotime($fechafin[$i]))}}', 
              {{ number_format($rpm[$i], 0, '.', '') }},
              {{ number_format($rpm[$periodos + 1], 0, '.', '') }}],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation" },
                          2,
                        ]);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_rpm"));
        chart.draw(view, options);



        /////////------ RALENTI-------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (%)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos - 1; $i++)
              ['{{date('d/m/Y',strtotime($fechainicio[$i]))}} - {{date('d/m/Y',strtotime($fechafin[$i]))}}', 
              {{ number_format($ralenti[$i],1) }},
              {{ number_format($ralenti[$periodos + 1],1) }},
              {{ number_format($objetivoralenti,1) }}],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation" },
                          2,3,
                        ]);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_ralenti"));
        chart.draw(view, options);


      

        ////////////////--------GRAFICOS DETALLADOS-------------//////////////////////

         $( document ).ready(function() {
          //cuando cargue la pagina que se vea arriba de todo
          $('html,body').scrollTop(0);

            $('.detalle').change(function(){
              var element_id = $(this).attr('id');
              if (element_id == "detallesuperficie"){
                divcarga = document.getElementById("carga_superficie");
                var div_grafico = "chart_superficie_detallado";
                var path = "{{ route('utilidad.detalle_superficie_consumo_vel_tractor') }}";
              }
              if (element_id == "detalleconsumo"){
                divcarga = document.getElementById("carga_consumo");
                var div_grafico = "chart_consumo_detallado";
                var path = "{{ route('utilidad.detalle_superficie_consumo_vel_tractor') }}";
              }
              if (element_id == "detallevelocidad"){
                divcarga = document.getElementById("carga_velocidad");
                var div_grafico = "chart_velocidad_detallado";
                var path = "{{ route('utilidad.detalle_superficie_consumo_vel_tractor') }}";
              }
              if (element_id == "detallefactor"){
                divcarga = document.getElementById("carga_factor");
                var div_grafico = "chart_factor_detallado";
                var path = "{{ route('utilidad.detalle_tractor_ralenti') }}";
              }
              if (element_id == "detallerpm"){
                divcarga = document.getElementById("carga_rpm");
                var div_grafico = "chart_rpm_detallado";
                var path = "{{ route('utilidad.detalle_tractor_ralenti') }}";
              }
              if (element_id == "detalleralenti"){
                divcarga = document.getElementById("carga_ralenti");
                var div_grafico = "chart_ralenti_detallado";
                var path = "{{ route('utilidad.detalle_tractor_ralenti') }}";
              }
              
              if ($(this).val() != ''){
                var value = $(this).val();
                var maquina = "{{ $maquina->NumSMaq }}";
                var implemento = "{{ $implemento }}";
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    beforeSend:function()
                    {
                      divcarga.style.display='block';
                    },
                    complete:function()
                    {
                      divcarga.style.display='none';
                    },
                    url: path,
                    method:"POST",
                    data:{value:value, _token:_token, maquina:maquina,implemento:implemento, element_id:element_id},
                    dataType: "JSON",
                    error: function(){
                          alert("No se puede obtener detalle del indicador");
                      },
                    success:function(result)
                    {
                      var arrDia = [['Month','{{ $maquina->ModeMaq }}']];
                      $.each(result, function (index, value) {
                          arrDia.push([ result[index][1], result[index][0]]);
                      });

                      /////////------ SUPERFICIE COSECHADA POR HORA-------////////
                      var data = google.visualization.arrayToDataTable(arrDia);
                      var view = new google.visualization.DataView(data);
                      view.setColumns([0, 1,
                                      { calc: "stringify",
                                        sourceColumn: 1,
                                        type: "string",
                                        role: "annotation" },
                                      ]);

                        var options = {
                        backgroundColor: { fill:'transparent' },
                        chartArea:{top:20,bottom:40,width:"93%",height:"80%"},
                        legend: { position: 'top'},
                        seriesType: 'line',
                        bar: {groupWidth: "90%"},
                        vAxis: {
                            minValue: 0
                          },
                        colors: ["#367C2B"],
                        selectionMode: 'multiple',
                        tooltip: {trigger: 'selection'},
                      };

                      var chart = new google.visualization.LineChart(document.getElementById(div_grafico));
                      chart.draw(view, options); 
                    }
                  });
              }
            });
          });

    }

  </script>

@endsection
