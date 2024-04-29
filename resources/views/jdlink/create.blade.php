@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Registrar máquina conectada') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/jdlink') }}">
                        @csrf
                        @include('jdlink.formcreate', ['modo'=>'crear'])
                        
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
                    url:"{{ route('jdlink.fetch') }}",
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

    });

    function suma(){
        actualizacion_comp = document.getElementById("actualizacion_comp");
        visita_inicial = document.getElementById("visita_inicial");
        capacitacion_op = document.getElementById("capacitacion_op");
        ensayo = document.getElementById("ensayo");
        check_list = document.getElementById("check_list");
        limpieza_inyectores = document.getElementById("limpieza_inyectores");
        analisis_final = document.getElementById("analisis_final");
        costo = document.getElementById("costo");

        //funciones necesarias para calcular la cantidad de maquinas y aplicar un descuento
        maquinas = document.getElementById("NumSMaq");
        var mq = $('#NumSMaq').val();
        var cont = 0;
        var desc = 0;
        /*
        mq.forEach(element => {
            cont = cont + 1 ;
            if (cont > 1){
                desc = desc + 5;
                $('#desc_visita').html('<strong>-'+desc+'%</strong> (descuento)');
                $('#desc_check').html('<strong>-'+desc+'%</strong> (descuento)');
            }
        });
        */

        var total = 650;
        if (actualizacion_comp.checked) {
         total = total + 100;
        }
        if (visita_inicial.checked) {
         total = total + 200;
        }
        if (capacitacion_op.checked) {
         total = total + 100;
        }
        if (capacitacion_asesor.checked) {
         total = total + 100;
        }
        if (ensayo.checked) {
         total = total + 200;
        }
        if (check_list.checked) {
         total = total + 200;
        }
        if (limpieza_inyectores.checked) {
         total = total + 500;
        }
        if (analisis_final.checked) {
         total = total + 150;
        }
    
        costo.value = total;
    }
    
</script>
@endsection