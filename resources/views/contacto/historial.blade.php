@php
    use App\contacto;
    use App\User;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>Historial de contactos con {{ $organizacion->NombOrga }}
                </h3></div>
                <div class="card-body">
                    @foreach($historicos as $historico)
                        @if($historico->tabla == "contactos")
                            <div class="title-default"><h5>CONTACTO</h5></div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{ $historico->campo4 }}
                                </div>
                                <div >
                                    {{  date('d/m/Y H:m',strtotime($historico->creado)) }} hs.
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{ $historico->campo2 }} 
                                </div>
                                <div >
                                    {{ $historico->campo3 }}
                                </div>
                            </div>
                            <hr>
                            <b>Persona con la que se contactó: </b>{{ $historico->campo8 }}
                            <br>
                            <b>Tema de contacto: </b>
                            @if($historico->campo3 == "Ticket CSC")
                                <a href="{{ route('ticket.show',$historico->campo5) }}"><i>Ver ticket CSC</i></a>
                            @else
                                {{ $historico->campo5 }}
                            @endif
                            <br>
                            <a href="{{ route('contacto.show',$historico->idclase) }}"><i>Ver más</i></a>
                            <br>
                            <br>
                        @endif

                        @if($historico->tabla == "alertas")
                            <div class="title-dark"><h5>ALERTA</h5></div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{  date('d/m/Y',strtotime($historico->campo2)) }}
                                    {{  date('H:m',strtotime($historico->campo3)) }} hs.
                                </div>
                                <div >
                                    {{ $historico->campo4 }} 
                                </div>
                            </div>
                            <div class="justify-content">
                                <div>
                                    {{ $historico->campo8 }} 
                                </div>
                                <div >
                                    {{ $historico->campo5 }}
                                </div>
                            </div>
                         
                            <a href="{{ route('alerta.show',$historico->idclase) }}"><i>Ver más</i></a>
                            <br>
                            <br>
                        @endif

                        @if($historico->tabla == "informes")
                            <div class="title-success"><h5>INFORMES</h5></div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{  date('d/m/Y',strtotime($historico->campo2)) }}
                                    {{  date('d/m/Y',strtotime($historico->campo3)) }}
                                </div>
                                <div >
                                    {{ $historico->campo4 }} 
                                </div>
                            </div>
                            <div class="justify-content">
                                <div>
                                   <b>Cultivo: </b> {{ $historico->campo5 }} 
                                </div>
                                @isset($historico->campo5)
                                    <div >
                                        <b>Hs. de trilla: </b>{{ $historico->campo8 }}
                                    </div>
                                @endisset
                            </div>
                            
                            <a href="{{ url('/utilidad/'.$historico->idclase) }}"><i>Ver más</i></a>
                            <br>
                            <br>
                        @endif

                        @if($historico->tabla == "asists")
                            <div class="title-warning"><h5>ASISTENCIA</h5></div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{  date('d/m/Y',strtotime($historico->creado)) }}
                                </div>
                                <div >
                                    <b>Estado: </b>{{ $historico->campo4 }} 
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{ $historico->campo2 }} 
                                </div>
                                <div >
                                    <b>Resuelto: </b>{{ $historico->campo5 }}
                                </div>
                            </div>
                            <div class="justify-content">
                                <div>
                                    <b>Descripción de solicitud: </b>{{ $historico->campo3 }} 
                                </div>
                                @isset($historico->campo8)
                                <div >
                                    <b>Calificación: </b>{{ $historico->campo8 }}
                                </div> 
                                @endisset
                            </div>
                         
                            <a href="{{ route('asist.show',$historico->idclase) }}"><i>Ver más</i></a>
                            <br>
                            <br>
                        @endif
                    @endforeach
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection