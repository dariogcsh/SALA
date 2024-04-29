<?php

include'conexion.php';

if ($con) {
    echo "Conexion con base de datos exitosa! ";
    
    if(isset($_POST['codigo'])) {
        
        $codigo = $_POST['codigo'];
        echo "Codigo Recibido";
        echo " codigo : ".$codigo;
        
        $consulta = "INSERT INTO code_loginJD(codigo) VALUES ('$codigo')";
        $resultado = mysqli_query($con, $consulta);
        
        if ($resultado){
            echo " Registo en base de datos OK! ";
            
        } else {
            echo " Falla! Registro BD";
        }
    }
    
    
} else {
    echo "Falla! conexion con Base de datos ";   
}


?>