@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>Tutoriales
                @can('haveaccess','tutorial.create')
                    <a href="{{ route('tutorial.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                @php
                   $i = 0; 
                @endphp
                
                @foreach($tutorials as $tutorial)
                 
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <h2 style="text-align: center; "><u>{{ $tutorial->titulo }}</u></h2>
                        @isset($tutorial->descripcion)
                            {{ $tutorial->descripcion }}  
                        @endisset
                       
                        <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="{{ $tutorial->url }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <hr>
                        <br>

                    </div>
                </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
