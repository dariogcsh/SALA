<?php session_start();
include("conexion.php");
include("info_varios.php");

$obj = new Varios;
$array = $obj->designacion($_SESSION["CodiOrga"]);
$arr = mysqli_fetch_array($array);
$tipoasis = $_POST["tipoasis"];
$CodDAsis = $_POST["CodDAsis"];
$CodiMaq = $_POST["CodiMaq"];
$DescAsis = $_POST["DescAsis"];
$CodiEmpl = $arr["CodiEmpl"];
$CodiClie = $_SESSION["CodiClie"];
$MaqDAsis = $_POST["MaqDAsis"];
$EstaAsis = "Solicitud Nueva";
$mailempl = $arr["MailEmpl"];
$time = time();

$fecha = date("Y-m-d H:i:s", $time);

		$query = "INSERT INTO asistencia (CodTAsis, CodDAsis, DescAsis, EstaAsis, FecIAsis, CodiEmpl, CodiMaq, MaqDAsis, CodiClie) VALUES ('". $tipoasis ."', '". $CodDAsis ."', '". $DescAsis ."', '". $EstaAsis ."', '". $fecha ."', '". $CodiEmpl ."', '". $CodiMaq ."', '". $MaqDAsis ."', '". $CodiClie ."')";
		$conn->query($query);
		$conn->close();
		$arr = $obj->cliente_organizacion($CodiClie);
		
		$nombreclie = $arr["NombClie"];
		$organizacion = $arr["NombOrga"];
		$mail = $arr["MailClie"];
		

		$to = "dariogarcia@salahnos.com.ar"; // reemplazar por $mailempl
		$subject = "Solicitud de asistencia";
		$message = "Solicitud de asistencia de: '" . $nombreclie."' perteneciente a la organizacion: '". $organizacion ."' ". "\r\n" ."'". $DescAsis ."'." ;
		$headers = "From: '". $mail ."'" . "\r\n" . "CC: dario.garciacampi@gmail.com";
		 
		mail($to, $subject, $message, $headers);

		echo "Se ha generado con éxito la solicitud de asistencia, en breve nos contactaremos. Muchas gracias.";
		
	
?>