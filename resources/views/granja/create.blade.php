@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Granja nueva') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/granja') }}">
                        @csrf
                        @include('granja.form', ['modo'=>'crear'])
                        
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
    $('#id_organizacion').change(function(){
        if ($(this).val() != ''){ 
            var select = $(this).attr("id");
            var value = $(this).val();             
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('lote.fetch') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#id_cliente').html(result); 
                }
            })
        }
    }); 
});
</script>
@endsection

