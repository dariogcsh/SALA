@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar mejora/actualización') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/ideaproyecto/'.$ideaproyecto->id) }}">
                        @csrf
                        @method('patch')
                        @include('ideaproyecto.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection