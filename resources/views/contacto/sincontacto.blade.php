@php
    use App\contacto;
    use App\User;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Organizaciones monitoreadas sin contactar en los últimos @if($busqueda <> "")
                    {{$busqueda}} 
                    @else 15
                @endif días
                </h2></div>
                <div class="card-body">
                    @include('custom.message')
                    
                    @can('haveaccess','contacto.index')
                    @if ($filtro=="")
                        <form class="form-inline float-right">
                            <div class="row">
                                <div class="input-group col-md-12">
                                    <select name="sucursal" class="form-control mr-sm-2">
                                        <option value="">Sucursal</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}">{{ $sucursal->NombSucu }}</option>
                                        @endforeach
                                    </select>
                                    <input class="form-control py-3" type="number" placeholder="Dias sin contactar" name="buscarpor">
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
                        <a class="btn btn-secondary float-right" href="{{ route('contacto.sincontacto') }}">
                            <i class="fa fa-times"> </i>
                           {{$busqueda_sucu}} {{ $busqueda }} dias
                        </a>
                    @endif
                    @endcan

                <br>
                <br>
               <p><u>Cantidad: </u>{{ $contador_orga }}</p>
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Organización</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Último contacto</th>
                            <th scope="col">Último contacto con</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Responsables de realizar el contacto</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        @foreach($organizaciones_monitoreada as $org)
                        @php
                        $contacto = Contacto::select('contactos.id','contactos.id_organizacion','organizacions.NombOrga',
                                                    'contactos.departamento','contactos.created_at','users.name',
                                                    'users.last_name','sucursals.NombSucu','organizacions.id as id_orga')
                                            ->join('organizacions','contactos.id_organizacion','=','organizacions.id')
                                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                            ->join('users','contactos.id_user','=','users.id')
                                            ->where([['contactos.created_at','>=',$desde], ['contactos.id_organizacion',$org->id]])
                                            ->orderBy('contactos.created_at','desc')->first(); 
                        @endphp         
                            @isset($contacto)
                            @else
                            @php
                            
                                $sincontacto = Contacto::select('contactos.id','contactos.id_organizacion','organizacions.NombOrga',
                                                    'contactos.departamento','contactos.created_at','users.name',
                                                    'users.last_name','sucursals.NombSucu', 'organizacions.id as id_orga')
                                            ->join('organizacions','contactos.id_organizacion','=','organizacions.id')
                                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                            ->join('users','contactos.id_user','=','users.id')
                                            ->where([['contactos.created_at','<',$desde], ['contactos.id_organizacion',$org->id]])
                                            ->orderBy('contactos.created_at','desc')->first(); 
                                          
                            @endphp
                            @isset($sincontacto)
                                <tr>
                                <th scope="row">{{ $sincontacto->NombOrga }}</th>
                                <th scope="row">{{ $sincontacto->NombSucu }}</th>
                                <th scope="row">{{ date_format($sincontacto->created_at, 'd/m/Y H:i:s')  }}</th>
                                <th scope="row">{{ $sincontacto->name }} {{ $sincontacto->last_name }}</th>
                                <th scope="row">{{ $sincontacto->departamento }}</th>
                                @php
                                    $responsables = User::select('users.name','users.last_name')
                                                        ->leftjoin('mails','users.id','=','mails.UserMail')
                                                        ->where([['mails.OrgaMail',$sincontacto->id_orga],
                                                                ['mails.TipoMail','Copia oculta']])->get();
                                @endphp
                                <th scope="row">
                                    @foreach($responsables as $responsable)
                                        {{$responsable->name}} {{$responsable->last_name}} - 
                                    @endforeach
                                </th>
                                @can('haveaccess','contacto.show')
                                    <th><a href="{{ route('contacto.show',$sincontacto->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                                @endcan
                                @can('haveaccess','contacto.show')
                                    <th><a href="{{ route('contacto.historial',$sincontacto->id) }}" title="Ver historial de contactos">HISTORIAL</a> </th>
                                @endcan
                                </tr>
                            @else
                            <tr>
                                <th scope="row">{{ $org->NombOrga }}</th>
                                <th scope="row">{{ $org->NombSucu }}</th>
                                <th scope="row"><span style="color:red">Nunca se realizo un contacto</span></th>
                                <th scope="row"></th>
                                <th scope="row"></th>
                                @php
                                    $responsables = User::select('users.name','users.last_name')
                                                        ->leftjoin('mails','users.id','=','mails.UserMail')
                                                        ->where([['mails.OrgaMail',$org->id],
                                                                ['mails.TipoMail','Copia oculta']])->get();
                                @endphp
                                <th scope="row">
                                    @foreach($responsables as $responsable)
                                        {{$responsable->name}} {{$responsable->last_name}} - 
                                    @endforeach
                                </th>
                                @can('haveaccess','contacto.show')
                                    <th> </th>
                                @endcan
                                @can('haveaccess','contacto.show')
                                    <th> </th>
                                @endcan
                                </tr>
                            @endisset
                            @endisset
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
@section('script')
<script type="text/javascript">



</script>
@endsection

