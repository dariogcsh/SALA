@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pantalla nueva') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/pantalla') }}">
                        @csrf
                        @include('pantalla.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
