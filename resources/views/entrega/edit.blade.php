@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar entrega') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/entrega/'.$entrega->id) }}">
                        @csrf
                        @method('patch')
                        @include('entrega.form', ['modo'=>'modificar'])
                        
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

        $('input[type=checkbox]').on('change', function() {
            var chk = $(this).attr('id');
            var detalle = document.getElementById("detallediv"+chk);

            if ($(this).is(':checked') ) {
                detalle.style.display = "block";
            } else {
                detalle.style.display = "none";
            }
        });
});
    
</script>
@endsection