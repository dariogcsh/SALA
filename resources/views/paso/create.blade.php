@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Nuevo paso') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/paso') }}">
                        @csrf
                        @include('paso.form', ['modo'=>'crear'])
                        
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
    
        $('#id_etapa').change(function(){   

            if ($(this).val() != ''){ 
                var select = 'id_etapa';
                var value = $(this).val();           
                var _token = $('input[name="_token"]').val(); 
                var orden_ultimo = document.getElementById("orden_ultimo");
                $.ajax({
                    url:"{{ route('paso.fetch') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        //$('#orden_ultimo').html(result); 
                        orden_ultimo.value = result;
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
