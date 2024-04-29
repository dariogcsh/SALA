@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Viaje a campo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">
                            @if($aux == "conceder")
                                <iframe class="iframe" src={{ $viaje->url }} height="400" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                            @else
                            <div class="row d-flex justify-content-center">
                                <div class="row">
                                    <h4><b>El tiempo para visualizar el recorrido del viaje a campo ha caducado.</b></h4>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-4 col-md-5"></div>
                                    <div class="col-sm-4 col-md-2"><img src="/imagenes/cronometro.png" class="img-fluid"></div>
                                    <div class="col-sm-4 col-md-5"></div>
                                </div>
                            </div>

                            @endif
                            
                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                    <a class="btn btn-light btn-block" href="{{ route('viaje.index') }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','viaje.edit')
                                    <a href="{{ route('viaje.edit',$viaje->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                                </div>
                                <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                @can('haveaccess','viaje.destroy')
                                <form action="{{ route('viaje.destroy',$viaje->id) }}" method="post">
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