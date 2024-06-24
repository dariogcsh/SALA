@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar órden de trabajo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/ordentrabajo/'.$ordentrabajo->id) }}">
                        @csrf
                        @method('patch')
                        @include('ordentrabajo.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection