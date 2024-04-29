<?php
include("conexion.php");

$TipoMaq = $_POST["TipoMaq"];
$marca = $_POST["marca"];
$modelo = $_POST["modelo"];
$numero_serie = $_POST["numero_serie"];
$CodiOrga = $_POST["CodiOrga"];


		$query = "INSERT INTO maquinaria (NumSMaq, TipoMaq, MarcMaq, ModeMaq, CodiOrga, CanPMaq, InscMaq) VALUES ('". $numero_serie ."', '". $TipoMaq ."', '". $marca ."', '". $modelo ."', '". $CodiOrga ."', '0', 'NO')";
		$conn->query($query);
		$conn->close();

		$query2 = "INSERT INTO idmaquina (CodiMaqu, NumSMaqu) VALUES ('0','". $numero_serie ."')";
		$conn->query($query2);
		$conn->close();

		echo "Se ha creado con éxito la nueva unidad.";
?>