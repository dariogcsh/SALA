<?php
	class Push
	{
	public function enviar_push($titulo,$cuerpo){
		 echo '<script> Push.create("'. $titulo .'", {
        body: "'. $cuerpo .'",
        icon: "imagen/john.png",
        timeout: 10000,
     	}); </script>';
	}
}

?>