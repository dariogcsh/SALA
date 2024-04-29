@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Compartir viaje') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/viaje') }}">
                        @csrf
                        @include('viaje.form', ['modo'=>'crear'])
                        
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
    $("#id_user").multipleSelect({
    filter: true
    });
    
        $('#id_organizacion').change(function(){   

            if ($(this).val() != ''){ 
                var select = 'CodiOrga';
                var value = $(this).val();           
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('viaje.fetch') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#id_user').html(result);
                        $("#id_user").multipleSelect({
                            filter: true
                        }); 
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