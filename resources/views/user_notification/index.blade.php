@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>
                Notificaciones
                @can('haveaccess','user_notification.create')
                <a href="{{ route('user_notification.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan</h2></div>
                <div class="card-body">
                @include('custom.message')
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha de notificación</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($notifications as $notification)
                            <tr href="{{ $notification->path }}">
                                <th scope="row">
                                @if($notification->estado == '1')
                                <img src="{{ asset('/imagenes/alertwarning.png') }}"  height="10">
                                @endif
                                </th>
                            <th scope="row">{{ $notification->title }}</th>
                            <th scope="row">{{ $notification->body }}</th>
                            <th scope="row">{{ date_format($notification->created_at, 'd/m/Y H:i:s')}}</th>
                            <th><a href="{{ $notification->path }}"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        
                        </div>
                         
                        <div class="d-flex justify-content-center">
                            {!! $notifications->onEachSide(0)->links() !!}
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
