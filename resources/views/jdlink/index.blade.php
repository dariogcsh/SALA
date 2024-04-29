@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de máquinas conectadas 
                @can('haveaccess','jdlink.create')
                  <a href="{{ route('jdlink.createconect') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                
                <form>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <h5><u>Sucursal</u></h5>
                            <select name="sucursales" id="sucursales" class="form-control">
                                <option value="">Todas las sucursales</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">{{ $sucursal->NombSucu }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Tipo de máquina</u></h5>
                            <select name="tipomaq" id="tipomaq" class="form-control">
                                <option value="">Todas las máquinas</option>
                                <option value="COSECHADORA">Cosechadora</option>
                                <option value="TRACTOR">Tractor</option>
                                <option value="PULVERIZADORA">Pulverizadora</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Modelo de maquinaria</u></h5>
                            <select name="modelos" id="modelos" class="form-control">
                               
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Año fiscal</u></h5>
                            <select class="form-control @error('anofiscal') is-invalid @enderror" data-live-search="true" id="anofiscal" name="anofiscal" value="{{ isset($jdlink->anofiscal)?$jdlink->anofiscal:old('anofiscal') }}" autofocus>
                                
                                @php $year = date("Y"); @endphp
                                <option value="">Todos</option>
                                    @for ($i= 2021; $i <= $year + 1 ; $i++)
                                        <option value="{{$i}}">'{{$i}}</option>
                                    @endfor
                            </select>
                            @error('anofiscal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      
                        
                        <div class="form-group col-md-1">
                            <h5><u>Conectado</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="conectado[]">
                                <label class="form-check-label" for="conectado">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="conectado[]">
                                <label class="form-check-label" for="conectado">
                                  No
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-1">
                            <h5><u>Monitoreado</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="monitoreado[]">
                                <label class="form-check-label" for="monitoreado">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="monitoreado[]">
                                <label class="form-check-label" for="monitoreado">
                                  No
                                </label>
                            </div>
                          </div>

                        <div class="form-group col-md-2">
                          <h5><u>Soporte en siembra</u></h5>
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="si" name="soporte_siembra[]">
                              <label class="form-check-label" for="soporte_siembra">
                                Si
                              </label>
                              <br>
                              <input class="form-check-input" type="checkbox" value="no" name="soporte_siembra[]">
                              <label class="form-check-label" for="soporte_siembra">
                                No
                              </label>
                          </div>
                        </div>

                        <div class="form-group col-md-1">
                            <h5><u>Informes</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="informes[]">
                                <label class="form-check-label" for="informes">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="informes[]">
                                <label class="form-check-label" for="informes">
                                  No
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-1">
                            <h5><u>Orden. Agron.</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="ordenamiento_agro[]">
                                <label class="form-check-label" for="ordenamiento_agro">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="ordenamiento_agro[]">
                                <label class="form-check-label" for="ordenamiento_agro">
                                  No
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Mantenimiento</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="mantenimiento[]">
                                <label class="form-check-label" for="mantenimiento">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="mantenimiento[]">
                                <label class="form-check-label" for="mantenimiento">
                                  No
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="cargado" name="mantenimiento[]">
                                <label class="form-check-label" for="mantenimiento">
                                  Cargado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Actualización de componentes</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="actualizacion_comp[]">
                                <label class="form-check-label" for="actualizacion_comp">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="actualizacion_comp[]">
                                <label class="form-check-label" for="actualizacion_comp">
                                  No
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="bonificado" name="actualizacion_comp[]">
                                <label class="form-check-label" for="actualizacion_comp">
                                  Bonificado
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="realizado" name="actualizacion_comp[]">
                                <label class="form-check-label" for="actualizacion_comp">
                                  Realizado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Capacitación a operarios</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="capacitacion_op[]">
                                <label class="form-check-label" for="capacitacion_op">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="capacitacion_op[]">
                                <label class="form-check-label" for="capacitacion_op">
                                  No
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-1">
                            <h5><u>Visita inicial</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="vinicial[]">
                                <label class="form-check-label" for="vinicial">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="vinicial[]">
                                <label class="form-check-label" for="vinicial">
                                  No
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="bonificado" name="vinicial[]">
                                <label class="form-check-label" for="vinicial">
                                  Bonificado
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="realizada" name="vinicial[]">
                                <label class="form-check-label" for="vinicial">
                                  Realizada
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Ensayo Combine Advisor</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="ensayo[]">
                                <label class="form-check-label" for="ensayo">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="ensayo[]">
                                <label class="form-check-label" for="ensayo">
                                  No
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="pagada" name="ensayo[]">
                                <label class="form-check-label" for="ensayo">
                                  Realizado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-1">
                            <h5><u>Check list</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="check[]">
                                <label class="form-check-label" for="check">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="check[]">
                                <label class="form-check-label" for="check">
                                  No
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="bonificado" name="check[]">
                                <label class="form-check-label" for="check">
                                  Bonificado
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="realizado" name="check[]">
                                <label class="form-check-label" for="check">
                                  Realizado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Limpieza de inyectores</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="limpieza[]">
                                <label class="form-check-label" for="limpieza">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="limpieza[]">
                                <label class="form-check-label" for="limpieza">
                                  No
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="realizado" name="limpieza[]">
                                <label class="form-check-label" for="limpieza">
                                  Realizada
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <h5><u>Analisis final de campaña</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="analisis[]">
                                <label class="form-check-label" for="analisis">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="analisis[]">
                                <label class="form-check-label" for="analisis">
                                  No
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="bonificado" name="analisis[]">
                                <label class="form-check-label" for="analisis">
                                  Bonificado
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="realizada" name="analisis[]">
                                <label class="form-check-label" for="analisis">
                                  Realizado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-1">
                            <h5><u>Contrato</u></h5>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="no" name="contrato[]">
                                <label class="form-check-label" for="contrato">
                                  No realizado
                                </label>
                                <br>
                              <input class="form-check-input" type="checkbox" value="confeccionado" name="contrato[]">
                                <label class="form-check-label" for="contrato">
                                  Confeccionado
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="enviado al cliente" name="contrato[]">
                                <label class="form-check-label" for="contrato">
                                  Enviado al cliente
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="firmado" name="contrato[]">
                                <label class="form-check-label" for="contrato">
                                  Firmado
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="validado" name="contrato[]">
                                <label class="form-check-label" for="contrato">
                                  Validado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-1">
                            <h5><u>Facturado</u></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="si" name="factura[]">
                                <label class="form-check-label" for="factura">
                                  Si
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="no" name="factura[]">
                                <label class="form-check-label" for="factura">
                                  No
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="enviada al cliente" name="factura[]">
                                <label class="form-check-label" for="factura">
                                  Enviada al cliente
                                </label>
                                <br>
                                <input class="form-check-input" type="checkbox" value="pagada" name="factura[]">
                                <label class="form-check-label" for="factura">
                                  Pagada
                                </label>
                            </div>
                        </div>
                        
                       
                        <div class="input-group col-md-4">
                            <select name="tipo" class="form-control">
                                <option value="">Buscar por</option>
                                <option value="organizacions.NombOrga">Organizacion </option>
                                <option value="jdlinks.NumSMaq">N° de serie</option>
                                <option value="costo">Costo</option>
                            </select>
                            <input class="form-control " type="text" placeholder="Buscar" name="buscarpor">
                            <span class="input-group-append">
                                <button class="form-control btn btn-warning" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
                @if ($filtro=="SI")
                    <a class="btn btn-secondary float-right" href="{{ route('jdlink.index') }}">
                        <i class="fa fa-times"> </i>
                        Limpiar filtro
                    </a>
                @endif
                <br>
                @can('haveaccess','jdlink.createnect')
                  <div class="row">
                    <div class="col-md-2">
                    <a href="{{ route('jdlink.create') }}" class="btn btn-dark float-left"><b>+ Paquete de cosechadora</b></a>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-2">
                    <a href="{{ route('jdlink.createtractor') }}" class="btn btn-dark float-left"><b>+ Soporte en siembra</b></a>
                    </div>
                  </div>
                @endcan
                <br>
                <br>

                <u><b>Cantidad: </b></u>{{$cantreg}}
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">N° de serie</th>
                            <th scope="col">Año fiscal</th>
                            <th scope="col">Monitoreo</th>
                            <th scope="col">Fecha aprox. de comienzo</th>
                            <th scope="col">Visita inicial</th>
                            <th scope="col">Fecha visita</th>
                            <th scope="col">Check list</th>
                            <th scope="col">Contrato firmado</th>
                            <th scope="col">Vigencia hasta</th>
                            <th scope="col">Facturado</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($jdlinks as $jdlink)
                            @can('haveaccess','jdlink.show')
                            <tr href="{{ route('jdlink.show',$jdlink->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $jdlink->NombOrga }}</th>
                            <th scope="row">{{ $jdlink->TipoMaq }}</th>
                            <th scope="row">{{ $jdlink->ModeMaq }}</th>
                            <th scope="row">{{ $jdlink->NumSMaq }}</th>
                            <th scope="row">{{ $jdlink->anofiscal }}</th>
                            <th scope="row">{{ $jdlink->monitoreo }}</th>
                            @isset($jdlink->fecha_comienzo)
                              <th scope="row">{{ date('d/m/Y',strtotime($jdlink->fecha_comienzo)) }}</th>
                            @else
                              <th></th>
                            @endisset
                            <th scope="row">{{ $jdlink->visita_inicial }}</th>
                            @isset($jdlink->fecha_visita)
                              <th scope="row">{{ date('d/m/Y',strtotime($jdlink->fecha_visita)) }}</th>
                            @else
                              <th></th>
                            @endisset
                            <th scope="row">{{ $jdlink->check_list }}</th>
                            <th scope="row">{{ $jdlink->contrato_firmado }}</th>
                            @isset($jdlink->vencimiento_contrato)
                              <th scope="row">{{ date('d/m/Y',strtotime($jdlink->vencimiento_contrato)) }}</th>
                            @else
                              <th></th>
                            @endisset
                            <th scope="row">{{ $jdlink->factura }}</th>
                            @can('haveaccess','jdlink.show')
                            <th><a href="{{ route('jdlink.show',$jdlink->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
$(document).ready(function(){
    $('#tipomaq').change(function(){   
        if ($(this).val() != ''){ 
            var select = 'TipoMaq';
            var value = $(this).val();           
            var _token = $('input[name="_token"]').val(); 
            $.ajax({
                url:"{{ route('maquina.modelo') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#modelos').html(result); 
                },
                error:function(){
                    alert("Ha ocurrido un error, intentelo más tarde");
                }
            })
        }
    });
       $('table tr').click(function(){
        if ($(this).attr('href')) {
           window.location = $(this).attr('href');
        }
           return false;
       });
});
</script>
@endsection
