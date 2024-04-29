@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tipo de asistencia nueva') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/asistenciatipo') }}">
                        @csrf
                        @include('asistenciatipo.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
