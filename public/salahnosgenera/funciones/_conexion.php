<?php
  $conn = new mysqli("localhost", "root", "", "sala");
  
  if ($conn->connect_error) {
    die("ERROR: No se puede conectar al servidor: " . $conn->connect_error);
  } 
 if(!$conn->set_charset("utf8")) {
 }

 date_default_timezone_set('America/Argentina/Cordoba');

?>

