<?php
  $conn = new mysqli("mysql.hostinger.com.ar", "u765957855_sala2", "sala2019", "u765957855_salahnos2");
  
  if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  } 
 if(!$conn->set_charset("utf8")) {
 }

 date_default_timezone_set('America/Argentina/Cordoba');

?>