@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Registrar tractor / pulverizadora') }}</div>

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

    });

    function suma(){
        if(muestreo.checked){
            muestreo_suelo.style.display='block';
            ambientes = 1;
        }else{
            muestreo_suelo.style.display='none';
            ambientes = 0;
            analisis.value = 'US$ ' + 0;
        }


        alertas = document.getElementById("alertas");
        actualizacion_comp = document.getElementById("actualizacion_comp");
        capacitacion = document.getElementById("capacitacion");
        calidad_siembra = document.getElementById("calidad_siembra");
        muestreo = document.getElementById("muestreo");
        costo = document.getElementById("costo");
        ambientes = $('#ambientes').val();
        muestreo_suelo = document.getElementById("muestreo_suelo");
        analisis = document.getElementById("analisis");
        

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
        if(ambientes == ""){
            ambientes = 0;
        }
        var total = 300;
        if (alertas.checked) {
         total = total + 100;
        }
        if (actualizacion_comp.checked) {
         total = total + 100;
        }
        if (capacitacion.checked) {
         total = total + 100;
        }
        if (calidad_siembra.checked) {
         total = total + 250;
        }
        if (muestreo.checked) {
         total = total + (80*ambientes);
         analisis.value = 'US$ ' + 80*ambientes;
        }
        if(muestreo_suelo)
        costo.value = total;
    }
    
</script>
@endsection