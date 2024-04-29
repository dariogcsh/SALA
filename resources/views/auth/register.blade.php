@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <p><small> Los campos marcados con * son de caracter obligatorio</small></p> 
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <input id="notification-token-input" hidden type="text" name="notification-token">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} *</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="TeleUser" class="col-md-4 col-form-label text-md-right">{{ __('TeleUser') }} *</label>

                            <div class="col-md-6">
                                <input id="TeleUser" type="number" class="form-control @error('TeleUser') is-invalid @enderror" name="TeleUser" value="{{ old('TeleUser') }}" required autocomplete="TeleUser" autofocus>

                                @error('TeleUser')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="CodiSucu" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }} de preferencia *</label>
                            <div class="col-md-6">
                                <select name="CodiSucu" id="CodiSucu" class="form-control">
                                <option value="">Seleccionar sucursal</option>
                                    @foreach($sucursals as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->NombSucu }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} *</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} *</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} *</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript"> // your code
    function onReady(e){
        function receiveMessage(event) {
            console.log("Received event", event);
            if (!event.data) return;
            const { action } = JSON.parse(event.data);
            if (action === "get-token-successfully") {
                console.log('TOKEN SUCCESS: ', window.mobileAppNotificationToken);
                const notificationTokenElemen = document.getElementById("notification-token-input");
                notificationTokenElemen.value = window.mobileAppNotificationToken;
            }
        }
        window.addEventListener('message', receiveMessage);
     }
     document.addEventListener('DOMContentLoaded', onReady);
</script>
@endsection
