@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Órden de trabajo nueva') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/ordentrabajo') }}">
                        @csrf
                        @include('ordentrabajo.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
