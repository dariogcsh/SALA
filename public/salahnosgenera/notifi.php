<!DOCTYPE html>
<html>
<head>
	<title>Notify</title>
</head>
<body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.6.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.2/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.2/firebase-messaging.js"></script>
<script src="bower_components/firebase/firebase.js"></script>
<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>

  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyBKgLGx6YoY3TLIkUHQl-PxOT3of3tu2vc",
    authDomain: "agrotecnologiasala.firebaseapp.com",
    databaseURL: "https://agrotecnologiasala.firebaseio.com",
    projectId: "agrotecnologiasala",
    storageBucket: "agrotecnologiasala.appspot.com",
    messagingSenderId: "258712435571",
    appId: "1:258712435571:web:7aeec914f0e15e8ffe6306",
    measurementId: "G-5CY7TNRD91"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);

var messaging = firebase.messaging();
//var databaseService = firebase.database();
//var referencia = databaseService.ref('prueba');

messaging.requestPermission()
  .then(function() {
    console.log('Se han aceptado las notificaciones');
    return messaging.getToken();
  })
  .then(function(token) {
    if(token) {
      console.log(token);
      
      // escribo en esa referencia
      /*
		referencia.set({
	  	campoTest: token
		});
		console.log("SE HA GENERADO TOKEN"); */
    } else {
    	//console.log("NO se genero");
    	console.log('no se pudo');
    	
    }
  })
  .catch(function(err) {
    //mensajeFeedback(err);
    console.log('No se ha recibido permiso / token: ', err);
  });
  
</script>

<?php echo "HOLAAAA"; ?>
</body>
</html>