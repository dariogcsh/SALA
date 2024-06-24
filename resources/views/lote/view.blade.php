@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Lote</h2></div>

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
                                <label for="client" class="col-md-4 col-form-label text-md-right">{{ __('Cliente') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="client" type="text" class="form-control @error('client') is-invalid @enderror" name="client" value="{{ isset($lote->client)?$lote->client:old('client') }}" disabled autocomplete="client" autofocus>
    
                                    @error('client')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="farm" class="col-md-4 col-form-label text-md-right">{{ __('Granja') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="farm" type="text" class="form-control @error('farm') is-invalid @enderror" name="farm" value="{{ isset($lote->farm)?$lote->farm:old('farm') }}" disabled autocomplete="farm" autofocus>
    
                                    @error('farm')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Lote') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($lote->name)?$lote->name:old('name') }}" disabled autocomplete="name" autofocus>
    
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('lote.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','lote.edit')
                            <a href="{{ route('lote.edit',$lote->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','lote.destroy')
                            <form action="{{ route('lote.destroy',$lote->id) }}" method="post">
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