@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar proyecto') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/proyecto/'.$proyecto->id) }}">
                        @csrf
                        @method('patch')
                        @include('proyecto.form', ['modo'=>'modificar'])
                        
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