<?php
include("conexion.php");

$orga = $_POST["CodiOrga"];
$url = $_POST["url"];
$cultivo = $_POST["cultivo"];
$maq = $_POST["maq"];
$finicio = $_POST["finicio"];
$ffin = $_POST["ffin"];
$tipoinf = $_POST["tipoinf"];


		$query = "INSERT INTO informes (FecIInfo, FecFInfo, NumSMaq, CodiOrga, TipoInfo, CultInfo, URLInfo) VALUES ('". $finicio ."', '". $ffin ."', '". $maq ."', '". $orga ."', '". $tipoinf ."', '". $cultivo ."', '". $url ."')";
		$conn->query($query);
		$conn->close();

		echo "Se ha guardado con exito el informe";
?>