@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar máquina conectada') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/jdlink/storeconect') }}">
                        @csrf
                        @include('jdlink.form', ['modo'=>'crear'])
                        
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
            var select = 'CodiOrga';
            var value = $(this).val();           
            var _token = $('input[name="_token"]').val(); 
            $.ajax({
                url:"{{ route('utilidad.fetch') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#NumSMaq').html(result);
                },
                error:function(){
                    alert("Ha ocurrido un error, intentelo más tarde");
                }
            })
        }
    });
});
    
</script>
@endsection