<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if (Request::url() == route('utilidad.index') || Request::url() == route('objetivo.create') 
        || Request::url() == route('utilidad.enviarInforme') || Request::url() == route('utilidad.informe')
        || Request::url() == route('mail.create') || Request::url() == route('reporte_agronomico.index')
        || Request::url() == route('reporte_agronomico.informe') || Request::url() == route('user_notification.create')
        || Request::url() == route('asist.create') || Request::url() == route('maquina.create')
        || Request::url() == route('senal.create') || Request::url() == route('jdlink.create')
        || Request::url() == route('paqueteagronomico.create') 
        || Request::url() == route('jdlink.createconect') || request()->is('tarea/*'
        || Request::url() == route('jdlink.createtractor') || Request::url() == route('utilidad.informeCompararCosechadora')))
    <!-- CDN necesarios para funcionarmiento de selectpicker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    @else
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SALA</title>
    
    <!--- SCRIPT PARA NO RETROCEDER A LA PAGINA ANTERIOR    

    <script type="text/javascript">
        function disableBack() { window.history.forward(); }
        setTimeout("disableBack()", 0);
        window.onunload = function () { null };
    </script>

    -->
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!-- Include the default stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.css">
    <!-- Include plugin -->
    <script src="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.js"></script>

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
   
    <!-- Multi Select -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app_sala.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top rounded-pill" style="margin-top: 15px">
            <div class="container" id="contenedorr">
              
                <ul class="nav navbar-nav navbar-left">
                    
                    <li class="nav-item marg2"><a href="{{ isset($rutavolver)?$rutavolver:route('home') }}" class="nav-link"><img src="/imagenes/homef.png" class="img-responsive" height="25px" title="Volver"></a></li>      
                </ul>
                <ul class="nav navbar-nav navbar-center">
                    <li><a class="navbar-brand mx-auto" href="{{ url('/') }}">
                        <div id="overlay"></div>
                        <div id="loader" class="text-center">
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        </div>
                        <div id="logo_sala">
                            <img src="/imagenes/SALA APP NEGRO.png" height="25px">
                        </div>
                    </a>
                    </li>    
                </ul>
              
                <div class="navbar-header" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <div class="row" style="padding-right: 5px;">
                                @auth
                                <!--- Si el usuario tiene notificaciones sin ver ---->
                                    @if (App\user_notification::where([['id_user',auth()->user()->id],['estado','1']])->count() >0)
                                        <li class="nav-item marg2"><a href="{{ route('user_notification.index') }}" class="nav-link" ><img src="/imagenes/newnotification.png" class="img-responsive" height="25px" title="Notificaciones"></a></li>
                                    @else
                                        <li class="nav-item marg2"><a href="{{ route('user_notification.index') }}" class="nav-link"><img src="/imagenes/notification.png" class="img-responsive" height="25px" title="Notificaciones"></a></li>
                                    @endif
                                @endauth

                             
                                
                                
                                <!--- Se oculta debido a que no se puede preguntar antes de cerrar la sesión y si se borra el código deja de funcionar la seleccion del periodo en el informe de eficiencia semanal, El cierre de sesión se hará en la configuración ---->
                                <li class="nav-item marg2" style="display:none;">
                                    <a id="logout" class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                     <img src="/imagenes/logout.png" class="img-responsive" height="25px" title="Cerrar sesión">
                                    </a>
                                </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-bottom">
            <div class="container-fluid" style="height: 50px">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-2" align="center">
                            <a href="{{ route('home') }}"><img src="/imagenes/_home.png" class="img-responsive" height="30px"  title="Inicio"></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="{{ route('asist.index') }}"><img src="/imagenes/asistencia.png" class="img-responsive" height="30px"  title="Asistencias"></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="{{ route('jdlink.menu') }}"><img src="/imagenes/informes_m.png" class="img-responsive" height="30px"  title="Informes de equipos"></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="{{ route('alerta.index') }}"><img src="/imagenes/alertas_m.png" class="img-responsive" height="30px"  title="Alertas"></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="{{ route('paqueteagronomico.menu') }}"><img src="/imagenes/agro_m.png" class="img-responsive" height="30px"  title="Informes agronómicos"></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="{{ route('internoconfiguracion_user') }}"><img src="/imagenes/config_m.png" class="img-responsive" height="30px"  title="Configuracion"></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('script')
</body>
<script type="application/javascript"> // your code

    document.getElementById("logout").addEventListener("click", function(){
        var messageObj = { action: "logout" };
        var stringifiedMessageObj = JSON.stringify(messageObj);
        if(typeof webkit != "undefined"){
            webkit.messageHandlers.cordova_iab.postMessage(stringifiedMessageObj);
        }
    }, false);


window.addEventListener("load", function () {
  const loader = document.getElementById("loader");
  const overlay = document.getElementById("overlay");
  const logo_sala = document.getElementById("logo_sala");
  loader.style.display = "none";
  overlay.style.display = "none";
  logo_sala.style.display = "block";
});

window.addEventListener("beforeunload", function () {
  const loader = document.getElementById("loader");
  const overlay = document.getElementById("overlay");
  const logo_sala = document.getElementById("logo_sala");
  overlay.style.display = "block";
  loader.style.display = "block";
  logo_sala.style.display = "none";
});

window.addEventListener("unload", function () {
  const loader = document.getElementById("loader");
  const overlay = document.getElementById("overlay");
  const logo_sala = document.getElementById("logo_sala");
  loader.style.display = "none";
  overlay.style.display = "none";
  logo_sala.style.display = "block";
});
</script>
</html>
