@php
    use App\img_noticia;
    use App\like;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2>Noticias
                        @can('haveaccess','noticia.create')
                            <a href="{{ route('noticia.create') }}" class="btn btn-success float-right"><b>+</b></a>
                        @endcan
                    </h2>
                </div>
                <div class="card-body">
                    @isset($noticias)
                    <div class="row">
                        @foreach($noticias as $noticia)
                                <div class="col-md-12">
                                    <br>
                                 
                                    <h3><u>{{$noticia->titulo}}</u></h3> <small>{{ date("d/m/Y  H:m",strtotime($noticia->created_at)) }} hs.</small>
                                    @php
                                        $imagenes = Img_noticia::where('id_noticia',$noticia->id)->get();
                                        $cant_like = Like::where('id_noticia',$noticia->id)->count();
                                        $user_like = Like::where([['id_user',auth()->id()], 
                                                                ['id_noticia',$noticia->id]])->count();
                                    @endphp
                                    @foreach($imagenes as $imagen)
                                        <img src="{{ asset('img/noticias/' .$imagen->nombre) }}" width="100%" class="img img-responsive">
                                    @endforeach
                                    
                                    <br>
                                    <br>
                                    <p>{{ $noticia->descripcion }}</p>
                                    
                                    
                                    <div class="row align-items-center">
                                        <div class="col-2 col-sm-1">
                                            @php
                                                $estado_like = 'none';
                                                $estado_not_like = 'none';
                                                if($user_like > 0){
                                                    $estado_like = 'block';
                                                }else{
                                                    $estado_not_like = 'block';
                                                }
                                            @endphp
                                            <a id="{{$noticia->id}}" href="" class="yes_not_like" name="{{$noticia->id}}" style="display: {{$estado_like}}"><img src="{{ asset('imagenes/like.png') }}" height="30px" class="img img-responsive" style="padding-right: 5px"></a>
                                            <a id="{{$noticia->id}}not" href="" class="yes_not_like" name="{{$noticia->id}}" style="display: {{$estado_not_like}}"><img src="{{ asset('imagenes/notlike.png') }}" height="30px" class="img img-responsive" style="padding-right: 5px"></a>
                                        </div>
                                       <div class="col-3 col-sm-3" style="padding-top: 7px">
                                        <h5 id="{{$noticia->id}}cant"><b>{{ $cant_like }}</b></h5>
                                       </div>
                                        <div class="col-7 col-sm-8" style="text-align: right">
                                            @isset($noticia->fuente)
                                                <small class="float-right"><u>Fuente:</u> {{ $noticia->fuente }}</small>
                                            @endisset
                                            
                                        </div>

                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @can('haveaccess','noticia.edit')
                                                <a href="{{ route('noticia.edit',$noticia->id) }}" class="btn btn-warning btn-block">Editar</a>
                                            @endcan
                                        </div>
                                        <br>
                                        <br>
                                        <div class="col-md-3">
                                            @can('haveaccess','noticia.destroy')
                                                <form id="form-delete" action="{{ route('noticia.destroy',$noticia->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                
                        @endforeach
                    </div>
                    @endisset
                    <div class="d-flex justify-content-center">
                        {!! $noticias->onEachSide(0)->links() !!}
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    $('.yes_not_like').click(function(event){
        event.preventDefault();
        var noticia = $(this).attr("name");
        var id_name = $(this).attr("id");
        img1 = document.getElementById(noticia);
        img2 = document.getElementById(noticia+'not');
        cantidad = document.getElementById(noticia+'cant');
        if(noticia == id_name){
            img1.style.display = 'none';
            img2.style.display = 'block';
        }else{
            img1.style.display = 'block';
            img2.style.display = 'none';
        }

        var _token = $('input[name="_token"]').val(); 
        $.ajax({
            url:"{{ route('noticia.like_noticia') }}",
            method:"POST",
            data:{_token:_token, noticia:noticia},
            error:function()
            {
                alert("Ha ocurrido un error, intentelo más tarde");
            },
            success:function(data)
            {   
                $(cantidad).html(data);
            },
        })
    });
});
</script>
@endsection