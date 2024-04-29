@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Registrar paquete de monitoreo tractor / pulverizadora') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/jdlink/storetractor') }}">
                        @csrf
                        @include('jdlink.formtractorsolo', ['modo'=>'crear'])
                        
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
                url:"{{ route('jdlink.fetchtractor') }}",
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
    
    $("#hectareas").keyup(function () {
      var hectareas = $(this).val();
      var costoh = $("#costoh").val();
      $("#costo").val(hectareas * costoh);
    }).keyup();

});
</script>
@endsection