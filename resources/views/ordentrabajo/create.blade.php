@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Órden de trabajo nueva') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/ordentrabajo') }}">
                        @csrf
                        <p><small> Los campos marcados con * son de caracter obligatorio</small></p>
                        <input type="text" hidden value="{{ $organizacion }}" id="id_organizacion" name="id_organizacion"> 
                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de trabajo') }} *</label>

                            <div class="col-md-6">
                                <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ old('tipo') }}" required autofocus> 
                                    @isset($ordentrabajo->tipo)
                                        @if($ordentrabajo->tipo == "Siembra")
                                            <option value="Siembra" selected>Siembra</option>
                                            <option value="Fertilizacion">Fertilizacion</option>
                                            <option value="Aplicacion">Aplicacion</option>
                                            <option value="Cosecha">Cosecha</option>
                                        @elseif($ordentrabajo->tipo == "Fertilizacion")
                                            <option value="Siembra">Siembra</option>
                                            <option value="Fertilizacion" selected>Fertilizacion</option>
                                            <option value="Aplicacion">Aplicacion</option>
                                            <option value="Cosecha">Cosecha</option>
                                        @elseif($ordentrabajo->tipo == "Aplicacion")
                                            <option value="Siembra">Siembra</option>
                                            <option value="Fertilizacion">Fertilizacion</option>
                                            <option value="Aplicacion" selected>Aplicacion</option>
                                            <option value="Cosecha">Cosecha</option>
                                        @else
                                            <option value="Siembra">Siembra</option>
                                            <option value="Fertilizacion">Fertilizacion</option>
                                            <option value="Aplicacion">Aplicacion</option>
                                            <option value="Cosecha" selected>Cosecha</option>
                                        @endif
                                    @else
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Siembra">Siembra</option>
                                        <option value="Fertilizacion">Fertilizacion</option>
                                        <option value="Aplicacion">Aplicacion</option>
                                        <option value="Cosecha">Cosecha</option>
                                    @endisset
                                </select>

                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="id_lote" class="col-md-4 col-form-label text-md-right">{{ __('Lote') }} *</label>
                            
                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_usuariotrabajo') is-invalid @enderror" data-live-search="true" id="id_lote" name="id_lote" value="{{ isset($ordentrabajo->id_usuariotrabajo)?$ordentrabajo->id_usuariotrabajo:old('id_usuariotrabajo') }}" required autocomplete="id_usuariotrabajo" autofocus>
                                    <option value="">Seleccionar lote</option>
                                    @foreach ($lotes as $lote)
                                        <option value="{{ $lote->id }}" data-subtext="{{ $lote->client }} - {{ $lote->farm }}"
                                        @isset($lotetrabajo->id)
                                                @if($lote->id == $lotetrabajo->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $lote->name }}</option>
                                    @endforeach
                                </select>
                                @error('id_lote')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @can('haveaccess','ordentrabajo.create')
                            <div class="col-md-2">
                                <a href="{{ route('lote.create') }}" title="Crear máquina nueva" class="btn btn-warning float-left" onclick="return confirm('¿Desea crear un lote nuevo y salir de la orden de trabajo?');"><b>+</b></a>
                            </div>
                            @endcan
                            
                        </div>
                        
                        <div class="form-group row">
                            <label for="id_usuarioorden" class="col-md-4 col-form-label text-md-right">{{ __('Usuario emisor de órden de trabajo') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('id_usuarioorden') is-invalid @enderror" id="id_usuarioorden" name="id_usuarioorden" value="{{ old('id_usuarioorden') }}" readonly autofocus> 
                                    <option value="{{ $usuarioorden->id }}" selected>{{ $usuarioorden->last_name }} {{ $usuarioorden->name }}</option>
                                </select>

                                @error('id_usuarioorden')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_usuariotrabajo" class="col-md-4 col-form-label text-md-right">{{ __('Usuario receptor de órden de trabajo') }} *</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('id_usuariotrabajo') is-invalid @enderror" data-live-search="true" id="id_usuariotrabajo" name="id_usuariotrabajo" value="{{ isset($ordentrabajo->id_usuariotrabajo)?$ordentrabajo->id_usuariotrabajo:old('id_usuariotrabajo') }}" required autocomplete="id_usuariotrabajo" autofocus>
                                    <option value="">Seleccionar usuario</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                        @isset($usuariotrabajo->id)
                                                @if($usuario->id == $usuariotrabajo->id)
                                                    selected
                                                @endif
                                        @endisset
                                            >{{ $usuario->last_name }} {{ $usuario->name }}</option>
                                    @endforeach
                                </select>
                                @error('id_usuariotrabajo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fechaindicada" class="col-md-4 col-form-label text-md-right">{{ __('Fecha indicada') }}</label>

                            <div class="col-md-6">
                                <input id="fechaindicada" type="date" class="form-control @error('fechaindicada') is-invalid @enderror" id="fechaindicada" name="fechaindicada" value="{{ isset($orden->fechaindicada)?$orden->fechaindicada:old('fechaindicada') }}" autofocus>

                                @error('fechaindicada')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="has" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de hectáreas') }}</label>

                            <div class="col-md-6">
                                <input id="has" type="number" step="0.01" class="form-control @error('has') is-invalid @enderror" id="has" name="has" value="{{ isset($orden->has)?$orden->has:old('has') }}" autofocus>

                                @error('has')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prescripcion" class="col-md-4 col-form-label text-md-right">{{ __('Prescripción') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="prescripcion" id="prescripcion" onchange="javascript:mostrarInput()">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dosis_variable" class="col-md-4 col-form-label text-md-right">{{ __('Dosis variable') }}</label>

                            <div class="col-md-6">
                                <label class="switch">
                                    <input type="checkbox" class="warning" name="dosis_variable" id="dosis_variable" onchange="javascript:mostrarInput()">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <br>
                        <h4>Insumos</h4>
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

                                    <div class="col-md-4">
                                        <input id="cantidad{{ $i }}" type="number" step="0.01" class="form-control @error('cantidad{{ $i }}') is-invalid @enderror" name="cantidad{{ $i }}" value="{{ isset($mezcla->cantidad)?$mezcla->cantidad:old('cantidad'.$i) }}" autocomplete="cantidad{{ $i }}" autofocus>

                                        @error('cantidad{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control @error('unidades_medidas{{ $i }}') is-invalid @enderror" id="unidades_medidas{{ $i }}" name="unidades_medidas{{ $i }}" value="{{ old('unidades_medidas'.$i) }}" required autofocus> 
                                            
                                            <option value="semillas/ha">semillas/ha</option>
                                            <option value="lts/ha">lts/ha</option>
                                            <option value="kg/ha">kg/ha</option>
                                        </select>
                                        @error('unidades_medidas{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div id='insu_variable{{ $i }}' style='display: none'>
                                    <div class="form-group row">
                                        <label for="has_variable{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad hectáreas') }}</label>

                                        <div class="col-md-4">
                                            <input id="has_variable{{ $i }}" type="number" class="form-control @error('has_variable{{ $i }}') is-invalid @enderror" name="has_variable{{ $i }}" value="{{ isset($mezcla->has_variable)?$mezcla->has_variable:old('has_variable'.$i) }}" autocomplete="has_variable{{ $i }}" autofocus>

                                            @error('has_variable{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
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
                        <br>
                        <h4>Mezclas de tanque</h4>
                        <hr>
                        @for($i = 1; $i <= 20; $i++)
                            @if ($i == 1)
                                <div id='mez{{ $i }}' style='display: block'>
                            @else
                                <div id='mez{{ $i }}' style='display: none'>
                            @endif
                            
                                <div class="form-group row">
                                    <label for="id_mezcla{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Mezcla de tanque') }}</label>

                                    <div class="col-md-6">
                                        <select class="selectpicker form-control @error('id_mezcla{{ $i }}') is-invalid @enderror" data-live-search="true" id="{{ $i }}" name="id_mezcla{{ $i }}" value="{{ old('id_mezcla'.$i) }}" autofocus> 
                                            <option value="">Seleccionar mezcla de tanque</option>
                                            @foreach($mezclas as $mezcla)
                                                <option value="{{ $mezcla->id }}">{{ $mezcla->nombre }} </option>
                                            @endforeach
                                        </select>

                                        @error('id_mezcla{{ $i }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div id='insumez{{ $i }}' style='display: none'></div>
                                <div id='insumos{{ $i }}' name='insumos{{ $i }}'></div>

                                <div id='mez_variable{{ $i }}' style='display: none'>
                                    <div class="form-group row">
                                        <label for="has_variable_mez{{ $i }}" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad hectáreas') }}</label>

                                        <div class="col-md-4">
                                            <input id="has_variable_mez{{ $i }}" type="number" class="form-control @error('has_variable_mez{{ $i }}') is-invalid @enderror" name="has_variable_mez{{ $i }}" value="{{ isset($mezcla->has_variable_mez)?$mezcla->has_variable_mez:old('has_variable_mez'.$i) }}" autocomplete="has_variable_mez{{ $i }}" autofocus>

                                            @error('has_variable_mez{{ $i }}')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @if($i <> 20)
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <a class="btn btn-warning" id="otrom{{ $i }}">Agregar otro</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endfor
                        
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ __('Crear') }}
                                  
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
    var i = 1;
    for (let i = 1; i < 21; i++) {
        $( "#otrom"+i ).click(function() {
            i=i+1;
            mez = document.getElementById("mez"+i);

            mez.style.display = 'block';
            this.style.display = 'none';
        });   
    }

    $('#id_lote').on('change', function() {
        if ($(this).val() != ''){ 
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            
            $.ajax({
                url:"{{ route('ordentrabajo.has_lote') }}",
                method:"POST",
                data:{_token:_token, value:value},
                success:function(data)
                {
                    //alert(data);
                    $('#has').val(data);
                },
                error:function(){
                    $('#has').val('');
                }
            })  
        }
    });

    //Si se selecciona una mezcla buscara los insumos que la componen y devolvera con la marca y cantidades tmbn
    $('select').on('change', function() {
            if ($(this).val() != ''){ 
                var iddiv = $(this).attr('id');
                var separador = iddiv.split('medidas');
                var separador2 = iddiv.split('ipo');
                var comparativa = separador[0];
                var comparativa2 = separador2[0];
                if((comparativa != 'unidades_') && (comparativa2 != 't')){
                    var nombrecampo = $(this).attr('name');
                    var value = $(this).val();         
                    var _token = $('input[name="_token"]').val(); 
                    $.ajax({
                        url:"{{ route('ordentrabajo.insumomezcla') }}",
                        method:"POST",
                        dataType: "json",
                        data:{nombrecampo:nombrecampo,value:value, _token:_token, iddiv:iddiv},
                        success:function(data)
                        {
                            if(data.datos == "Mezcla"){
                                $('#insumos'+iddiv).html('');
                                //Se recuperan los datos por JSON en un array y se cargan dentro de una table
                                var table = $('<table></table>').addClass('table table-hover')
                                    for (let index = 0; index < data.i; index++) {
                                        var row = $('<tr></tr>')
                                        table.append(row);
                                        var dato = $('<th><u>Marca</u></th>').text(data.nombremarca[index]); 
                                        table.append(dato);
                                        var dato = $('<th>Producto</th>').text(data.nombreinsu[index]); 
                                        table.append(dato);
                                        var dato = $('<th>lts/ha ó kg/ha</th>').text(data.cantidad[index]); 
                                        table.append(dato);
                                    }
                                    $('#insumos'+iddiv).append(table);
                            } else {
                                var cbox = data.unidades_medidas;
                                var did = data.id;
                                $('#unidades_medidas'+did).html(cbox); 
                            }
                        },
                        error:function(){
                            $('#insumos'+iddiv).html('');
                            alert("No se ha encontrado ningun insumo para la mezcla de tanque seleccionada");
                        }
                    })
                }
            } else {
                var iddiv = $(this).attr('id');
                $('#insumos'+iddiv).html('');
            }
    
        });

});

function mostrarInput() {
    check = document.getElementById("dosis_variable");
    var i = 1;
    for (let i = 1; i < 21; i++) {
        insumo_variable = document.getElementById("insu_variable"+i);
        mezcla_variable = document.getElementById("mez_variable"+i);
        if (check.checked) {
            insumo_variable.style.display='block';
            mezcla_variable.style.display='block';
        }
        else {
            insumo_variable.style.display='none';
            mezcla_variable.style.display='none';
        }
    }
}
</script>
@endsection