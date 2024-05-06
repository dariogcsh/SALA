@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Informe de eficiencia de máquina - SALA') }}
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
                  <div>
                    <div class="col-md-4 divleft">
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
                        <div class="col-sm-6"><b>Max. aceite:</b> {{ date('d/m/Y',strtotime($diahidraulicomax->FecIUtil)) }}</div> 
                        <div class="col-sm-6"><b>Max. refrig:</b> {{ date('d/m/Y',strtotime($diarefrigerantemax->FecIUtil)) }}</div>
                      </div>
                      <br>
                    </div>
                    <div class="col-md-4 divleft">
                      <h4>UTILIZACIÓN DE LA TECNOLOGÍA</h4>
                      <hr>
                      <div id="chart_tecnologia"></div>
                      <br>
                    </div>
                        <div class="col-md-4 divright">
                          <h4>USO SEGUN EL ESTADO</h4>
                          <hr>
                          <div id="chart_estado"></div>
                          <br>
                          <br>
                        </div>
                        <div class="col-md-4 divright">
                          <h4>USO DETALLADO</h4>
                          <hr>
                          <div id="chart_estadodetalle"></div>
                          <br>
                          <br>
                        </div>
                        <div class="col-md-8 divleft">
                          <h4>CONSUMO DE COMBUSTIBLE</h4>
                          <hr>
                          <div id="chart_consumos"></div>
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
                                    <th scope="col">Hs Trilla</th>
                     <!--           <th scope="col">Tasa de precisión de indicadores</th>  -->
                                    <th scope="col">Superficie cosechada por hora</th>
                                    <th scope="col">Consumo de combustible por hectárea</th>
                                    <th scope="col">Ralentí</th>
                                    <th scope="col">Virajes con cabecero engranado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @for ($i=0; $i <= $periodos + 1; $i++)
                                    @if($i == $periodos + 1)
                                    <?php
                                         $acumtrabajandohs = $trabajandohs[$i] ;
                                         $acumralentihs = $ralentihs[$i] ;
                                         $acumtransportehs = $transportehs[$i] ;
                                         ?>
                                            <tr>
                                            <th scope="row">Acumulado</th>
                                            <th scope="row">{{ date('d/m/Y',strtotime($horasdetrillainicial->FecIUtil)) }}</th>
                                            <th scope="row">{{ date('d/m/Y',strtotime($horasdetrillafinal->FecIUtil)) }}</th>
                                            <th scope="row"></th>
                                   <!--     <th scope="row"></th> -->
                                            <th scope="row">{{ number_format($superficie[$i],1) }} has</th>
                                            <th scope="row">{{ number_format($consumo[$i],1) }} lts</th>
                                            <th scope="row">{{ number_format($ralenti[$i],1) }} %</th>
                                            <th scope="row">{{ number_format($separadordevirajes[$i],1) }} %</th>
                                            </tr>
                                    @else
                                        <tr>
                                        <th scope="row">P{{ $i + 1}}</th>
                                        <th scope="row">{{ date('d/m/Y',strtotime($pinicial[$i])) }}</th>
                                        <th scope="row">{{ date('d/m/Y',strtotime($pfinal[$i])) }}</th>
                                        <th scope="row">{{ number_format($hstrilla[$i],0) }} hs</th>
                             <!--       <th scope="row">{{ number_format($tasaprecision[$i],0) }} %</th> -->
                                        <th scope="row">{{ number_format($superficie[$i],1) }} has</th>
                                        <th scope="row">{{ number_format($consumo[$i],1) }} lts</th>
                                        <th scope="row">{{ number_format($ralenti[$i],1) }} %</th>
                                        <th scope="row">{{ number_format($separadordevirajes[$i],1) }} %</th>
                                        </tr>
                                    @endif
                                @endfor
                                </tbody>
                                </table>
                            </div>
                            <br>


                         
                              <div class="row">
                                @if((!empty($mantenerauto)) OR ($maquina->combine_advisor == "SI"))
                                  <div class="col-md-6" style="display: block">
                                @else
                                  <div class="col-md-6" style="display: none">
                                @endif
                                  <h3 style="text-align: center">Automantain (%)</h3>
                                  <div class="row">
                                    <div class="col-md-6" align="left" style="padding-left:5%">
                                    
                                    </div>
                                    <div class="col-md-6" align="right" style="padding-right:5%">
                                      @php $porc10 = ($objetivo_automation * 1.1 - $objetivo_automation ) @endphp
                                      @if(($mantenerauto_p[$periodos + 1] < ($objetivo_automation + $porc10)) AND ($mantenerauto_p[$periodos + 1] > $objetivo_automation))
                                        <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                        <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                      @elseif($mantenerauto_p[$periodos + 1] > $objetivo_automation)
                                        <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                        <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                      @else
                                        <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                      @endif
                                      <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a el porcentaje de utilización de la tecnología de mantener automáticamente. Lo que hace esta tecnología es hacer ajustes de configuración de regulación de la máquina de manera automática cada 3 minutos segun el objetivo que se le fijó.')" title="Detalle" height="30px" alt="">
                                    </div>
                                  </div>
                                  <br>
                                  <div id="chart_automation"></div>
                                  <div class="form-group row">
                                    <label for="detalleautomation" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                      <div class="col-md-6">
                                      <select class="detalle form-control @error('detalleautomation') is-invalid @enderror" name="detalleautomation" id="detalleautomation"  title="Seleccionar periodo" autofocus> 
                                          <option value="">Seleccionar período</option>
                                          @for ($i=0; $i <= $periodos; $i++)
                                                <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                          @endfor
                                      </select>
                                     </div>
                                  </div>
                                    <div class="text-center" id="carga_automation" style="display: none">
                                      <div class="spinner-grow text-warning" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                    </div>
                                    <div id="chart_automation_detallado" ></div>
                                  <br>
                                </div>

                                @if((!empty($harvest)) OR ($maquina->harvest_smart == "SI"))
                                  <div class="col-md-6" style="display: block">
                                @else
                                  <div class="col-md-6" style="display: none">
                                @endif
                                  <h3 style="text-align: center">Harvest Smart (%)</h3>
                                  <div class="row">
                                    <div class="col-md-6" align="left" style="padding-left:5%">
                                    
                                    </div>
                                    <div class="col-md-6" align="right" style="padding-right:5%">
                                      @php $porc10 = ($objetivo_harvest * 1.1 - $objetivo_harvest ) @endphp
                                        @if(($harvest_p[$periodos + 1] < ($objetivo_harvest + $porc10)) AND ($harvest_p[$periodos + 1] > $objetivo_harvest))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($harvest_p[$periodos + 1] > $objetivo_harvest)
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @else
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @endif
                                      <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la velocidad automática de cosecha. Cuando se activa la función, la máquina cosechadora va regulando automáticamente la velocidad de cosecha según la capacidad de máquina o según los niveles de perdida.')" title="Detalle" height="30px" alt="">
                                    </div>
                                  </div>
                                  <br>
                                  <div id="chart_harvest"></div>
                                  <div class="form-group row">
                                    <label for="detalleharvest" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                      <div class="col-md-6">
                                      <select class="detalle form-control @error('detalleharvest') is-invalid @enderror" name="detalleharvest" id="detalleharvest"  title="Seleccionar periodo" autofocus> 
                                          <option value="">Seleccionar período</option>
                                          @for ($i=0; $i <= $periodos; $i++)
                                                <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                          @endfor
                                      </select>
                                    </div>
                                  </div>
                                    <div class="text-center" id="carga_harvest" style="display: none">
                                      <div class="spinner-grow text-warning" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                    </div>
                                    <div id="chart_harvest_detallado" ></div>
                                    <br>
                                  </div>
                              

                                @if(($cultivo <> 'Maiz') AND ($cultivo <> 'Maíz') AND ($cultivo <> 'Girasol'))
                                  <div class="col-md-6" style="display: block">
                                @else
                                  <div class="col-md-6" style="display: none">
                                @endif
                                  <h3 style="text-align: center">Uso velocidad automática del molinete (%)</h3>
                                  <div class="row">
                                    <div class="col-md-6" align="left" style="padding-left:5%">
                                    
                                    </div>
                                    <div class="col-md-6" align="right" style="padding-right:5%">
                                      @php $porc10 = ($objetivo_molinete * 1.1 - $objetivo_molinete ) @endphp
                                        @if(($velmolinete_p[$periodos + 1] < ($objetivo_molinete + $porc10)) AND ($velmolinete_p[$periodos + 1] > $objetivo_molinete))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($velmolinete_p[$periodos + 1] > $objetivo_molinete)
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @else
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @endif
                                      <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la velocidad automática de cosecha. Cuando se activa la función, la máquina cosechadora va regulando automáticamente la velocidad de cosecha según la capacidad de máquina o según los niveles de perdida.')" title="Detalle" height="30px" alt="">
                                    </div>
                                  </div>
                                  <br>
                                  <div id="chart_molinete"></div>
                                  <div class="form-group row">
                                    <label for="detallemolinete" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                      <div class="col-md-6">
                                      <select class="detalle form-control @error('detallemolinete') is-invalid @enderror" name="detallemolinete" id="detallemolinete"  title="Seleccionar periodo" autofocus> 
                                          <option value="">Seleccionar período</option>
                                          @for ($i=0; $i <= $periodos; $i++)
                                                <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                          @endfor
                                      </select>
                                    </div>
                                  </div>
                                    <div class="text-center" id="carga_molinete" style="display: none">
                                      <div class="spinner-grow text-warning" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                    </div>
                                    <div id="chart_molinete_detallado" ></div>
                                    <br>
                                  </div>
                                  
                                  @if(($maquina->ModeMaq == "S760") OR ($maquina->ModeMaq == "S770") OR ($maquina->ModeMaq == "S780") OR ($maquina->ModeMaq == "S790"))
                                    <div class="col-md-6" style="display: block">
                                  @else
                                    <div class="col-md-6" style="display: none">
                                  @endif
                                    <h3 style="text-align: center">Uso de ajuste activo de terreno (%)</h3>
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                      
                                      </div>
                                      <div class="col-md-6" align="right" style="padding-right:5%">
                                        @php $porc10 = ($objetivo_atta * 1.1 - $objetivo_atta ) @endphp
                                          @if(($atta_p[$periodos + 1] < ($objetivo_atta + $porc10)) AND ($atta_p[$periodos + 1] > $objetivo_atta))
                                            <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                            <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                            <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          @elseif($atta_p[$periodos + 1] > $objetivo_atta)
                                            <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                            <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                            <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          @else
                                            <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                            <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                            <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                          @endif
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al ajuste automático de terreno, es decir que la máquina es capaz de hacer ajustes de apertura de zaranda y zarandon según la inclinación de la máquina para evitar pérdidas o que la máquina no despida el material inerte de manera adecuada.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <div id="chart_atta"></div>
                                    <div class="form-group row">
                                      <label for="detalleatta" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detalleatta') is-invalid @enderror" name="detalleatta" id="detalleatta"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                            @endfor
                                        </select>
                                      </div>
                                    </div>
                                      <div class="text-center" id="carga_atta" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_atta_detallado" ></div>
                                      <br>
                                    </div>

                                    <div class="col-md-6">
                                      <h3 style="text-align: center">Autotrac (%)</h3>
                                      <div class="row">
                                        <div class="col-md-6" align="left" style="padding-left:5%">
                                        
                                        </div>
                                        <div class="col-md-6" align="right" style="padding-right:5%">
                                          @php $porc10 = ($objetivo_autotrac * 1.1 - $objetivo_autotrac ) @endphp
                                            @if(($autotrac_p[$periodos + 1] < ($objetivo_autotrac + $porc10)) AND ($autotrac_p[$periodos + 1] > $objetivo_autotrac))
                                              <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                              <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                              <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                            @elseif($autotrac_p[$periodos + 1] > $objetivo_autotrac)
                                              <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                              <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                              <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                            @else
                                              <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                              <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                              <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                            @endif
                                          <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a la utilización del piloto automático.')" title="Detalle" height="30px" alt="">
                                        </div>
                                      </div>
                                      <br>
                                      <div id="chart_autotrac"></div>
                                      <div class="form-group row">
                                        <label for="detalleautotrac" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                          <div class="col-md-6">
                                          <select class="detalle form-control @error('detalleautotrac') is-invalid @enderror" name="detalleautotrac" id="detalleautotrac"  title="Seleccionar periodo" autofocus> 
                                              <option value="">Seleccionar período</option>
                                              @for ($i=0; $i <= $periodos; $i++)
                                                    <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                              @endfor
                                          </select>
                                        </div>
                                      </div>
                                        <div class="text-center" id="carga_autotrac" style="display: none">
                                          <div class="spinner-grow text-warning" role="status">
                                            <span class="sr-only">Loading...</span>
                                          </div>
                                        </div>
                                        <div id="chart_autotrac_detallado" ></div>
                                        <br>
                                      </div>

                                      @if((($maquina->ModeMaq == "S760") OR ($maquina->ModeMaq == "S770") OR ($maquina->ModeMaq == "S780") OR ($maquina->ModeMaq == "S790")) AND ($maquina->harvest_smart == "SI"))
                                        <div class="col-md-6" style="display: block">
                                      @else
                                        <div class="col-md-6" style="display: none">
                                      @endif
                                        <h3 style="text-align: center">Maniobras automáticas (%)</h3>
                                        <div class="row">
                                          <div class="col-md-6" align="left" style="padding-left:5%">
                                          
                                          </div>
                                          <div class="col-md-6" align="right" style="padding-right:5%">
                                            <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere a las maniobras automáticas que es capaz de realizar el equipo en la cabecera.')" title="Detalle" height="30px" alt="">
                                          </div>
                                        </div>
                                        <br>
                                        <div id="chart_giros"></div>
                                        <div class="form-group row">
                                          <label for="detallegiros" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                            <div class="col-md-6">
                                            <select class="detalle form-control @error('detallegiros') is-invalid @enderror" name="detallegiros" id="detallegiros"  title="Seleccionar periodo" autofocus> 
                                                <option value="">Seleccionar período</option>
                                                @for ($i=0; $i <= $periodos; $i++)
                                                      <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                                @endfor
                                            </select>
                                          </div>
                                        </div>
                                          <div class="text-center" id="carga_giros" style="display: none">
                                            <div class="spinner-grow text-warning" role="status">
                                              <span class="sr-only">Loading...</span>
                                            </div>
                                          </div>
                                          <div id="chart_giros_detallado" ></div>
                                          <br>
                                        </div>
                                </div>
                            

                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Superficie cosechada por hora (Has)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($totalrefsuperficie,1) }}</h5>
                                      </div>
                                      <div class="col-md-6" align="right" style="padding-right:5%">
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
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
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
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
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
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
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
                                      <div class="col-md-6" align="right" style="padding-right:5%">
                                        @if(($factordecarga[$periodos + 1] > 80) OR (($factordecarga[$periodos + 1] >= 70) AND ($factordecarga[$periodos + 1] < 75)))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($factordecarga[$periodos + 1] < 70)
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @elseif(($factordecarga[$periodos + 1] >= 75) AND ($factordecarga[$periodos + 1] <= 80))
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @endif
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al porcentaje de potencia que se utilizó del motor en cada período, lo ideal es estar siempre próximo al 80%')" title="Detalle" height="30px" alt="">
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
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
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
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
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
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Ralenti con tolva llena (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($refralentilleno,1) }}</h5>
                                      </div>
                                      <div class="col-md-6" align="right" style="padding-right:5%">
                                        @php $porc10 = ($objetivoralentilleno * 1.1 - $objetivoralentilleno ) @endphp
                                        @if(($ralentillena[$periodos + 1] < ($objetivoralentilleno + $porc10)) AND ($ralentillena[$periodos + 1] > $objetivoralentilleno))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($ralentillena[$periodos + 1] > $objetivoralentilleno)
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @else
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @endif
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al porcentaje de tiempo que está la máquina en marcha sin realizar ningun trabajo y con la tolva llena. Para mejorar este indicador se tienen que analizar los tiempos inproductivos de máquina en marcha y tolva llena como ser cuando la máquina espera a la tolva para descargar o analizar la logística de trabajo en el lote.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_ralentillena"></div>
                                    <div class="form-group row">
                                      <label for="detalleralentilleno" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detalleralentilleno') is-invalid @enderror" name="detalleralentilleno" id="detalleralentilleno"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                            @endfor
                                        </select>
                                       </div>
                                    </div>
                                      <div class="text-center" id="carga_ralenti_lleno" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_ralenti_lleno_detallado" ></div>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Ralenti con tolva vacia (%)</h3>
                                    <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                    <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($refralentivacio,1) }}</h5>
                                      </div>
                                      <div class="col-md-6" align="right" style="padding-right:5%">
                                        @php $porc10 = ($objetivoralentivacio * 1.1 - $objetivoralentivacio ) @endphp
                                        @if(($ralentivacia[$periodos + 1] < ($objetivoralentivacio + $porc10)) AND ($ralentivacia[$periodos + 1] > $objetivoralentivacio))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($ralentivacia[$periodos + 1] > $objetivoralentivacio)
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @else
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @endif
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al porcentaje de tiempo que está la máquina en marcha sin realizar ningun trabajo y con la tolva vacía. Para mejorar este indicador se deben analizar los tiempos que se encuentra en marcha inproductivos como ser tiempos de calentamiento, limpieza, reparación, mantenimiento, etc.')" title="Detalle" height="30px" alt="">
                                      </div>
                                    </div>
                                    <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_ralentivacia"></div>
                                    <div class="form-group row">
                                      <label for="detalleralentivacio" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detalleralentivacio') is-invalid @enderror" name="detalleralentivacio" id="detalleralentivacio"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                            @endfor
                                        </select>
                                       </div>
                                    </div>
                                      <div class="text-center" id="carga_ralenti_vacio" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_ralenti_vacio_detallado" ></div>
                                    <br>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="text-align: center">Separador de virajes con cabecero engranado (%)</h3>
                                     <!-- Si esta cerca de alcanzar el objetivo, figura circulo amarillo, si no llega al objetivo se muestra circulo rojo y si no circulo verde -->
                                     <div class="row">
                                      <div class="col-md-6" align="left" style="padding-left:5%">
                                        <h5><i>Referencia:</i> {{ number_format($refseparadordevirajes,1) }}</h5>
                                      </div>
                                      <div class="col-md-6" align="right" style="padding-right:5%">
                                        @php $porc10 = ($objetivoseparador * 1.1 - $objetivoseparador ) @endphp
                                        @if(($separadordevirajes[$periodos + 1] < ($objetivoseparador + $porc10)) AND ($separadordevirajes[$periodos + 1] > $objetivoseparador))
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertwarning.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @elseif($separadordevirajes[$periodos + 1] > $objetivoseparador)
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alerterror.png') }}" height="20px" alt="">
                                        @else
                                          <img src="{{ asset('/imagenes/alertsuccess.png') }}" height="20px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                          <img src="{{ asset('/imagenes/alertinformation.png') }}" height="10px" alt="">
                                        @endif
                                        <img src="{{ asset('/imagenes/informacion.png') }}" onclick="alert('Refiere al tiempo en que la plataforma o cabezal se encuentra embrallada y no ingrsando cultivo (como por ejemplo el giro en la cabecera). Para mejorar este indicador se deben analizar los factores de apertura de melgas, formato del lote, etc.')" title="Detalle" height="30px" alt="">
                                      </div>
                                     </div>
                                     <br>
                                    <!-- fin de condicional -->
                                    <div id="chart_separadordevirajes"></div>
                                    <div class="form-group row">
                                      <label for="detalleseparador" class="col-md-4 col-form-label text-md-right">{{ __('Detallar periodo') }}</label>
                                        <div class="col-md-6">
                                        <select class="detalle form-control @error('detalleseparador') is-invalid @enderror" name="detalleseparador" id="detalleseparador"  title="Seleccionar periodo" autofocus> 
                                            <option value="">Seleccionar período</option>
                                            @for ($i=0; $i <= $periodos; $i++)
                                                  <option value="{{ $pinicial[$i] }}/{{ $pfinal[$i] }}"><b>P{{ $i + 1}}</b>  -  {{ $pinicial[$i] }} - {{ $pfinal[$i] }}</option>
                                            @endfor
                                        </select>
                                       </div>
                                    </div>
                                      <div class="text-center" id="carga_separador" style="display: none">
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                      </div>
                                      <div id="chart_separador_detallado" ></div>
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
                                          <th scope="col">Has. cosechadas (aprox)</th>
                                          <th scope="col">Lts. consumidos</th>
                                          <th scope="col">Lts. objetivo</th>
                                          <th scope="col">Lts. ahorrados</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <tr>
                                                <th scope="row">Consumo en ralenti</th>
                                                <th scope="row"></th>
                                                <th scope="row">{{ number_format($consumoralenti,0) }} Lts.</th>
                                                <th scope="row">{{ number_format($consumoralentiobjetivo,0) }} Lts.</th>
                                                <th scope="row">{{number_format($consumoralentiobjetivo - $consumoralenti,0) }} Lts.</th>
                                              </tr>
                                              <tr>
                                                <th scope="row">Consumo en separador de virajes</th>
                                                <th scope="row"></th>
                                                <th scope="row">{{ number_format($consumoseparador,0) }} Lts.</th>
                                                <th scope="row">{{ number_format($consumoseparadorobjetivo,0) }} Lts.</th>
                                                <th scope="row">{{number_format($consumoseparadorobjetivo - $consumoseparador,0) }} Lts.</th>
                                              </tr>
                                              <tr>
                                                <th scope="row">Totales</th>
                                                <th scope="row"></th>
                                                <th scope="row">{{ number_format($consumoralenti + $consumoseparador,0) }} Lts.</th>
                                                <th scope="row">{{ number_format($consumoseparadorobjetivo + $consumoralentiobjetivo,0) }} Lts.</th>
                                                <th scope="row">{{number_format(($consumoseparadorobjetivo + $consumoralentiobjetivo) - ($consumoralenti + $consumoseparador),0) }} Lts.</th>
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
                                          <th scope="row"><h2>{{ number_format(($consumoseparadorobjetivo + $consumoralentiobjetivo) - ($consumoralenti + $consumoseparador),0) }} Lts.</h2></th>
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
                                          @if(!empty($consumo[$periodos + 1]))
                                            <th scope="row"><h4>{{ number_format((($consumoseparadorobjetivo + $consumoralentiobjetivo) - ($consumoralenti + $consumoseparador)) / $consumo[$periodos + 1],0) }} Has.</h4></th>
                                          @else
                                            <th scope="row"><h4>0 Has.</h4></th>
                                          @endif
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
                  var combustible = {{ (($consumoseparadorobjetivo + $consumoralentiobjetivo) - ($consumoralenti + $consumoseparador)) }};
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


          /////////------ GRAFICO PIE DE HS DE TRABAJO RALENTI Y TRANSPORTE DETALLADO-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            ['Cosecha (hs)', {{ number_format($acumcosechahs,1) }}],
            ['Cosecha y Descarga (hs)', {{ number_format($acumcosechaydescargahs,1) }}],
            ['Descarga no cosechando (hs)', {{ number_format($acumdescargahs,1) }}],
            ['Separador de virajes con cabecero engranado (hs)', {{ number_format($acumseparadorhs,1) }}],
            ['Ralenti con tolva llena (hs)', {{ number_format($acumralentillenohs,1) }}],
            ['Ralenti con tolva vacia (hs)', {{ number_format($acumralentivaciohs,1) }}],
            //['Transporte - Desconexión para carretera activada', {{ number_format($acumtransportemas16hs,1) }}],
            //['Transporte - Desconexión para carretera desactivada', {{ number_format($acumtransportemenos16hs,1) }}],
            ['Transporte (hs)', {{ number_format($acumtransportehs,1) }}],
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0.50,
          colors: ["#367C2B", "#21B403", "#2ECC0E", "#50EA30", "#FFDE00","#F4FA3B", "#27251F", "#525252"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"97%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_estadodetalle'));
          chart.draw(data, options);


          {{$horasencultivo = number_format($horasencultivo,0) }}
        
        // GRAFICO DE UTILIZACIÓN DE TECNOLOGIA-----------------------------------
        var data = google.visualization.arrayToDataTable([
          ['Month','Utilización de Tecnología (hs) ', 'Tiempo en cultivo (hs) '],
          ['AutoTrac™', {{ number_format($autotrac,0) }},  {{$horasencultivo}} ],
          @if ($cultivo <> "maíz")
            ['Velocidad Autom. de Molinete', {{ number_format($velmolinete,0) }}, {{$horasencultivo}}],
          @endif
          ['Harvest Smart', {{ number_format($harvest,0) }}, {{$horasencultivo}}],
          ['Altura Autom. de Plataforma', {{ number_format($alturaplataforma,0) }}, {{$horasencultivo}}],
          @if ($cultivo == "maíz")
            ['RowSense™', {{ number_format(0,0) }}, {{$horasencultivo}}],
          @endif
          ['Mantener Automáticamente', {{ number_format($mantenerauto,0) }}, {{$horasencultivo}}],
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
                backgroundColor: { fill:'transparent' },
                height:'365',
                chartArea:{left:90,top:20,bottom:20,width:"95%",height:"80%"},
                legend: {position: 'top', maxLines: 3},
                hAxis: {
                  minValue: 0
                },
                seriesType: 'bars',
                colors: ["#FFDE00", "#367C2B"],
                };

                var chart = new google.visualization.BarChart(document.getElementById('chart_tecnologia'));
                chart.draw(view, options);

                //GRAFICO DE CONSUMOS DE COMBUSTIBLES TRABAJANDO, RALENTI Y TRANSPORTE
                var data = google.visualization.arrayToDataTable([
                  ['Year', 'Trabajando (lts) ', 'Ralenti (lts) ', 'Transporte (lts) '],
                  @for ($i=0; $i <= $periodos; $i++)
                    ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', {{ $trabajandolts[$i] }}, {{ $ralentilts[$i] }}, {{ $transportelts[$i] }}],
                  @endfor
                ]);

                var options = {
                  backgroundColor: { fill:'transparent' },
                  height:'320',
                  chartArea:{top:20,bottom:90,width:"90%",height:"80%"},
                  legend: {position: 'top', maxLines: 3},
                  colors: [ "#367C2B","#FFDE00","#27251F"],
                  selectionMode: 'multiple',
                  tooltip: {trigger: 'selection'},
                  aggregationTarget: 'category',
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_consumos'));
                chart.draw(data, options);

                
        //GRAFICO DE TEMPERATURAS PROMEDIO Y MÁXIMAS
        var data = google.visualization.arrayToDataTable([
                ["Temperatura", "{{ $maquina->ModeMaq }} (°C)"],
                ['Prom aceite hidraulico', {{ number_format($temppromhidraulico,0) }}],
                ['Max aceite hidraulico', {{ number_format($tempmaxhidraulico,0) }}],
                ['Prom refrigerante', {{ number_format($temppromrefrigerante,0) }}],
                ['Max refrigerante', {{ number_format($tempmaxrefrigerante,0) }}],
              ]);

              var options = {
                backgroundColor: { fill:'transparent' },
                height:'130',
                bar: {groupWidth: "45%"},
                chartArea:{top:20,bottom:30,width:"93%",height:"80%"},
                legend: {position: 'top', maxLines: 3},
                colors: [ "#367C2B"],
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
          ["Velocidad", "{{ $maquina->ModeMaq }} (Has)", "Acumulado"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}',
              {{ number_format($superficie[$i],1) }},
              {{ number_format($superficie[$periodos + 1],1) }}],
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
          ["Velocidad", "{{ $maquina->ModeMaq }} (Lts)", "Acumulado"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($consumo[$i],1) }},
              {{ number_format($consumo[$periodos + 1],1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_consumo"));
        chart.draw(view, options);



          /////////------ VELOCIDAD-------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (km/h)", "Acumulado"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
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
          ["Velocidad", "{{ $maquina->ModeMaq }} (%)", "Acumulado","Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($factordecarga[$i],1) }},
              {{ number_format($factordecarga[$periodos + 1],1) }},
              {{ number_format($objetivofactor,1) }}],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation" },
                          2,3
                        ]);

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_cargamotor"));
        chart.draw(view, options);







/////////------ Automantain-------////////
var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (%)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($mantenerauto_p[$i],1) }},
              {{ number_format($mantenerauto_p[$periodos + 1],1) }},
              {{ number_format($objetivo_automation,1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_automation"));
        chart.draw(view, options);


        /////////------ HARVEST SMART-------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (Lts)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($harvest_p[$i],1) }},
              {{ number_format($harvest_p[$periodos + 1],1) }},
              {{ number_format($objetivo_harvest,1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_harvest"));
        chart.draw(view, options);

       

         /////////------ VELOCIDAD DEL MOLINETE-------////////
         var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (Lts)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($velmolinete_p[$i],1) }},
              {{ number_format($velmolinete_p[$periodos + 1],1) }},
              {{ number_format($objetivo_molinete,1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_molinete"));
        chart.draw(view, options);

         /////////------ ATTA-------////////
         var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (Lts)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($atta_p[$i],1) }},
              {{ number_format($atta_p[$periodos + 1],1) }},
              {{ number_format($objetivo_atta,1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_atta"));
        chart.draw(view, options);

         /////////------ AUTOTRAC-------////////
         var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (Lts)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($autotrac_p[$i],1) }},
              {{ number_format($autotrac_p[$periodos + 1],1) }},
              {{ number_format($objetivo_autotrac,1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_autotrac"));
        chart.draw(view, options);

         /////////------ Giros automáticos------////////
         var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (Lts)", "Acumulado"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($autotrac_automation_p[$i],1) }},
              {{ number_format($autotrac_automation_p[$periodos + 1],1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_giros"));
        chart.draw(view, options);


        


        /////////------ RALENTI-------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (%)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
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


        /////////------ RALENTI CON TOLVA LLENA-------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (%)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($ralentillena[$i],1) }},
              {{ number_format($ralentillena[$periodos + 1],1) }},
              {{ number_format($objetivoralentilleno,1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_ralentillena"));
        chart.draw(view, options);

        /////////------ RALENTI CON TOLVA VACIA-------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (%)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($ralentivacia[$i],1) }},
              {{ number_format($ralentivacia[$periodos + 1],1) }},
              {{ number_format($objetivoralentivacio,1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_ralentivacia"));
        chart.draw(view, options);


        /////////------ SEPARADOR DE VIRAJES CON CABECERO ENGRANADO------////////
        var data = google.visualization.arrayToDataTable([
          ["Velocidad", "{{ $maquina->ModeMaq }} (%)", "Acumulado", "Objetivo"],
          @for ($i=0; $i <= $periodos; $i++)
              ['{{date('d/m/Y',strtotime($pinicial[$i]))}} - {{date('d/m/Y',strtotime($pfinal[$i]))}}', 
              {{ number_format($separadordevirajes[$i],1) }},
              {{ number_format($separadordevirajes[$periodos + 1],1) }},
              {{ number_format($objetivoseparador,1) }}],
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_separadordevirajes"));
        chart.draw(view, options);


        ////////////////--------GRAFICOS DETALLADOS-------------//////////////////////

         $( document ).ready(function() {
          //cuando cargue la pagina que se vea arriba de todo
          $('html,body').scrollTop(0);

            $('.detalle').change(function(){
              var element_id = $(this).attr('id');
              if (element_id == "detalleautomation"){
                divcarga = document.getElementById("carga_automation");
                var div_grafico = "chart_automation_detallado";
                var path = "{{ route('utilidad.detalle_tecnologia') }}";
              }
              
              if (element_id == "detalleharvest"){
                divcarga = document.getElementById("carga_harvest");
                var div_grafico = "chart_harvest_detallado";
                var path = "{{ route('utilidad.detalle_tecnologia') }}";
              }

              if (element_id == "detallemolinete"){
                divcarga = document.getElementById("carga_molinete");
                var div_grafico = "chart_molinete_detallado";
                var path = "{{ route('utilidad.detalle_tecnologia') }}";
              }

              if (element_id == "detalleatta"){
                divcarga = document.getElementById("carga_atta");
                var div_grafico = "chart_atta_detallado";
                var path = "{{ route('utilidad.detalle_tecnologia') }}";
              }

              if (element_id == "detalleautotrac"){
                divcarga = document.getElementById("carga_autotrac");
                var div_grafico = "chart_autotrac_detallado";
                var path = "{{ route('utilidad.detalle_tecnologia') }}";
              }
              
              if (element_id == "detallegiros"){
                divcarga = document.getElementById("carga_giros");
                var div_grafico = "chart_giros_detallado";
                var path = "{{ route('utilidad.detalle_tecnologia') }}";
              }
              
              if (element_id == "detallesuperficie"){
                divcarga = document.getElementById("carga_superficie");
                var div_grafico = "chart_superficie_detallado";
                var path = "{{ route('utilidad.detalle_superficie_consumo_vel') }}";
              }
              if (element_id == "detalleconsumo"){
                divcarga = document.getElementById("carga_consumo");
                var div_grafico = "chart_consumo_detallado";
                var path = "{{ route('utilidad.detalle_superficie_consumo_vel') }}";
              }
              if (element_id == "detallevelocidad"){
                divcarga = document.getElementById("carga_velocidad");
                var div_grafico = "chart_velocidad_detallado";
                var path = "{{ route('utilidad.detalle_superficie_consumo_vel') }}";
              }
              if (element_id == "detallefactor"){
                divcarga = document.getElementById("carga_factor");
                var div_grafico = "chart_factor_detallado";
                var path = "{{ route('utilidad.detalle_carga_cabecero_ralenti') }}";
              }
              if (element_id == "detalleralenti"){
                divcarga = document.getElementById("carga_ralenti");
                var div_grafico = "chart_ralenti_detallado";
                var path = "{{ route('utilidad.detalle_carga_cabecero_ralenti') }}";
              }
              if (element_id == "detalleralentilleno"){
                divcarga = document.getElementById("carga_ralenti_lleno");
                var div_grafico = "chart_ralenti_lleno_detallado";
                var path = "{{ route('utilidad.detalle_carga_cabecero_ralenti') }}";
              }
              if (element_id == "detalleralentivacio"){
                divcarga = document.getElementById("carga_ralenti_vacio");
                var div_grafico = "chart_ralenti_vacio_detallado";
                var path = "{{ route('utilidad.detalle_carga_cabecero_ralenti') }}";
              }
              if (element_id == "detalleseparador"){
                divcarga = document.getElementById("carga_separador");
                var div_grafico = "chart_separador_detallado";
                var path = "{{ route('utilidad.detalle_carga_cabecero_ralenti') }}";
              }
              if ($(this).val() != ''){
                var value = $(this).val();
                var cultivo = "{{ $cultivo }}";
                var maquina = "{{ $maquina->NumSMaq }}";
                var maicero = "{{ $implemento }}";
                var draper = "{{ $implemento }}";
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
                    data:{value:value, _token:_token, maquina:maquina, cultivo:cultivo, draper:draper, maicero:maicero, element_id:element_id},
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
