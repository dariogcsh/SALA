@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Ensayos 
                    @can('haveaccess','ensayo.create')
                        <a href="{{ route('ensayo.create') }}" class="btn btn-success float-right"><b>+</b></a>
                    @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="row">
                
                        @foreach ($ensayos as $ensayo)
                        <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12">
                                        <u><h4>{{ $ensayo->TipoMaq }} {{ $ensayo->ModeMaq }} - {{ $ensayo->cultivo }}</h4></u>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="img img-responsive" src="{{ '/imagenes/COSECHADORA.png' }}" height="100px">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-12">
                                            <h5>{{$ensayo->zona}} - <small>{{ date('d/m/Y',strtotime($ensayo->fecha)) }}</small></h5>
                                        </div>
                                        <div class="col-12">
                                            <small>{{ $ensayo->nserie }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p>{{ $ensayo->descripcion }}</p>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-md-6" style="margin-bottom:5px;">
                                        <a href="{{asset('/pdfjs/web/viewer.html?file=').asset('/pdf/ensayos/'.$ensayo->ruta)}}" class="btn btn-success btn-block">Ver ensayo</a>
                                    </div>
                                    <div class="col-12 col-md-6" style="margin-bottom:5px;">
                                        @can('haveaccess','ensayo.destroy')
                                        <form action="{{ route('ensayo.destroy',$ensayo->id) }}" method="post">
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
                            </div>
                        @endforeach
                    
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $ensayos->onEachSide(0)->links() !!}
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
