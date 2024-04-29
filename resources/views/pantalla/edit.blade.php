@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar pantalla') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/pantalla/'.$pantalla->id) }}">
                        @csrf
                        @method('patch')
                        @include('pantalla.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection