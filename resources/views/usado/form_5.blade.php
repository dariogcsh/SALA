<div class="form-group row">
    <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio de venta (US$)') }} </label>

    <div class="col-md-6">
        @can('haveaccess','usado_precio.edit')
            <input id="precio" type="number" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ isset($usado->precio)?$usado->precio:old('precio') }}" autofocus>
        @else
            <input id="precio" type="number" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ isset($usado->precio)?$usado->precio:old('precio') }}" disabled autofocus>
        @endcan
        <span class="text-danger" id="precioError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="ingreso" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de posible ingreso') }} *</label>

    <div class="col-md-6">
        <input id="ingreso" type="date" class="form-control @error('ingreso') is-invalid @enderror" name="ingreso" value="{{ isset($usado->ingreso)?$usado->ingreso:old('ingreso') }}" autofocus>

        <span class="text-danger" id="ingresoError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="id_sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Ubicacion') }} *</label>

    <div class="col-md-6">
        <select class="form-control @error('id_sucursal') is-invalid @enderror" id="id_sucursal" name="id_sucursal" value="{{ isset($usado->id_sucursal)?$usado->id_sucursal:old('id_sucursal') }}" required autocomplete="id_sucursal" autofocus>
            <option value="">Seleccionar</option>
            @foreach ($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}" 
                @isset($usado->id_sucursal)
                        @if($sucursal->id == $usado->id_sucursal)
                            selected
                        @endif
                @endisset
                >
                @if($sucursal->NombSucu == "Otra")
                    Cliente
                @else
                    {{ $sucursal->NombSucu }}
                @endif
                    </option>
            @endforeach
        </select>
        <span class="text-danger" id="id_sucursalError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="comentarios" class="col-md-4 col-form-label text-md-right">{{ __('Comentarios') }}</label>

    <div class="col-md-6">
        <textarea id="comentarios" class="form-control-textarea @error('comentarios') is-invalid @enderror" name="comentarios" autocomplete="comentarios" autofocus>{{ isset($usado->comentarios)?$usado->comentarios:old('comentarios') }}</textarea>

        <span class="text-danger" id="comentariosError"></span>
    </div>
</div> 

<div class="form-group row">
    <label for="excliente" class="col-md-4 col-form-label text-md-right">{{ __('Ex dueño') }} *</label>

    <div class="col-md-6">
        <input id="excliente" type="text" class="form-control @error('excliente') is-invalid @enderror" name="excliente" value="{{ isset($usado->excliente)?$usado->excliente:old('excliente') }}" autofocus>

        <span class="text-danger" id="exclienteError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="precio_reparacion" class="col-md-4 col-form-label text-md-right">{{ __('Precio de reparacion (US$)') }} </label>

    <div class="col-md-6">
        @can('haveaccess','usado_precio.edit')
            <input id="precio_reparacion" type="number" class="form-control @error('precio_reparacion') is-invalid @enderror" name="precio_reparacion" value="{{ isset($usado->precio_reparacion)?$usado->precio_reparacion:old('precio_reparacion') }}" autofocus>
        @else
            <input id="precio_reparacion" type="number" class="form-control @error('precio_reparacion') is-invalid @enderror" name="precio_reparacion" value="{{ isset($usado->precio_reparacion)?$usado->precio_reparacion:old('precio_reparacion') }}" disabled autofocus>
        @endcan
        <span class="text-danger" id="precio_reparacionError"></span>
    </div>
</div>

<div class="form-group row">
    <label for="comentario_reparacion" class="col-md-4 col-form-label text-md-right">{{ __('Comentarios de reparación') }}</label>

    <div class="col-md-6">
        <textarea id="comentario_reparacion" class="form-control-textarea @error('comentario_reparacion') is-invalid @enderror" name="comentario_reparacion" autocomplete="comentario_reparacion" autofocus>{{ isset($usado->comentario_reparacion)?$usado->comentario_reparacion:old('comentario_reparacion') }}</textarea>

        <span class="text-danger" id="comentariosError"></span>
    </div>
</div> 

<div class="form-group row">
    <label for="id_vendedor" class="col-md-4 col-form-label text-md-right">{{ __('Vendedor que tomó el usado') }} *</label>

    <div class="col-md-6">
        <select class="form-control @error('id_vendedor') is-invalid @enderror" id="id_vendedor" name="id_vendedor" value="{{ isset($vendedor->id_vendedor)?$vendedor->id_vendedor:old('id_vendedor') }}" required autocomplete="id_vendedor" autofocus>
            <option value="">Seleccionar</option>
            @foreach ($vendedores as $vendedor)
                <option value="{{ $vendedor->id }}" 
                @isset($usado->id_vendedor)
                        @if($vendedor->id == $usado->id_vendedor)
                            selected
                        @endif
                @endisset
                    >{{ $vendedor->last_name }} {{ $vendedor->name }}</option>
            @endforeach
        </select>
        <span class="text-danger" id="id_vendedorError"></span>
    </div>
</div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="btn-paso5" class="btn btn-success">
            {{ $modo=='crear' ? __('Terminar'):__('Guardar cambios') }}
            </button>
        </div>
    </div>
