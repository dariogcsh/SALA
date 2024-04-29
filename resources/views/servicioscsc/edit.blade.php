@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar servicio') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/servicioscsc/'.$servicioscsc->id) }}">
                        @csrf
                        @method('patch')
                        @include('servicioscsc.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection