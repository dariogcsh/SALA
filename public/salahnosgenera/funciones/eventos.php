<?php 
include('conexion.php');
if(isset($_POST["codi_org"]) && !empty($_POST["codi_org"])){
	
	$orga = $_POST["codi_org"];
	
    //Get all state data
    $query = $conn->query("SELECT * FROM maquinaria WHERE CodiOrga = '".$orga."' ORDER BY TipoMaq ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display states list
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){ 
        	if ($row["InscMaq"] == "SI") {
        		 echo '<option value="'.$row['NumSMaq'].'">'.$row['NumSMaq'].' - '. $row['ModeMaq'] .' - (Monitoreado)</option>';
        	} else {
            echo '<option value="'.$row['NumSMaq'].'">'.$row['NumSMaq'].' - '. $row['ModeMaq'] .'</option>';
        }}
       
    }else{
        echo '<option value="">Maquinaria no disponible</option>';
    }
}

if(isset($_POST["codi_maq"]) && !empty($_POST["codi_maq"])){
    
    $maquina = $_POST["codi_maq"];
    
    //Get all state data
    $query = $conn->query("SELECT * FROM maquinaria WHERE NumSMaq = '".$maquina."' ORDER BY TipoMaq ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display states list
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){ 
            
                 $resp = $row['CanPMaq'];
}
}
echo $resp;
}

?>