@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Ticket</h2></div>

                <div class="card-body">
                    @include('custom.message')
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="id_organizacion" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>
    
                                <div class="col-md-6">
                                    <input id="id_organizacion" type="text" class="form-control @error('id_organizacion') is-invalid @enderror" name="id_organizacion" value="{{ isset($show_t->NombOrga)?$show_t->NombOrga:old('id_organizacion') }}" disabled autocomplete="id_organizacion" autofocus>
    
                                    @error('id_organizacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_servicioscsc" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de servicio') }}</label>
    
                                <div class="col-md-6">
                                    <input id="id_servicioscsc" type="text" class="form-control @error('id_servicioscsc') is-invalid @enderror" name="id_servicioscsc" value="{{ isset($show_t->nombre)?$show_t->nombre:old('id_servicioscsc') }}" disabled>
    
                                    @error('id_servicioscsc')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="servicioscsc" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de servicio') }}</label>
    
                                <div class="col-md-6">
                                    <input id="servicioscsc" type="text" class="form-control @error('servicioscsc') is-invalid @enderror" name="servicioscsc" value="{{ isset($show_t->nombreservicio)?$show_t->nombreservicio:old('servicioscsc') }}" disabled>
    
                                    @error('servicioscsc')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                            <div class="table-responsive-md">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Fecha y hora inicio</th>
                                        <th scope="col">Fecha y hora fin</th>
                                        <th scope="col">Minutos de trabajo</th>
                                        <th scope="col">Comentario</th>
                                        <th colspan=3></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($servicioscscs as $servicioscsc)
                                        @can('haveaccess','ticket.show')
                                            @isset($servicioscsc->fecha_fin)
                                                <tr href="{{ route('detalle_ticket.show',$servicioscsc->id) }}">
                                            @endisset
                                        @else
                                            <tr>
                                        @endcan 
                                        <th scope="row">{{ $servicioscsc->id }}</th>
                                        <th scope="row">{{ $servicioscsc->name }} {{ $servicioscsc->last_name }}</th>
                                        <th scope="row">{{ $servicioscsc->fecha_inicio }}</th>
                                        <th scope="row">{{ $servicioscsc->fecha_fin }}</th>
                                        <th scope="row">{{ $servicioscsc->tiempo }}</th>
                                        <th scope="row">{{ $servicioscsc->detalle }}</th>
                                        @can('haveaccess','ticket.show')
                                            @isset($servicioscsc->fecha_fin)
                                                <th><a href="{{ route('detalle_ticket.show',$servicioscsc->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                                            @endisset
                                        @endcan
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $servicioscscs->links() !!}
                            </div> 


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                                <a class="btn btn-light btn-block" href="{{ route('ticket.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                                @can('haveaccess','ticket.create')
                                    @isset($tarea_inconclusa)
                                        <a class="btn btn-danger btn-block" href="{{ route('detalle_ticket.finalizar_tarea',$tarea_inconclusa->id) }}">Finalizar tarea</a>
                                    @else
                                        <a class="btn btn-success btn-block" href="{{ route('detalle_ticket.nueva_tarea',$show_t->id) }}">Nueva tarea</a>
                                    @endisset
                                @endcan
                            </div>
                            <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                            @can('haveaccess','ticket.edit')
                                <a href="{{ route('ticket.edit',$ticket->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                            @can('haveaccess','ticket.destroy')
                            <form action="{{ route('ticket.destroy',$ticket->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                            </form>
                            @endcan
                            </div> 
                            </div>
                            <br>
                            <div class="row">
                            <div class="col-xs-12 col-md-4">
                            </div>
                            <div class="col-xs-12 col-md-4">
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','ticket.create')
                                    @isset($tarea_inconclusa_2)
                                        <button class="btn btn-dark btn-block" disabled>Finalizar tarea</button>
                                    @else
                                        @isset($servicioscsc)
                                            <a class="btn btn-danger btn-block" href="{{ route('ticket.cerrar_ticket',$servicioscsc->id_ticket) }}">Cerrar ticket</a>
                                        @endisset
                                    @endisset
                                @endcan
                            </div>
                            </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection