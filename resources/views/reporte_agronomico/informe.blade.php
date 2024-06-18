@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Informe agronómico - SALA') }}</div>
                <div class="card-body">
                  @include('custom.message')
                  <div class="divleft">
                    <h2><b>{{ $organizacion->NombOrga }}</b></h2>
                  </div>
                  <div class="divright">
                    <h4>Cosecha - {{ $año }}</h4>
                    <input id="NombOrga" hidden type="text" value="{{ $organizacion->NombOrga }}">
                    <input id="año" hidden type="text" value="{{ $año }}">
                  </div>
                  <br>
                  <hr>
                  <br>
                  <div class="row">
                    <div class="col-xs-0 col-md-4">
                      <div class="form-group row">
                        <div class="col-md-10">
                          <select class="cboagronomico form-control @error('cultivo') is-invalid @enderror" name="cultivo" id="cultivo"  title="Seleccionar cultivo" autofocus> 
                            <option value="">Seleccionar cultivo</option>
                            @foreach($cultivos as $cultivo)
                                  <option value="{{ $cultivo->cultivo }}">{{ $cultivo->cultivo }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <div class="form-group row">
                        <div class="col-md-10">
                          <select class="cboagronomico form-control @error('cliente') is-invalid @enderror" name="cliente" id="cliente"  title="Seleccionar cliente" autofocus> 
                            <option value="">Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                                  <option value="{{ $cliente->cliente }}">{{ $cliente->cliente }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-0 col-md-4"></div>
                  </div> 
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-xs-12 col-md-6">
                      <div id="graf1" style="display: none"> 
                        <h3 style="text-align: center">Superficie</h3>
                      </div>
                      <div id="div_superficie"></div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <div id="graf2" style="display: none">
                        <h3 style="text-align: center">Rinde total</h3>
                      </div>
                      <div id="div_rinde"></div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-xs-12 col-md-6">
                      <div id="graf3" style="display: none">
                        <h3 style="text-align: center">Humedad</h3>
                      </div>
                      <div id="div_humedad"></div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <div id="graf4" style="display: none">
                        <h3 style="text-align: center">Rinde promedio</h3>
                      </div>
                      <div id="div_rindemedio"></div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-xs-12 col-md-6">
                      <div id="graf5" style="display: none">
                        <h3 style="text-align: center">Rinde promedio de variedades</h3>
                      </div>
                      <div id="div_variedad1"></div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <div id="graf6" style="display: none">
                        <h3 style="text-align: center">Rinde total de variedades</h3>
                      </div>
                      <div id="div_variedad2"></div>
                    </div>
                  </div>
                  <div id="tabladetalle" style="display: none">
                  <br>
                  <br>
                  <h4>Lotes</h4>
                  <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                              <th scope="col">Cliente</th>
                              <th scope="col">Granja</th>
                              <th scope="col">Campo</th>
                              <th scope="col">Cultivo</th>
                              <th scope="col">Variedad</th>
                              <th scope="col">Superficie</th>
                              <th scope="col">Humedad</th>
                              <th scope="col">Promedio rendimiento seco</th>
                              <th scope="col">Rendimiento seco total</th>
                            </tr>
                        </thead>
                        <tbody>
                          @isset($datos)
                            @foreach ($datos as $dato)
                              <tr>
                                <th scope="row">{{ $dato->cliente }}</th>
                                <th scope="row">{{ $dato->granja }}</th>
                                <th scope="row">{{ $dato->campo }}</th>
                                <th scope="row">{{ $dato->cultivo }}</th>
                                <th scope="row">{{ $dato->variedad }}</th>
                                <th scope="row">{{ number_format($dato->superficie,1) }} has</th>
                                <th scope="row">{{ number_format($dato->humedad,1) }} %</th>
                                <th scope="row">{{ number_format($dato->rendimientosm,1) }} t/has</th>
                                <th scope="row">{{ number_format($dato->rendimiento,1) }} t</th>
                              </tr>
                            @endforeach
                          @endisset
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

      google.charts.load("current", {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
          $( document ).ready(function() {
              $('.cboagronomico').change(function(){
                if (($('#cliente').val() != '') && ($('#cultivo').val() != '')){
                          var cliente = $('#cliente').val();
                          var cultivo = $('#cultivo').val();
                          var NombOrga = $('#NombOrga').val();
                          var año = $('#año').val();
                          var _token = $('input[name="_token"]').val();
                          var path = "{{ route('reporte_agronomico.cambioCliente') }}";
                          divcarga1 = document.getElementById("graf1");
                          divcarga2 = document.getElementById("graf2");
                          divcarga3 = document.getElementById("graf3");
                          divcarga4 = document.getElementById("graf4");
                          divcarga5 = document.getElementById("graf5");
                          divcarga6 = document.getElementById("graf6");
                          divcarga7 = document.getElementById("tabladetalle");

                          $.ajax({
                              url: path,
                              method:"POST",
                              data:{ _token:_token, cliente:cliente, cultivo:cultivo, NombOrga:NombOrga, año:año},
                              dataType: "JSON",
                              complete:function()
                              {
                                divcarga1.style.display='block';
                                divcarga2.style.display='block';
                                divcarga3.style.display='block';
                                divcarga4.style.display='block';
                                divcarga5.style.display='block';
                                divcarga6.style.display='block';
                                divcarga7.style.display='block';
                              },
                              error: function(){
                                    alert("No se encontraron datos agronómico");
                              },
                              success:function(result)
                              {
                                //Asigno los 2 arrays recibidos a unos nuevos
                                var data1 = result[0];
                                var data2 = result[1];
                                
                                var arrSuperficie = [['Month','Has']];
                                var arrRinde = [['Month','t']];
                                var arrHumedad = [['Month','%']];
                                var arrRindeMedio = [['Month','t/ha']];

                                $.each(data1, function (index, value) {
                                    arrSuperficie.push([ data1[index][0], Math.round(data1[index][1])]);
                                    arrRinde.push([ data1[index][2], Math.round(data1[index][3])]);
                                    arrHumedad.push([ data1[index][4], Math.round((data1[index][5]+ Number.EPSILON) * 10) / 10]);
                                    arrRindeMedio.push([ data1[index][6], Math.round((data1[index][7]+ Number.EPSILON) * 10) / 10]);
                                });
                                
                                // bucle de 4 iteraciones 1 por cada grafico
                                for (let i = 0; i < 4; i++) {
                                  if (i==0){
                                    var arrIndicador = arrSuperficie;
                                    var div_indicador = "div_superficie";
                                  }
                                  if (i==1){
                                    var arrIndicador = arrRinde;
                                    var div_indicador = "div_rinde";
                                  }
                                  if (i==2){
                                    var arrIndicador = arrHumedad;
                                    var div_indicador = "div_humedad";
                                  }
                                  if (i==3){
                                    var arrIndicador = arrRindeMedio;
                                    var div_indicador = "div_rindemedio";
                                  }
                                  /////////------ Indicadores por granja-------////////
                                  var data = google.visualization.arrayToDataTable(arrIndicador);
                                  var view = new google.visualization.DataView(data);
                                  view.setColumns([0, 1,
                                                  { calc: "stringify",
                                                    sourceColumn: 1,
                                                    type: "string",
                                                    role: "annotation" },
                                                  ]);

                                    var options = {
                                    backgroundColor: { fill:'transparent' },
                                    chartArea:{top:20,bottom:40,width:"75%",height:"90%"},
                                    legend: { position: 'top'},
                                    seriesType: 'bars',
                                    bar: {groupWidth: "85%"},
                                    vAxis: {
                                        minValue: 0
                                      },
                                    colors: ["#367C2B"],
                                    selectionMode: 'multiple',
                                    tooltip: {trigger: 'selection'},
                                  };

                                  var chart = new google.visualization.ColumnChart(document.getElementById(div_indicador));
                                  chart.draw(view, options); 
                                }

                                var arrRindeMV = [['Month','t/ha']];
                                var arrRindeTV = [['Month','t']];
                                $.each(data2, function (index, value) {
                                  arrRindeMV.push([ data2[index][0], Math.round((data2[index][1]+ Number.EPSILON) * 10) / 10]);
                                  arrRindeTV.push([ data2[index][2], Math.round(data2[index][3])]);
                                });

                                for (let v = 0; v < 2; v++) {
                                  if (v==0){
                                    var arrIndicadorV = arrRindeMV;
                                    var div_indicadorV = "div_variedad1";
                                  }
                                  if (v==1){
                                    var arrIndicadorV = arrRindeTV;
                                    var div_indicadorV = "div_variedad2";
                                  }
                                  /////////------ Indicadores por granja-------////////
                                  var data = google.visualization.arrayToDataTable(arrIndicadorV);
                                  var view = new google.visualization.DataView(data);
                                  view.setColumns([0, 1,
                                                  { calc: "stringify",
                                                    sourceColumn: 1,
                                                    type: "string",
                                                    role: "annotation" },
                                                  ]);

                                    var options = {
                                    height:'500',
                                    backgroundColor: { fill:'transparent' },
                                    chartArea:{top:20,bottom:40,width:"75%",height:"90%"},
                                    legend: { position: 'top'},
                                    seriesType: 'bars',
                                    bar: {groupWidth: "85%"},
                                    hAxis: {
                                        minValue: 0
                                      },
                                    colors: ["#367C2B"],
                                    selectionMode: 'multiple',
                                    tooltip: {trigger: 'selection'},
                                  };
                                  var chart = new google.visualization.BarChart(document.getElementById(div_indicadorV));
                                  chart.draw(view, options); 
                                }
                              }
                            });
                          }
              });
          });
      }
</script>
@endsection
