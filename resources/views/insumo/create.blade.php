@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Insumo nuevo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/insumo') }}">
                        @csrf
                        @include('insumo.form', ['modo'=>'crear'])
                        
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
    $('#categoria').change(function(){   
        if ($(this).val() != ''){
            var value = $(this).val();
            productoquimico = document.getElementById("producto_quimico");
            if(value == 'Producto quimico'){
                productoquimico.style.display='block';
            } else {
                productoquimico.style.display='none';
            }
        }
    });
});

    function mostrarInputMarca() {
        marcanueva = document.getElementById("marca_nueva");
        marca = document.getElementById("id_marcainsumo");
        if(marca.disabled == false){
            marca.disabled = true;
            marcanueva.style.display='block';
            marca.selected = "";
        } else {
            marca.disabled = false;
            marcanueva.style.display='none';
            marca.selected = "";
        }
    }
</script>
@endsection