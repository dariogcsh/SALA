@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar tipo de objetivo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/tipoobjetivo/'.$tipoobjetivo->id) }}">
                        @csrf
                        @method('patch')
                        @include('tipoobjetivo.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection