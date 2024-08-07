@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Nueva factura de paquete de monitoreo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/monitoreo') }}">
                        @csrf
                        @include('monitoreo.form', ['modo'=>'crear'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">

function calcular(input)
{
    var total = 0;
    for (let i = 1; i < 21; i++) {
        suma = document.getElementById("costo"+i).value * 1;
        total = total + suma;
    }
    document.getElementById("costo_total").value = total;
}

$( document ).ready(function() {

    var i = 1;
    for (let i = 1; i < 21; i++) {
        $( "#otro"+i ).click(function() {
            i=i+1;
            equipo = document.getElementById("equipo"+i);
            equipo.style.display = 'block';
            costo = document.getElementById("costo"+i);
            costo.style.display = 'block';
            this.style.display = 'none';
        });   
    }
});
</script>
@endsection