@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Subir PDF') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/poliza') }}" enctype="multipart/form-data">
                        @csrf
                        @include('poliza.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
