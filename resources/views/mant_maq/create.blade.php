@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Registrar máquina conectada') }}</div>

                <div class="card-body">
                        @include('mant_maq.form', ['modo'=>'crear'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
function enviar_formulario1(){
            document.formulario1.submit()
        }
function enviar_formulario2(){
            document.formulario2.submit()
        }
$( document ).ready(function() {
    


        $('#id_organizacion').change(function(){   

            if ($(this).val() != ''){ 
                var select = 'CodiOrga';
                var value = $(this).val();           
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('mant_maq.fetch') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#pin').html(result);
                        $('#id_tipo_paquete_mant').html('<option value="otra">Debe seleccionar una máquina</option>');
                    },
                    error:function(){
                        alert("Ha ocurrido un error, intentelo más tarde");
                    }
                })
            }
            if ($(this).val() != ''){ 
            var select = 'mibonificacions.id_organizacion';
            var value = $(this).val();           
            var _token = $('input[name="_token"]').val(); 
            $.ajax({
                url:"{{ route('senal.buscarbonif') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token},
                success:function(result)
                {
                    $('#id_mibonificacion').html(result); 
                },
                error:function(){
                    alert("Ha ocurrido un error, intentelo más tarde");
                }
            })
            }
        });

        $('#pin').change(function(){   

            if ($(this).val() != ''){ 
                var select = 'NumSMaq';
                var value = $(this).val();           
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('mant_maq.tipoPaquete') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#id_tipo_paquete_mant').html(result);
                    },
                    error:function(){
                        alert("Ha ocurrido un error, intentelo más tarde");
                    }
                })
            }
        });

      

        //Si se selecciona o desselecciona check, se ejecuta la funcion para calcular total del paquete contratado
        $('input[type=checkbox]').on('change', function() {
            var costo = $(this).attr('id');
            var total = $('#costo').val();
            //limpiamos los campos checked y costo
            var costototal = document.getElementById("costo");
            var btn = document.getElementById("btn-enviar");
    
            if ($(this).is(':checked') ) {
                total = Number(total) + Number(costo);
            } else {
                if (total != 0){
                    total = Number(total) - Number(costo);
                }
            }
            costototal.value = total;
            if (total == 0){
                btn.disabled = true;
            } else {
                btn.disabled = false;
            }
        });

    });
    
</script>
@endsection