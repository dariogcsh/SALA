@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>Lista de correos
                @can('haveaccess','mail.create')
                <a href="{{ route('mail.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                    @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="tipo" class="form-control mr-sm-2">
                                        <option value="">Buscar por</option>
                                        <option value="organizacions.NombOrga">Organizacion</option>
                                        <option value="users.last_name">Apellido</option>
                                        <option value="users.name">Nombre</option>
                                        <option value="users.email">E-mail</option>
                                        <option value="mails.TipoMail">Forma de envio</option>
                                    </select>
                                    <input class="form-control py-2" type="text" placeholder="Buscar" name="buscarpor">
                                    <span class="input-group-append">
                                        <button class="btn btn-warning" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    @endif
                    @if ($filtro=="SI")
                        <a class="btn btn-secondary float-right" href="{{ route('mail.index') }}">
                            <i class="fa fa-times"> </i>
                            {{ $busqueda }}
                        </a>
                    @endif
                    <br>
                    <br>
                    <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Organizacion a enviar</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo Electrónico</th>
                            <th scope="col">Tipo de envio</th>
                            <th scope="col">Tipo de informe</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($mails as $mail)
                            @can('haveaccess','mail.show')
                            <tr href="{{ route('mail.show',$mail->id) }}">
                            @else
                            <tr>
                            @endcan
                            <th scope="row">{{ $mail->NombOrga }}</th>
                            <th scope="row">{{ $mail->last_name }}</th>
                            <th scope="row">{{ $mail->name }}</th>
                            <th scope="row">{{ $mail->email }}</th>
                            <th scope="row">{{ $mail->TipoMail }}</th>
                            <th scope="row">{{ $mail->TiInMail }}</th>
                            @can('haveaccess','mail.show')
                            <th><a href="{{ route('mail.show',$mail->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $mails->onEachSide(0)->links() !!}
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
