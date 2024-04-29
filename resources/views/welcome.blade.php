<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

@font-face{
    font-family: JDSANS-BOLD;
    src: url(/fonts/JDSANS-BOLD.TTF);
}

body {
  margin: 0;
  font-family: JDSANS-BOLD;
  font-size: 17px;
}

#myVideo {
  position: fixed;
  object-fit: cover; /* Do not scale the image */
  object-position: center; /* Center the image within the element */
  width: 100%;
  min-width: 100%; 
  min-height: 100%;
}

.content {
  background: rgba(0, 0, 0, 0.3);
  color: #f1f1f1;
  width: 100%;
  padding: 20px;
  text-align: center;
}


.full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
                background: rgba(0, 0, 0, 0.5);
                color: #f1f1f1;
                border-radius: 25rem;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #fff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .links > a:hover {
                color: #367C2B;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
</style>
</head>
<body>
    <?php function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini
    |mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    } ?>
    @if(isMobile())
        <video id="myVideo" src="" autoplay muted loop poster="/imagenes/postal_cosecha.jpg">
            Este navegador no soporta HTML5.
        </video>
    @else
    <!-- Para reproducir video
        <video id="myVideo" src="/imagenes/home.mp4" autoplay muted loop poster="/imagenes/postal.jpg">
    -->
    <video id="myVideo" src="" autoplay muted loop poster="/imagenes/postal_cosecha.jpg">
            Este navegador no soporta HTML5.
        </video>
    @endif


<div class="flex-center position-ref full-height">
    
            @if (Route::has('login'))
                <div class="top-right links">
                    
                    @auth
                        <a href="{{ url('/home') }}">Inicio</a>
                    @else
                        <a href="{{ route('login') }}">Iniciar sesion</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Crear cuenta</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                
                    <img src="/imagenes/SALA APP BLANCO.png" class="img-fluid" width="70%">
                

                <div class="links">
                    <a href="https://www.youtube.com/channel/UC-je5rhymSXyMJ4yfrRaKng">You Tube</a>
                    <a href="https://www.instagram.com/salahnosok/">Instagram</a>
                    <a href="https://www.facebook.com/salahnosok/">Facebook</a>
                    <a href="https://twitter.com/salahnosok">Twitter</a>
                    <a href="http://www.salahnos.com.ar/">Web</a>
                </div>
            </div>
        </div>

<script>
  var video = document.getElementById("myVideo");
  
</script>

</body>
</html>
