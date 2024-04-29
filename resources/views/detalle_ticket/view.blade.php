@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Tarea</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="fecha_inicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha inicio') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="fecha_inicio" type="datetime-local" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio" value="{{ isset($detalle_ticket->fecha_inicio)?$detalle_ticket->fecha_inicio:old('fecha_inicio') }}" disabled autocomplete="fecha_inicio" autofocus>
    
                                    @error('fecha_inicio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="fecha_fin" class="col-md-4 col-form-label text-md-right">{{ __('Fecha fin') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="fecha_fin" type="datetime-local" class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin" value="{{ isset($detalle_ticket->fecha_fin)?$detalle_ticket->fecha_fin:old('fecha_fin') }}" disabled autocomplete="fecha_fin" autofocus>
    
                                    @error('fecha_fin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="detalle" class="col-md-4 col-form-label text-md-right">{{ __('Comentario') }}</label>
    
                                <div class="col-md-6">
                                    <textarea id="detalle" class="form-control-textarea @error('detalle') is-invalid @enderror" name="detalle" value="{{ old('detalle') }}" autocomplete="detalle" disabled autofocus>{{ isset($detalle_ticket->detalle)?$detalle_ticket->detalle:old('detalle') }}</textarea>
    
                                    @error('detalle')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('ticket.show',$detalle_ticket->id_ticket) }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','ticket.edit')
                                    <a href="{{ route('detalle_ticket.edit',$detalle_ticket->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    @can('haveaccess','ticket.destroy')
                                        <form action="{{ route('detalle_ticket.destroy',$detalle_ticket->id) }}" method="post">
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