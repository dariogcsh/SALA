@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar permiso') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/permission/'.$permission->id) }}">
                        @csrf
                        @method('patch')
                        @include('permission.form', ['modo'=>'modificar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection