@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Listas de precios </h2></div>
                <div class="card-body">
                @include('custom.message')
                        @foreach ($subirpdfs as $subirpdf)
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <h4>{{ date_format($subirpdf->created_at, 'd/m/Y - H:i:s') }}</h4>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-8">
                                    <h4>{{ $subirpdf->titulo }}</h4>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-md-2" style="margin-bottom:5px;">
                                    @can('haveaccess','subirpdf.show')
                                        <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/pdf/ventas/'.$subirpdf->ruta)}}" class="btn btn-success btn-block">Ver archivo</a>
                                    @endcan
                                </div>
                                <div class="col-xs-12 col-md-2" style="margin-bottom:5px;">
                                    @can('haveaccess','subirpdf.destroy')
                                    <form action="{{ route('subirpdf.destroy',$subirpdf->id) }}" method="post">
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
                        {!! $subirpdfs->onEachSide(0)->links() !!}
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
