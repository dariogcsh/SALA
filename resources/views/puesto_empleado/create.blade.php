@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Puesto de empleado nuevo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/puesto_empleado') }}">
                        @csrf
                        @include('puesto_empleado.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
