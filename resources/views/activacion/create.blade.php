@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar activacion/suscripcion') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/activacion') }}">
                        @csrf
                        @include('activacion.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
