@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Beneficios vigentes</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('mibonificacion.index') }}" class="btn btn-success btn-block">Ver beneficios solicitados</a>
                        </div>
                        <br><br>
                        @can('haveaccess','bonificacion.create')
                            <div class="col-md-4">
                                <a href="{{ route('bonificacion.administrar') }}" class="btn btn-warning btn-block">Administrar beneficios</a>
                            </div>
                            <br><br>
                        @endcan
                    </div>
                    <br>
                    @php $i = 0; @endphp
                    @foreach($bonificaciones as $bonificacion)
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                            <!-- Accordion card -->
                            <div class="card">
                        
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingOne{{$i}}">
                                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne{{$i}}" aria-expanded="false"
                                    aria-controls="collapseOne{{$i}}">
                                    <h4 class="mb-0">
                                        <i class="fas fa-angle-down rotate-icon"></i> {{ $bonificacion->tipo }} @isset($bonificacion->descuento) - {{$bonificacion->descuento}}% @endisset
                                    </h4>
                                    </a>
                                </div>
                                
                                <!-- Card body -->
                                <div id="collapseOne{{$i}}" class="collapse" role="tabpanel" aria-labelledby="headingOne{{$i}}"
                                    data-parent="#accordionEx1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img src="{{ asset('img/bonificaciones/' .$bonificacion->imagen) }}" width="100%" class="img img-responsive">
                                            </div>
                                            <br>
                                            <div class="col-md-9"><p>{{ $bonificacion->descripcion }}</p></div>
                                        </div>
                                        <br>
                                        <p>Beneficio vigente desde el <b>{{ date('d/m/Y',strtotime($bonificacion->desde)) }}</b> hasta el <b>{{ date('d/m/Y',strtotime($bonificacion->hasta)) }}</b></p>
                                        @isset($bonificacion->costo)
                                            @if($bonificacion->costo < 100)
                                                <p>Precio: <b>US$ {{ $bonificacion->costo }} por Ha.</b></p>
                                            @else
                                                <p>Precio: <b>US$ {{ $bonificacion->costo }}</b></p>
                                            @endif
                                            @if($bonificacion->descuento <> 0)
                                                @php $resultadobonif = $bonificacion->costo - $bonificacion->costo/$bonificacion->descuento @endphp
                                                <p>Precio con descuento: <b>US$ {{ number_format($resultadobonif,1) }}</b></p>
                                            @endif
                                        @endisset
                                        <div class="row">
                                            <div class="col-md-4">
                                                @if(stripos($bonificacion->tipo,'siembra'))
                                                    <a href="{{ route('jdlink.createtractorsolo') }}" class="btn btn-success btn-block">Ver formulario</a>
                                                @elseif(stripos($bonificacion->tipo,'cosecha a medida'))
                                                    <a href="{{ route('jdlink.create') }}" class="btn btn-success btn-block">Ver formulario</a>
                                                @elseif(stripos($bonificacion->tipo,'soporte agronomico de siembra'))
                                                    <a href="{{ route('paqueteagronomico.create') }}" class="btn btn-success btn-block">Ver formulario</a>
                                                @elseif(stripos($bonificacion->tipo,'mantenimiento'))
                                                    <a href="{{ route('mant_maq.create') }}" class="btn btn-success btn-block">Ver formulario</a>
                                                @else
                                                    <button class="solicitud btn btn-success btn-block" id="{{ $bonificacion->id }}">Solicitar</button>
                                                @endif
                                            </div>
                                            <br><br>
                                            <div class="col-md-4">
                                                @if((stripos($bonificacion->tipo,'monitoreo') !== false) OR (stripos($bonificacion->tipo,'soporte') !== false))
                                                   @if(stripos($bonificacion->tipo,'cosecha a medida'))
                                                        <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/pdf/monitoreo/Monitoreo de cosecha personalizado.pdf')}}" class="btn btn-light btn-block">Ver detalle del monitoreo</a>
                                                        
                                                    @elseif(stripos($bonificacion->tipo,'soporte agronomico'))
                                                        <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/pdf/monitoreo/Paquete de soporte agronomico de siembra.pdf')}}" class="btn btn-light btn-block">Ver detalle del monitoreo</a>
                                                
                                                        @elseif(stripos($bonificacion->tipo,'siembra'))
                                                        <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/pdf/monitoreo/Monitoreo siembra.pdf')}}" class="btn btn-light btn-block">Ver detalle del monitoreo</a>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-md-4" style="text-align: center;">
                                                @if((stripos($bonificacion->tipo,'monitoreo') !== false) OR (stripos($bonificacion->tipo,'soporte') !== false))
                                                <a href="tel:3584901139"><img src="{{ asset('/imagenes/llamar.png') }}" height="15px"> Quiero saber más</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>
                            <!-- Accordion card -->
                        
                        </div>
                        <!-- Accordion wrapper -->
                        @php $i++; @endphp
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {!! $bonificaciones->onEachSide(0)->links() !!}
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    $('.solicitud').click(function(){
        var opcion = confirm('¿Desea confirmar la solicitud de bonificación?');
            if (opcion == true) { 
                var id = $(this).val();
                var id_boton = $(this).attr('id');
                boton_envio = document.getElementById(id_boton);
                var _token = $('input[name="_token"]').val();
                var path = "{{ route('mibonificacion.store') }}";
                $.ajax({
                    url: path,
                    method:"POST",
                    data:{ _token:_token, id:id_boton},
                    error: function(){
                          alert("No se puede solicitar la bonificación en este momento, intentelo más tarde");
                    },
                    success:function(response)
                    {
                        window.location.replace(response);
                    }
                  });
            } else {
                alert("Se ha cancelado la solicitud de bonificación");
            }
        
    });
});
</script>
@endsection
