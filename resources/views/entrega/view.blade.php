@php
    use App\paso;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>Entrega</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">
                            <div class="row">
                                @isset($entrega->organizacions->NombOrga)
                                    <div class="col-md-4" align="center">
                                        <img class="img img-responsive" src="{{ '/imagenes/organizacion.png' }}" height="75px"><h3>{{ $entrega->organizacions->NombOrga }}</h3>
                                    </div>
                                @else
                                    <div class="col-md-4" align="center">
                                        <img class="img img-responsive" src="{{ '/imagenes/organizacion.png' }}" height="75px"><h3 style="color: red;">Sin asignar</h3>
                                    </div>
                                @endisset
                                <div class="col-md-4" align="center">
                                    <img class="img img-responsive" src="{{ '/imagenes/interno.png' }}" height="75px"><h3>{{ $entrega->sucursals->NombSucu }}</h3>
                                </div>
                                <div class="col-md-4" align="center">
                                    <img class="img img-responsive" @if($entrega->marca == 'PLA') src="{{ '/imagenes/'.$entrega->tipo.'PLA.png' }}" @else src="{{ '/imagenes/'.$entrega->tipo.'.png' }}" @endif height="75px"><h3>{{ $entrega->marca }} {{ $entrega->modelo }}</h3><span>{{ $entrega->pin }}</span>
                                </div>
                            </div>
                            <hr>
                            @isset($entrega->detalle)
                                <div class="row">
                                    {{ $entrega->detalle }}
                                </div>
                                <hr>
                            @endisset
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="main-timeline7">
                                        @foreach($entrega_pasos as $entrega_paso)
                                            <div class="timeline">
                                                <div class="timeline-icon"><i class="fa fa-globe"></i></div>
                                                <span class="year">{{ $entrega_paso->pasos->etapas->nombre }}</span>
                                                <div class="timeline-content">
                                                    <h5 class="title">
                                                        {{ $entrega_paso->pasos->nombre }}
                                                        @isset($entrega_paso->valor_condicion)
                                                            <p class="description">
                                                                 ({{ $entrega_paso->valor_condicion }})
                                                            </p>
                                                        @endisset
                                                    </h5>
                                                    <p class="description">
                                                        <u>Fecha:</u> {{ date('d/m/Y H:i',strtotime($entrega_paso->created_at)) }}
                                                    </p>
                                                    <p class="description">
                                                        <u>Usuario:</u> {{ $entrega_paso->Users->name }} {{ $entrega_paso->Users->last_name[0] }}
                                                    </p>
                                                    @isset($entrega_paso->detalle)
                                                        <p class="description">
                                                            <u>Detalle:</u> {{ $entrega_paso->detalle }}
                                                        </p>
                                                    @endisset
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @isset($imagenes)
                                @if($imagenes->count()>0)
                                    <h3>Fotos de la entrega</h3>
                                    <hr>
                                
                                    <div class="row">
                                        @foreach($imagenes as $imagen)
                                            <div class="col-md-6">
                                                <img src="{{ asset('img/entregas/'.$imagen->path) }}" width="100%" class="img img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endisset
                            
                        </div>

                        

                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('entrega.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','entrega.edit')
                            <a href="{{ route('entrega.edit',$entrega->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','entrega.destroy')
                            <form action="{{ route('entrega.destroy',$entrega->id) }}" method="post">
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