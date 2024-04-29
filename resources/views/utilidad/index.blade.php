@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear informe') }}</div>
                <div class="card-body">
                    @include('custom.message')
                    <form method="POST" action="{{ route('utilidad.informe') }}" id="informef" name="informef">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                        <input id="vista" hidden type="text" value="{{ $habilitar }}">
                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                            <div class="col-md-6">
                                @if($organizacion->NombOrga == "Sala Hnos")
                                    <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" required @if ($habilitar == "NO") disabled @endif autofocus> 
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
                                    <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" id="CodiOrga" value="{{ old('CodiOrga') }}" title="Seleccionar Organizacion" required @if ($habilitar == "NO") readonly @endif autofocus> 
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
                            <select class="form-control @error('NumSMaq') is-invalid @enderror" name="NumSMaq" id="NumSMaq" value="{{ old('NumSMaq') }}" required @if ($habilitar == "NO") readonly @endif autofocus> 
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
                       
                        <div id="cultivo" style="display: none;">
                            <div class="form-group row">
                                <label for="inlineRadioOptions" class="col-md-4 col-form-label text-md-right"></label>
                               
                                @isset($informe->CultInfo)
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Soja")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="soja" value="soja" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="soja" value="soja">
                                            @endif
                                            <label class="form-check-label" for="soja">Soja</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Maiz")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maiz" value="maíz" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maiz" value="maíz">
                                            @endif
                                            <label class="form-check-label" for="maiz">Maíz</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Trigo")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="trigo" value="trigo" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="trigo" value="trigo">
                                            @endif
                                            <label class="form-check-label" for="trigo">Trigo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Girasol")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="girasol" value="girasol" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="girasol" value="girasol">
                                            @endif
                                            <label class="form-check-label" for="girasol">Girasol</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if ($informe->CultInfo == "Siembra")
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="siembra" value="siembra" checked>
                                            @else
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="siembra" value="siembra">
                                            @endif
                                            <label class="form-check-label" for="siembra">Siembra</label>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="soja" onchange="handleChange(this);" value="soja" checked>
                                            <label class="form-check-label" for="soja">Soja</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maiz" onchange="handleChange(this);" value="maíz">
                                            <label class="form-check-label" for="maiz">Maíz</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="trigo" onchange="handleChange(this);" value="trigo">
                                            <label class="form-check-label" for="trigo">Trigo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="girasol" onchange="handleChange(this);" value="girasol">
                                            <label class="form-check-label" for="girasol">Girasol</label>
                                        </div>
                                        <div class="form-check form-check-inline" hidden>
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="siembra" onchange="handleChange(this);" value="siembra">
                                            <label class="form-check-label" for="siembra">Siembra</label>
                                        </div>
                                    </div>
                                @endisset
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label for="desde" class="col-md-4 col-form-label text-md-right">{{ __('Desde') }} *</label>

                            <div class="col-md-6">
                                <input id="desde" type="date" class="form-control @error('desde') is-invalid @enderror" name="desde" value="{{ isset($informe->FecIInfo)?$informe->FecIInfo:old('desde') }}" required @if (((auth()->user()->email <> "martinezpablo06@gmail.com") && ($habilitar == "NO"))) readonly @endif autofocus>

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
                                <input id="hasta" type="date" class="form-control @error('hasta') is-invalid @enderror" name="hasta" value="{{ isset($informe->FecFInfo)?$informe->FecFInfo:old('hasta') }}" required @if (((auth()->user()->email <> "martinezpablo06@gmail.com") && ($habilitar == "NO"))) readonly @endif autofocus>

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
                                <input id="horas" type="number" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($informe->HsTrInfo)?'50':old('horas') }}" placeholder="Mayor a 30" @if ($habilitar == "NO") readonly @endif autofocus>

                                @error('horas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="div_plataforma" style="display: none;">
                            <div class="form-group row">
                                <label for="plataforma" class="col-md-4 col-form-label text-md-right">{{ __('Plataforma (pies) *') }} </label>

                                <div class="col-md-6">
                                    <input id="plataforma" type="number" class="form-control @error('plataforma') is-invalid @enderror" name="plataforma" value="{{ isset($maquinas->NumSMaq)?$maquinas->CanPMaq:old('plataforma') }}" placeholder="Ej: 40" autofocus>

                                    @error('plataforma')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="div_apero" style="display: none;">
                            <div class="form-group row">
                                <label for="apero" class="col-md-4 col-form-label text-md-right">{{ __('Maicero/Implemento (mts) *') }} </label>

                                <div class="col-md-6">
                                    <input id="apero" type="number" step="0.01" class="form-control @error('apero') is-invalid @enderror" name="apero" value="{{ isset($maquinas->MaicMaq)?$maquinas->MaicMaq:old('apero') }}" placeholder="Ej: 8.40" autofocus>

                                    @error('apero')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <div class="text-center" id="carga" name="carga" style="display: none">
                                    <div class="spinner-border text-secondary" role="status">
                                    <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <button id="crear" name="crear" type="submit" class="btn btn-success">Crear informe</button>
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

function radiosCheck()
{
    div_plataforma = document.getElementById("div_plataforma"); 
    div_apero = document.getElementById("div_apero");

    if ((document.getElementById('maiz').checked) || (document.getElementById('siembra').checked) || (document.getElementById('girasol').checked)){
        div_plataforma.style.display='none';
        div_apero.style.display='block';
    } else {
        div_plataforma.style.display='block';
        div_apero.style.display='none';      
    }
}

window.onload = radiosCheck();

$('input[type=radio][name=inlineRadioOptions]').change(function() {
    var implemento = '';
    var NumSMaq = $('#NumSMaq').val();
    var cultivo = this.value;
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url:"{{ route('utilidad.cargaImplemento') }}",
        method:"POST",
        data:{NumSMaq:NumSMaq, _token:_token, cultivo:cultivo},
        success:function(result)
        {
            implemento = result;

            if ((cultivo == 'maíz') || (cultivo == 'girasol')) {
                div_plataforma.style.display='none';
                div_apero.style.display='block';
                $('#apero').val(implemento);
            } else {
                div_plataforma.style.display='block';
                div_apero.style.display='none';
                $('#plataforma').val(implemento);
            }
        }
    })

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
                    url:"{{ route('utilidad.fetch') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#NumSMaq').html(result); 
                    }
                })
            }
        });

        $('#NumSMaq').change(function(){
            
            if ($(this).val() != ''){ 
                var implemento = '';
                var NumSMaq = $(this).val();
                var cultivo = '';
                if (document.getElementById('maiz').checked){
                    cultivo = document.getElementById('maiz').value;
                } else{
                    if (document.getElementById('girasol').checked){
                    cultivo = document.getElementById('girasol').value;
                    } else{
                        if (document.getElementById('soja').checked){
                            cultivo = document.getElementById('soja').value;
                        } else{
                            cultivo = document.getElementById('trigo').value;
                        }
                    }
                }
                var _token = $('input[name="_token"]').val();
                tipocultivo = document.getElementById("cultivo");

                $.ajax({
                    url:"{{ route('utilidad.cargaImplemento') }}",
                    method:"POST",
                    data:{NumSMaq:NumSMaq, _token:_token, cultivo:cultivo},
                    success:function(result)
                    {
                        implemento = result;
                    }
                })

                $.ajax({
                    url:"{{ route('utilidad.verificaTipoMaquina') }}",
                    method:"POST",
                    data:{NumSMaq:NumSMaq, _token:_token},
                    success:function(result)
                    {
                        if (result == "COSECHADORA"){
                            tipocultivo.style.display='block';
                            if ((cultivo == 'maíz') || (cultivo == 'girasol')) {
                                div_plataforma.style.display='none';
                                div_apero.style.display='block';
                                $('#apero').val(implemento);
                            } else {
                                div_plataforma.style.display='block';
                                div_apero.style.display='none';
                                $('#plataforma').val(implemento);
                            }
                        }else{
                            tipocultivo.style.display='none';
                            div_plataforma.style.display='none';
                            div_apero.style.display='block';
                            $('#apero').val(implemento);
                        }
                    }
                    
                })

            } else {
                tipocultivo.style.display='none';
            }
        });

    }); 
</script>
@endsection

@endsection
