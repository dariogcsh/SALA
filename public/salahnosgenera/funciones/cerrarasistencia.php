<?php session_start();
include("info_varios.php");

$obj = new Varios;
$CodiAsis = $_POST["CodiAsis"];
$time = time();
$fecha = date("Y-m-d H:i:s", $time);

$obj->cerrar_asistencia("Finalizado",$fecha,$CodiAsis);

echo "La asistencia ha sido finalizada.";
		
	
?>