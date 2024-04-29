@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar bonificacion solicitada') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/mibonificacion/'.$mibonificacion->id) }}">
                        @csrf
                        @method('patch')
                        @include('mibonificacion.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection