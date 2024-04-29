<?php  session_start();
include('conexion.php');
if(isset($_POST["user"]) && !empty($_POST["user"]) && isset($_POST["pass"]) && !empty($_POST["pass"])){
	
	$user = $_POST["user"];
    $pass = $_POST["pass"];
	
    //Get all state data
    $query = $conn->query("SELECT * FROM cliente WHERE UsuaClie = '".$user."' AND PassClie = '".$pass."'");

    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display states list
    if($rowCount > 0){
   
        while($row = $query->fetch_assoc()){
            $_SESSION["CodiClie"] = $row["CodiClie"];
            $_SESSION["CodiOrga"] = $row["CodiOrga"];
            $_SESSION["empleado"] = "NO";
        }

        echo 0;
    }
       
    else{
            $query = $conn->query("SELECT * FROM empleado WHERE UsuaEmpl = '".$user."' AND PassEmpl = '".$pass."'");
            
    
            //Count total number of rows
            $rowCount = $query->num_rows;
            
            //Display states list
            if($rowCount > 0){
               while($row = $query->fetch_assoc()){ 
                     $_SESSION["CodiEmpl"] = $row["CodiEmpl"];
                     $_SESSION["NombEmpl"] = $row["NombEmpl"];
                     $_SESSION["PermEmpl"] = $row["PermEmpl"];
                     $_SESSION["empleado"] = "SI";
                }
                echo 1; 
            

        }else{
        echo 2;
    }
}

}



?>