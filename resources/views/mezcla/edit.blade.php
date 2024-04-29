@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar mezcla de tanque') }}</div>

                <div class="card-body">
                
                    <form id="formulario1" method="POST" action="{{ url('/mezcla/'.$mezcla->id) }}">
                        @csrf
                        @method('patch')
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
                        @php
                            $i = 1;
                        @endphp
                        @foreach($mezclainsus as $mezclainsu)  
                                <div class="form-group row">
                                    <label for="id_insumo{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Insumo') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control @error('id_insumo{{ $i }}') is-invalid @enderror" id="id_insumo{{ $i }}" name="id_insumo{{ $i }}" value="{{  isset($mezclainsu->id_insumo)?$mezclainsu->id_insumo:old('id_insumo'.$i) }}" autofocus> 
                                            <option value="">Seleccionar insumo</option>
                                            @foreach($insumos as $insumo)
                                                @if($insumo->id == $mezclainsu->id_insumo)
                                                    <option value="{{ $insumo->id }}" selected>{{ $insumo->nombre }} </option>
                                                @else
                                                    <option value="{{ $insumo->id }}">{{ $insumo->nombre }} </option>
                                                @endif
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
                                        <input id="cantidad{{ $i }}" type="number" step="0.01" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}" value="{{ isset($mezclainsu->cantidad)?$mezclainsu->cantidad:old('cantidad'.$i) }}" autocomplete="cantidad{{ $i }}" autofocus>

                                        @error('cantidad{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @can('haveaccess','mezcla_insu.destroy')
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button class="btn btn-danger beliminar" id="{{ $mezclainsu->id }}" name="{{ $mezcla->id }}">Eliminar insumo</button>
                                        </div>
                                    </div>
                                @endcan
                                <hr>
                                @php
                                    $i++;
                                @endphp
                        @endforeach
                            <hr>
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="guardar" class="btn btn-success">
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
document.addEventListener("DOMContentLoaded", function(e) {

var elBotones = document.querySelectorAll("button");
console.log(elBotones);

/*Asignamos  función para escuchar*/
for (var i = 0; i < elBotones.length; i++) {
  elBotones[i].addEventListener("click", manejarBotones, false)
}


});

/*Podremos usar  this.id  para identificar cada botón*/
function manejarBotones(e) {
    e.preventDefault();
        var id_insumo = $(this).attr('id');
        var id_mezcla = $(this).attr('name');
        var _token = $('input[name="_token"]').val();
        if(id_insumo == 'guardar'){
            formulario1.submit();
        } else {
        var opcion = confirm('¿Esta seguro que desea eliminar el insumo de la mezcla de tanque?');
            if (opcion == true) {
                $.ajax({
                    url:"{{ route('mezcla.destroyinsumo') }}",
                    method:"POST",
                    data:{_token:_token, id_insumo:id_insumo, id_mezcla:id_mezcla},
                    success:function(data)
                    {
                        window.location = data.url
                    },
                })
            }
        }
}
            
</script>
@endsection