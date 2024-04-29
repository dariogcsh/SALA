@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear informee') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('utilidad.informeAcarreo') }}" id="informef" name="informef">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                            <div class="col-md-6">
                                @if($organizacion->NombOrga == "Sala Hnos")
                                    <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" required autofocus> 
                                        @foreach($organizaciones as $organ)
                                            <option value="{{ $organ->id }}" data-subtext="{{ $organ->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                @isset($informe->CodiOrga)
                                                        @if($organ->CodiOrga == $informe->CodiOrga)
                                                            selected
                                                        @endif
                                                @endisset
                                                >{{ $organ->NombOrga }} </option>
                                        @endforeach
                                @else
                                    <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" required autofocus> 
                                            <option value="{{ $organizacion->id }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                                >{{ $organizacion->NombOrga }} </option>
                                @endif 
                                   
                            </select>
                                @error('CodiOrga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('Maquina') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('NumSMaq') is-invalid @enderror" name="NumSMaq" id="NumSMaq" value="{{ old('NumSMaq') }}" required autofocus> 
                                @isset($informe->NumSMaq)
                                    <option value="{{ $informe->NumSMaq }}">{{ $informe->NumSMaq }}</option>
                                @endisset
                            </select>
                                @error('NumSMaq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="desde" class="col-md-4 col-form-label text-md-right">{{ __('Desde') }} *</label>

                            <div class="col-md-6">
                                <input id="desde" type="date" class="form-control @error('desde') is-invalid @enderror" name="desde" value="{{ isset($informe->FecIInfo)?$informe->FecIInfo:old('desde') }}" required autofocus>

                                @error('desde')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hasta" class="col-md-4 col-form-label text-md-right">{{ __('Hasta') }} *</label>

                            <div class="col-md-6">
                                <input id="hasta" type="date" class="form-control @error('hasta') is-invalid @enderror" name="hasta" value="{{ isset($informe->FecFInfo)?$informe->FecFInfo:old('hasta') }}" required autofocus>

                                @error('hasta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de hs. de motor por intervalo *') }} </label>

                            <div class="col-md-6">
                                <input id="horas" type="number" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($informe->HsTrInfo)?'50':old('horas') }}" placeholder="Mayor a 30" autofocus>

                                @error('horas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <div class="text-center" id="carga" name="carga" style="display: none">
                                    <div class="spinner-border text-secondary" role="status">
                                    <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <button id="crear" type="submit" class="btn btn-success">Crear informe</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script type="text/javascript">
$( document ).ready(function() {

    window.addEventListener('unload', function(event) {
        divcarga.style.display='none';
      });

    $("#informef").submit(function(e){
            divcarga = document.getElementById("carga");
            divcarga.style.display='block';
        });

    $('#CodiOrga').change(function(){
        
        if ($(this).val() != ''){ 
            var select = $(this).attr("id");
            var value = $(this).val();             
            var _token = $('input[name="_token"]').val(); 
            $.ajax({
                url:"{{ route('jdlink.solotractor') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#NumSMaq').html(result); 
                }
            })
        }
    });
}); 
</script>
@endsection

@endsection
