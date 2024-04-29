@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Detalle de Usuario</h2></div>

                <div class="card-body">
                @include('custom.message')
                    
                    <form action="{{ route('user.update', $user->id) }}" method="post">
                    @csrf
                    @method('put')

                        <div class="container">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required readonly autocomplete="name" autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->last_name) }}" required readonly autocomplete="last_name" autofocus>
                            </div>
                        </div>

                            <div class="form-group row">
                                <label for="TeleUser" class="col-md-4 col-form-label text-md-right">{{ __('TeleUser') }}</label>

                                <div class="col-md-6">
                                    <input id="TeleUser" type="number" class="form-control @error('TeleUser') is-invalid @enderror" name="TeleUser" value="{{ old('TeleUser', $user->TeleUser) }}" required readonly autocomplete="TeleUser" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required disabled autocomplete="email">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>
                                <div class="col-md-6">
                                    <select name="CodiOrga" id="CodiOrga" class="form-control" disabled>
                                    <option value="">Seleccionar organizacion</option>
                                        @foreach($organizacions as $organizacion)
                                        <option value="{{ $organizacion->id }}"
                                        @isset($user->organizacions->NombOrga)
                                            @if($organizacion->NombOrga == $user->organizacions->NombOrga)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $organizacion->NombOrga }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="CodiPuEm" class="col-md-4 col-form-label text-md-right">{{ __('NombPuEm') }}</label>
                                <div class="col-md-6">
                                    <select name="CodiPuEm" id="CodiPuEm" class="form-control" disabled>
                                    <option value="">Seleccionar puesto de trabajo</option>
                                        @foreach($puestoemps as $puestoemp)
                                        <option value="{{ $puestoemp->id }}"
                                        @isset($user->puestoemps->NombPuEm)
                                            @if($puestoemp->NombPuEm == $user->puestoemps->NombPuEm)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $puestoemp->NombPuEm }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="CodiSucu" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>
                                <div class="col-md-6">
                                    <select name="CodiSucu" id="CodiSucu" class="form-control" disabled>
                                    <option value="">Seleccionar sucursal</option>
                                        @foreach($sucursals as $sucursal)
                                        <option value="{{ $sucursal->id }}"
                                        @isset($user->sucursals->NombSucu)
                                            @if($sucursal->NombSucu == $user->sucursals->NombSucu)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $sucursal->NombSucu }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>
                                <div class="col-md-6">
                                    <select name="roles" id="roles" class="form-control" disabled>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}"
                                        @isset($user->roles[0]->name)
                                            @if($role->name == $user->roles[0]->name)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $role->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('user.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('view',[$user, ['user.edit','userown.edit']])
                            <a href="{{ route('user.edit',$user->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','user.destroy')
                            <form action="{{ route('user.destroy',$user->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                            </form>
                            @endcan
                            </div>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection