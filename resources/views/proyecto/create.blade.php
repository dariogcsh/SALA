@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Nuevo proyecto') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/proyecto') }}">
                        @csrf
                        @include('proyecto.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    $("#id_responsable").multipleSelect({
        filter: true
    });
});
</script>
@endsection