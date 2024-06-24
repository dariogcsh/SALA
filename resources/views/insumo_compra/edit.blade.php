@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar compra') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/insumo_compra/'.$insumo_compra->id) }}">
                        @csrf
                        @method('patch')
                        <p>Ante alguna modificación en las cantidades del insumo, deberá realizarlo manualmente desde el Stock de productos. Los cambios en las cantidades del insumo que realice aqui no se verá reflejado en el Stock</p>
                        @include('insumo_compra.form', ['modo'=>'modificar'])
                        
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

    if ($('#categoria').val() != ''){ 
            var value = $('#categoria').val();
            var insumo = $('#id_insumo').val();
            var _token = $('input[name="_token"]').val();
            semillas = document.getElementById("semillas");
            bultos = document.getElementById("bultos");
            litros = document.getElementById("litros");
            peso = document.getElementById("peso");
            if(value == 'Producto quimico'){
                semillas.disabled=true;
                bultos.disabled=true;
                litros.disabled=false;
                peso.disabled=true;
            } else {
                if(value == 'Fertilizante'){
                    semillas.disabled=true;
                    bultos.disabled=true;
                    litros.disabled=true;
                    peso.disabled=false;
                } else {
                    semillas.disabled=false;
                    bultos.disabled=false;
                    litros.disabled=true;
                    peso.disabled=true;
                }
            }
            
            $.ajax({
                url:"{{ route('insumo_compra.fetch') }}",
                method:"POST",
                data:{_token:_token, value:value,insumo:insumo},
                success:function(data)
                {
                    //alert(data);
                    $('#id_insumo').html(data);
                },
                error:function(){
                    $('#id_insumo').html('');
                }
            })  
        }
        
    $('#categoria').on('change', function() {
        if ($(this).val() != ''){ 
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            semillas = document.getElementById("semillas");
            bultos = document.getElementById("bultos");
            litros = document.getElementById("litros");
            peso = document.getElementById("peso");
            if(value == 'Producto quimico'){
                semillas.disabled=true;
                bultos.disabled=true;
                litros.disabled=false;
                peso.disabled=true;
            } else {
                if(value == 'Fertilizante'){
                    semillas.disabled=true;
                    bultos.disabled=true;
                    litros.disabled=true;
                    peso.disabled=false;
                } else {
                    semillas.disabled=false;
                    bultos.disabled=false;
                    litros.disabled=true;
                    peso.disabled=true;
                }
            }
            
            $.ajax({
                url:"{{ route('insumo_compra.fetch') }}",
                method:"POST",
                data:{_token:_token, value:value},
                success:function(data)
                {
                    //alert(data);
                    $('#id_insumo').html(data);
                },
                error:function(){
                    $('#id_insumo').html('');
                }
            })  
        }
    });
});
</script>
@endsection