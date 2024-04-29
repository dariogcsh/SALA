@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Paquete agronómico</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organización') }}</label>

                                <div class="col-md-6">
                                    <input id="id_organizacion" type="text" class="form-control" name="id_organizacion" value="{{ $organizacion->NombOrga }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="maquinas" class="col-md-4 col-form-label text-md-right">{{ __('Maquinas monitoreadas') }}</label>

                                <div class="col-md-6">
                                    <input id="maquinas" type="text" class="form-control" name="maquinas" value="@foreach ($maquinas as $maquina){{$maquina->ModeMaq}} - @endforeach" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="anofiscal" class="col-md-4 col-form-label text-md-right">{{ __('Año fiscal') }}</label>

                                <div class="col-md-6">
                                    <input id="anofiscal" type="text" class="form-control" name="anofiscal" value="{{ $paqueteagronomico->anofiscal }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="altimetria" class="col-md-4 col-form-label text-md-right">{{ __('Altimetría') }}</label>

                                <div class="col-md-6">
                                    <input id="altimetria" type="text" class="form-control" name="altimetria" value="{{ $paqueteagronomico->altimetria }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="suelo" class="col-md-4 col-form-label text-md-right">{{ __('Suelo') }}</label>

                                <div class="col-md-6">
                                    <input id="suelo" type="text" class="form-control" name="suelo" value="{{ $paqueteagronomico->suelo }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="compactacion" class="col-md-4 col-form-label text-md-right">{{ __('Compactación') }}</label>

                                <div class="col-md-6">
                                    <input id="compactacion" type="text" class="form-control" name="compactacion" value="{{ $paqueteagronomico->compactacion }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="vencimiento" class="col-md-4 col-form-label text-md-right">{{ __('Vencimiento') }}</label>

                                <div class="col-md-6">
                                    <input id="vencimiento" type="date" class="form-control" name="vencimiento" value="{{ $paqueteagronomico->vencimiento }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="lotes" class="col-md-4 col-form-label text-md-right">{{ __('Lotes') }}</label>

                                <div class="col-md-6">
                                    <input id="lotes" type="text" class="form-control" name="lotes" value="{{ $paqueteagronomico->hectareas }}" disabled>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="hectareas" class="col-md-4 col-form-label text-md-right">{{ __('Hectáreas') }}</label>

                                <div class="col-md-6">
                                    <input id="hectareas" type="text" class="form-control" name="hectareas" value="{{ $paqueteagronomico->hectareas }}" disabled>
                                </div>
                            </div> 
                        
                            <div class="form-group row">
                                <label for="costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo') }}</label>

                                <div class="col-md-6">
                                    <input id="costo" type="text" class="form-control" name="costo" value="{{ $paqueteagronomico->costo }}" disabled>
                                </div>
                            </div> 
                        


                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('paqueteagronomico.index') }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','paqueteagronomico.edit')
                                        <a href="{{ route('paqueteagronomico.edit',$paqueteagronomico->id) }}" class="btn btn-warning btn-block">Editar</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','paqueteagronomico.destroy')
                                    <form action="{{ route('paqueteagronomico.destroy',$paqueteagronomico->id) }}" method="post">
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