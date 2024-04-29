@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Maquina</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                        <div class="form-group row">
                            <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('CodiOrga') }}</label>

                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('CodiOrga') is-invalid @enderror" data-live-search="true" name="CodiOrga" value="{{ isset($organizacion->CodiOrga)?$organizacion->CodiOrga:old('CodiOrga') }}" disabled>
                                <option value="">Seleccionar Organización</option>
                                @foreach ($organizacions as $organizacion)
                                    <option value="{{ $organizacion->CodiOrga }}" 
                                    @isset($maquina->organizacions->NombOrga)
                                            @if($organizacion->NombOrga == $maquina->organizacions->NombOrga)
                                                selected
                                            @endif
                                    @endisset
                                        >{{ $organizacion->NombOrga }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="TipoMaq" class="col-md-4 col-form-label text-md-right">{{ __('TipoMaq') }}</label>

                            <div class="col-md-6">
                            <select class="selectpicker form-control @error('TipoMaq') is-invalid @enderror" data-live-search="true" name="TipoMaq" value="{{ isset($maquina->TipoMaq)?$maquina->TipoMaq:old('TipoMaq') }}" disabled>
                                @isset($maquina->TipoMaq)
                                    <option value="{{ $maquina->TipoMaq }}">{{ $maquina->TipoMaq }}</option>
                                @else
                                    <option value="">Seleccionar tipo de maquina</option>
                                @endisset
                                    <option value="COSECHADORA">COSECHADORA</option>
                                    <option value="TRACTOR">TRACTOR</option>
                                    <option value="PULVERIZADORA">PULVERIZADORA</option>
                                    <option value="PICADORA">PICADORA</option>
                                    <option value="SEMBRADORA">SEMBRADORA</option>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="MarcMaq" class="col-md-4 col-form-label text-md-right">{{ __('MarcMaq') }}</label>

                            <div class="col-md-6">
                                <select class="selectpicker form-control @error('MarcMaq') is-invalid @enderror" data-live-search="true" name="MarcMaq" value="{{ isset($maquina->MarcMaq)?$maquina->MarcMaq:old('MarcMaq') }}" disabled>
                                @isset($maquina->MarcMaq)
                                    <option value="{{ $maquina->MarcMaq }}">{{ $maquina->MarcMaq }}</option>
                                @else
                                    <option value="">Seleccionar la marca</option>
                                @endisset
                                    <option value="JOHN DEERE">JOHN DEERE</option>
                                    <option value="MASSEY FERGUSON">MASSEY FERGUSON</option>
                                    <option value="CASE IH">CASE IH</option>
                                    <option value="NEW HOLLAND">NEW HOLLAND</option>
                                    <option value="DEUTZ - FAHR">DEUTZ - FAHR</option>
                                    <option value="AGCO ALLIS">AGCO ALLIS</option>
                                    <option value="OTRA">OTRA</option>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="idjdlink" class="col-md-4 col-form-label text-md-right">{{ __('idjdlink') }}</label>

                            <div class="col-md-6">
                                <input id="idjdlink" type="text" class="form-control @error('idjdlink') is-invalid @enderror" name="idjdlink" value="{{ isset($maquina->idjdlink)?$maquina->idjdlink:old('idjdlink') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ModeMaq" class="col-md-4 col-form-label text-md-right">{{ __('ModeMaq') }}</label>

                            <div class="col-md-6">
                                <input id="ModeMaq" type="text" class="form-control @error('ModeMaq') is-invalid @enderror" name="ModeMaq" value="{{ isset($maquina->ModeMaq)?$maquina->ModeMaq:old('ModeMaq') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="anio" class="col-md-4 col-form-label text-md-right">{{ __('Año') }}</label>

                            <div class="col-md-6">
                                <input id="anio" type="text" class="form-control @error('anio') is-invalid @enderror" name="anio" value="{{ isset($maquina->anio)?$maquina->anio:old('anio') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de máquina') }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($maquina->nombre)?$maquina->nombre:old('nombre') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie de máquina') }}</label>

                            <div class="col-md-6">
                                <input id="NumSMaq" type="text" class="form-control @error('NumSMaq') is-invalid @enderror" name="NumSMaq" value="{{ isset($maquina->NumSMaq)?$maquina->NumSMaq:old('NumSMaq') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nseriemotor" class="col-md-4 col-form-label text-md-right">{{ __('N° de serie de motor') }}</label>

                            <div class="col-md-6">
                                <input id="nseriemotor" type="text" class="form-control @error('nseriemotor') is-invalid @enderror" name="nseriemotor" value="{{ isset($maquina->nseriemotor)?$maquina->nseriemotor:old('nseriemotor') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor') }}</label>

                            <div class="col-md-6">
                                <input id="horas" type="text" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($maquina->horas)?$maquina->horas:old('horas') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de toma de horas de motor') }}</label>

                            <div class="col-md-6">
                                <input id="horas" type="text" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($maquina->fecha)?date('d/m/Y',strtotime($maquina->fecha)):old('fecha') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="harvest_smart" class="col-md-4 col-form-label text-md-right">{{ __('Harvest Smart') }}</label>

                            <div class="col-md-6">
                                <input id="harvest_smart" type="text" class="form-control @error('harvest_smart') is-invalid @enderror" name="harvest_smart" value="{{ isset($maquina->harvest_smart)?$maquina->harvest_smart:old('harvest_smart') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="combine_advisor" class="col-md-4 col-form-label text-md-right">{{ __('Combine Advisor') }}</label>

                            <div class="col-md-6">
                                <input id="combine_advisor" type="text" class="form-control @error('combine_advisor') is-invalid @enderror" name="combine_advisor" value="{{ isset($maquina->combine_advisor)?$maquina->combine_advisor:old('combine_advisor') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Hsemana" class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor en la última semana') }}</label>

                            <div class="col-md-6">
                                <input id="Hsemana" type="text" class="form-control @error('Hsemana') is-invalid @enderror" name="Hsemana" value="{{ isset($maquina->Hsemana)?$maquina->Hsemana:old('Hsemana') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ethernet" class="col-md-4 col-form-label text-md-right">{{ __('Estado de ethernet') }}</label>

                            <div class="col-md-6">
                                <input id="ethernet" type="text" class="form-control @error('ethernet') is-invalid @enderror" name="ethernet" value="{{ isset($maquina->ethernet)?$maquina->ethernet:old('ethernet') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="CantPMaq" class="col-md-4 col-form-label text-md-right">{{ __('CanPMaq') }}</label>

                            <div class="col-md-6">
                                <input id="CanPMaq" type="number" class="form-control @error('CanPMaq') is-invalid @enderror" name="CanPMaq" value="{{ isset($maquina->CanPMaq)?$maquina->CanPMaq:old('CanPMaq') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="MaicMaq" class="col-md-4 col-form-label text-md-right">{{ __('MaicMaq') }}</label>

                            <div class="col-md-6">
                                <input id="MaicMaq" type="number" step="0.01" class="form-control @error('MaicMaq') is-invalid @enderror" name="MaicMaq" value="{{ isset($maquina->MaicMaq)?$maquina->MaicMaq:old('MaicMaq') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="InscMaq" class="col-md-4 col-form-label text-md-right">{{ __('Monitoreado') }}</label>

                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('InscMaq') is-invalid @enderror" data-live-search="true" name="InscMaq" value="{{ old('InscMaq') }}" disabled autocomplete="InscMaq">
                                        @isset($maquina->InscMaq)
                                                    @if($maquina->InscMaq == 'NO')
                                                    <option value="NO" selected>NO</option>
                                                    <option value="SI">SI</option>
                                                    @elseif($maquina->InscMaq == 'SI')
                                                    <option value="NO">NO</option>
                                                    <option value="SI" selected>SI</option>
                                                    @endif
                                        @else
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            @isset($ubicacion->lat)
                                @isset($ubicacion->lon)
                                    <div class="form-group row">
                                        <label for="ubicacion" class="col-md-4 col-form-label text-md-right">{{ __('Ubicación') }}</label>
                                        <div class="col-md-6">
                                            <iframe class="iframe" src="https://maps.google.com/?q={{ $ubicacion->lat }},{{ $ubicacion->lon }}&z=14&t=k&output=embed" height="400" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de toma de ubicación') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="fecha" type="text" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($ubicacion->fecha)?date('d/m/Y',strtotime($ubicacion->fecha)):old('fecha') }}" readonly>
                                        </div>
                                    </div>
                                @endisset
                            @endisset


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('maquina.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','maquina.edit'||'haveaccess','maquinaown.edit')
                            <a href="{{ route('maquina.edit',$maquina->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','maquina.destroy')
                            <form action="{{ route('maquina.destroy',$maquina->id) }}" method="post">
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