@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar limite de velocidad') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/velocidad_limite/'.$velocidad_limite->id) }}">
                        @csrf
                        @method('patch')
                        @include('velocidad_limite.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
