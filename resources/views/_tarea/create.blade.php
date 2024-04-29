@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tarea nueva') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/tarea') }}">
                        @csrf
                        @include('tarea.form', ['modo'=>'crear'])
                        
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
            var selecttec = 'id';
            var value = $(this).val();           
            var _token = $('input[name="_token"]').val(); 
            $.ajax({
                url:"{{ route('utilidad.fetch') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#nseriemaq').html(result);
                },
                error:function(){
                    alert("Ha ocurrido un error, intentelo más tarde");
                }
            })
            $.ajax({
                url:"{{ route('tarea.selecttecnico') }}",
                method:"POST",
                data:{select:selecttec, value:value, _token:_token},
                success:function(result)
                {
                    $('#id_tecnico').html(result);
                    $("#id_tecnico").multipleSelect({
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

function mostrarInputOrga() {
        organizacion = document.getElementById("organizacion_nueva");
        organizacion.style.display='block';
}
function mostrarInputMaq() {
        maquina = document.getElementById("maquina_nueva");
        maquina.style.display='block';
}
</script>
@endsection
