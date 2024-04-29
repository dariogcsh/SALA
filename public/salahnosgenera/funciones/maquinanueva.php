<?php session_start();
include("conexion.php");

$TipoMaq = $_POST["TipoMaq"];
$marca = $_POST["marca"];
$modelo = $_POST["modelo"];
$numero_serie = $_POST["numero_serie"];
$CodiOrga = $_POST["CodiOrga"];


		$query = "INSERT INTO maquinaria (NumSMaq, TipoMaq, MarcMaq, ModeMaq, CodiOrga, CanPMaq, InscMaq) VALUES ('". $numero_serie ."', '". $TipoMaq ."', '". $marca ."', '". $modelo ."',, '". $CodiOrga ."' '0', 'NO')";
		$conn->query($query);
		$conn->close();


		echo "Se ha creado con éxito la nueva unidad. Ya puede visualizarla en el listado de maquinarias.";
		
	
?>