@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar puesto de empleado') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/puesto_empleado/'.$puesto_empleado->id) }}">
                        @csrf
                        @method('patch')
                        @include('puesto_empleado.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection