@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <iframe src="{{'http://docs.google.com/gview?url='.asset('/img/asistencias/'.$solucion->ruta).'&embedded=true'}}" style="width:100%; height:600px;" frameborder="0"></iframe>                    
        </div>
    </div>
</div>
@endsection