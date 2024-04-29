@php
    use App\maquina;
@endphp   
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar paquete de mantenimiento de máquina') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/mant_maq/'.$mant_maq->id) }}">
                        @csrf
                        @method('patch')
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="id_paquetemant" class="col-md-4 col-form-label text-md-right">{{ __('Id paquete') }}</label>

                            <div class="col-md-6">
                                <input id="id_paquetemant" type="number" class="form-control @error('id_paquetemant') is-invalid @enderror" name="id_paquetemant" value="{{ isset($mant_maq->id_paquetemant)?$mant_maq->id_paquetemant:old('id_paquetemant') }}" readonly autocomplete="id" autofocus>

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @php
                            $st = stripos($mant_maq->pin,"otra");
                            if($st !== false){
                                $dato = explode('-',$mant_maq->pin);
                                $maquinas = Maquina::where('CodiOrga',$dato[1])->get();
                            }
                        @endphp

                        <div class="form-group row">
                            <label for="pin" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie de máquina') }}</label>

                            <div class="col-md-6">
                                <input id="pin" type="text" class="form-control @error('pin') is-invalid @enderror" name="pin" value="{{ isset($mant_maq->pin)?$mant_maq->pin:old('pin') }}" readonly autocomplete="pin" autofocus>

                                @error('pin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if($st !== false)
                        <div class="form-group row">
                            <label for="maquina" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie correspondiente') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('maquina') is-invalid @enderror" id="maquina" name="maquina" value="{{ isset($maquina)?$maquina:old('maquina') }}" autofocus>
                                    <option value="otra">Ingrese el pin de máquina correspondiente</option>
                                    @isset($maquinas)
                                        @foreach($maquinas as $maq)
                                                <option value="{{ $maq->NumSMaq }}" 
                                                    >{{ $maq->ModeMaq }} - {{ $maq->NumSMaq }}</option>
                                            
                                        @endforeach
                                    @endisset
                                </select>
                                @error('maquina')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                @can('haveaccess','maquina.create')
                                    <div class="col-md-2">
                                        <a href="{{ route('maquina.create') }}" title="Crear máquina nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea crear una máquina nueva y salir del registro de mantenimiento?');"><b>+</b></a>
                                    </div>
                                @endcan
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="realizado" class="col-md-4 col-form-label text-md-right">{{ __('Realizado') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('realizado') is-invalid @enderror" id="realizado" name="realizado" value="{{ isset($mant_maq->realizado)?$mant_maq->realizado:old('realizado') }}" autofocus>
                                    @isset($mant_maq->realizado)
                                        <option value="{{ $mant_maq->realizado }}">{{ $mant_maq->realizado }}</option>
                                    @endisset
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                </select>
                                @error('realizado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Horas de máquina') }}</label>

                            <div class="col-md-6">
                                <input id="horas" type="number" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($mant_maq->horas)?$mant_maq->horas:old('horas') }}" autocomplete="horas" autofocus>

                                @error('horas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de trabajo') }}</label>

                            <div class="col-md-6">
                                <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($mant_maq->fecha)?$mant_maq->fecha:old('fecha') }}" autocomplete="fecha" autofocus>

                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cor" class="col-md-4 col-form-label text-md-right">{{ __('N° COR') }}</label>

                            <div class="col-md-6">
                                <input id="cor" type="number" class="form-control @error('cor') is-invalid @enderror" name="cor" value="{{ isset($mant_maq->cor)?$mant_maq->cor:old('cor') }}" autocomplete="cor" autofocus>

                                @error('cor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                            <div class="form-group row" id="leyenda">
                                <label for="leyenda" class="col-md-4 col-form-label text-md-right"></label>

                                <div class="col-md-6">
                                    @if($st !== false)
                                        <b style="color: red">No se puede modificar el registro sin asignar el número de serie de la máquina correspondiente al paquete de mantenimiento</b>
                                    @endif
                                </div>
                            </div>
                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success" id="modificar" @if($st !== false) disabled @endif>
                                {{ __('Modificar') }}
                                  
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

    $('#maquina').change(function(){   
        maquina = document.getElementById("maquina");
        leyenda = document.getElementById("leyenda");
        modificar = document.getElementById("modificar");
    if ($(this).val() == 'otra'){ 
        leyenda.style.display='block';
        modificar.disabled = true;
    } else {
        leyenda.style.display='none';
        modificar.disabled = false;
    }
});

});
</script>
@endsection