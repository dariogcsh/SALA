<?php
$to = "dario.garciacampi@gmail.com";
$subject = "Asunto del email";
$message = "Este es mi primer envío de email con PHP";
$headers = "From: dariogarcia@salahnos.com.ar" . "\r\n" . "CC: gc.globalcom@gmail.com";
 
mail($to, $subject, $message, $headers);

?>