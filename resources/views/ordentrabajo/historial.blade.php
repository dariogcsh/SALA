@php
    use App\orden_insumo;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Historial de trabajos </h2></div>
                <div class="card-body">
                @include('custom.message')
                <form action="">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                       <h6> Organización</h6>
                       <div class="form-group row">
                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" id="id_organizacion" name="id_organizacion" value="{{ isset($organizacion->id_organizacion)?$organizacion->id_organizacion:old('id_organizacion') }}" autocomplete="id_organizacion" autofocus>
                                    <option value="">Seleccionar Organización</option>
                                    @foreach ($organizaciones as $organ)
                                        <option value="{{ $organ->id }}" 
                                            >{{ $organ->NombOrga }}</option>
                                    @endforeach
                                </select>
                                @error('id_organizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <h6> Fecha inicio y fin</h6>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="fechainicio" type="date" class="form-control @error('fechainicio') is-invalid @enderror" name="fechainicio" value="{{ isset($calendario->fechainicio)?$calendario->fechainicio:old('fechainicio') }}">

                                @error('fechainicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="col-md-6">
                                <input id="fechafin" type="date" class="form-control @error('fechafin') is-invalid @enderror" name="fechafin" value="{{ isset($calendario->fechafin)?$calendario->fechafin:old('fechafin') }}">

                                @error('fechafin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                     </div>
                     <br>
                     <br>
                     <br>
                     <div class="col-xs-12 col-sm-6 col-md-3">
                        <h6> Lote</h6>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <select class="form-control @error('id_lote') is-invalid @enderror" id="id_lote" name="id_lote" value="{{ old('id_lote') }}" autofocus> 
                                    <option value="">Seleccione organizacion</option>
                                </select>
                                @error('id_lote')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                        </div>
                     </div>
                     <br>
                     <br>
                     <br>
                     <div class="col-xs-12 col-sm-6 col-md-3">
                        <h6> Trabajo</h6>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <select class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ isset($ordentrabajo->tipo)?$ordentrabajo->tipo:old('tipo') }}" autocomplete="tipo" autofocus>
                                    <option value="">Seleccionar trabajo</option>
                                    <option value="Siembra" >Siembra</option>
                                    <option value="Fertilizacion" >Fertilizacion</option>
                                    <option value="Aplicacion" >Aplicacion</option>
                                    <option value="Cosecha" >Cosecha</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                     </div>
                     <br>
                     <br>
                     <br>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <h6> Producto</h6>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <select class="form-control @error('producto') is-invalid @enderror" id="producto" name="producto" value="{{ old('producto') }}" autofocus> 
                                    <option value="">Seleccione organizacion</option>
                                </select>
                                @error('producto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <h6> Operario</h6>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <select class="form-control @error('id_usuariotrabajo') is-invalid @enderror" id="id_usuariotrabajo" name="id_usuariotrabajo" value="{{ old('id_usuariotrabajo') }}" autofocus> 
                                    <option value="">Seleccione organizacion</option>
                                </select>
                                @error('id_usuariotrabajo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <h6> Estado</h6>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ isset($ordentrabajo->estado)?$ordentrabajo->estado:old('estado') }}" autocomplete="estado" autofocus>
                                        <option value="">Seleccionar estado</option>
                                        <option value="Enviado" >Enviado</option>
                                        <option value="En ejecucion" >En ejecucion</option>
                                        <option value="Finalizado" >Finalizado</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                         </div>
                    
                    <br>
                    <br>
                    <br>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <br>
                        <button type="submit" class="btn btn-warning">Buscar</button>
                    </div>
                    <br>
                    <br>
                    <br>
                </div>
                </form>
                    <div class="row">
                        <div class="col-md-11">
                        @if ($filtro=="SI")
                            <a class="btn btn-secondary float-right" href="{{ route('ordentrabajo.historial') }}">
                                <i class="fa fa-times"> </i> Sacar filtro</a>
                        @endif
                        </div>
                    </div>
                </div>
                <br>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Organización</th>
                            <th scope="col">Lote</th>
                            <th scope="col">Has.</th>
                            <th scope="col">Labor</th>
                            <th scope="col">Insumos por Ha.</th>
                            <th scope="col">Fecha inicio</th>
                            <th scope="col">Fecha Fin</th>
                            <th scope="col">Operario</th>
                            <th scope="col">Estado</th>
                            <th scope="col">US$ por Ha.</th>
                            <th scope="col">US$</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($ordentrabajos as $ordentrabajo)
                            @can('haveaccess','ordentrabajo.show')
                            <tr href="{{ route('ordentrabajo.show',$ordentrabajo->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $ordentrabajo->NombOrga }}</th>
                            <th scope="row">{{ $ordentrabajo->name }} <small>({{ $ordentrabajo->client }} - {{ $ordentrabajo->farm }})</small></th>
                            <th scope="row">{{ $ordentrabajo->has }}</th>
                            <th scope="row">{{ $ordentrabajo->tipo }}</th>
                            @php
                                //Busco los insumos utilizados para cada orden de trabajo
                                $insumos = Orden_insumo::where('id_ordentrabajo',$ordentrabajo->id)->get();
                            @endphp
                            <th scope="row">
                            @foreach($insumos as $insumo)
                                {{ $insumo->insumo }} 
                                <small>
                                    @isset($insumo->unidades)
                                        ({{ $insumo->unidades }} semillas) 
                                    @else
                                        @isset($insumo->kg)
                                            ({{ $insumo->kg }} kg) 
                                        @else
                                            ({{ $insumo->lts }} lts) 
                                        @endisset
                                    @endisset
                                </small>
                                - 
                            @endforeach
                            </th>
                            <th scope="row">{{ date('d/m/Y',strtotime($ordentrabajo->fechainicio)) }}</th>
                            <th scope="row">{{ date('d/m/Y',strtotime($ordentrabajo->fechafin)) }}</th>
                            <th scope="row">{{ $ordentrabajo->uname }} {{ $ordentrabajo->last_name }}</th>
                            <th scope="row">{{ $ordentrabajo->estado }}</th>
                            <th scope="row">
                                @foreach($insumos as $insumo)
                                   US$ {{ $insumo->precio }} - 
                                @endforeach
                            </th>
                            <th scope="row">
                                @foreach($insumos as $insumo)
                                    @php
                                        $subtotal = $insumo->precio * $ordentrabajo->has;
                                        $total = $total + $subtotal;
                                    @endphp
                                @endforeach
                                US$ {{ $total }}
                            </th>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $ordentrabajos->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
$(document).ready(function(){
       $('table tr').click(function(){
        if ($(this).attr('href')) {
           window.location = $(this).attr('href');
        }
           return false;
       });

       $('#id_organizacion').change(function(){
            if ($(this).val() != ''){ 
                var select = 'id_organizacion';
                var value = $(this).val();           
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('ordentrabajo.flote') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#id_lote').html(result); 
                    },
                    error:function(){
                        alert("No se pudieron cargar los lotes, intentelo más tarde");
                    }
                })
                $.ajax({
                url:"{{ route('ordentrabajo.fusuario') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#id_usuariotrabajo').html(result); 
                },
                error:function(){
                    alert("No se pudieron cargar los usuarios, intentelo más tarde");
                }
            })
            $.ajax({
                url:"{{ route('ordentrabajo.fproducto') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#producto').html(result); 
                },
                error:function(){
                    alert("No se pudieron cargar los productos, intentelo más tarde");
                }
            })
            }
        });
});
</script>
@endsection
