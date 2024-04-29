@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de vehículos
                @can('haveaccess','viaje.create')
                    <a href="{{ route('viaje.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    {{ $enlace }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
