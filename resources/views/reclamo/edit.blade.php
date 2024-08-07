@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar reclamo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/reclamo/'.$reclamo->id) }}">
                        @csrf
                        @method('patch')
                        @include('reclamo.form', ['modo'=>'modificar'])
                        
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
    //Es para el formato de select multiple
    $("#id_user_correctiva").multipleSelect({
                        filter: true
    });
});
</script>
@endsection