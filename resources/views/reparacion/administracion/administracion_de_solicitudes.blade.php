@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Administracion de solicitudes<h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Razon Social</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Responsable del relevamiento</th>
                                    <th scope="col">Fecha</th>
                                    <th colspan=3></th>
                                </tr>
                            </thead>
                            @foreach ($solicitudes as $solicitud)
                                <tbody>
                                    <td> {{ $solicitud->razon_social }} </td>
                                    <td> {{ $solicitud->telefono_cliente }} </td>
                                    <td> {{ $solicitud->responsable_relevamiento }} </td>
                                    <td> {{ $solicitud->created_at }} </td>
                                    <td><a href="{{ route('reparacion.administrar_solicitud',$solicitud->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $solicitudes->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection