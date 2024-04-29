@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar suscripcion/activacion') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/suscripcion/'.$suscripcion->id) }}">
                        @csrf
                        @method('patch')
                        @include('suscripcion.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection