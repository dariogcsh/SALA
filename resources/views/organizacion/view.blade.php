@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Organización</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }}</label>

                            <div class="col-md-6">
                                <input id="CodiOrga" type="number" class="form-control @error('CodiOrga') is-invalid @enderror" name="CodiOrga" value="{{ isset($organizacion->CodiOrga)?$organizacion->CodiOrga:old('CodiOrga') }}" disabled autocomplete="CodiOrga" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="CUIT" class="col-md-4 col-form-label text-md-right">{{ __('CUIT') }}</label>

                            <div class="col-md-6">
                                <input id="CUIT" type="number" class="form-control @error('CUIT') is-invalid @enderror" name="CUIT" value="{{ isset($organizacion->CUIT)?$organizacion->CUIT:old('CUIT') }}" disabled autocomplete="CUIT" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="NombOrga" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="NombOrga" type="text" class="form-control @error('NombOrga') is-invalid @enderror" name="NombOrga" value="{{ isset($organizacion->NombOrga)?$organizacion->NombOrga:old('NombOrga') }}" disabled autocomplete="NombOrga" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="CodiSucu" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>
                                <div class="col-md-6">
                                    <select name="CodiSucu" id="CodiSucu" class="form-control" disabled>
                                        @foreach($sucursals as $sucursal)
                                        <option value="{{ $sucursal->id }}"
                                        @isset($organizacion->sucursals->NombSucu)
                                            @if($sucursal->NombSucu == $organizacion->sucursals->NombSucu)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $sucursal->NombSucu }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="InscOrga" class="col-md-4 col-form-label text-md-right">{{ __('Monitoreado') }}</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('InscOrga') is-invalid @enderror" data-live-search="true" name="InscOrga" value="{{ old('InscOrga') }}" disabled autocomplete="InscOrga" autofocus>
                                    @isset($organizacion->InscOrga)
                                                @if($organizacion->InscOrga == 'NO')
                                                <option value="NO" selected>NO</option>
                                                <option value="SI">SI</option>
                                                @else
                                                <option value="NO">NO</option>
                                                <option value="SI" selected>SI</option>
                                                @endif
                                    @else
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                    @endisset
                                    
                                    <option value="SI">SI</option>
                                </select>
                            </div>
                        </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('organizacion.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','organizacion.edit')
                            <a href="{{ route('organizacion.edit',$organizacion->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','organizacion.destroy')
                            <form action="{{ route('organizacion.destroy',$organizacion->id) }}" method="post">
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