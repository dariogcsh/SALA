<?php session_start();
include("funciones/conexion.php");
$conn->close();
  	session_destroy(); 
  	$_SESSION = array();
header("Location: index.php");
exit;
?>