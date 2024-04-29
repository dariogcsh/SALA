@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar contacto') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/contacto/'.$contacto->id) }}">
                        @csrf
                        @method('patch')
                        @include('contacto.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection