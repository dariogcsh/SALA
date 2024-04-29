@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Agendar fecha') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/calendario') }}">
                        @csrf
                        @include('calendario.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">

function nodispo(){
    var fechainicio = $('#fechainicio').val();
        var fechafin = $('#fechafin').val();
        var _token = $('input[name="_token"]').val();
        //var myOpts = document.getElementById('id_userpar').options; 

        $.ajax({
            url:"{{ route('calendario.disponibilidad') }}",
            method:"POST",
            data:{_token:_token, fechainicio:fechainicio, fechafin:fechafin},
            dataType: "JSON",
            error:function(){
                //Remueve los textos rojos en caso de cambiar de fecha y no haya evento en el dia
                $("#id_userpar option").each(function(){
                    var id_remove = $(this).val();
                    $('.'+id_remove).removeClass('text-danger');
                });
            },
            success:function(data)
            {
                //Remueve los textos rojos en caso de cambiar de fecha y no haya evento en el dia
                $("#id_userpar option").each(function(){
                    var id_remove = $(this).val();
                    $('.'+id_remove).removeClass('text-danger');
                });
                //genera clases nuevas de textos rojos
                $.each(data , function( index, value ) {
                    $("#id_userpar option").each(function(){
                        //Aplica la clase de texto rojo en caso afirmativo
                        if ($(this).val() == data[index]) {
                            $('.'+data[index]).addClass('text-danger');
                        }
                    });
                }); 
            }
        })
}

$( document ).ready(function() {
    //Es para el formato de select multiple
    $("#id_userdis").multipleSelect({
        filter: true
    });

    //Es para el formato de select multiple
    $("#id_userpar").multipleSelect({
        filter: true
    });
});
</script>
@endsection
