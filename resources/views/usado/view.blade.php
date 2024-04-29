@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" id="logo" style="display: none">
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <img src="/imagenes/logo_sala_negro.png" class="img img-responsive float-right" height="90px" title="Activaciones y suscripciones">
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3">
                        @if(($usado->tipo == 'PULVERIZADORA') AND ($usado->marca == 'PLA'))
                            <th scope="row"><img class="img img-responsive float-right" src="{{ '/imagenes/PULVERIZADORAPLA.png' }}" height="90px"></th>
                        @else
                            <th scope="row"><img class="img img-responsive float-right" src="{{ '/imagenes/'.$usado->tipo.'.png' }}" height="90px"></th>
                        @endif
                    </div>
                </div>
                <br>
            </div>
            <br>
            <div class="card">
                <div class="card-header"><h3>{{ $usado->marca }} - {{ $usado->modelo }}
                    <a id="download" class="btn btn-success float-right" href={{ route('usado.usado_pdf',$usado->id) }}><i class="fa fa-download"></i></a>
                    </h3></div>

                <div class="card-body">
                      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @php $x=0; @endphp
                            @foreach($imagenes as $imagen)
                                @if($x == 0)
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ asset('/img/usados/'.$imagen->ruta) }}">
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ asset('/img/usados/'.$imagen->ruta) }}">
                                    </div>
                                @endif
                                @php $x++; @endphp
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Anterior</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Siguiente</span>
                        </a>
                        </div>
                       <div id="fotos" class="row" style="display: none">
                        @php $cant_fotos = 0; @endphp
                        @foreach($imagenes as $imagen)
                            @if($cant_fotos < 3)
                                <div class="col-md-4">
                                    <img class="img img-responsive" width="100%" src="{{ asset('/img/usados/'.$imagen->ruta) }}">
                                </div>
                            @endif
                            @php $cant_fotos++; @endphp
                        @endforeach
                       </div>
                       <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <br><br><br>
                                <h4>GENERALIDADES</h4>
                        </div>
                       </div>
                       <hr>
                       <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <b>TIPO: </b>{{ $usado->tipo }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>MARCA: </b>{{ $usado->marca }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>MODELO: </b>{{ $usado->modelo }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>AÑO: </b>{{ $usado->ano }} <br>
                                </div>
                                @if(($usado->tipo <> "SEMBRADORA") AND ($usado->tipo <> "PLATAFORMA DE MAIZ") AND ($usado->tipo <> "PLATAFORMA DE GIRASOL") AND ($usado->tipo <> "PLATAFORMA SINFIN") AND ($usado->tipo <> "PLATAFORMA DRAPER") AND ($usado->tipo <> "ROTOENFARDADORA"))
                                <div class="col-sm-12 col-md-3">
                                    <b>HORAS DE MOTOR: </b>{{ $usado->horasm }} hs. <br>
                                </div>
                                @endif
                                @if($usado->tipo == "COSECHADORA")
                                <div class="col-sm-12 col-md-3">
                                    <b>HORAS DE TRILLA: </b>{{ $usado->horast }} hs. <br>
                                </div>
                                @endif
                                @isset($usado->patente)
                                <div class="col-sm-12 col-md-3">
                                    <b>PATENTE: </b>{{ $usado->patente }} <br>
                                </div>
                                @endisset
                            </div>
                            <div class="row"></div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <br><br><br>
                                    <h4>CARACTERÍSTICAS</h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                @if(($usado->tipo == "PLATAFORMA DE MAIZ") OR ($usado->tipo == "PLATAFORMA DE GIRASOL"))
                                <div class="col-sm-12 col-md-3">
                                    <b>HILERAS: </b>{{ $usado->surcos }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>ESPACIAMIENTO ENTRE HILERAS: </b>{{ $usado->espaciamiento }} mts <br>
                                </div>
                                @endif
                                @if(($usado->tipo == "PLATAFORMA SINFIN") OR ($usado->tipo == "PLATAFORMA DRAPER"))
                                <div class="col-sm-12 col-md-3">
                                    <b>ANCHO DE PLATAFORMA: </b>{{ $usado->ancho_plataforma }} Pies <br>
                                </div>
                                @endif
                                @if($usado->tipo == "ROTOENFARDADORA")
                                <div class="col-sm-12 col-md-3">
                                    <b>CONFIGURACION: </b>{{ $usado->configuracion_roto }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>CANTIDAD DE ROLLOS: </b>{{ $usado->cantidad_rollos }} <br>
                                </div>
                                    @if($usado->monitor_roto == "SI")
                                        <div class="col-sm-12 col-md-3">
                                            <b>MONITOR: </b>{{ $usado->monitor_roto }} <br>
                                        </div>
                                    @endif
                                    @if($usado->cutter == "SI")
                                        <div class="col-sm-12 col-md-3">
                                            <b>CUTTER: </b>{{ $usado->cutter }} <br>
                                        </div>
                                    @endif
                                @endif
                                @if(($usado->tipo == "COSECHADORA") OR ($usado->tipo == "TRACTOR"))
                                <div class="col-sm-12 col-md-3">
                                    <b>TRACCIÓN: </b>{{ $usado->traccion }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>RODADO: </b>{{ $usado->rodado }} <br>
                                </div>
                                @endif
                                @if($usado->tipo == "COSECHADORA")
                                <div class="col-sm-12 col-md-3">
                                    <b>PLATAFORMA: </b>{{ $usado->plataforma }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>DESPARRAMADOR: </b>{{ $usado->desparramador }} <br>
                                </div>
                                @endif
                                @if($usado->tipo == "PULVERIZADORA")
                                <div class="col-sm-12 col-md-3">
                                    <b>BOTALÓN: </b>{{ $usado->botalon }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>TANQUE: </b>{{ $usado->tanque }} Lts. <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>PICOS: </b>{{ $usado->picos }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>CORTE POR SECCIONES: </b>{{ $usado->corte }} <br>
                                </div>
                                @endif
                                @if($usado->tipo == "SEMBRADORA")
                                <div class="col-sm-12 col-md-3">
                                    <b>CATEGORIA: </b>{{ $usado->categoria }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>CANTIDAD DE SURCOS: </b>{{ $usado->surcos }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>DISTANCIA ENTRE SURCOS: </b>{{ $usado->distancia }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>DOSIFICACIÓN: </b>{{ $usado->dosificacion }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>FERTILIZACIÓN: </b>{{ $usado->fertilizacion }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>CAPACIDAD DE TOLVA: </b>{{ $usado->tolva }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>CAPACIDAD DE FERTILIZANTE: </b>{{ $usado->fertilizante }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>REQUERIMIENTO HIDRÁULICO: </b>{{ $usado->reqhidraulico }} <br>
                                </div>
                                @endif
                                @if($usado->tipo == "TRACTOR")
                                <div class="col-sm-12 col-md-3">
                                    <b>CABINA: </b>{{ $usado->cabina }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>HP: </b>{{ $usado->hp }} <br>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <b>TRANSMISIÓN: </b>{{ $usado->transmision }} <br>
                                </div>
                                    @isset($usado->nseriemotor)
                                    <div class="col-sm-12 col-md-3">
                                        <b>N° DE SERIE DE MOTOR: </b>{{ $usado->nseriemotor }} <br>
                                    </div>
                                    @endisset
                                    <div class="col-sm-12 col-md-3">
                                        <b>TOMA DE FUERZA: </b>{{ $usado->tomafuerza }} <br>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <b>BOMBA HIDRÁULICA: </b>{{ $usado->bombah }} <br>
                                    </div>
                                @endif
                            </div>
                            @if(($usado->tipo <> "PLATAFORMA DE MAIZ") AND ($usado->tipo <> "PLATAFORMA DE GIRASOL") AND ($usado->tipo <> "PLATAFORMA SINFIN") AND ($usado->tipo <> "PLATAFORMA DRAPER"))
                            
                                
                                    @if($usado->tipo == "SEMBRADORA")
                                        @if($usado->monitor == "SI")
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <br><br><br>
                                                <h4>TECNOLOGÍA</h4>
                                            </div>
                                        </div>
                                                <hr>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <b>MONITOR: </b>{{ $usado->monitor }} <br>
                                            </div>
                                        @endif
                                    @elseif ($usado->tipo == "ROTOENFAARDADORA")
                                        @if($usado->monitor_roto == "SI")
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <br><br><br>
                                                <h4>TECNOLOGÍA</h4>
                                            </div>
                                        </div>
                                                <hr>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <b>MONITOR: </b>{{ $usado->monitor_roto }} <br>
                                            </div>
                                        @endif
                                    @else
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <br><br><br>
                                            <h4>TECNOLOGÍA</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @isset($conectividad)
                                        <div class="col-sm-12 col-md-4">
                                            <b>Conectividad: </b>{{ $conectividad->nombre }} <br>
                                        </div>
                                        @endisset
                                        @isset($$usado->agprecision)
                                        <div class="col-sm-12 col-md-4">
                                            <b>AutoTrac (Piloto): </b>{{ $usado->agprecision }} <br>
                                        </div>
                                        @endisset
                                        @isset($pantalla)
                                        <div class="col-sm-12 col-md-4">
                                            <b>Monitor: </b>{{ $pantalla->NombPant }} <br>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <b>Activaciones de monitor: </b>{{ $usado->activacion_pantalla }} <br>
                                        </div>
                                        @endisset
                                        @isset($antena)
                                        <div class="col-sm-12 col-md-4">
                                            <b>Antena: </b>{{ $antena->NombAnte }} <br>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <b>Activaciones de antena: </b>{{ $usado->activacion_antena }} <br>
                                        </div>
                                        @endisset
                                        @if($usado->tipo == "COSECHADORA")
                                        <div class="col-sm-12 col-md-4">
                                            <b>Camaras de automatización: </b>{{ $usado->camaras }} <br>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <b>Harvest Smart: </b>{{ $usado->prodrive }} <br>
                                        </div>
                                        @endif
                                    @endif
                                </div>
                            @endif

                        @if(($usado->tipo <> "SEMBRADORA") AND ($usado->tipo <> "PLATAFORMA DE MAIZ") AND ($usado->tipo <> "PLATAFORMA DE GIRASOL") AND ($usado->tipo <> "PLATAFORMA SINFIN") AND ($usado->tipo <> "PLATAFORMA DRAPER") AND ($usado->tipo <> "ROTOENFARDADORA"))
                            <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <br><br><br>
                                            <h4>RODADO</h4>
                                    </div>
                            </div>
                                <hr>
                            <div class="row">
                                @if($usado->tipo == "PULVERIZADORA")
                                    <div class="col-sm-12 col-md-3">
                                        <b>N°: </b>{{ $usado->nrodado }} <br>
                                    </div>
                                    @if($organizacion->NombOrga == "Sala Hnos")
                                    <div class="col-sm-12 col-md-3">
                                        <b>Estado del rodado delantero: </b>{{ $usado->rodadoest }} % <br>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <b>Estado del rodado trasero: </b>{{ $usado->rodadoesttras }} % <br>
                                    </div>
                                    @endif
                                @elseif ($usado->tipo == "SEMBRADORA")
                                    <div class="col-sm-12 col-md-3">
                                        <b>N°: </b>{{ $usado->nrodado }} <br>
                                    </div>
                                    @if($organizacion->NombOrga == "Sala Hnos")
                                        @isset($usado->rodadoest)
                                            <div class="col-sm-12 col-md-3">
                                                <b>Estado del rodado: </b>{{ $usado->rodadoest }} % <br>
                                            </div>
                                        @endisset
                                    @endif
                                @else
                                    <div class="col-sm-12 col-md-3">
                                        <b>Delantero N°: </b>{{ $usado->nrodado }} <br>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <b>Trasero N°: </b>{{ $usado->nrodadotras }} <br>
                                    </div>
                                    @if($organizacion->NombOrga == "Sala Hnos")
                                        @isset($usado->rodadoest)
                                            <div class="col-sm-12 col-md-3">
                                                <b>Estado del rodado delantero: </b>{{ $usado->rodadoest }} % <br>
                                            </div>
                                        @endisset
                                        @isset($usado->rodadoesttras)
                                            <div class="col-sm-12 col-md-3">
                                                <b>Estado del rodado trasero: </b>{{ $usado->rodadoesttras }} % <br>
                                            </div>
                                        @endisset
                                    @endif
                                @endif
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <br><br><br>
                                <h4>UBICACION</h4>
                                <hr>
                            </div>
                            
                            <div class="col-sm-12">
                                <b>SUCURSAL: </b>
                                @if($sucursal->NombSucu == "Otra")
                                    Ninguno (En campo del cliente)
                                @else
                                    {{ $sucursal->NombSucu }}
                                @endif 
                            </div>
                        </div>
                                  <br><br>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>PRECIO</h4>
                                 <hr>
                            </div>
                            <div class="col-sm-12">
                                <h4><b>US$: </b>{{ number_format($usado->precio) }} <br></h4>
                            </div>
                        </div>
                       
                       <div class="row">
                            <div class="col-sm-12">
                                <br><br><br>
                                <h4>INFORMACIÓN ADICIONAL</h4>
                            </div>
                       </div>
                            <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <b>COMENTARIOS: </b>{{ $usado->comentarios }} <br>
                            </div>
                        </div>
                       @if($organizacion->NombOrga == "Sala Hnos")
                       <div class="row">
                        <div id="adicional" class="col-sm-12 col-md-6">
                            <br><br><br>
                            <h4>INFORMACIÓN ADICIONAL</h4>
                                <hr>
                                <b>PRECIO DE REPARACIÓN: </b>{{ $usado->precio_reparacion }} <br>
                                <b>DETALLES DE REPARACIÓN: </b>{{ $usado->comentario_reparacion }} <br>
                                <b>FECHA DE POSIBLE INGRESO: </b>{{ date('d/m/Y',strtotime($usado->ingreso)) }} <br>
                                <b>FECHA DE REGISTRO: </b>{{ date_format($usado->created_at , 'd/m/Y H:i:s') }} <br>
                                <b>FECHA DE ÚLTIMA MODIFICACIÓN: </b>{{ date_format($usado->updated_at , 'd/m/Y H:i:s') }} <br>
                                <b>EX DUEÑO: </b>{{ $usado->excliente }} <br>
                                <b>VENDEDOR QUE TOMÓ EL USADO: </b>{{ $vendedor->name }} {{ $vendedor->last_name }} <br>
                                <b>ESTADO: </b>{{ $usado->estado }} <br>
                                @if($usado->estado == "Reservado")
                                    <b>RESERVADO POR: </b>{{ $vreserva->last_name }} {{ $vreserva->name }} <br>
                                    <b>FECHA DE RESERVA: </b>{{ date('d/m/Y',strtotime($usado->fechareserva)) }} <br>
                                    <b>RESERVADO PARA CLIENTE: </b>{{ $usado->reservado_para }}<br>
                                    <b>RESERVADO HASTA: </b>{{ date('d/m/Y',strtotime($usado->fechahasta)) }} <br>
                                @endif
                        </div>
                        <div id="opciones" class="col-sm-12 col-md-6">
                            <br><br><br>
                            <h4>OPCIONES</h4>
                            <hr>
                            @if(($usado->estado == "Reservado") AND ($usado->id_vreserva == auth()->user()->id))
                                <a onclick="return confirm('¿Seguro que desea disponibilizar el usado?');" href="{{ route('usado.hacerDisponible', $usado->id) }}" class="btn btn-success btn-block">Hacer disponible</a>
                                @can('haveaccess','usado.edit')
                                    <a href="{{ route('usado.edit', $usado->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                                @can('haveaccess','usado.vendido')
                                    <a onclick="return confirm('¿Seguro que desea marcar como vendido el usado?');" href="{{ route('usado.vendido', $usado->id) }}" class="btn btn-default btn-block">Marcar como vendido</a>
                                @endcan
                            @elseif(($usado->estado == "Reservado") AND ($usado->id_vreserva <> auth()->user()->id))
                                <a onclick="reservar()" href="{{ route('usado.reservaVendedor', $usado->id) }}" class="btn btn-success btn-block disabled">Reservar</a>
                                @can('haveaccess','usado.edit')
                                    <a href="{{ route('usado.edit', $usado->id) }}" class="btn btn-warning btn-block disabled">Editar</a>
                                @endcan
                                @can('haveaccess','usado.vendido')
                                    <a onclick="return confirm('¿Seguro que desea marcar como vendido el usado?');" href="{{ route('usado.vendido', $usado->id) }}" class="btn btn-default btn-block">Marcar como vendido</a>
                                @endcan
                            @elseif($usado->estado == "Vendido")
                            @can('haveaccess','usado.hacerDisponible')
                                <a onclick="return confirm('¿Seguro que desea disponibilizar el usado?');" href="{{ route('usado.hacerDisponible', $usado->id) }}" class="btn btn-success btn-block">Hacer disponible</a>
                            @endcan
                            @else
                                <a onclick="reservar()" class="btn btn-success btn-block">Reservar</a>
                                @can('haveaccess','usado.edit')
                                    <a href="{{ route('usado.edit', $usado->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                                @can('haveaccess','usado.vendido')
                                    <a onclick="return confirm('¿Seguro que desea marcar como vendido el usado?');" href="{{ route('usado.vendido', $usado->id) }}" class="btn btn-light btn-block">Marcar como vendido</a>
                                @endcan
                                @can('haveaccess','usado.destroy')
                                <br>
                                <form action="{{ route('usado.destroy',$usado->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el usado?');">Eliminar usado</button>
                                </form>
                                @endcan
                            @endif
                        </div>
                       </div>
                       
                       @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
</div>
@endsection
@section('script')
<script type="text/javascript">
function reservar() {
    overlay.style.display = "block";
  loader.style.display = "block";
  logo_sala.style.display = "none";
  var cliente = prompt("¿Para que cliente es la reserva?");
  var id_usado = {{$usado->id}};
  var _token = $('input[name="_token"]').val(); 
  if(cliente != ""){
        $.ajax({
            url:"{{ route('usado.reservaVendedor') }}",
            method:"POST",
            data:{_token:_token, id_usado:id_usado, cliente:cliente},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
            },
            success:function(data)
            {
                //window.location = "/usado/createUpdate/" + data;
                window.location = data.url
            }
        })
  }
}
</script>
@endsection