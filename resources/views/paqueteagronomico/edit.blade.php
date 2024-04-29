@php
    use App\jdlink;
    use Carbon\Carbon;
     //Verifico año fiscal actual
    $hoy = Carbon::now();
    $año = $hoy->format('Y');
    if (($hoy > $año."-10-31") AND ($hoy <= $año."-12-31")){
        $año = $año + 1;
    }
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar paquete agronómico') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/paqueteagronomico/'.$paqueteagronomico->id) }}">
                        @csrf
                        @method('patch')
                        <div class="form-group row">
                            <label for="id_organizacion" class="col-md-5 col-form-label text-md-right">{{ __('Organización') }}</label>

                            <div class="col-md-5">
                                <input id="id_organizacion" type="text" class="form-control" name="id_organizacion" value="{{ $organizacion->NombOrga }}" disabled>
                            </div>
                        </div> 

                        @foreach($maquinas as $maquina)
                            <div class="form-group row">
                                <label for="maquinas" class="col-md-5 col-form-label text-md-right">{{ __('Maquina monitoreada') }}</label>

                                <div class="col-md-5">
                                    <input id="maquinas" type="text" class="form-control" name="maquinas" value="{{ $maquina->ModeMaq }} - {{ $maquina->NumSMaq }}" disabled>
                                </div>
                                @can('haveaccess','paqueteagronomico.destroy')
                                    <button id="{{ $maquina->idpaqmaq }}" class="btn btn-danger beliminar">X</button>
                                @endcan
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <label for="pin" class="col-md-5 col-form-label text-md-right">{{ __('N° de serie de la máquina') }} *</label>

                            <div class="col-md-5">
                                <select class="form-control @error('pin') is-invalid @enderror" id="pin" multiple name="pin[]" autofocus>
                                    @foreach($maqs as $maq)
                                        @php
                                            $maquina = Jdlink::where([['NumSMaq',$maq->NumSMaq], ['anofiscal',$año]])->first();
                                        @endphp
                                        @isset($maquina)
                                            @if($maquina->monitoreo == "NO")
                                                <option value="{{ $maq->NumSMaq }}">{{ $maq->ModeMaq }} - {{ $maq->NumSMaq }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $maq->NumSMaq }}">{{ $maq->ModeMaq }} - {{ $maq->NumSMaq }}</option>
                                        @endisset
                                    @endforeach
                                </select>
                                @error('pin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                @can('haveaccess','maquina.create')
                                    <div class="col-md-2">
                                        <a href="{{ route('maquina.create') }}" title="Crear máquina nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea crear una máquina nueva y salir del formulario actual?');"><b>+</b></a>
                                    </div>
                                @endcan
                        </div>

                        <div class="form-group row">
                            <label for="anofiscal" class="col-md-5 col-form-label text-md-right">{{ __('Año fiscal') }}</label>

                            <div class="col-md-5">
                                <input id="anofiscal" type="text" class="form-control" name="anofiscal" value="{{ $paqueteagronomico->anofiscal }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="suelo" class="col-md-5 col-form-label text-md-right">{{ __('Muestreo de suelo') }}</label>

                            <div class="col-md-5">
                                <label class="switch">
                                    @if($paqueteagronomico->suelo == 'SI')
                                        <input type="checkbox" class="warning" name="suelo" checked >
                                    @else
                                        <input type="checkbox" class="warning" name="suelo" >
                                    @endif
                                    
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="compactacion" class="col-md-5 col-form-label text-md-right">{{ __('Medición de compactación de suelo') }}</label>

                            <div class="col-md-5">
                                <label class="switch">
                                    @if($paqueteagronomico->compactacion == 'SI')
                                        <input type="checkbox" class="warning" name="compactacion" checked >
                                    @else
                                        <input type="checkbox" class="warning" name="compactacion" >
                                    @endif
                                    
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="altimetria" class="col-md-5 col-form-label text-md-right">{{ __('Pasadas de piloto cortando pendiente') }}</label>

                            <div class="col-md-5">
                                <label class="switch">
                                    @if($paqueteagronomico->altimetria == 'SI')
                                        <input type="checkbox" class="warning" name="altimetria" checked >
                                    @else
                                        <input type="checkbox" class="warning" name="altimetria" >
                                    @endif
                                    
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vencimiento" class="col-md-5 col-form-label text-md-right">{{ __('Vencimiento') }}</label>

                            <div class="col-md-5">
                                <input id="vencimiento" type="date" class="form-control" name="vencimiento" value="{{ $paqueteagronomico->vencimiento }}" required>
                            </div>
                        </div> 
                    <!--
                        <div class="form-group row">
                            <label for="costoph" class="col-md-5 col-form-label text-md-right">{{ __('Costo por hectárea') }}</label>

                            <div class="col-md-5">
                                <input id="costoph" type="number" class="form-control" name="costoph" value="7" readonly>
                            </div>
                        </div> 
                    -->
                        <div class="form-group row">
                            <label for="hectareas" class="col-md-5 col-form-label text-md-right">{{ __('Hectáreas') }}</label>

                            <div class="col-md-5">
                                <input id="hectareas" type="number" class="form-control" name="hectareas" value="{{ $paqueteagronomico->hectareas }}" required>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="lotes" class="col-md-5 col-form-label text-md-right">{{ __('Cant. Lotes') }}</label>

                            <div class="col-md-5">
                                <input id="lotes" type="number" class="form-control" name="lotes" value="{{ $paqueteagronomico->lotes }}" required>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="costo" class="col-md-5 col-form-label text-md-right">{{ __('Costo') }}</label>

                            <div class="col-md-5">
                                <input id="costo" type="number" class="form-control" name="costo" value="{{ $paqueteagronomico->costo }}">
                            </div>
                        </div> 
                        <div class="form-group row mb-5">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-success">
                                {{__('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$( document ).ready(function() { 

   
        $("#pin").multipleSelect({
            filter: true
        });


    $("#hectareas").keyup(function(){
        costot = document.getElementById("costo");
        var costo = $("#costo").val();
        var hectareas = $("#hectareas").val();
        var costoph = $("#costoph").val();   
        var total = 0;
        total = costoph * hectareas;
        costot.value = total;
    });

    $('.beliminar').click(function(){
        var idpaqmaq = $(this).attr('id');
        var _token = $('input[name="_token"]').val();
        var opcion = confirm('¿Esta seguro que desea eliminar la maquinaria vinculada al soporte agronómico?');
            if (opcion == true) {
                $.ajax({
                    url:"{{ route('paqueteagronomico.destroymaq') }}",
                    method:"POST",
                    data:{_token:_token, idpaqmaq:idpaqmaq},
                    success:function(data)
                    {
                        window.location = data.url
                    },
                })
            }
        
    });

});
    
</script>
@endsection