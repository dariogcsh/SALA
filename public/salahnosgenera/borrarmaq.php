<?php
include("conexion.php");

$codigo = $_POST["codigo"];



		$query = "DELETE FROM maquinaria WHERE IdMaq = '". $codigo ."'";
		$conn->query($query);
		$conn->close();


		echo "Se ha eliminado correctamente la unidad";
		
	
?>