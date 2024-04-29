<?php 
						include("funciones/info_varios.php");
      					$obj = new Varios;
                        $lista = $obj->registros_sin_cultivo2(); 
                        $a = 0;
                        while ($fila = mysqli_fetch_array($lista)) { 
                        	if ($a == 50){
                        		break;
                        	}
                          $cultivo = $obj->buscar_cultivo($fila["FecIUtil"], $fila["HorIUtil"], $fila["FecFUtil"], $fila["HorFUtil"], $fila["NumSMaq"]);
                          $obj->actualizar_cultivo($fila["FecIUtil"], $fila["HorIUtil"], $fila["FecFUtil"], $fila["HorFUtil"], $fila["NumSMaq"], $cultivo);
                          $a = $a +1 ;
                        }
                        if ($a <> 50) {
                        	echo "OK";
                        } else {
                        header("Refresh: 1; URL='tiempo_cultivo.php'");
                        }
                      ?>