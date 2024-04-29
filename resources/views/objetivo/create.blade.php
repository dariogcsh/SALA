@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear objetivo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/objetivo') }}">
                        @csrf
                        @include('objetivo.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
        $('#CodiOrga').change(function(){
            
            if ($(this).val() != ''){ 
                var select = $(this).attr("id");
                var value = $(this).val();
               
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('utilidad.fetchidmaq') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#id_maquina').html(result); 
                    }
                })
            }
        });

    }); 
</script>
@endsection
@endsection
