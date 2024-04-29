@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                    <div class="col-md-4 offset-md-4">
                        <img src="{{ asset('/imagenes/logo_sala_negro.png') }}" width="80%" class=" mx-auto d-block"></br>
                        
                        <img src="{{ asset('/imagenes/john_deere.png') }}" width="140" class="mx-auto d-block"></br>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <input id="notification-token-input" hidden type="text" name="notification-token">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success" id="login">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                            <br>
                            <hr>
                                <a href="{{ route('register') }}" class="btn btn-warning btn-block">Crear cuenta</a>
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

     document.getElementById("login").addEventListener("click", function(){
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        let messageObj = { action: "login", email, password };
        let stringifiedMessageObj = JSON.stringify(messageObj);
        console.log("email: ", email);
        console.log("password: ", password);
        console.log("messageObj: ", messageObj);
        console.log("stringifiedMessageObj: ", stringifiedMessageObj);
        console.log("webkit: ", webkit);
        console.log("window.webkit: ", window.webkit);
        if(typeof webkit != "undefined"){
            try {
                webkit.messageHandlers.cordova_iab.postMessage(stringifiedMessageObj);
            } catch (error) {
                console.log("error:", error);
            }
        }
    }, false);
</script>
@endsection
