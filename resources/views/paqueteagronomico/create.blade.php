@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Registrar paquete de soporte agronómico') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/paqueteagronomico') }}">
                        @csrf
                        @include('paqueteagronomico.form', ['modo'=>'crear'])
                        
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
                url:"{{ route('paqueteagronomico.fetchtractor') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#NumSMaq').html(result);
                    $("#NumSMaq").multipleSelect({
                        filter: true
                    }); 
                },
                error:function(){
                    alert("Ha ocurrido un error, intentelo más tarde");
                }
            })
        }
    });

    $("#hectareas").keyup(function(){
        costot = document.getElementById("costo");
        var costo = $("#costo").val();
        var hectareas = $("#hectareas").val();
        var costoph = $("#costoph").val();   
        var total = 0;
        total = costoph * hectareas;
        costot.value = total;
    });

});
    
</script>
@endsection