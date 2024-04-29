@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar tipo de paquete de mantenimiento') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/tipo_paquete_mant/'.$tipo_paquete_mant->id) }}">
                        @csrf
                        @method('patch')
                        @include('tipo_paquete_mant.form', ['modo'=>'modificar'])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection