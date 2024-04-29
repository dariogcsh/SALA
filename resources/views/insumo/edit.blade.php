@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar producto') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/insumo/'.$insumo->id) }}">
                        @csrf
                        @method('patch')
                        @include('insumo.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
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