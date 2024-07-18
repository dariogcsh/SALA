@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Polizas de vehículos 
                    @can('haveaccess','poliza.create')
                        <a href="{{ route('poliza.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
            </h2></div>
                <div class="card-body">
                @include('custom.message')
                        @foreach ($polizas as $poliza)
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <h4>{{ date_format($poliza->created_at, 'd/m/Y - H:i:s') }}</h4>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-8">
                                    <h4>{{ $poliza->titulo }}</h4>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-md-2" style="margin-bottom:5px;">
                                    @can('haveaccess','poliza.index')
                                        <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/pdf/polizas/'.$poliza->ruta)}}" class="btn btn-success btn-block">Ver archivo</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-2" style="margin-bottom:5px;">
                                    @can('haveaccess','poliza.destroy')
                                    <form action="{{ route('poliza.destroy',$poliza->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                                    </form>
                                    @endcan
                                </div> 
                            </div>
                            <br>
                            <hr>
                            <br>
                        @endforeach
                    <div class="d-flex justify-content-center">
                        {!! $polizas->onEachSide(0)->links() !!}
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
$(document).ready(function(){
       $('table tr').click(function(){
        if ($(this).attr('href')) {
           window.location = $(this).attr('href');
        }
           return false;
       });
});
</script>
@endsection
