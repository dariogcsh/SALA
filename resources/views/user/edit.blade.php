@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Editar Usuario</h2></div>

                <div class="card-body">
                    <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                @include('custom.message')
                    
                    <form action="{{ route('user.update', $user->id) }}" method="post">
                    @csrf
                    @method('put')

                        <div class="container">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} *</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }} *</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->last_name) }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="form-group row">
                                <label for="TeleUser" class="col-md-4 col-form-label text-md-right">{{ __('TeleUser') }} *</label>

                                <div class="col-md-6">
                                    <input id="TeleUser" type="number" class="form-control @error('TeleUser') is-invalid @enderror" name="TeleUser" value="{{ old('TeleUser', $user->TeleUser) }}" required autocomplete="TeleUser" autofocus>
                                    @error('TeleUser')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} *</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required readonly autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            @can('haveaccess','user.edit')
                                <div class="form-group row">
                            @endcan
                            @cannot('haveaccess','user.edit')
                                <div class="form-group row" hidden>
                            @endcan
                                <label for="CodiOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }}</label>
                                <div class="col-md-6">
                                    <select name="CodiOrga" id="CodiOrga" class="form-control">
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

                            @can('haveaccess','user.edit')
                                <div class="form-group row">
                            @endcan
                            @cannot('haveaccess','user.edit')
                                <div class="form-group row" hidden>
                            @endcan
                                <label for="CodiPuEm" class="col-md-4 col-form-label text-md-right">{{ __('NombPuEm') }}</label>
                                <div class="col-md-6">
                                    <select name="CodiPuEm" id="CodiPuEm" class="form-control">
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
                                <label for="CodiSucu" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} *</label>
                                <div class="col-md-6">
                                    <select name="CodiSucu" id="CodiSucu" class="form-control" required>
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
                                <label for="nacimiento" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>
    
                                <div class="col-md-6">
                                    <input id="nacimiento" type="date" class="form-control @error('nacimiento') is-invalid @enderror" name="nacimiento" value="{{ old('nacimiento',$user->nacimiento) }}" autocomplete="nacimiento" autofocus>
    
                                    @error('nacimiento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @can('haveaccess','user.edit')
                                <div class="form-group row">
                            @endcan
                            @cannot('haveaccess','user.edit')
                                <div class="form-group row" hidden>
                            @endcan
                                <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>
                                <div class="col-md-6">
                                    <select name="roles" id="roles" class="form-control">
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
                            <p><small>En el caso de NO querer modificar la contraseña, NO es necesario completar los siguientes campos</small></p>
                            
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="new-password">
                            </div>
                        </div>
                            
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" class="btn btn-success" value="Guardar">
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