@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Alerta</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf

                    <div class="form-group row">
                        <label for="NombOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>

                        <div class="col-md-6">
                            <input id="NombOrga" type="text" class="form-control @error('NombOrga') is-invalid @enderror" name="NombOrga" value="{{ isset($alerta->NombOrga)?$alerta->NombOrga:old('NombOrga') }}" disabled autocomplete="NombOrga" autofocus>

                            @error('NombOrga')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>

                        <div class="col-md-6">
                            <input id="sucursal" type="text" class="form-control @error('sucursal') is-invalid @enderror" name="sucursal" value="{{ isset($alerta->NombSucu)?$alerta->NombSucu:old('NombSucu') }}" disabled autocomplete="NombSucu" autofocus>

                            @error('sucursal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 
                
                    <div class="form-group row">
                        <label for="fecha" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }}</label>

                        <div class="col-md-6">
                            <input id="fecha" type="text" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ isset($alerta->fecha)?date('d/m/Y',strtotime($alerta->fecha)):old('fecha') }}" disabled autocomplete="fecha" autofocus>

                            @error('fecha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="hora" class="col-md-4 col-form-label text-md-right">{{ __('Hora') }}</label>

                        <div class="col-md-6">
                            <input id="hora" type="text" class="form-control @error('hora') is-invalid @enderror" name="hora" value="{{  isset($alerta->hora)?$alerta->hora:old('hora') }}" disabled autocomplete="hora" autofocus>

                            @error('hora')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-6">
                                <img class="img img-responsive" src="/imagenes/{{ $alerta->TipoMaq }}.png" height="30px"> <b>{{ $alerta->ModeMaq }} </b>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="anio" class="col-md-4 col-form-label text-md-right">{{ __('Año') }}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control @error('anio') is-invalid @enderror" value="{{  isset($alerta->anio)?$alerta->anio:old('anio') }}" disabled autofocus>

                            @error('anio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="horasm" class="col-md-4 col-form-label text-md-right">{{ __('Horas de motor') }}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control @error('horasm') is-invalid @enderror" value="{{  isset($alerta->horas)?$alerta->horas:old('horas') }}" disabled autofocus>

                            @error('horasm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ isset($alerta->nombre)?$alerta->nombre:old('nombre') }}" disabled autocomplete="nombre" autofocus>

                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="pin" class="col-md-4 col-form-label text-md-right">{{ __('PIN') }}</label>

                        <div class="col-md-6">
                            <input id="pin" type="text" class="form-control @error('pin') is-invalid @enderror" name="pin" value="{{ isset($alerta->pin)?$alerta->pin:old('pin') }}" disabled autocomplete="pin" autofocus>

                            @error('pin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }}</label>

                        <div class="col-md-6">
                            @php
                            /* TRADUCTOR DE INGLES A ESPAÑOL
                                $textt = $alerta->descripcion;
                                try {
                                    $json = file_get_contents('https://api.mymemory.translated.net/get?q='.urlencode($textt).'&langpair=en|es'); 
                                    if (!empty($json)) { 
                                        $obj = json_decode($json);
                                    }  
                                } catch (Throwable $e) {
                                
                                } */
                            @endphp
                            <textarea id="descripcion" class="form-control-textarea @error('DescAsis') is-invalid @enderror" name="descripcion" disabled autocomplete="descripcion" autofocus rows="12">{{  isset($alerta->descripcion)?$alerta->descripcion:old('descripcion') }}</textarea>

                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 

                    @isset($alerta->lat)
                        @isset($alerta->lon)
                            <div class="form-group row">
                                <label for="ubicacion" class="col-md-4 col-form-label text-md-right">{{ __('Ubicación') }}</label>
                                <div class="col-md-6">
                                    <iframe class="iframe" src="https://maps.google.com/?q={{ $alerta->lat }},{{ $alerta->lon }}&z=14&t=k&output=embed" height="400" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                                </div>
                            </div>
                        @endisset
                    @endisset
                    
                    <div class="form-group row">
                        <label for="accion" class="col-md-4 col-form-label text-md-right">{{ __('Acción tomada por el concesionario') }}</label>

                        <div class="col-md-6">
                            <textarea id="accion" class="form-control-textarea @error('accion') is-invalid @enderror" name="accion" disabled autocomplete="accion" autofocus rows="8">{{ isset($alerta->accion)?$alerta->accion:old('accion') }}</textarea>

                            @error('accion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="id_useraccion" class="col-md-4 col-form-label text-md-right">{{ __('Acción tomada por') }}</label>

                        <div class="col-md-6">
                            <input id="id_useraccion" type="text" class="form-control @error('id_useraccion') is-invalid @enderror" name="id_useraccion" value="{{ isset($alerta->last_name)?$alerta->name.' '.$alerta->last_name:old('id_useraccion') }}" disabled autocomplete="id_useraccion" autofocus>

                            @error('id_useraccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="tiempo_alertas" class="col-md-4 col-form-label text-md-right">{{ __('Tiempo que dispone para soporte de alertas (minutos)') }}</label>

                        <div class="col-md-6">
                            <input id="tiempo_alertas" type="number" class="form-control" name="tiempo_alertas" value="{{ isset($jdlink->tiempo_alertas)?$jdlink->tiempo_alertas:old('tiempo_alertas') }}" disabled>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="tiempo_destinado" class="col-md-4 col-form-label text-md-right">{{ __('Tiempo de soporte destinado (minutos)') }}</label>

                        <div class="col-md-6">
                            <input id="tiempo_destinado" type="number" class="form-control" name="tiempo_destinado" value="{{ isset($alerta->tiempo_destinado)?$alerta->tiempo_destinado:old('tiempo_destinado') }}" disabled>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="presupuesto" class="col-md-4 col-form-label text-md-right">{{ __('N° Presupuesto') }}</label>

                        <div class="col-md-6">
                            <input id="presupuesto" type="number" class="form-control @error('presupuesto') is-invalid @enderror" name="presupuesto" value="{{ isset($alerta->presupuesto)?$alerta->presupuesto:old('presupuesto') }}" disabled autocomplete="presupuesto" autofocus>

                            @error('presupuesto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cor" class="col-md-4 col-form-label text-md-right">{{ __('N° COR') }}</label>

                        <div class="col-md-6">
                            <input id="cor" type="number" class="form-control @error('cor') is-invalid @enderror" name="cor" value="{{ isset($alerta->cor)?$alerta->cor:old('cor') }}" disabled autocomplete="cor" autofocus>

                            @error('cor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('alerta.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','alerta.edit')
                            <a href="{{ route('alerta.edit',$alerta->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','alerta.destroy')
                            <form action="{{ route('alerta.destroy',$alerta->id) }}" method="post">
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