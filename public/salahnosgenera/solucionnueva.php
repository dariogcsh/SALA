<?php session_start();
include("conexion.php");
include("info_varios.php");

$DescAsis = $_POST["DescAsis"];
$CodiAsis = $_POST["CodiAsis"];	
$time = time();
$fecha = date("Y-m-d H:i:s", $time);
$obj = new Varios ;
$array = $obj->detalle_asistencia($idasistencia);
$fechamodif = $array["FecRAsis"];

    if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])) { 
           $CodiClie = 0;
           $CodiEmpl = $_SESSION["CodiEmpl"]; 
           $obj->modificar_estado_asistencia("Respondido",$fechamodif,$CodiAsis); 
           $x=1;        
    } else { 
           $CodiEmpl = 0;
           $CodiClie = $_SESSION["CodiClie"]; 
           $obj->modificar_estado_asistencia("Solicitud",$fechamodif,$CodiAsis);
           $x=0;         
     }
    

     	

		$query = "INSERT INTO solucion (DescSolu, FecISolu, CodiEmpl, CodiClie) VALUES ('". $DescAsis ."', '". $fecha ."', '". $CodiEmpl ."', '". $CodiClie ."')";
		$conn->query($query);
		

		$query = "SELECT * FROM solucion ORDER BY CodiSolu DESC LIMIT 1";
		$result = $conn->query($query);
		
		$array = mysqli_fetch_array($result);
		$CodiSolu = $array[0];

		$query = "INSERT INTO asistencia_solucion (CodiAsis, CodiSolu) VALUES ('". $CodiAsis ."', '". $CodiSolu ."')";
		$conn->query($query);
		

		
		

		echo $x;
		
	
?>