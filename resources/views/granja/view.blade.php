@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Granja</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('id_organizacion') is-invalid @enderror" data-live-search="true" name="id_organizacion" id="id_organizacion" value="{{ old('id_organizacion') }}" title="Seleccionar Organizacion" disabled autofocus> 
                                        @isset($organizacionshow)
                                            <option value="{{ $organizacionshow->id }}" data-subtext="{{ $organizacionshow->InscOrga == 'SI' ? 'Monitoreado':'' }}" selected>{{ $organizacionshow->NombOrga }} </option>
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
                                <label for="cliente" class="col-md-4 col-form-label text-md-right">{{ __('Cliente') }} *</label>
                                <div class="col-md-6">
                                <select class="form-control @error('cliente') is-invalid @enderror" name="cliente" id="cliente" value="{{ old('cliente') }}" disabled autofocus> 
                                    @isset($cliente)
                                            <option value="{{ $cliente->id }}" selected>{{ $cliente->nombre }} </option>
                                    @endif
                                </select>
                                    @error('cliente')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Granja') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($granja->nombre)?$granja->nombre:old('nombre') }}" disabled autocomplete="nombre" autofocus>
    
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('granja.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','granja.edit')
                            <a href="{{ route('granja.edit',$granja->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','granja.destroy')
                            <form action="{{ route('antena.destroy',$granja->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                            </form>
                            @endcan
                            </div> 
                            </div> 
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection