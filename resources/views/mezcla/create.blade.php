@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Mezcla de tanque nueva') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/mezcla') }}">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p>
                        <input type="text" hidden value="{{ $organizacion }}" id="id_organizacion" name="id_organizacion"> 
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Dá un nombre a la mezcla') }} *</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($mezcla->nombre)?$mezcla->nombre:old('nombre') }}" required autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        @for($i = 1; $i <= 20; $i++)
                            @if ($i == 1)
                                <div id='insu{{ $i }}' style='display: block'>
                            @else
                                <div id='insu{{ $i }}' style='display: none'>
                            @endif
                            
                                <div class="form-group row">
                                    <label for="id_insumo{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }}</label>

                                    <div class="col-md-6">
                                        <select class="selectpicker form-control @error('id_insumo{{ $i }}') is-invalid @enderror" data-live-search="true" id="id_insumo{{ $i }}" name="id_insumo{{ $i }}" value="{{ old('id_insumo'.$i) }}" autofocus> 
                                            <option value="">Seleccionar insumo</option>
                                            @foreach($insumos as $insumo)
                                                <option value="{{ $insumo->id }}">{{ $insumo->nombre }} </option>
                                            @endforeach
                                        </select>

                                        @error('id_insumo{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cantidad{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                                    <div class="col-md-6">
                                        <input id="cantidad{{ $i }}" type="number" step="0.01" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}" value="{{ isset($mezcla->cantidad)?$mezcla->cantidad:old('cantidad'.$i) }}" autocomplete="cantidad{{ $i }}" autofocus>

                                        @error('cantidad{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                @if($i <> 20)
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <a class="btn btn-warning" id="otro{{ $i }}">Agregar otro</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endfor
                            <hr>
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar mezcla')}}
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
    var i = 1;
    for (let i = 1; i < 21; i++) {
        $( "#otro"+i ).click(function() {
            i=i+1;
            insu = document.getElementById("insu"+i);

            insu.style.display = 'block';
            this.style.display = 'none';
        });   
    }
});
</script>
@endsection