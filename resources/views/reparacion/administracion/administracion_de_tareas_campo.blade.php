@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Administracion de tareas de campo<h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">COR</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Garantia</th>
                                    <th scope="col">Fecha</th>
                                    <th colspan=3></th>
                                </tr>
                            </thead>
                            @foreach ($reparacions as $reparacion)
                                <tbody>
                                    <td> {{ $reparacion->cor }} </td>
                                    <td> {{ $reparacion->cliente }} </td>
                                    <td> {{ $reparacion->garantia }} </td>
                                    <td> {{ $reparacion->created_at }} </td>
                                    <td><a href="{{ route('reparacion.administrar_tarea_campo',$reparacion->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $reparacions->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection