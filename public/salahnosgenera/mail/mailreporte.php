<?php
		$headers = "From: dariogarcia@salahnos.com.ar" . "\r\n";
		$to = "";
		include("../funciones/info_varios.php");
		$obj = new Varios;
		$org = $_POST["CodiOrga"];
		$url = $_POST["url"];
		$resultado = $obj->get_email($org);
		$cant = 0;
		$cant = count($resultado);
		if ($cant > 0) {
			while ($fila = mysqli_fetch_array($resultado)) {
				$email = $fila["CorrMail"];
				$tipo = $fila["TipoMail"];
				if ($tipo == "Principal") {
					$to = $email;
					}elseif ($tipo == "Copia") {
						$headers .= "Cc: ".$email. "\r\n";
						}elseif ($tipo == "Copia Oculta") {
							$headers .= "Bcc: ".$email. "\r\n";
						}
			}
		}
	
		$subject = "Reporte Agronomico";
		$message = "Muy buenas tardes, adjuntamos Reporte Agronomico de los cosechado hasta el momento. Para visualizarlo solo debe ingresar al siguiente enlace: " . $url. "\r\n \r\n" ."Cualquier consulta quedamos a disposicion. \r\n \r\n Saludos Cordiales. \r\n \r\n Atte. Dario Garcia Campi - Sala Hnos." ;
 		if ($to <> "") {
 			mail($to, $subject, $message, $headers);
 			echo "Mensajes enviados con éxito";
 		} else {
			echo "No se encuentra dirección de correo perteneciente a la organización";
 		}

?>
